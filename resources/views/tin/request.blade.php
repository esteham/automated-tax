@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-2xl font-semibold text-gray-900 mb-6">Request for TIN Number</h2>
                    
                    @if (session('error'))
                        <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-500 text-red-700">
                            <p>{{ session('error') }}</p>
                        </div>
                    @endif
                    
                    @if (session('message'))
                        <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700">
                            <p>{{ session('message') }}</p>
                        </div>
                    @endif
                    
                    @if ($errors->any())
                        <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-500 text-red-700">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <livewire:tin.request-tin-number />
                </div>
            </div>
        </div>
    </div>
@endsection
