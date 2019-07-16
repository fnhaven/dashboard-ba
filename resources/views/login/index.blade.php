<!doctype html>
<html lang="{{ app()->getLocale() }}" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Language" content="en" />

    <meta name="msapplication-TileColor" content="#2d89ef">
    <meta name="theme-color" content="#4188c9">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"/>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">

    <link rel="icon" href="favicon.ico" type="image/x-icon"/>
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />

    <title>Login</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,300i,400,400i,500,500i,600,600i,700,700i&amp;subset=latin-ext">
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet" />

    <script src="{{ asset('js/require.min.js') }}"></script>
    <script>
        requirejs.config({
            baseUrl: '{{ asset('') }}'
        });
    </script>

    <script src="{{ asset('js/dashboard.js') }}"></script>
    <script src="{{ asset('plugins/input-mask/plugin.js') }}"></script>
</head>
<body class="">
    <div class="page">
      <div class="page-single">
        <div class="container">
          <div class="row">
            <div class="col col-login mx-auto">
              <div class="text-center mb-6">
                <img src="https://tabler.io/img/tabler.svg" class="h-6" alt="">
              </div>
              @if(session('login-error'))
              <div class="alert alert-danger" role="alert">
                  {{ session('login-error') }}
              </div>
              @endif
              <form class="card" action="{{ url('login') }}" method="post">
                {{ csrf_field() }}
                <div class="card-body p-6">
                  <div class="card-title">Login to your account</div>
                  <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="Enter email">
                  </div>
                  <div class="form-group">
                    <label class="form-label">
                      Password
                    </label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                  </div>
                  <div class="invalid-feedback" id="alert-feedback">email and password required</div>
                  <!-- <div class="form-group">
                    <label class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input" />
                      <span class="custom-control-label">Remember me</span>
                    </label>
                  </div> -->
                  <div class="form-footer">
                    <button type="submit" class="btn btn-primary btn-block btn-signin">Sign in</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script type="text/javascript">
        require(['jquery', 'swal'], function( $ ) {
            // login setting
            $('.btn-signin').on('click', function(e){
                e.preventDefault();

                if($('#username').val() == '' || $('#password').val() == '') return $('#alert-feedback').show(200);

                $(this).parents('form').submit();
            });

            $('form :input:not(:button)').on('keypress', function(e){
                if(e.which == 13) $('.btn-signin').trigger('click');
            });
        });
    </script>
</body>
</html>