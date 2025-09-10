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

        // Toggle between login and registration forms
        document.addEventListener('DOMContentLoaded', function() {
            const loginBtn = document.getElementById('login-btn');
            const registerBtn = document.getElementById('register-btn');
            const loginForm = document.getElementById('login-form');
            const registerForm = document.getElementById('register-form');

            if (loginBtn && registerBtn && loginForm && registerForm) {
                loginBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    loginForm.classList.remove('hidden');
                    registerForm.classList.add('hidden');
                    loginBtn.classList.add('bg-primary-600', 'text-white');
                    loginBtn.classList.remove('text-gray-700', 'bg-white');
                    registerBtn.classList.remove('bg-primary-600', 'text-white');
                    registerBtn.classList.add('text-gray-700', 'bg-white');
                });

                registerBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    registerForm.classList.remove('hidden');
                    loginForm.classList.add('hidden');
                    registerBtn.classList.add('bg-primary-600', 'text-white');
                    registerBtn.classList.remove('text-gray-700', 'bg-white');
                    loginBtn.classList.remove('bg-primary-600', 'text-white');
                    loginBtn.classList.add('text-gray-700', 'bg-white');
                });
            }
        });
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
    </div>
  </header>

  <!-- Main Content -->
  <div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
      <div class="text-center mb-8">
        <h1 class="text-3xl font-extrabold text-gray-900">Taxpayer's Portal</h1>
        <p class="mt-2 text-sm text-gray-600">Access your account or register for a new TIN</p>
      </div>
      
      <!-- Toggle Buttons -->
      <div class="flex mb-8 bg-white rounded-lg shadow-sm overflow-hidden max-w-md mx-auto">
        <button id="login-btn" class="flex-1 py-3 px-4 text-center font-medium bg-primary-600 text-white">
          Login
        </button>
        <button id="register-btn" class="flex-1 py-3 px-4 text-center font-medium text-gray-700 bg-white">
          Register for TIN
        </button>
      </div>
      
      <div class="bg-white py-8 px-6 shadow rounded-lg sm:px-10">
        <!-- Login Form -->
        <div id="login-form" class="hidden">
          <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Login to Your Account</h2>
          
          @if (session('status'))
            <div class="mb-4 p-4 text-sm text-green-800 rounded-lg bg-green-50" role="alert">
              {{ session('status') }}
            </div>
          @endif

          @if ($errors->any())
            <div class="mb-4 p-4 text-sm text-red-800 rounded-lg bg-red-50" role="alert">
              <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif
          
          <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf
            
            <!-- Email -->
            <div>
              <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
              <div class="mt-1">
                <input id="email" name="email" type="email" autocomplete="email" required 
                       class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm"
                       value="{{ old('email') }}">
              </div>
            </div>
            
            <!-- Password -->
            <div>
              <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
              <div class="mt-1">
                <input id="password" name="password" type="password" autocomplete="current-password" required 
                       class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
              </div>
            </div>
            
            <!-- Remember Me -->
            <div class="flex items-center justify-between">
              <div class="flex items-center">
                <input id="remember_me" name="remember" type="checkbox" 
                       class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                <label for="remember_me" class="ml-2 block text-sm text-gray-700">
                  Remember me
                </label>
              </div>
              
              @if (Route::has('password.request'))
                <div class="text-sm">
                  <a href="{{ route('password.request') }}" class="font-medium text-primary-600 hover:text-primary-500">
                    Forgot your password?
                  </a>
                </div>
              @endif
            </div>
            
            <!-- Submit Button -->
            <div>
              <button type="submit" 
                      class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                Sign in
              </button>
            </div>
          </form>
          
          <div class="mt-6">
            <div class="relative">
              <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-300"></div>
              </div>
              <div class="relative flex justify-center text-sm">
                <span class="px-2 bg-white text-gray-500">
                  Don't have an account?
                </span>
              </div>
            </div>
            
            <div class="mt-6">
              <button id="register-switch" class="w-full flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                Register for a new TIN
              </button>
            </div>
          </div>
        </div>
        
        <!-- Registration Form -->
        <div id="register-form">
          
          @if (session('status'))
            <div class="mb-4 p-4 text-sm text-green-800 rounded-lg bg-green-50" role="alert">
              {{ session('status') }}
            </div>
          @endif

          @if ($errors->any())
            <div class="mb-4 p-4 text-sm text-red-800 rounded-lg bg-red-50" role="alert">
              <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif
          
          <!-- Registration Form -->
          @livewire('tin.registration-form')
          
          <div class="mt-6">
            <div class="relative">
              <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-300"></div>
              </div>
              <div class="relative flex justify-center text-sm">
                <span class="px-2 bg-white text-gray-500">
                  Already have an account?
                </span>
              </div>
            </div>
            
            <div class="mt-6">
              <button id="login-switch" class="w-full flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                Sign in to your account
              </button>
            </div>
          </div>
        </div>
        
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

  <script>
    // Add event listeners for the switch buttons
    document.addEventListener('DOMContentLoaded', function() {
      const loginForm = document.getElementById('login-form');
      const registerForm = document.getElementById('register-form');
      const loginBtn = document.getElementById('login-btn');
      const registerBtn = document.getElementById('register-btn');
      const loginSwitch = document.getElementById('login-switch');
      const registerSwitch = document.getElementById('register-switch');
      
      if (loginSwitch) {
        loginSwitch.addEventListener('click', function(e) {
          e.preventDefault();
          loginForm.classList.remove('hidden');
          registerForm.classList.add('hidden');
          loginBtn.click(); // Trigger the tab button click to update UI
        });
      }
      
      if (registerSwitch) {
        registerSwitch.addEventListener('click', function(e) {
          e.preventDefault();
          registerForm.classList.remove('hidden');
          loginForm.classList.add('hidden');
          registerBtn.click(); // Trigger the tab button click to update UI
        });
      }
      
      // Show login form if there are login errors
      const loginErrors = document.querySelector('#login-form .text-red-800');
      if (loginErrors) {
        loginForm.classList.remove('hidden');
        registerForm.classList.add('hidden');
        loginBtn.classList.add('bg-primary-600', 'text-white');
        loginBtn.classList.remove('text-gray-700', 'bg-white');
        registerBtn.classList.remove('bg-primary-600', 'text-white');
        registerBtn.classList.add('text-gray-700', 'bg-white');
      }
    });
  </script>

  <!-- Footer -->
  <footer class="bg-gray-800 text-white mt-12 py-8">
    <div class="container mx-auto px-4 flex flex-col md:flex-row justify-between items-center">
      <p class="text-gray-400 mb-4 md:mb-0"> 2023 Taxpayer's Portal. Government of Bangladesh.</p>
      <div class="flex space-x-6">
        <a href="#" class="text-gray-400 hover:text-white">Privacy Policy</a>
        <a href="#" class="text-gray-400 hover:text-white">Terms of Service</a>
        <a href="#" class="text-gray-400 hover:text-white">Contact</a>
      </div>
    </div>
  </footer>
</body>
</html>
