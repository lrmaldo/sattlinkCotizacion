

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

<div class="container-fluid">

    <!-- 404 Error Text -->
    <div class="text-center">
      <div class="h1" data-text="404">404</div>
      <p class="lead text-gray-800 mb-5">Página no encontrada</p>
      <p class="text-gray-500 mb-0">Verifica la url a la que quieres acceder</p>
      <a href="/home">&larr; Voler al Dashboard</a>
    </div>

  </div>


  
</body>













