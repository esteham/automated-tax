@extends('layouts.app')

@section('content')
<div>
    <form wire:submit.prevent="save">
        <!-- Form fields for taxpayer creation -->
        <input type="text" wire:model="tin_number" placeholder="TIN Number" />
        <input type="text" wire:model="business_name" placeholder="Business Name" />
        <input type="file" wire:model="kyc_docs" multiple />
        <button type="submit">Create Taxpayer</button>
    </form>

    @if (session()->has('message'))
        <div>{{ session('message') }}</div>
    @endif
</div>
@endsection
