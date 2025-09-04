<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UpdateTaxpayerRequest;
use App\Models\Taxpayer;

class TaxpayerController extends Controller 
{
    public function __construct()
    {
        $this->middleware(['auth']);

    }//end methoad

    public function index()
    {
        $this->authorize('viewAny', Taxpayer::class);
        $taxpayers = Taxpayer::with('user')->latest()->paginate(20);
        return view('taxpayers.index', compact('taxpayers'));

    }//end methoad

    public function edit(Taxpayer $taxpayer)
    {
        $this->authorize('update', $taxpayer);
        return view('taxpayers.edit', compact('taxpayer'));

    }//end methoad

    public function update(UpdateTaxpayerRequest $request, Taxpayer $taxpayer)
    {
        $this->authorize('update', $taxpayer);
        $taxpayer->update($request->validated());
        return redirect()->route('taxpayers.show', $taxpayer)->with('ok','Taxpayer updated.');

    }//end methoad

    public function destroy(Taxpayer $taxpayer)
    {
        $this->authorize('delete', $taxpayer);
        $taxpayer->delete();
        return redirect()->route('taxpayers.index')->with('ok','Taxpayer deleted.');

    }//end methoad

}
