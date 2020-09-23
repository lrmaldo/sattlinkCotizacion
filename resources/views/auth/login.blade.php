{{-- @extends('layouts.app')

@section('content') --}}


{{-- <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Login</div>

                    <div class="panel-body">
                        <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                                    @if($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="col-md-4 control-label">Password</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password" required>

                                    @if($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Login
                                    </button>

                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        Forgot Your Password?
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="Ing. Leonardo Maldonado López" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>SattLink</title>

    <!-- Styles -->
    {{--  <link href="{{ asset('css/app.css') }}" rel="stylesheet"> --}}
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" crossorigin="anonymous">
    </script>
</head>

<body>
    <div id="layoutAuthentication" class="div">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center"  >
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5" style="background-color: rgba(0,0,0,0.6);">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4 text-white">Login</h3>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="{{ route('login') }}">
                                        {{ csrf_field() }}
                                        <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                                            <label class="small mb-1 text-white" for="inputEmailAddress">Correo Electrónico</label>
                                            <input class="form-control py-4" id="email" name="email"
                                                value="{{ old('email') }}" type="email"
                                                placeholder="Ingresa el correo electrónico" required autofocus />
                                            @if($errors->has('email'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label class="small mb-1 text-white" for="inputPassword">Contraseña</label>
                                            <input class="form-control py-4" id="password" name="password"
                                                type="password" placeholder="Escribe tu contraseña" required />



                                            @if($errors->has('password'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('password') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                      {{--   <div class="form-group">
                                            <div class="custom-control custom-checkbox">
                                                <input class="custom-control-input" id="rememberPasswordCheck"
                                                    type="checkbox" name="remember"
                                                    {{ old('remember') ? 'checked' : '' }} />
                                                <label class="custom-control-label"
                                                    for="rememberPasswordCheck">Recuerdame
                                                </label>
                                            </div>
                                        </div> --}}
                                        <div
                                            class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <a class="small text-white" href="{{ route('password.request') }}">¿Olvidades tu
                                                contraseña?</a>
                                            {{-- <a class="btn btn-primary" href="index.html">Login</a> --}}
                                            <button type="submit" class="btn btn-primary">
                                                Login
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                {{--  <div class="card-footer text-center">
                                    <div class="small"><a href="register.html">Need an account? Sign up!</a></div>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div id="layoutAuthentication_footer">
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Sattlink <script> document.write(new Date().getFullYear());</script>  </div>
                        <div>
                            <a href="#">Políticas de privacidad</a>
                            &middot;
                            <a href="#">Terminos &amp; Condiciones</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="js/scripts.js"></script>
</body>
<style>
    .div{
  height:100%;
  width: 100%;
 
  position: fixed;
  /* background-image: url("img/torres/2.jpg"); */
  background-position: center; /* Center the image */
  background-repeat: no-repeat; /* Do not repeat the image */
  background-size: cover;
 
}


      .custom-margin {
         margin-top: 20vh;
      }
.login{
    /*background-color:rgb(255,0,0);*/
    opacity:0.6; /* Opacidad 60% */
}
</style>
<script>

    
$(document).ready(function(){
    function random(min, max) {
        return Math.floor(Math.random() * (max - min + 1) + min);
    }

    var spec = {
        backgrounds: [
           '1.jpg',
           '2.jpg',
           '3.jpg',
           '4.jpg',
           '5.jpg',
           '6.jpg',
         
        ]
    };
    var i = random(0, spec.backgrounds.length - 1);
    var b = spec.backgrounds[i];
    /* 
    background-position: center;
  background-repeat: no-repeat;
  background-size: cover; */
    $('body').css('background-image', 'url("img/torres/' + b + '")');
    $('body').css('background-size','cover');
    $('body').css('background-position','center');
    $('body').css('background-repeat','no-repeat');

});
</script>
</html>

{{-- @endsection
 --}}
