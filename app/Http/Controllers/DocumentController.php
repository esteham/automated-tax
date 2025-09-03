<?php

namespace App\Http\Controllers;

use App\Models\Taxpayer;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','permission:document.upload|document.delete|document.view']);

    }//end methoad

    /** Upload KYC for a taxpayer */
    public function store(Request $request, Taxpayer $taxpayer)
    {
        $this->authorize('update', $taxpayer);

        $request->validate([
            'file' => ['required','file','mimes:pdf,jpg,jpeg,png,webp','max:5120'],
        ]);

        $taxpayer->addMediaFromRequest('file')
            ->usingFileName('kyc_'.time().'.'.$request->file('file')->getClientOriginalExtension())
            ->toMediaCollection('kyc_docs');

        return back()->with('ok','KYC document uploaded.');

    }//end methoad

    /** Optional: delete a KYC doc */
    public function destroy(Taxpayer $taxpayer, string $mediaId)
    {
        $this->authorize('update', $taxpayer);
        $media = $taxpayer->media()->where('id',$mediaId)->firstOrFail();
        $media->delete();
        return back()->with('ok','KYC document removed.');

    }//end methoad
    
}
