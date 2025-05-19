@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="role" class="col-md-4 col-form-label text-md-end">{{ __('Role') }}</label>

                            <div class="col-md-6">
                                <select id="role" class="form-control @error('role') is-invalid @enderror" name="role" required>
                                    <option value="">-- Select Role --</option>
                                    <option value="requestor" {{ old('role') == 'requestor' ? 'selected' : '' }}>Requestor</option>
                                    <option value="implementor" {{ old('role') == 'implementor' ? 'selected' : '' }}>Implementor</option>
                                    <option value="hou" {{ old('role') == 'hou' ? 'selected' : '' }}>Head of Unit (HOU)</option>
                                    <option value="hod" {{ old('role') == 'hod' ? 'selected' : '' }}>Head of Department (HOD)</option>
                                </select>

                                @error('role')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Unit dropdown (only shown if role is HOU) -->
                        <div class="row mb-3" id="unitField" style="display: none;">
                            <label for="unit" class="col-md-4 col-form-label text-md-end">{{ __('Unit') }}</label>

                            <div class="col-md-6">
                                <select id="unit" class="form-control @error('unit') is-invalid @enderror" name="unit">
                                    <option value="">-- Select Unit --</option>
                                    <option value="Logistics and Engineering (L&E)" {{ old('unit') == 'Logistics and Engineering (L&E)' ? 'selected' : '' }}>Logistics and Engineering (L&E)</option>
                                    <option value="Delivery & Optimization (D&O)" {{ old('unit') == 'Delivery & Optimization (D&O)' ? 'selected' : '' }}>Delivery & Optimization (D&O)</option>
                                    <option value="Finance" {{ old('unit') == 'Finance' ? 'selected' : '' }}>Finance</option>
                                    <option value="Human Resource & Back End (HR)" {{ old('unit') == 'Human Resource & Back End (HR)' ? 'selected' : '' }}>Human Resource & Back End (HR)</option>
                                </select>

                                @error('unit')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JS to show/hide unit field -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const roleSelect = document.getElementById('role');
        const unitField = document.getElementById('unitField');

        function toggleUnitField() {
            if (roleSelect.value === 'hou') {
                unitField.style.display = 'flex';
                document.getElementById('unit').setAttribute('required', true);
            } else {
                unitField.style.display = 'none';
                document.getElementById('unit').removeAttribute('required');
            }
        }

        roleSelect.addEventListener('change', toggleUnitField);
        toggleUnitField(); // run once in case of old input
    });
</script>
@endsection
