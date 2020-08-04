@extends('layouts.app')
@section('content')
    {{-- @foreach ($folio as $item)
        {{ $item->folio }}
    @endforeach --}}
    <div class="container-fluid">
        <h1 class="mt-4">Nueva Cotización</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item "><a href="/home">Cotizador</a></li>
            <li class="breadcrumb-item active">Nueva Cotización</li>
        </ol>

        <div class="card-body">
            <form>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">Vendedor:</label>
                        <input type="text" class="form-control" name="vendedor" value="{{ Auth::user()->name }}"
                            placeholder="Nombre del vendedor">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">Folio</label>
                        @foreach ($folio as $item)

                            <input type="text" class="form-control" name="folio" value="{{ $item->folio }}"
                                placeholder="folio">
                        @endforeach
                    </div>

                    <div class="form-group">
                        
                            <div class="form-row align-items-center">
                              <div class="col-auto">
                                <label class="sr-only" for="inlineFormInput">Selecciona el cliente</label>
                                <select class='mi-selector form-control' name='cliente_id'>
                                    <option value=''>Seleccionar un cliente</option>
                                    @foreach ($clientes as $item)
                                        <option value='{{ $item->id }}'>{{ $item->nombre }}</option>
        
                                        @endforeach
                                        
                                    </select>
                              </div>
                             
                              <div class="col-auto">
                                <button type="submit" class="btn btn-primary mb-2">Buscar</button>
                              </div>
                            </div>
                          
                    
                    </div>
                   
                </div>

            </form>

        </div>
    </div>

    <script>
        jQuery(document).ready(function($) {
            $(document).ready(function() {
                $('.mi-selector').select2();
            });
        });

    </script>
@endsection
