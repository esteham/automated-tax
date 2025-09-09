<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TIN Registration - Tax Portal</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 font-sans">
    <!-- Modern Header Navigation -->
    <header class="bg-gradient-to-r from-primary-700 to-primary-800 text-white shadow-lg">
        <div class="container mx-auto px-4 py-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                    </svg>
                    <div>
                        <h1 class="text-xl font-bold">Taxpayer's Portal</h1>
                        <p class="text-primary-100 text-sm">Government of Bangladesh</p>
                    </div>
                </div>
                
                
                
                <button class="md:hidden p-2 rounded-md hover:bg-primary-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
        
    </header>

    <div class="items-right justify-end hidden md:flex mt-3">
        <nav class="hidden md:flex space-x-1">
            <a href="{{ route('home') }}" class="px-4 py-2 rounded-md text-sm font-medium transition-all duration-200 hover:bg-primary-600 hover:text-white">Home</a>
            <a href="#" class="px-4 py-2 rounded-md text-sm font-medium transition-all duration-200 hover:bg-primary-600 hover:text-white">Login</a>
            <a href="#" class="px-4 py-2 rounded-md text-sm font-medium bg-primary-600 text-white shadow-sm">Registration</a>
            <a href="#" class="px-4 py-2 rounded-md text-sm font-medium transition-all duration-200 hover:bg-primary-600 hover:text-white">Forgot Password</a>
            <a href="#" class="px-4 py-2 rounded-md text-sm font-medium transition-all duration-200 hover:bg-primary-600 hover:text-white">Registration Process</a>
            <a href="#" class="px-4 py-2 rounded-md text-sm font-medium transition-all duration-200 hover:bg-primary-600 hover:text-white">Return Verification</a>
        </nav>
    </div>

    <div class="container mx-auto px-4 py-8">
        <!-- Main Content -->
        <main class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="p-8">
                <h1 class="text-2xl font-bold text-gray-800 mb-6">Welcome to Taxpayer's Identification Number (TIN) Registration / Cancellation</h1>
                
                <div class="prose max-w-none">
                    <p class="mb-4 text-gray-600">
                        Welcome to the Taxpayer's Identification Number (TIN) registration portal. This platform allows you to:
                    </p>
                    
                    <ul class="list-disc pl-6 mb-6 text-gray-600">
                        <li class="mb-2">Register for a new TIN (Taxpayer Identification Number)</li>
                        <li class="mb-2">Update your existing TIN information</li>
                        <li class="mb-2">Check the status of your TIN application</li>
                        <li class="mb-2">Download your TIN certificate</li>
                        <li>Request for TIN cancellation (if applicable)</li>
                    </ul>

                    <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-6 rounded-md">
                        <p class="text-blue-700 flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 mt-0.5 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                            <span><strong>Note:</strong> If you're a new user, please read the registration process before proceeding.</span>
                        </p>
                    </div>

                    <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                        <a href="#" class="bg-gradient-to-r from-primary-600 to-primary-700 text-white px-6 py-3 rounded-md font-medium shadow-md hover:from-primary-700 hover:to-primary-800 transition-all duration-300 transform hover:-translate-y-0.5 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            New Registration
                        </a>
                        <a href="#" class="bg-white border border-gray-300 text-gray-700 px-6 py-3 rounded-md font-medium shadow-sm hover:bg-gray-50 transition-all duration-300 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                            </svg>
                            Existing User Login
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Additional Info Section -->
            <div class="bg-gray-50 p-8 border-t border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Quick Links</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <a href="#" class="bg-white p-4 rounded-lg shadow-sm border border-gray-200 hover:border-primary-500 transition-all duration-200 group">
                        <div class="flex items-center">
                            <div class="bg-primary-50 p-2 rounded-md group-hover:bg-primary-100 transition-colors duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="font-medium text-gray-800 group-hover:text-primary-600">TIN Guidelines</h3>
                                <p class="text-sm text-gray-600">Learn about TIN requirements</p>
                            </div>
                        </div>
                    </a>
                    
                    <a href="#" class="bg-white p-4 rounded-lg shadow-sm border border-gray-200 hover:border-primary-500 transition-all duration-200 group">
                        <div class="flex items-center">
                            <div class="bg-primary-50 p-2 rounded-md group-hover:bg-primary-100 transition-colors duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="font-medium text-gray-800 group-hover:text-primary-600">Check Status</h3>
                                <p class="text-sm text-gray-600">Track your application</p>
                            </div>
                        </div>
                    </a>
                    
                    <a href="#" class="bg-white p-4 rounded-lg shadow-sm border border-gray-200 hover:border-primary-500 transition-all duration-200 group">
                        <div class="flex items-center">
                            <div class="bg-primary-50 p-2 rounded-md group-hover:bg-primary-100 transition-colors duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="font-medium text-gray-800 group-hover:text-primary-600">Download Certificate</h3>
                                <p class="text-sm text-gray-600">Get your TIN certificate</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </main>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-12 py-8">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-4 md:mb-0">
                    <p class="text-gray-400">© 2023 Taxpayer's Portal. Government of Bangladesh.</p>
                </div>
                <div class="flex space-x-6">
                    <a href="#" class="text-gray-400 hover:text-white transition-colors duration-200">Privacy Policy</a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors duration-200">Terms of Service</a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors duration-200">Contact</a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>