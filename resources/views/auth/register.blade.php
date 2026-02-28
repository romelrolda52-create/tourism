<x-guest-layout>
    <div class="min-h-screen flex flex-col md:flex-row">
        <!-- Left side with background/design -->
        <div class="hidden md:flex md:w-1/2 bg-gradient-to-br from-purple-600 to-indigo-900 p-8 flex-col justify-between relative overflow-hidden">
            <!-- Animated background elements -->
            <div class="absolute inset-0 overflow-hidden">
                <div class="absolute -top-40 -right-40 w-80 h-80 bg-purple-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>
                <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-indigo-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>
            </div>
            
            <div class="relative">
                <a href="/" class="text-white text-2xl font-bold flex items-center">
                    <svg class="w-8 h-8 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                    YourApp
                </a>
            </div>
            <div class="relative text-white max-w-md">
                <h1 class="text-4xl font-bold mb-6">Join Our Community</h1>
                <p class="text-lg opacity-90 mb-8">Create your account and start your journey with us. Get access to exclusive features and content.</p>
                
                <!-- Features list -->
                <div class="space-y-4">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 mr-3 text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Secure and encrypted data</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 mr-3 text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Access to all features</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 mr-3 text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>24/7 Customer support</span>
                    </div>
                </div>
            </div>
            <div class="relative text-white opacity-80">
                <p class="text-sm">Already have an account? 
                    <a href="{{ route('login') }}" class="font-semibold underline hover:text-white transition duration-200">
                        Sign in here
                    </a>
                </p>
            </div>
        </div>

        <!-- Right side with registration form -->
        <div class="w-full md:w-1/2 flex items-center justify-center p-6 bg-gradient-to-b from-gray-50 to-white">
            <div class="w-full max-w-lg">
                <!-- Mobile header -->
                <div class="mb-8 md:hidden text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-purple-600 to-indigo-600 rounded-2xl shadow-lg mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                    </div>
                    <h1 class="text-3xl font-bold text-gray-800">Create Account</h1>
                    <p class="text-gray-600 mt-2">Join our community today</p>
                </div>

                <!-- Registration card -->
                <div class="bg-white rounded-2xl shadow-xl p-8 md:p-10">
                    <!-- Desktop header -->
                    <div class="hidden md:block text-center mb-10">
                        <h2 class="text-3xl font-bold text-gray-800">Get Started</h2>
                        <p class="text-gray-600 mt-2">Fill in your details to create your account</p>
                    </div>

                    <form method="POST" action="{{ route('register') }}" class="space-y-6">
                        @csrf

                        <!-- Name -->
                        <div>
                            <x-input-label for="name" :value="__('Full Name')" class="mb-2 block text-sm font-medium text-gray-700" />
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <x-text-input 
                                    id="name" 
                                    class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition duration-200 placeholder-gray-400"
                                    type="text" 
                                    name="name" 
                                    :value="old('name')" 
                                    required 
                                    autofocus 
                                    autocomplete="name"
                                    placeholder="John Doe"
                                />
                            </div>
                            <x-input-error :messages="$errors->get('name')" class="mt-2 text-sm text-red-600" />
                        </div>

                        <!-- Email Address -->
                        <div>
                            <x-input-label for="email" :value="__('Email Address')" class="mb-2 block text-sm font-medium text-gray-700" />
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <x-text-input 
                                    id="email" 
                                    class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition duration-200 placeholder-gray-400"
                                    type="email" 
                                    name="email" 
                                    :value="old('email')" 
                                    required 
                                    autocomplete="email"
                                    placeholder="john@example.com"
                                />
                            </div>
                            <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-600" />
                        </div>

                        <!-- Role Selection -->
                        <div>
                            <x-input-label for="role" :value="__('Account Type')" class="mb-2 block text-sm font-medium text-gray-700" />
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                </div>
                                <select name="role" id="role" class="block w-full pl-10 pr-10 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition duration-200 appearance-none bg-white" required>
                                    <option value="user" {{ old('role', 'user') === 'user' ? 'selected' : '' }}>Regular User</option>
                                    <!-- Add more options if needed -->
                                </select>
                                  <select name="role" id="role" class="block w-full pl-10 pr-10 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition duration-200 appearance-none bg-white" required>
                                    <option value="admin" {{ old('role', 'admin') === 'admin' ? 'selected' : '' }}>Admin</option>
                                    <!-- Add more options if needed -->
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                            <p class="mt-2 text-sm text-gray-500">Select your preferred account type</p>
                        </div>

                        <!-- Password -->
                        <div>
                            <x-input-label for="password" :value="__('Password')" class="mb-2 block text-sm font-medium text-gray-700" />
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
                                </div>
                                <x-text-input 
                                    id="password" 
                                    class="block w-full pl-10 pr-10 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition duration-200"
                                    type="password"
                                    name="password"
                                    required 
                                    autocomplete="new-password"
                                    placeholder="••••••••"
                                />
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                    <button type="button" id="togglePassword" class="text-gray-400 hover:text-gray-600 focus:outline-none">
                                        <svg id="passwordEyeIcon" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="mt-3">
                                <div class="flex items-center mb-1">
                                    <div id="passwordStrength" class="h-2 w-full bg-gray-200 rounded-full overflow-hidden">
                                        <div id="passwordStrengthBar" class="h-full bg-gray-400 transition-all duration-300"></div>
                                    </div>
                                </div>
                                <p id="passwordStrengthText" class="text-xs text-gray-500">Password strength: <span class="font-medium">None</span></p>
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-600" />
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="mb-2 block text-sm font-medium text-gray-700" />
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                    </svg>
                                </div>
                                <x-text-input 
                                    id="password_confirmation" 
                                    class="block w-full pl-10 pr-10 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition duration-200"
                                    type="password"
                                    name="password_confirmation" 
                                    required 
                                    autocomplete="new-password"
                                    placeholder="••••••••"
                                />
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                    <button type="button" id="toggleConfirmPassword" class="text-gray-400 hover:text-gray-600 focus:outline-none">
                                        <svg id="confirmPasswordEyeIcon" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-sm text-red-600" />
                        </div>

                        <!-- Terms and Conditions -->
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="terms" name="terms" type="checkbox" class="focus:ring-purple-500 h-4 w-4 text-purple-600 border-gray-300 rounded" required>
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="terms" class="font-medium text-gray-700">
                                    I agree to the 
                                    <a href="#" class="text-purple-600 hover:text-purple-500 font-semibold">Terms of Service</a> 
                                    and 
                                    <a href="#" class="text-purple-600 hover:text-purple-500 font-semibold">Privacy Policy</a>
                                </label>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-4">
                            <x-primary-button class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-lg text-sm font-medium text-white bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition duration-200 transform hover:-translate-y-0.5">
                                {{ __('Create Account') }}
                                <svg class="ml-2 -mr-1 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                                </svg>
                            </x-primary-button>
                        </div>

                        <!-- Login link -->
                        <div class="text-center pt-6">
                            <p class="text-sm text-gray-600">
                                Already have an account?
                                <a href="{{ route('login') }}" class="font-semibold text-purple-600 hover:text-purple-500 transition duration-200">
                                    Sign in
                                </a>
                            </p>
                        </div>
                    </form>
                </div>
                
                <!-- Mobile footer -->
                <div class="mt-8 text-center text-sm text-gray-500 md:hidden">
                    <p>By creating an account, you agree to our Terms and Privacy Policy</p>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for enhanced features -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Password toggle functionality
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');
            const passwordEyeIcon = document.getElementById('passwordEyeIcon');
            
            const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
            const confirmPasswordInput = document.getElementById('password_confirmation');
            const confirmPasswordEyeIcon = document.getElementById('confirmPasswordEyeIcon');
            
            // Toggle main password
            if (togglePassword && passwordInput) {
                togglePassword.addEventListener('click', function() {
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);
                    
                    if (type === 'text') {
                        passwordEyeIcon.innerHTML = `
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L6.59 6.59m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                        `;
                    } else {
                        passwordEyeIcon.innerHTML = `
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        `;
                    }
                });
            }
            
            // Toggle confirm password
            if (toggleConfirmPassword && confirmPasswordInput) {
                toggleConfirmPassword.addEventListener('click', function() {
                    const type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    confirmPasswordInput.setAttribute('type', type);
                    
                    if (type === 'text') {
                        confirmPasswordEyeIcon.innerHTML = `
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L6.59 6.59m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                        `;
                    } else {
                        confirmPasswordEyeIcon.innerHTML = `
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        `;
                    }
                });
            }
            
            // Password strength indicator
            const passwordStrengthBar = document.getElementById('passwordStrengthBar');
            const passwordStrengthText = document.getElementById('passwordStrengthText');
            
            if (passwordInput && passwordStrengthBar && passwordStrengthText) {
                passwordInput.addEventListener('input', function() {
                    const password = passwordInput.value;
                    let strength = 0;
                    let text = 'None';
                    let color = 'bg-gray-400';
                    let width = '0%';
                    
                    // Check password strength
                    if (password.length > 0) {
                        strength++;
                        width = '25%';
                        text = 'Very Weak';
                        color = 'bg-red-500';
                    }
                    
                    if (password.length >= 8) {
                        strength++;
                        width = '50%';
                        text = 'Weak';
                        color = 'bg-orange-500';
                    }
                    
                    if (/[A-Z]/.test(password) && /[a-z]/.test(password)) {
                        strength++;
                        width = '75%';
                        text = 'Good';
                        color = 'bg-yellow-500';
                    }
                    
                    if (/[0-9]/.test(password) && /[^A-Za-z0-9]/.test(password)) {
                        strength++;
                        width = '100%';
                        text = 'Strong';
                        color = 'bg-green-500';
                    }
                    
                    // Update display
                    passwordStrengthBar.className = `h-full ${color} transition-all duration-300`;
                    passwordStrengthBar.style.width = width;
                    passwordStrengthText.innerHTML = `Password strength: <span class="font-medium">${text}</span>`;
                });
            }
            
            // Real-time password confirmation check
            if (passwordInput && confirmPasswordInput) {
                const checkPasswords = () => {
                    if (passwordInput.value && confirmPasswordInput.value) {
                        if (passwordInput.value === confirmPasswordInput.value) {
                            confirmPasswordInput.classList.remove('border-red-300');
                            confirmPasswordInput.classList.add('border-green-300');
                        } else {
                            confirmPasswordInput.classList.remove('border-green-300');
                            confirmPasswordInput.classList.add('border-red-300');
                        }
                    } else {
                        confirmPasswordInput.classList.remove('border-red-300', 'border-green-300');
                        confirmPasswordInput.classList.add('border-gray-300');
                    }
                };
                
                passwordInput.addEventListener('input', checkPasswords);
                confirmPasswordInput.addEventListener('input', checkPasswords);
            }
        });
    </script>
</x-guest-layout>