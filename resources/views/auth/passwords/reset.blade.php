@extends('layouts.app')

@section('content')
    @push('styles')
    <style>
        /* Logo title style (uses Lobster from your layout's head) */
        .logo-title {
            font-family: 'Lobster', cursive;
            font-size: 2rem;
            color: #000;               /* pure black */
            text-shadow: 1px 1px rgba(0,0,0,0.1);
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

            {{-- Card with logo pane + form pane --}}
            <div class="card shadow-sm">
              <div class="row g-0">

                {{-- LEFT: Logo + SmartCR title --}}
                <div class="col-md-5 d-none d-md-flex flex-column justify-content-center align-items-center"
                     style="background-color:#f1f3f5; padding:2rem;">
                  <img
                    src="{{ asset('img/resetpass.png') }}"
                    alt="SmartCR Logo"
                    class="img-fluid"
                    style="max-width:80%; max-height:160px;"
                  >
                  <h2 class="logo-title mt-3">SmartCR</h2>
                </div>

                {{-- RIGHT: Reset Password form --}}
                <div class="col-md-7">
                  <div class="card-body p-4">
                    <h4 class="card-title text-center mb-4">{{ __('Reset Password') }}</h4>

                    <form method="POST" action="{{ route('password.update') }}">
                      @csrf
                      <input type="hidden" name="token" value="{{ $token }}">

                      <div class="mb-3">
                        <label for="email" class="form-label">{{ __('Email Address') }}</label>
                        <input
                          id="email"
                          type="email"
                          class="form-control @error('email') is-invalid @enderror"
                          name="email"
                          value="{{ $email ?? old('email') }}"
                          required autocomplete="email" autofocus
                        >
                        @error('email')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>

                      <div class="mb-3">
                        <label for="password" class="form-label">{{ __('Password') }}</label>
                        <input
                          id="password"
                          type="password"
                          class="form-control @error('password') is-invalid @enderror"
                          name="password"
                          required autocomplete="new-password"
                        >
                        @error('password')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>

                      <div class="mb-3">
                        <label for="password-confirm" class="form-label">{{ __('Confirm Password') }}</label>
                        <input
                          id="password-confirm"
                          type="password"
                          class="form-control"
                          name="password_confirmation"
                          required autocomplete="new-password"
                        >
                      </div>

                      <div class="d-grid">
                        <button type="submit" class="btn btn-primary">
                          {{ __('Reset Password') }}
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
