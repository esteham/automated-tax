@extends('layouts.app')

@section('content')

<h1>Create Taxpayer</h1>
    <form method="POST" action="{{ route('taxpayers.store') }}">
        @csrf
        <label>User</label>
            <input type="number" name="user_id" value="{{ old('user_id', auth()->id()) }}" required>

        <label>TIN</label>
            <input type="text" name="tin_number" value="{{ old('tin_number') }}" required>

        <label>Type</label>
            <select name="taxpayer_type">
                <option value="individual">Individual</option>
                <option value="business">Business</option>
            </select>

        <label>Business name</label>
            <input type="text" name="business_name" value="{{ old('business_name') }}">

        <label>NID</label>
            <input type="text" name="nid" value="{{ old('nid') }}">

        <label>Address</label>
            <textarea name="address">{{ old('address') }}</textarea>

        <button type="submit">Save</button>
    </form>
@endsection
