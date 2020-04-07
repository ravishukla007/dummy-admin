@extends('admin.layouts.unauthorize.app')

@section('content')

<div class="login-box">
  <div class="login-logo"><b>{{ __('Login') }}</b>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <form method="POST" action="{{ route('admin.login') }}">
        
        @csrf

        <div class="input-group mb-3">
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
            name="email" value="{{ old('email') }}" required 
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
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="{{ __('Password') }}">

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
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}> 
              <label for="remember">{{ __('Remember Me') }}</label>
            </div>
          </div>
          
        </div>

      <div class="social-auth-links text-center mb-3"> 
        <button class="btn btn-block btn-primary" type="submit">Sign in</button>
      </div>
      <!-- /.social-auth-links -->
      </form>

      <p class="mb-1">
        <a href="{{ route('admin.password.request') }}">{{ __('Forgot Your Password?') }}</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->
 
@endsection
