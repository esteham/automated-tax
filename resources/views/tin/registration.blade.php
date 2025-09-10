<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TIN Registration - Tax Portal</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @livewireStyles
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
      </div>
    </div>
  </header>

  <!-- Main Content -->
  <div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
      <div class="text-center mb-8">
        <h1 class="text-3xl font-extrabold text-gray-900">Taxpayer's Identification Number (TIN) Registration</h1>
        <p class="mt-2 text-sm text-gray-600">Please fill in the form below to register for a TIN</p>
      </div>
      
      <div class="bg-white py-8 px-6 shadow rounded-lg sm:px-10">
        @if (session('status'))
          <div class="mb-4 p-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
            {{ session('status') }}
          </div>
        @endif

        @if ($errors->any())
          <div class="mb-4 p-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
            <ul class="list-disc pl-5 space-y-1">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif
        
        <!-- Registration Form -->
        @livewire('tin.new-registration-form')
        
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
    </div>
  </div>

  @livewireScripts


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
