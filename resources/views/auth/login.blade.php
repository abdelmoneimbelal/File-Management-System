@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5 col-lg-4">
        <div class="card card-modern">
            <div class="card-body p-5">
                <div class="text-center mb-4">
                    <div class="mb-3">
                        <i class="bi bi-shield-lock" style="font-size: 3rem; color: var(--primary-color);"></i>
                    </div>
                    <h2 class="card-title fw-bold mb-2">Welcome Back</h2>
                    <p class="text-muted">Sign in to your account</p>
                </div>

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold">Email Address</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="bi bi-envelope"></i>
                            </span>
                            <input id="email" 
                                   name="email" 
                                   type="email" 
                                   class="form-control form-control-modern border-start-0 @error('email') is-invalid @enderror" 
                                   placeholder="your@email.com"
                                   value="{{ old('email') }}" 
                                   required 
                                   autofocus>
                        </div>
                        @error('email')
                            <div class="invalid-feedback d-block">
                                <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label fw-semibold">Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="bi bi-lock"></i>
                            </span>
                            <input id="password" 
                                   name="password" 
                                   type="password" 
                                   class="form-control form-control-modern border-start-0 @error('password') is-invalid @enderror" 
                                   placeholder="••••••••"
                                   required>
                        </div>
                        @error('password')
                            <div class="invalid-feedback d-block">
                                <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember">
                            <label class="form-check-label" for="remember">
                                Remember me
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary-modern w-100 text-white fw-semibold py-2">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
                    </button>
                </form>

                {{-- <div class="text-center mt-4">
                    <p class="text-muted mb-0">
                        Don't have an account? 
                        <a href="{{ route('register') }}" class="text-decoration-none fw-semibold" style="color: var(--primary-color);">
                            Sign up
                        </a>
                    </p>
                </div> --}}
            </div>
        </div>
    </div>
</div>
@endsection

