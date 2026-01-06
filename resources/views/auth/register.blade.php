@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
        <div class="card card-modern">
            <div class="card-body p-5">
                <div class="text-center mb-4">
                    <div class="mb-3">
                        <i class="bi bi-person-plus-fill" style="font-size: 3rem; color: var(--primary-color);"></i>
                    </div>
                    <h2 class="card-title fw-bold mb-2">Create Account</h2>
                    <p class="text-muted">Join us and start uploading files</p>
                </div>

                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold">Full Name</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="bi bi-person"></i>
                            </span>
                            <input id="name" 
                                   name="name" 
                                   type="text" 
                                   class="form-control form-control-modern border-start-0 @error('name') is-invalid @enderror" 
                                   placeholder="John Doe"
                                   value="{{ old('name') }}" 
                                   required 
                                   autofocus>
                        </div>
                        @error('name')
                            <div class="invalid-feedback d-block">
                                <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>

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
                                   required>
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
                        <label for="password_confirmation" class="form-label fw-semibold">Confirm Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="bi bi-lock-fill"></i>
                            </span>
                            <input id="password_confirmation" 
                                   name="password_confirmation" 
                                   type="password" 
                                   class="form-control form-control-modern border-start-0" 
                                   placeholder="••••••••"
                                   required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary-modern w-100 text-white fw-semibold py-2">
                        <i class="bi bi-person-check me-2"></i>Create Account
                    </button>
                </form>

                <div class="text-center mt-4">
                    <p class="text-muted mb-0">
                        Already have an account? 
                        <a href="{{ route('login') }}" class="text-decoration-none fw-semibold" style="color: var(--primary-color);">
                            Sign in
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

