@extends('layouts.master')

@section('title', 'Đăng Nhập')

@section('content')

<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '3710349192321947',
      xfbml      : true,
      version    : 'v9.0'
    });
    FB.AppEvents.logPageView();
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "https://connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
</script>

<script>

  function statusChangeCallback(response) {  // Called with the results from FB.getLoginStatus().
    console.log('statusChangeCallback');
    console.log(response);                   // The current login status of the person.
    if (response.status === 'connected') {   // Logged into your webpage and Facebook.
      testAPI();  
    } else {                                 // Not logged into your webpage or we are unable to tell.
      document.getElementById('status').innerHTML = 'Please log ' +
        'into this webpage.';
    }
  }


  function checkLoginState() {               // Called when a person is finished with the Login Button.
    FB.getLoginStatus(function(response) {   // See the onlogin handler
      statusChangeCallback(response);
    });
  }


  window.fbAsyncInit = function() {
    FB.init({
      appId      : '3710349192321947',
      cookie     : true,                     // Enable cookies to allow the server to access the session.
      xfbml      : true,                     // Parse social plugins on this webpage.
      version    : 'v9.0'           // Use this Graph API version for this call.
    });


    FB.getLoginStatus(function(response) {   // Called after the JS SDK has been initialized.
      statusChangeCallback(response);        // Returns the login status.
    });
  };
 
  function testAPI() {                      // Testing Graph API after login.  See statusChangeCallback() for when this call is made.
    console.log('Welcome!  Fetching your information.... ');
    FB.api('/me', function(response) {
      console.log('Successful login for: ' + response.name);
      document.getElementById('status').innerHTML =
        'Thanks for logging in, ' + response.name + '!';
    });
  }

</script>




  <section class="bread-crumb">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home_page') }}">{{ __('header.Home') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ __('header.Login') }}</li>
      </ol>
    </nav>
  </section>

  <div class="site-login">
      <div class="login-body">
        <h2 class="title">Đăng Nhập</h2>
        <form action="{{ route('login') }}" method="POST" accept-charset="utf-8">
          @csrf

          @if(session('message'))
            <div class="form_message">
              {{ session('message') }}
            </div>
          @endif

          <div class="input-group">
            <span class="input-group-addon"><i class="fas fa-user"></i></span>
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Email" value="{{ old('email') }}" required autocomplete="email" autofocus>

            @error('email')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>

          <div class="input-group">
            <span class="input-group-addon"><i class="fas fa-lock"></i></span>
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password" required autocomplete="current-password">

            @error('password')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>

          <div class="login-form-group">
            <div class="row">
              <div class="col-md-6">
                <div class="checkbox">
                  <label><input name="remember" type="checkbox" {{ old('remember') ? 'checked' : '' }}>Remember me</label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="forgot-password">
                    <a href="{{ route('password.request') }}" title="Forgot password">Forgot password</a>
                </div>
              </div>
            </div>
          </div>

          <button type="submit" class="btn btn-default">LOGIN</button>
        </form>
      </div>
      <div class="login-social">
        <div class="login-social-text">Or login with</div>
        <div class="row">

          <!-- <div class="col-md-6">
            <a href="{{URL('/login-facebook')}}" title="Facebook" class="btn btn-defaule"><i class="fab fa-facebook-square"></i> Đăng nhập bằng Facebook</a>
          </div> -->

<!-- <div class="fb-login-button" data-width="" data-size="large" data-button-type="continue_with" data-layout="default" data-auto-logout-link="false" data-use-continue-as="false"></div>
 -->

<div class="g-signin2" data-onsuccess="onSignIn"></div>

<!-- The JS SDK Login Button -->

<fb:login-button scope="public_profile,email" onlogin="checkLoginState();">
</fb:login-button>

<div id="status">
</div>

<!-- Load the JS SDK asynchronously -->
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js"></script>



          <!-- <div class="col-md-6">
            <a href="#" title="Google" class="btn btn-defaule"><i class="fab fa-google"></i> Google</a>
          </div>
        </div> -->

      </div>
      <div class="sign-up-now">
        Not a member? <a href="{{ route('register') }}">Sign up now</a>
      </div>
  </div>
@endsection

@section('css')
  <style>

  </style>
@endsection

@section('js')
  <script>
    $(document).ready(function(){
      @if(session('alert'))
        Swal.fire(
          '{{ session('alert')['title'] }}',
          '{{ session('alert')['content'] }}',
          '{{ session('alert')['type'] }}'
        )
      @endif
    });
  </script>
@endsection
