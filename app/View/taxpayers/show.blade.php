@extends('layouts.app')

@section('content')

<h1>Taxpayer: {{ $taxpayer->tin_number }}</h1>
<p>Type: {{ $taxpayer->taxpayer_type }}</p>
<p>Owner: {{ $taxpayer->user->name }} (ID {{ $taxpayer->user_id }})</p>

<h2>KYC Documents</h2>
<ul>
  @forelse($kyc as $doc)
    <li>
        <a href="{{ $doc->getFullUrl() }}" target="_blank">{{ $doc->file_name }}</a>

        @can('update', $taxpayer)
            <form method="POST" action="{{ route('taxpayers.kyc.destroy', [$taxpayer, $doc->id]) }}" style="display:inline">
                @csrf @method('DELETE')
                <button type="submit">Delete</button>
            </form>
        @endcan
    </li>
  @empty
    <li>No KYC uploaded yet.</li>
  @endforelse
</ul>

@can('update', $taxpayer)

<h3>Upload new KYC</h3>
    <form method="POST" action="{{ route('taxpayers.kyc.upload', $taxpayer) }}" enctype="multipart/form-data">
        @csrf
        <input type="file" name="file" required>
        <button type="submit">Upload</button>
    </form>
@endcan

@endsection
