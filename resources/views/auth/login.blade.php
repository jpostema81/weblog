@extends('layouts.master')

@section('breadcrumbs')

    <nav class="breadcrumb" aria-label="breadcrumbs">
        <ul>
            <li><a href="{{ route('messages.index') }}">{{ __('Home') }}</a></li>
            <li class="is-active"><a href="#" aria-current="page">{{ __('Login') }}</a></li>
        </ul>
    </nav>

@endsection

@section('content')

    <div class="container">
      <div class="columns is-centered">
        <div class="column is-5-tablet is-4-desktop is-3-widescreen">
            <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="field">
              <label for="" class="label">{{ __('E-Mail Address') }}</label>
              <div class="control has-icons-left">
                <input id="email" placeholder="e.g. bobsmith@gmail.com" type="email" class="input form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                <span class="icon is-small is-left">
                  <i class="fa fa-envelope"></i>
                </span>
                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>

            <div class="field">
              <label for="" class="label">{{ __('Password') }}</label>
              <div class="control has-icons-left">
                <input id="password" type="password" placeholder="*******" class="input form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                <span class="icon is-small is-left">
                  <i class="fa fa-lock"></i>
                </span>
                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>

            <div class="field">
              <label for="remember" class="checkbox">
              <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                {{ __('Remember Me') }}
              </label>
            </div>

            <div class="field is-grouped">
              <button type="submit" class="button is-success">
              {{ __('Login') }}
              </button>

              @if (Route::has('password.request'))
                <a class="button is-text" href="{{ route('password.request') }}">
                    {{ __('Forgot Your Password?') }}
                </a>
              @endif
            </div>
          </form>
        </div>
      </div>
    </div>


@endsection