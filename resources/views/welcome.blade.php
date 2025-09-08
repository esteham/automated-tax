<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Automated Tax System') }}</title>

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
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --light: #f8fafc;
            --dark: #0f172a;
            --gray: #64748b;
            --gray-light: #e2e8f0;
        }
        
        body {
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            min-height: 100vh;
            font-family: 'Figtree', sans-serif;
            color: var(--dark);
            line-height: 1.6;
        }
        
        .navbar {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }
        
        .hero {
            background: linear-gradient(135deg, #1e40af 0%, #1e3a8a 100%);
            color: white;
            padding: 5rem 0;
            position: relative;
            overflow: hidden;
        }
        
        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23ffffff' fill-opacity='0.05' fill-rule='evenodd'/%3E%3C/svg%3E");
            opacity: 0.5;
        }
        
        .hero-content {
            position: relative;
            z-index: 1;
        }
        
        .feature-card {
            background: white;
            border-radius: 1rem;
            padding: 2rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        
        .feature-icon {
            width: 3.5rem;
            height: 3.5rem;
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            font-size: 1.5rem;
        }
        
        .bg-primary-light {
            background-color: #dbeafe;
            color: var(--primary);
        }
        
        .bg-success-light {
            background-color: #d1fae5;
            color: var(--success);
        }
        
        .bg-warning-light {
            background-color: #fef3c7;
            color: var(--warning);
        }
        
        .bg-danger-light {
            background-color: #fee2e2;
            color: var(--danger);
        }
        
        .btn-primary {
            background-color: var(--primary);
            color: white;
            font-weight: 500;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
            text-align: center;
            display: inline-block;
            text-decoration: none;
            border: none;
            cursor: pointer;
            width: 100%;
            margin-top: auto;
        }
        
        .btn-primary:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
        }
        
        .btn-outline {
            background: transparent;
            border: 2px solid var(--primary);
            color: var(--primary);
        }
        
        .btn-outline:hover {
            background-color: var(--primary);
            color: white;
        }
        
        .stat-card {
            background: white;
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        
        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary);
            margin: 0.5rem 0;
        }
        
        .stat-label {
            color: var(--gray);
            font-size: 0.875rem;
        }
        
        .footer {
            background: var(--dark);
            color: white;
            padding: 4rem 0 2rem;
        }
        
        .footer a {
            color: var(--gray-light);
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .footer a:hover {
            color: white;
        }
        
        .footer-title {
            font-weight: 600;
            margin-bottom: 1.5rem;
            color: white;
        }
        
        .footer-links {
            list-style: none;
            padding: 0;
        }
        
        .footer-links li {
            margin-bottom: 0.75rem;
        }
        
        .social-links a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            margin-right: 0.75rem;
            transition: all 0.3s ease;
        }
        
        .social-links a:hover {
            background: var(--primary);
            transform: translateY(-3px);
        }
        
        .copyright {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 2rem;
            margin-top: 3rem;
            text-align: center;
            color: var(--gray);
            font-size: 0.875rem;
        }
        
        @media (max-width: 768px) {
            .hero {
                padding: 3rem 0;
            }
            
            .stat-number {
                font-size: 2rem;
            }
        }
        .btn-secondary {
            display: inline-block;
            width: 100%;
            max-width: 20rem;
            padding: 0.75rem 1.5rem;
            font-size: 1.125rem;
            font-weight: 500;
            color: #2563eb;
            background-color: white;
            border: 2px solid #2563eb;
            border-radius: 0.5rem;
            text-align: center;
            text-decoration: none;
            transition: background-color 0.2s;
        }
    </style>
