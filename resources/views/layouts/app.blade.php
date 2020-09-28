<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Cotizador - Sattlink" />
    <meta name="author" content="Ing. Leonardo Maldonado López" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="_token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/x-icon" href="img/icon.ico" />

    <title>Sattlink - Cotización</title>

    <!-- Styles -->
    {{--
    <link href="{{ asset('css/app.css') }}" rel="stylesheet"> --}}
    <link href="{{ asset('css/styles.css') }} " rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet"
        crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" crossorigin="anonymous">
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>
    {{-- js para el autocomplete --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js">
    </script>
    {{-- editor js --}}
    <script src="{{ asset('js/ckeditor.js') }}"></script>
    <script src="{{ asset('js/editor.js') }}"></script>

</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark" style="background-color: #ff5709ee">
        <a class="navbar-brand" href="/home">Sattlink</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i
                class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
            <div class="input-group">
                <input style="display: none;" class="form-control" type="text" placeholder="Search for..."
                    aria-label="Search" aria-describedby="basic-addon2" />
                <div class="input-group-append">
                    <button style="display: none;" class="btn btn-primary" type="button"><i
                            class="fas fa-search"></i></button>
                </div>
            </div>
        </form>
        <!-- Navbar-->
        <ul class="navbar-nav ml-auto ml-md-0">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="#">Settings</a>
                    <a class="dropdown-item" href="#">Activity Log</a>
                    <div class="dropdown-divider"></div>

                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();">
                        Salir
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </div>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Core</div>
                        <a class="nav-link" href="/home">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>
                       {{--  <div class="sb-sidenav-menu-heading">Interface</div>
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayouts"
                            aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            Layouts
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne"
                            data-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="layout-static.html">Static Navigation</a>
                                <a class="nav-link" href="layout-sidenav-light.html">Light Sidenav</a>
                            </nav>
                        </div> --}}
                        {{-- <a class="nav-link collapsed" href="#" data-toggle="collapse"
                            data-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                            <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                            Pages
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a> --}}
                        {{-- <div class="collapse" id="collapsePages"
                            aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                <a class="nav-link collapsed" href="#" data-toggle="collapse"
                                    data-target="#pagesCollapseAuth" aria-expanded="false"
                                    aria-controls="pagesCollapseAuth">
                                    Authentication
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne"
                                    data-parent="#sidenavAccordionPages">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link" href="login.html">Login</a>
                                        <a class="nav-link" href="register.html">Register</a>
                                        <a class="nav-link" href="password.html">Forgot Password</a>
                                    </nav>
                                </div>
                                <a class="nav-link collapsed" href="#" data-toggle="collapse"
                                    data-target="#pagesCollapseError" aria-expanded="false"
                                    aria-controls="pagesCollapseError">
                                    Error
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne"
                                    data-parent="#sidenavAccordionPages">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link" href="401.html">401 Page</a>
                                        <a class="nav-link" href="404.html">404 Page</a>
                                        <a class="nav-link" href="500.html">500 Page</a>
                                    </nav>
                                </div>
                            </nav>
                        </div> --}}
                        <div class="sb-sidenav-menu-heading"></div>
                        <a class="nav-link" href="/productos">
                            <div class="sb-nav-link-icon"><i class="fas fa-satellite-dish"></i></div>
                            Productos
                        </a>
                        <a class="nav-link" href="/unidad">
                            <div class="sb-nav-link-icon"><i class="fas fa-ruler-combined"></i></div>
                            Unidad de medida
                        </a>
                        <a class="nav-link" href="/clientes">
                            <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                            Clientes
                        </a>
                        <a class="nav-link" href="/usuarios">
                            <div class="sb-nav-link-icon"><i class="fas fa-id-card"></i></div>
                            Usuarios
                        </a>
                        <a class="nav-link" href="/datos">
                            <div class="sb-nav-link-icon"><i class="fas fa-building"></i></div>
                            Datos fiscales
                        </a>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logeado como:</div>
                    {{ Auth::user()->name }}
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                @include('flash-message')
                @yield('content')

            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Sattlink <script>
                                document.write(new Date().getFullYear());

                            </script>
                        </div>
                        <div>
                            <a  href="{{URL::to('politica')}}">Políticas de privacidad</a>
                            &middot;
                            <a  href="{{URL::to('terminos')}}">Terminos &amp; Condiciones</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>

        <!-- Scripts -->
        {{-- <script src="{{ asset('js/app.js') }}"></script>
        --}}

        <script src="{{ asset('js/scripts.js') }}"></script>

        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous">
        </script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous">
        </script>
        <script src="{{ asset('assets/demo/datatables-demo.js') }}"></script>

        {{-- guardar tipo de cambio --}}
        <script>
            $(document).ready(function() {
                var secret =
                    "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjRkZjU4M2U4YTA2NjgwMWNjNjFlZWYzZTBjZDRhM2IwNDljYWFmZjE3YzA0NGRmZWUxYWI0Njk1Mjk1MGUxMjRhNjZiMTVhNTI4YmMyZTNkIn0.eyJhdWQiOiJMYTJvUWNvMXhXWk5jTGoyeGRUZThoUVpHQWFiNkVtaCIsImp0aSI6IjRkZjU4M2U4YTA2NjgwMWNjNjFlZWYzZTBjZDRhM2IwNDljYWFmZjE3YzA0NGRmZWUxYWI0Njk1Mjk1MGUxMjRhNjZiMTVhNTI4YmMyZTNkIiwiaWF0IjoxNTk1OTcyMDY0LCJuYmYiOjE1OTU5NzIwNjQsImV4cCI6MTYyNzUwODA2NCwic3ViIjoiIiwic2NvcGVzIjpbXX0.bnN9ddV2OnhTX7ayP3nU8he3nKjoaIYn2vysbuS4tocPZU7YesRMjRulctCUsVMwuKDx27Qg1H4GOg9pi60u5vLEaQZTycrOTnNQT3MXEVRnLetoW2VWSGYjYcloZONZXLfEvXUETbCJk8egeXkApnTIe1rMheDPVG1P_LjhDVHrFZ-a6segyXCbseXLKUdiyE1gjq0-AQVydvpoeSURGaAueUTwcZ1BIx7svc9H2WUnPFk5E0Nr-nKVwLmSazosJxLPK3Mf5H_nL8dXyE3adzaobjjHW8_Dxmg04h7YpDl1YThiUfYs9qHwCyDeSvCKCNoTb-xjUSkzZDzY16UYJ1_g2XroGE-Pz9XZguhbw3vTN6r1jlUtweX14Meis8AEW3eM9BXzsyBN6-XvN20wao-ZjWW7XCQyRSHqcqOrw0UDDFw5oSl-BIr5uGojGDrO0koBaLZa-2PI0B0nf0v13SvfwTVY-XknSPABLqtk1ZTQJ40P5KKapldqXLhkdAFHM3Kw2E-ua4ZNYa2z-TV9GyXdDIi0roCTv79kNgspeNv7jceJDf5fO6wGHMkv7uDzio_1ftd-TSGAIENhxt3frK3tz2l8CPbZ9WiBjZSQPzhkTK6gVTkMxYh0tUuw-1gVgvYlZv-Fka2Gxv9FMV9I3ZlgIYJvmfSg7uBr7jRyDJE"
                var httpHeader = {
                    'Authorization': secret,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
                var misCabeceras = new Headers(httpHeader);
                var miInit = {
                    method: 'GET',
                    headers: misCabeceras,


                };

                //tipo de cambio
                function json(response) {
                    return response.json()
                }
                var cambio;
                fetch('https://developers.syscom.mx/api/v1/tipocambio', miInit)
                    .then(status)
                    .then(json)
                    .then(function(response) {


                        console.log(response.normal);
                        cambio = parseFloat(response.normal);
                        var data = {
                            _token: '{{ csrf_token() }}',
                            tipocambio: cambio
                        };
                        $.ajax({

                            type: 'post',
                            url: '/tipocambio',
                            data: data,
                            success: function(datos) {
                                //document.getElementById('resultado').innerHTML = datos;
                                //$('#resultado').html(datos);
                            }
                        })
                        //console.log(parse)
                    });


            });

        </script>
</body>

</html>

{{-- <nav class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">

            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- Branding Image -->
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->
            <ul class="nav navbar-nav">
                &nbsp;
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                @if (Auth::guest())
                    <li><a href="{{ route('login') }}">Login</a></li>
                    <li><a href="{{ route('register') }}">Register</a></li>
                    @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                    Logout
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav> --}}
