<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>File Tax Return - {{ config('app.name', 'Automated Tax System') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        :root {
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --secondary: #4f46e5;
            --light: #f8fafc;
            --dark: #0f172a;
            --gray: #64748b;
        }
        
        body {
            background: #f8fafc;
            min-height: 100vh;
            font-family: 'Figtree', sans-serif;
            color: var(--dark);
            line-height: 1.6;
        }
        
        .navbar {
            background: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .banner {
            background: linear-gradient(135deg, #1e40af 0%, #1e3a8a 100%);
            color: white;
            padding: 3rem 0;
            text-align: center;
        }
        
        .nav-links {
            background: white;
            padding: 1rem 0;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        
        .nav-links a {
            color: var(--gray);
            text-decoration: none;
            margin: 0 1rem;
            font-weight: 500;
            transition: color 0.2s;
        }
        
        .nav-links a:hover {
            color: var(--primary);
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }
        
        .content {
            padding: 3rem 0;
        }
        
        .btn {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
            border: none;
            text-decoration: none;
        }
        
        .btn-primary {
            background: var(--primary);
            color: white;
        }
        
        .btn-primary:hover {
            background: var(--primary-dark);
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <!-- <nav class="navbar">
        <div class="container">
            <div class="flex justify-between items-center py-4">
                <a href="{{ route('home') }}" class="text-2xl font-bold text-primary">
                    {{ config('app.name', 'Automated Tax System') }}
                </a>
                <div>
                    <a href="{{ route('login') }}" class="btn btn-outline">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-primary ml-4">Register</a>
                </div>
            </div>
        </div>
    </nav> -->

    <!-- Banner -->
    <header class="banner">
        <div class="container">
            <h1 class="text-3xl md:text-4xl font-bold mb-4">File Your Tax Return</h1>
            <p class="text-xl opacity-90">Quick, easy, and secure way to file your taxes online</p>
        </div>
    </header>

    <!-- Navigation Links -->
    <div class="nav-links">
        <div class="container">
            <nav class="flex items-center">
                <a href="{{ route('home') }}">Home</a>
                <a href="{{ route('login') }}">Login</a>
                <a href="{{ route('register') }}">Registration</a>
                <a href="{{ route('tin.registration') }}">TIN Registration</a>
            </nav>
        </div>
    </div>

    <!-- Main Content -->
    <main class="content">
        <div class="container">
            <div class="bg-white rounded-lg shadow-md p-8">
                <h2 class="text-2xl font-bold mb-6">File Your Tax Return</h2>
                <p class="text-gray-700 mb-6">
                    Welcome to our tax filing system. Please log in to start filing your tax return. 
                    If you don't have an account, you can register for free.
                </p>
                <div class="flex space-x-4">
                    <a href="{{ route('login') }}" class="btn btn-primary">Login to File Return</a>
                    <a href="{{ route('register') }}" class="btn" style="border: 1px solid var(--gray);">Create Account</a>
                </div>
            </div>
        </div>
    </main>

    @stack('scripts')
</body>
</html>
