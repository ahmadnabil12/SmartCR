@extends('layouts.app')

@section('content')
    @push('styles')
    <style>
        /* Logo title style */
        .logo-title {
            font-family: 'Lobster', cursive;
            font-size: 2rem;
            color: #000;
            text-shadow: 1px 1px rgba(0,0,0,0.1);
        }
        /* Override Bootstrap primary button to teal, if not overridden globally */
        .btn-primary {
            background-color: #41acbc !important;
            border-color: #41acbc !important;
            color: #fff !important;
        }
        .btn-primary:hover {
            background-color: #338fa1 !important;
            border-color: #338fa1 !important;
        }
    </style>
    @endpush

    {{-- Center under the navbar --}}
    <div
      class="d-flex justify-content-center align-items-center"
      style="min-height: calc(80vh - 56px);"
    >
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-8">

            {{-- Two‐column card --}}
            <div class="card shadow-sm">
              <div class="row g-0">

                {{-- LEFT: Logo + SmartCR title --}}
                <div class="col-md-5 d-none d-md-flex flex-column justify-content-center align-items-center"
                     style="background-color:#f1f3f5; padding:2rem;">
                  <img
                    src="{{ asset('img/email.webp') }}"
                    alt="SmartCR Logo"
                    class="img-fluid"
                    style="max-width:80%; max-height:160px;"
                  >
                  <h2 class="logo-title mt-3">SmartCR</h2>
                </div>

                {{-- RIGHT: Reset Link form --}}
                <div class="col-md-7">
                  <div class="card-body p-4">
                    <h4 class="card-title text-center mb-4">{{ __('Forgot Password') }}</h4>

                    @if (session('status'))
                      <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                      </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                      @csrf

                      <div class="mb-3">
                        <label for="email" class="form-label">{{ __('Email Address') }}</label>
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

                      <div class="d-grid">
                        <button type="submit" class="btn btn-primary">
                          {{ __('Send Password Reset Link') }}
                        </button>
                      </div>
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
