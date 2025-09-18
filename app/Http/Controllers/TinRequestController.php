<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTinRequest;
use App\Models\TinRequest;
use App\Models\User;
use App\Notifications\NewTinRequestNotification;
use App\Notifications\TinRequestApprovedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TinRequestController extends Controller
{
    use AuthorizesRequests;
    
    public function __construct()
    {
        // Middleware is now defined in the route file
    }

    /**
     * Display a listing of TIN requests for admin/auditor.
     */
    public function index()
    {
        $user = Auth::user();
        $query = TinRequest::with('user');
        
        if ($user->hasRole('user')) {
            $query->where('user_id', $user->id);
        }
        
        $requests = $query->latest()->paginate(15);
        
        return view('tin.requests.index', compact('requests'));
    }

    /**
     * Show the form for creating a new TIN request.
     */
    public function create()
    {
        $user = Auth::user();
        
        // Check if user already has a pending or approved TIN request
        $existingRequest = TinRequest::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'approved'])
            ->first();
            
        if ($existingRequest) {
            if ($existingRequest->isApproved()) {
                return redirect()->route('tin-requests.show', $existingRequest)
                    ->with('success', 'You already have an approved TIN: ' . $existingRequest->tin_number);
            }
            
            return redirect()->route('tin-requests.show', $existingRequest)
                ->with('info', 'You already have a pending TIN request.');
        }
        
        return view('tin.requests.create', [
            'user' => $user
        ]);
    }

    /**
     * Store a newly created TIN request in storage.
     */
    public function store(StoreTinRequest $request)
    {
        $user = Auth::user();
        
        $data = $request->validated();
        $data['user_id'] = $user->id;
        
        // Create the TIN request
        $tinRequest = TinRequest::create($data);
        
        // Notify admins and auditors about new TIN request
        $adminsAndAuditors = User::role(['admin', 'auditor'])->get();
        Notification::send($adminsAndAuditors, new NewTinRequestNotification($tinRequest));
        
        return redirect()->route('tin-requests.show', $tinRequest)
            ->with('success', 'Your TIN request has been submitted successfully!');
    }

    /**
     * Display the specified TIN request.
     */
    public function show(TinRequest $tinRequest)
    {
        $this->authorize('view', $tinRequest);
        
        return view('tin.requests.show', [
            'request' => $tinRequest->load('user', 'approver')
        ]);
    }

    /**
     * Approve a TIN request.
     */
    public function approve(Request $request, TinRequest $tinRequest)
    {
        $this->authorize('approve', $tinRequest);
        
        if ($tinRequest->isApproved()) {
            return back()->with('info', 'This TIN request has already been approved.');
        }
        
        // Generate TIN number (format: TIN-YYYY-XXXXX where X is random)
        $tinNumber = 'TIN-' . date('Y') . '-' . strtoupper(Str::random(5));
        
        // Update the TIN request
        $tinRequest->update([
            'status' => 'approved',
            'tin_number' => $tinNumber,
            'approved_at' => now(),
            'approved_by' => Auth::id(),
            'rejection_reason' => null,
        ]);
        
        // Generate TIN certificate
        $certificatePath = $this->generateTinCertificate($tinRequest);
        $tinRequest->update(['certificate_path' => $certificatePath]);
        
        // Send approval notification to the user
        $tinRequest->user->notify(new TinRequestApprovedNotification($tinRequest));
        
        return redirect()->route('tin-requests.show', $tinRequest)
            ->with('success', 'TIN request approved successfully!');
    }
    
    /**
     * Reject a TIN request.
     */
    public function reject(Request $request, TinRequest $tinRequest)
    {
        $this->authorize('approve', $tinRequest);
        
        $request->validate([
            'rejection_reason' => 'required|string|max:1000',
        ]);
        
        if ($tinRequest->isRejected()) {
            return back()->with('info', 'This TIN request has already been rejected.');
        }
        
        $tinRequest->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);
        
        // Send rejection notification to the user
        $tinRequest->user->notify(new TinRequestRejectedNotification($tinRequest, $request->rejection_reason));
        
        return redirect()->route('tin-requests.show', $tinRequest)
            ->with('success', 'TIN request rejected successfully.');
    }
    
    /**
     * Download TIN certificate.
     */
    public function downloadCertificate(TinRequest $tinRequest)
    {
        $this->authorize('view', $tinRequest);
        
        if (!$tinRequest->isApproved() || !$tinRequest->certificate_path) {
            abort(404);
        }
        
        return Storage::download($tinRequest->certificate_path, 'TIN-Certificate-' . $tinRequest->tin_number . '.pdf');
    }
    
    /**
     * Generate TIN certificate PDF.
     */
    protected function generateTinCertificate(TinRequest $tinRequest)
    {
        $pdf = PDF::loadView('pdf.tin-certificate', [
            'request' => $tinRequest,
        ]);
        
        $filename = 'tin-certificates/' . $tinRequest->tin_number . '.pdf';
        
        Storage::put($filename, $pdf->output());
        
        return $filename;
    }

    /**
     * Remove the specified TIN request from storage.
     */
    public function destroy(TinRequest $tinRequest)
    {
        $this->authorize('delete', $tinRequest);
        
        // Delete the certificate file if it exists
        if ($tinRequest->certificate_path && Storage::exists($tinRequest->certificate_path)) {
            Storage::delete($tinRequest->certificate_path);
        }
        
        $tinRequest->delete();
        
        return redirect()->route('tin-requests.index')
            ->with('success', 'TIN request has been deleted successfully.');
    }
}
