<div>
    <h1>Taxpayer: {{ $taxpayer->tin_number }}</h1>
    <p>Type: {{ $taxpayer->taxpayer_type }}</p>

    <h2>KYC Documents</h2>
    <ul>
        @foreach($taxpayer->getMedia('kyc_docs') as $document)
            <li>
                <a href="{{ $document->getUrl() }}" target="_blank">{{ $document->file_name }}</a>
            </li>
        @endforeach
    </ul>
</div>
