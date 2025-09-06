<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - {{ config('app.name', 'CRM System') }}</title>
    
    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css?family=Inter:400,500,600,700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
    <style>
        .login-background {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            overflow: hidden;
        }
        
        .login-header {
            background: linear-gradient(135deg, #2563eb 0%, #3b82f6 100%);
            color: white;
            padding: 2rem;
            text-align: center;
        }
        
        .login-form {
            padding: 2rem;
        }
        
        .form-floating .form-control {
            border-radius: 12px;
            border: 2px solid #e2e8f0;
            padding: 1rem 1rem 1rem 1rem;
            height: 58px;
        }
        
        .form-floating .form-control:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }
        
        .btn-login {
            background: linear-gradient(135deg, #2563eb 0%, #3b82f6 100%);
            border: none;
            border-radius: 12px;
            padding: 12px 24px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-login:hover {
            background: linear-gradient(135deg, #1d4ed8 0%, #2563eb 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(37, 99, 235, 0.3);
        }
        
        .brand-logo {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #fff 0%, #f8fafc 100%);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            color: #2563eb;
            font-size: 1.8rem;
        }
        
        .floating-elements {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
            pointer-events: none;
        }
        
        .floating-elements::before,
        .floating-elements::after {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }
        
        .floating-elements::before {
            top: -150px;
            right: -150px;
            animation-delay: -3s;
        }
        
        .floating-elements::after {
            bottom: -150px;
            left: -150px;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }
        
        .error-feedback {
            background: rgba(220, 38, 38, 0.1);
            border: 1px solid rgba(220, 38, 38, 0.2);
            border-radius: 8px;
            padding: 0.5rem 0.75rem;
            margin-top: 0.5rem;
            color: #dc2626;
            font-size: 0.875rem;
        }
    </style>
</head>
<body>
    <div class="login-background">
        <div class="floating-elements"></div>
        
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-5">
                    <div class="login-card">
                        <div class="login-header">
                            <div class="brand-logo">
                                <i class="bi bi-grid-3x3-gap-fill"></i>
                            </div>
                            <h2 class="mb-2 fw-bold">Welcome Back!</h2>
                            <p class="mb-0 opacity-75">Sign in to your CRM dashboard</p>
                        </div>
                        
                        <div class="login-form">
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                
                                <div class="form-floating mb-3">
                                    <input id="email" type="email" 
                                           class="form-control @error('email') is-invalid @enderror" 
                                           name="email" 
                                           value="{{ old('email') }}" 
                                           required 
                                           autocomplete="email" 
                                           autofocus 
                                           placeholder="name@company.com">
                                    <label for="email">
                                        <i class="bi bi-envelope me-2"></i>Email Address
                                    </label>
                                    
                                    @error('email')
                                        <div class="error-feedback">
                                            <i class="bi bi-exclamation-circle me-1"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-floating mb-3">
                                    <input id="password" type="password" 
                                           class="form-control @error('password') is-invalid @enderror" 
                                           name="password" 
                                           required 
                                           autocomplete="current-password"
                                           placeholder="Password">
                                    <label for="password">
                                        <i class="bi bi-lock me-2"></i>Password
                                    </label>
                                    
                                    @error('password')
                                        <div class="error-feedback">
                                            <i class="bi bi-exclamation-circle me-1"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <label class="form-check-label text-muted" for="remember">
                                            Remember me
                                        </label>
                                    </div>
                                    
                                    @if (Route::has('password.request'))
                                        <a class="text-decoration-none" href="{{ route('password.request') }}">
                                            Forgot password?
                                        </a>
                                    @endif
                                </div>

                                <button type="submit" class="btn btn-primary btn-login w-100 mb-3">
                                    <i class="bi bi-box-arrow-in-right me-2"></i>
                                    Sign In
                                </button>
                                
                                @if (Route::has('register'))
                                    <div class="text-center">
                                        <span class="text-muted">Don't have an account?</span>
                                        <a href="{{ route('register') }}" class="text-decoration-none fw-semibold">Sign up</a>
                                    </div>
                                @endif
                            </form>
                        </div>
                    </div>
                    
                    <div class="text-center mt-4">
                        <small class="text-white opacity-75">
                            © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Add floating animation to background elements
    document.addEventListener('DOMContentLoaded', function() {
        const floatingElements = document.querySelectorAll('.floating-element');
        floatingElements.forEach((element, index) => {
            element.style.animationDelay = `${index * 0.5}s`;
        });
        
        // Add form validation
        const forms = document.querySelectorAll('.needs-validation');
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            });
        });
    });
</script>

</body>
</html>
