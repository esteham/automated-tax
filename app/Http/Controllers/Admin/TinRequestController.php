<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TinRequest;
use App\Models\User;
use App\Notifications\TinRequestApprovedNotification;
use App\Notifications\TinRequestRejectedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TinRequestController extends Controller
{
    use AuthorizesRequests;
    
    /**
     * Display a listing of the TIN requests.
     */
    public function index()
    {
        $this->authorize('viewAny', TinRequest::class);
        
        $requests = TinRequest::with(['user', 'approver'])
            ->latest()
            ->paginate(15);
            
        return view('admin.tin-requests.index', compact('requests'));
    }

    /**
     * Show the specified TIN request.
     */
    public function show(TinRequest $tinRequest)
    {
        $this->authorize('view', $tinRequest);
        
        $tinRequest->load(['user', 'approver']);
        
        return view('admin.tin-requests.show', compact('tinRequest'));
    }
    
    /**
     * Approve a TIN request and generate TIN number.
     */
    public function approve(Request $request, TinRequest $tinRequest)
    {
        $this->authorize('update', $tinRequest);
        
        if ($tinRequest->isApproved()) {
            return back()->with('info', 'This TIN request has already been approved.');
        }
        
        // Generate TIN number (format: TIN-YYYY-XXXXX where X is random)
        $tinNumber = 'TIN-' . date('Y') . '-' . strtoupper(Str::random(5));
        
        $tinRequest->update([
            'status' => 'approved',
            'tin_number' => $tinNumber,
            'approved_by' => auth()->id(),
            'approved_at' => now(),
            'rejection_reason' => null,
        ]);
        
        // Generate and save TIN certificate
        $this->generateAndSaveCertificate($tinRequest);
        
        // Notify the user
        $tinRequest->user->notify(new TinRequestApprovedNotification($tinRequest));
        
        return back()->with('success', 'TIN request approved successfully.');
    }
    
    /**
     * Reject a TIN request.
     */
    public function reject(Request $request, TinRequest $tinRequest)
    {
        $this->authorize('update', $tinRequest);
        
        $request->validate([
            'rejection_reason' => 'required|string|max:1000',
        ]);
        
        if ($tinRequest->isApproved() || $tinRequest->isRejected()) {
            return back()->with('info', 'This TIN request has already been processed.');
        }
        
        $tinRequest->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);
        
        // Notify the user
        $tinRequest->user->notify(new TinRequestRejectedNotification(
            $tinRequest,
            $request->rejection_reason
        ));
        
        return back()->with('success', 'TIN request rejected successfully.');
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
        
        return Storage::download($tinRequest->certificate_path, 'tin-certificate-' . $tinRequest->tin_number . '.pdf');
    }
    
    /**
     * Generate and save TIN certificate as PDF.
     */
    protected function generateAndSaveCertificate(TinRequest $tinRequest)
    {
        $pdf = Pdf::loadView('pdf.tin-certificate', [
            'tinRequest' => $tinRequest->load('user')
        ]);
        
        $filename = 'certificates/tin-' . $tinRequest->tin_number . '.pdf';
        
        // Save the PDF to storage
        Storage::put('public/' . $filename, $pdf->output());
        
        // Update the TIN request with the certificate path
        $tinRequest->update([
            'certificate_path' => 'public/' . $filename
        ]);
        
        return $filename;
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Not used for TIN requests - users submit through their dashboard
        abort(404);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Not used - handled by the main TinRequestController
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TinRequest $tinRequest)
    {
        // Not used - TIN requests should be approved/rejected, not edited
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TinRequest $tinRequest)
    {
        // Not used - TIN requests should be approved/rejected, not edited
        abort(404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TinRequest $tinRequest)
    {
        $this->authorize('delete', $tinRequest);
        
        // Delete the certificate file if it exists
        if ($tinRequest->certificate_path && Storage::exists($tinRequest->certificate_path)) {
            Storage::delete($tinRequest->certificate_path);
        }
        
        $tinRequest->delete();
        
        return redirect()->route('admin.tin-requests.index')
            ->with('success', 'TIN request deleted successfully.');
    }
}
