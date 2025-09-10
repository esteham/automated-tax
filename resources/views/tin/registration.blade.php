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
  <!-- Header -->
  <header class="bg-gradient-to-r from-primary-700 to-primary-800 text-white shadow-lg">
    <div class="container mx-auto px-4 py-3 flex items-center justify-between">
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
  </header>

  <!-- Top Nav -->
  <div class="hidden md:flex justify-end my-5">
    <nav class="flex space-x-1">
      <a href="{{ route('home') }}" class="px-4 py-2 rounded-md text-sm font-medium hover:bg-primary-600 hover:text-white">Home</a>
      <a href="#" class="px-4 py-2 rounded-md text-sm font-medium hover:bg-primary-600 hover:text-white">Login</a>
      <a href="#" class="px-4 py-2 rounded-md text-sm font-medium bg-primary-600 text-white shadow-sm">Registration</a>
      <a href="#" class="px-4 py-2 rounded-md text-sm font-medium hover:bg-primary-600 hover:text-white">Forgot Password</a>
      <a href="#" class="px-4 py-2 rounded-md text-sm font-medium hover:bg-primary-600 hover:text-white">Registration Process</a>
      <a href="#" class="px-4 py-2 rounded-md text-sm font-medium hover:bg-primary-600 hover:text-white">Return Verification</a>
    </nav>
  </div>

  <!-- Main Content -->
<div class="container mx-auto px-4 py-8">
  <main class="bg-white rounded-xl shadow-lg overflow-hidden">
    <div class="p-8">
      <h1 class="text-2xl font-bold text-gray-800 mb-6 text-center">Taxpayer's Identification Number (TIN) Registration</h1>
      
      <div class="max-w-4xl mx-auto">
        <!-- Registration Form -->
        @livewire('tin.registration-form')
        
        <div class="mt-8 bg-blue-50 border-l-4 border-blue-400 p-4 rounded-md">
          <p class="text-blue-700 flex items-start">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 mt-0.5 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
            </svg>
            <span>
              <strong>Note:</strong> Please ensure all information provided is accurate. 
              Your TIN will be used for all tax-related transactions with the government.
            </span>
          </p>
        </div>
      </div>

    <!-- Right Sidebar -->
    <div class="bg-gray-50 p-8 border-t md:border-t-0 md:border-l border-gray-200 md:w-1/4 flex flex-col justify-start md:justify-between">
      <h2 class="text-lg font-semibold text-gray-800 mb-4">Quick Links</h2>
      <div class="flex flex-col gap-3">
        <a href="#" class="bg-primary-600 text-white px-4 py-3 rounded-md font-medium shadow-md hover:bg-primary-700 transition flex items-center justify-center">
          TIN Guidelines
        </a>
        <a href="#" class="bg-primary-600 text-white px-4 py-3 rounded-md font-medium shadow-md hover:bg-primary-700 transition flex items-center justify-center">
            Check Status
        </a>
        <a href="#" class="bg-primary-600 text-white px-4 py-3 rounded-md font-medium shadow-md hover:bg-primary-700 transition flex items-center justify-center">
            Download Certificate
        </a>
      </div>
    </div>
  </main>
</div>


  <!-- Footer -->
  <footer class="bg-gray-800 text-white mt-12 py-8">
    <div class="container mx-auto px-4 flex flex-col md:flex-row justify-between items-center">
      <p class="text-gray-400 mb-4 md:mb-0">© 2023 Taxpayer's Portal. Government of Bangladesh.</p>
      <div class="flex space-x-6">
        <a href="#" class="text-gray-400 hover:text-white">Privacy Policy</a>
        <a href="#" class="text-gray-400 hover:text-white">Terms of Service</a>
        <a href="#" class="text-gray-400 hover:text-white">Contact</a>
      </div>
    </div>
  </footer>
</body>
</html>
