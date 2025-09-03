<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\StoreTaxpayerRequest;
use App\Http\Requests\UpdateTaxpayerRequest;
use App\Models\Taxpayer;
use App\Models\User;

class TaxpayerController extends Controller 
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index()
    {
        $this->authorize('viewAny', Taxpayer::class);
        $taxpayers = Taxpayer::with('user')->latest()->paginate(20);
        return view('taxpayes.index', compact('taxpayers'));

    }// end method

    
    public function create()
    {
        $this->authorize('create', Taxpayer::class);
        $users = User::orderBy('name')->get(['id','name','email']);
        return view('taxpayers.create', compact('users'));
        
    }// end method

    
    public function store(StoreTaxpayerRequest $request)
    {
        $this->authorize('create', Taxpayer::class);
        $taxpayer = Taxpayer::create($request->validated());
        return redirect()->route('taxpayers.show', $taxpayer)->with('ok', 'Taxpayer created.');

    }// end method

    
    public function show(Taxpayer $taxpayer)
    {
        $this->authorize('view', $taxpayer);
        $kyc = $taxpayer->getMedia('kyc_docs');
        return view('taxpayers.show', compact('taxpayer','kyc'));
        
    }// end method

    
    public function edit(Taxpayer $taxpayer)
    {
        $this->authorize('update', $taxpayer);
        return view('taxpayers.edit', compact('taxpayer'));

    }// end method

    
    public function update(UpdateTaxpayerRequest $request, Taxpayer $taxpayer)
    {
        $this->authorize('update', $taxpayer);
        $taxpayer->update($request->validated());
        return redirect()->route('taxpayers.show', $taxpayer)->with('ok','Taxpayer updated.');

    }// end method

    
    
    public function destroy(Taxpayer $taxpayer)
    {
        $this->authorize('delete', $taxpayer);
        $taxpayer->delete();
        return redirect()->route('taxpayers.index')->with('ok','Taxpayer deleted.');

    }// end method

}