</head>
<body class="antialiased">
    <!-- Navigation -->
    <nav class="navbar fixed w-full z-50">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <a href="{{ url('/') }}" class="text-2xl font-bold text-primary flex items-center">
                <i class="fas fa-file-invoice-dollar text-primary mr-2"></i>
                <span>Automated Tax</span>
            </a>
            
            <div class="hidden md:flex items-center space-x-6">
                <a href="#services" class="text-gray-700 hover:text-primary transition">Services</a>
                <a href="#how-it-works" class="text-gray-700 hover:text-primary transition">How It Works</a>
                <a href="#about" class="text-gray-700 hover:text-primary transition">About</a>
                <a href="#contact" class="text-gray-700 hover:text-primary transition">Contact</a>
                
                @auth
                    <a href="{{ route('dashboard') }}" class="btn-primary px-6 py-2 rounded-full text-sm font-medium">
                        Dashboard <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="text-primary font-medium hover:underline">Log in</a>
                    <a href="{{ route('register') }}" class="btn-primary px-6 py-2 rounded-full text-sm font-medium">
                        Get Started
                    </a>
                @endauth
            </div>
            
            <!-- Mobile menu button -->
            <button class="md:hidden text-gray-700 focus:outline-none">
                <i class="fas fa-bars text-2xl"></i>
            </button>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero pt-20">
        <div class="container mx-auto px-4">
            <div class="hero-content max-w-4xl mx-auto text-center">
                <h1 class="text-4xl md:text-5xl font-bold mb-6">Simplified Tax Filing for Everyone</h1>
                <p class="text-xl text-blue-100 mb-10 max-w-2xl mx-auto">File your taxes quickly, securely, and accurately with our automated tax filing system. Save time and avoid the hassle of traditional tax filing.</p>
                
                <div class="flex flex-col sm:flex-row justify-center gap-4 mb-16">
                    @auth
                        <a href="{{ route('tax.dashboard') }}" class="btn-primary px-8 py-4 text-lg font-semibold">
                            Go to Dashboard <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="btn-primary px-8 py-4 text-lg font-semibold">
                            Get Started for Free <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                        <a href="#how-it-works" class="btn-primary bg-transparent border-2 border-white hover:bg-white hover:bg-opacity-10 px-8 py-4 text-lg font-semibold">
                            How It Works <i class="fas fa-play-circle ml-2"></i>
                        </a>
                    @endauth
                </div>
                
                <div class="flex flex-wrap justify-center gap-8 mt-16">
                    <div class="stat-card">
                        <div class="stat-number">100,000+</div>
                        <div class="stat-label">Tax Returns Filed</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">৳5B+</div>
                        <div class="stat-label">In Refunds Processed</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">4.9/5</div>
                        <div class="stat-label">User Rating</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <main class="py-20">
        <!-- Services Section -->
        <section id="services" class="container mx-auto px-4 mb-20">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">Tax Services Made Simple</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Everything you need to file your taxes accurately and maximize your refund, all in one place.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- TIN Registration Card -->
                <div class="feature-card">
                    <div class="feature-icon bg-primary-light">
                        <i class="fas fa-id-card"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">TIN Registration</h3>
                    <p class="text-gray-600 mb-6">Get your Taxpayer Identification Number (TIN) quickly and easily. Our step-by-step process makes it simple.</p>
                    @auth
                        <a href="{{ route('taxpayers.create') }}" class="btn-primary">
                            Register for TIN <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="btn-primary">
                            Get Started <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    @endauth
                </div>
                
                <!-- File Return Card -->
                <div class="feature-card">
                    <div class="feature-icon bg-success-light">
                        <i class="fas fa-file-upload"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">File Tax Return</h3>
                    <p class="text-gray-600 mb-6">File your income tax return online in minutes. Our smart forms guide you through the process.</p>
                    @auth
                        <a href="{{ route('tax.returns.create') }}" class="btn-primary">
                            File Now <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="btn-primary">
                            File Now <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    @endauth
                </div>
                
                <!-- Tax Calculator Card -->
                <div class="feature-card">
                    <div class="feature-icon bg-warning-light">
                        <i class="fas fa-calculator"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Tax Calculator</h3>
                    <p class="text-gray-600 mb-6">Estimate your tax liability or refund with our easy-to-use tax calculator. No registration required.</p>
                    <a href="#tax-calculator" class="btn-primary">
                        Calculate Now <i class="fas fa-calculator ml-2"></i>
                    </a>
                </div>
                
                <!-- Track Refund Card -->
                <div class="feature-card">
                    <div class="feature-icon bg-primary-light">
                        <i class="fas fa-search-dollar"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Track Refund</h3>
                    <p class="text-gray-600 mb-6">Check the status of your tax refund in real-time. Get notified the moment your refund is processed.</p>
                    <a href="#track-refund" class="btn-primary">
                        Track Refund <i class="fas fa-search ml-2"></i>
                    </a>
                </div>
                
                <!-- Tax Payment Card -->
                <div class="feature-card">
                    <div class="feature-icon bg-danger-light">
                        <i class="fas fa-credit-card"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Pay Tax Online</h3>
                    <p class="text-gray-600 mb-6">Make secure tax payments online using bKash, Nagad, or your credit/debit card.</p>
                    <a href="#pay-tax" class="btn-primary">
                        Pay Now <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
                
                <!-- Help & Support Card -->
                <div class="feature-card">
                    <div class="feature-icon bg-success-light">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Help & Support</h3>
                    <p class="text-gray-600 mb-6">Need help? Our tax experts are available 24/7 to answer your questions and provide guidance.</p>
                    <a href="#contact" class="btn-primary">
                        Get Help <i class="fas fa-comments ml-2"></i>
                    </a>
                </div>
            </div>
        </section>
        
        <!-- How It Works Section -->
        <section id="how-it-works" class="bg-gray-50 py-20">
            <div class="container mx-auto px-4">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold mb-4">How It Works</h2>
                    <p class="text-gray-600 max-w-2xl mx-auto">Filing your taxes has never been easier. Follow these simple steps to complete your tax return.</p>
                </div>
                
                <div class="grid md:grid-cols-4 gap-8 max-w-5xl mx-auto">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-primary bg-opacity-10 rounded-full flex items-center justify-center text-primary text-2xl font-bold mx-auto mb-4">1</div>
                        <h3 class="text-lg font-semibold mb-2">Create Account</h3>
                        <p class="text-gray-600 text-sm">Sign up for free in just 2 minutes</p>
                    </div>
                    <div class="text-center">
                        <div class="w-16 h-16 bg-primary bg-opacity-10 rounded-full flex items-center justify-center text-primary text-2xl font-bold mx-auto mb-4">2</div>
                        <h3 class="text-lg font-semibold mb-2">Enter Your Information</h3>
                        <p class="text-gray-600 text-sm">Answer simple questions about your income and deductions</p>
                    </div>
                    <div class="text-center">
                        <div class="w-16 h-16 bg-primary bg-opacity-10 rounded-full flex items-center justify-center text-primary text-2xl font-bold mx-auto mb-4">3</div>
                        <h3 class="text-lg font-semibold mb-2">Review & Submit</h3>
                        <p class="text-gray-600 text-sm">Check your information and submit your return</p>
                    </div>
                    <div class="text-center">
                        <div class="w-16 h-16 bg-primary bg-opacity-10 rounded-full flex items-center justify-center text-primary text-2xl font-bold mx-auto mb-4">4</div>
                        <h3 class="text-lg font-semibold mb-2">Get Your Refund</h3>
                        <p class="text-gray-600 text-sm">Receive your refund directly to your bank account</p>
                    </div>
                </div>
                
                <div class="text-center mt-16">
                    <a href="{{ route('register') }}" class="btn-primary inline-flex items-center px-8 py-3 text-lg font-semibold">
                        Get Started for Free
                        <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
        </section>
        
        <!-- Tax Calculator Section -->
        <section id="tax-calculator" class="container mx-auto px-4 py-20">
            <div class="bg-white rounded-2xl shadow-xl p-8 md:p-12 max-w-4xl mx-auto">
                <div class="text-center mb-10">
                    <h2 class="text-3xl md:text-4xl font-bold mb-4">Tax Calculator</h2>
                    <p class="text-gray-600">Estimate your tax liability or refund for the current tax year</p>
                </div>
                
                <div class="grid md:grid-cols-2 gap-8">
                    <div>
                        <div class="mb-6">
                            <label class="block text-gray-700 font-medium mb-2">Filing Status</label>
                            <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                                <option>Single</option>
                                <option>Married Filing Jointly</option>
                                <option>Married Filing Separately</option>
                                <option>Head of Household</option>
                            </select>
                        </div>
                        
                        <div class="mb-6">
                            <label class="block text-gray-700 font-medium mb-2">Annual Income</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500">৳</span>
                                </div>
                                <input type="number" class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary" placeholder="0">
                            </div>
                        </div>
                        
                        <div class="mb-6">
                            <label class="block text-gray-700 font-medium mb-2">Tax Year</label>
                            <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                                <option>2024-2025</option>
                                <option>2023-2024</option>
                                <option>2022-2023</option>
                            </select>
                        </div>
                        
                        <button class="w-full bg-primary text-white py-3 px-6 rounded-lg font-medium hover:bg-primary-dark transition duration-300">
                            Calculate Tax
                        </button>
                    </div>
                    
                    <div class="bg-gray-50 p-6 rounded-xl">
                        <h3 class="text-xl font-bold mb-6">Your Estimated Tax</h3>
                        
                        <div class="space-y-4">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Taxable Income:</span>
                                <span class="font-medium">৳0</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Tax Rate:</span>
                                <span class="font-medium">0%</span>
                            </div>
                            <div class="h-px bg-gray-200 my-3"></div>
                            <div class="flex justify-between text-lg font-bold">
                                <span>Estimated Tax:</span>
                                <span class="text-primary">৳0</span>
                            </div>
                            <div class="flex justify-between text-lg font-bold">
                                <span>Estimated Refund:</span>
                                <span class="text-green-600">৳0</span>
                            </div>
                        </div>
                        
                        <div class="mt-8 text-center">
                            <p class="text-sm text-gray-500 mb-4">This is an estimate. For a more accurate calculation, please log in.</p>
                            <a href="{{ route('register') }}" class="inline-block w-full bg-white border-2 border-primary text-primary py-2 px-6 rounded-lg font-medium hover:bg-primary hover:text-white transition duration-300">
                                Sign Up for Free
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">
                <div>
                    <h3 class="footer-title">Automated Tax</h3>
                    <p class="text-gray-400 mb-4">Making tax filing simple, fast, and secure for individuals and businesses in Bangladesh.</p>
                    <div class="social-links flex mt-6">
                        <a href="#" class="hover:bg-blue-600"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="hover:bg-blue-400"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="hover:bg-pink-600"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="hover:bg-blue-700"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                
                <div>
                    <h3 class="footer-title">Quick Links</h3>
                    <ul class="footer-links">
                        <li><a href="#" class="hover:text-white">Home</a></li>
                        <li><a href="#services" class="hover:text-white">Services</a></li>
                        <li><a href="#how-it-works" class="hover:text-white">How It Works</a></li>
                        <li><a href="#about" class="hover:text-white">About Us</a></li>
                        <li><a href="#contact" class="hover:text-white">Contact</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="footer-title">Services</h3>
                    <ul class="footer-links">
                        <li><a href="#" class="hover:text-white">TIN Registration</a></li>
                        <li><a href="#" class="hover:text-white">File Tax Return</a></li>
                        <li><a href="#" class="hover:text-white">Tax Calculator</a></li>
                        <li><a href="#" class="hover:text-white">Track Refund</a></li>
                        <li><a href="#" class="hover:text-white">Pay Tax Online</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="footer-title">Contact Us</h3>
                    <ul class="footer-links">
                        <li class="flex items-start">
                            <i class="fas fa-map-marker-alt mt-1 mr-3 text-primary"></i>
                            <span>123 Tax Street, Dhaka 1212, Bangladesh</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-phone-alt mr-3 text-primary"></i>
                            <span>+880 1234 567890</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-envelope mr-3 text-primary"></i>
                            <span>info@automatedtax.com</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="copyright">
                <p>&copy; {{ date('Y') }} Automated Tax. All rights reserved.</p>
                <div class="mt-2 text-sm">
                    <a href="#" class="hover:text-white mr-4">Privacy Policy</a>
                    <a href="#" class="hover:text-white mr-4">Terms of Service</a>
                    <a href="#" class="hover:text-white">Sitemap</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        // Mobile menu toggle
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.querySelector('.md\:hidden');
            const mobileMenu = document.querySelector('.mobile-menu');
            
            if (mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener('click', function() {
                    mobileMenu.classList.toggle('hidden');
                });
            }
            
            // Smooth scrolling for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    
                    const targetId = this.getAttribute('href');
                    if (targetId === '#') return;
                    
                    const targetElement = document.querySelector(targetId);
                    if (targetElement) {
                        window.scrollTo({
                            top: targetElement.offsetTop - 80,
                            behavior: 'smooth'
                        });
                        
                        // Close mobile menu if open
                        if (mobileMenu && !mobileMenu.classList.contains('hidden')) {
                            mobileMenu.classList.add('hidden');
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>
