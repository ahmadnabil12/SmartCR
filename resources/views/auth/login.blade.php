@extends('layouts.app')

@section('content')
    {{-- Custom font for the logo title (we already loaded Lobster in your layout) --}}
    <style>
        .logo-title {
            font-family: 'Lobster', cursive;
            font-size: 2rem;
            color: #000000;
            text-shadow: 1px 1px rgba(0,0,0,0.1);
        }
    </style>

    {{-- Full‐screen flex wrapper (minus 56px navbar) --}}
    <div
      class="d-flex justify-content-center align-items-center"
      style="min-height: calc(80vh - 56px);"
    >
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-8">

            {{-- Card with two panes --}}
            <div class="card shadow-sm">
              <div class="row g-0">

                {{-- LEFT: Logo + “SmartCR” title --}}
                <div class="col-md-5 d-none d-md-flex flex-column justify-content-center align-items-center"
                     style="background-color:#f1f3f5; padding:2rem;">
                  <img 
                    src="{{ asset('img/SmartCR_Logo_only.png') }}" 
                    alt="SmartCR Logo" 
                    class="img-fluid" 
                    style="max-width:80%; max-height:160px;"
                  >
                  <h2 class="logo-title mt-3">SmartCR</h2>
                </div>

                {{-- RIGHT: The standard Laravel login form --}}
                <div class="col-md-7">
                  <div class="card-body p-4">

                    <h4 class="card-title text-center mb-4">Sign into your account</h4>

                    <form method="POST" action="{{ route('login') }}">
                      @csrf

                      <div class="mb-3">
                        <label for="email" class="form-label">
                          {{ __('Email Address') }}
                        </label>
                        <input 
                          id="email" 
                          type="email" 
                          class="form-control @error('email') is-invalid @enderror" 
                          name="email" 
                          value="{{ old('email') }}" 
                          required autocomplete="email" autofocus
                        >
                        @error('email')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>

                      <div class="mb-3">
                        <label for="password" class="form-label">
                          {{ __('Password') }}
                        </label>
                        <input 
                          id="password" 
                          type="password" 
                          class="form-control @error('password') is-invalid @enderror" 
                          name="password" 
                          required autocomplete="current-password"
                        >
                        @error('password')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>

                      <div class="mb-3 form-check">
                        <input 
                          class="form-check-input" 
                          type="checkbox" 
                          name="remember" 
                          id="remember" 
                          {{ old('remember') ? 'checked' : '' }}
                        >
                        <label class="form-check-label" for="remember">
                          {{ __('Remember Me') }}
                        </label>
                      </div>

                      <div class="d-grid">
                        <button type="submit" class="btn btn-primary">
                          {{ __('Login') }}
                        </button>
                      </div>

                      @if (Route::has('password.request'))
                        <div class="mt-3 text-center">
                          <a class="btn btn-link small" href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                          </a>
                        </div>
                      @endif

                    </form>

                  </div>
                </div>

              </div>
            </div>
            {{-- /Card --}}

          </div>
        </div>
      </div>
    </div>
@endsection
