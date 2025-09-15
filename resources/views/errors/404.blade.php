@extends('layouts.error')

@section('title', __('Page Not Found'))

@section('code', '404')

@section('message')
    <div class="min-h-screen flex flex-col items-center justify-center bg-gray-100">
        <div class="max-w-md w-full p-6 bg-white rounded-lg shadow-md">
            <div class="text-center">
                <h1 class="text-6xl font-bold text-red-500">404</h1>
                <h2 class="text-2xl font-semibold text-gray-800 mt-4">Page Not Found</h2>
                <p class="text-gray-600 mt-2">The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.</p>
                
                <div class="mt-6">
                    <a href="{{ url('/') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition ease-in-out duration-150">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                        </svg>
                        Go to Homepage
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
