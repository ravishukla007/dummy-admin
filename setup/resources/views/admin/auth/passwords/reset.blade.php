@extends('admin.layouts.unauthorize.app')

@section('content')

<div class="login-box">
  <div class="login-logo"><b>{{ __('Reset Password') }}</b>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body"> 

      <form method="POST" action="{{ route('admin.password.update') }}">
        
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <div class="input-group mb-3">

            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
            name="email" required 
            value="{{ $email ?? old('email') }}"
            autocomplete="email" autofocus placeholder="{{ __('E-Mail Address') }}" >
            <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-envelope"></span>
                </div>
            </div>
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>


        <div class="input-group mb-3">
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="{{ __('Password') }}">

            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                </div>
            </div>

            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>


        <div class="input-group mb-3">
            <input id="password-confirm" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" required autocomplete="new-password" placeholder="{{ __('Confirm Password') }}">

            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                </div>
            </div>

            @error('password_confirmation')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>


      <div class="social-auth-links text-center mb-3"> 
        <button class="btn btn-block btn-primary" type="submit">Reset Password</button>
      </div>
      <!-- /.social-auth-links -->
      </form>

      <p class="mb-1 text-center">
        Back to
        <a href="{{ route('admin.login') }}">{{ __('login') }}</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

 
@endsection

