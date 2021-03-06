@extends('layouts.app')

@section('content')




<div class="container-fluid">
    <h1 class="mt-4">Nuevo Producto o Servicio</h1>
    <ol class="breadcrumb mb-4">
      <li class="breadcrumb-item "><a href="/home">Dashboard</a></li>
        <li class="breadcrumb-item "><a href="/productos">Productos</a></li>
        <li class="breadcrumb-item active">Crear producto o servicio</li>
    </ol>

    <div class="card-body">
        <form  role="form" method="POST"  action="{{ route('productos.store') }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                  <button type="submit" class="btn btn-xs btn-circle btn-primary">
                    Crear
                  </button>
                  <!--button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#exampleModal"> <i class="far fa-trash-alt"></i>
                                                      Eliminar
                                                      </button-->
                                                      
                </div>
              
              </div>
              <span class="help-block">
                @if(count($errors)>0)
                @foreach ($errors->all() as $error)
                <strong style="color: red">{{ $error }}</strong> <br>
                    
                @endforeach
                @endif  
              </span>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="inputEmail4">Nombre o Servicio</label>
                  <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Escribe el producto o servicio">
                </div>
                <div class="form-group col-md-2">
                  <label for="inputPassword4">Código</label>
                  <div class="input-group mb-2">
                    <div class="input-group-prepend">
                      <div class="input-group-text">#</div>
                    </div>
                    <input type="text" class="form-control" id="codigo" name="codigo" placeholder="Código">

                  </div>
                </div>
              </div>
            
              <div class="form-row">
               
                <div class="form-group col-md-4">
                  <label for="inputState">Unidad</label>
                  <select id="unidad" name="unidad" class="form-control">
                    <option selected>Selecciona...</option>
                    @foreach ($unidades as $item)
                  <option value="{{$item->nombre}}">{{$item->nombre}}</option>
                        
                    @endforeach
                  </select>
                </div>
                <div class="form-group col-md-2">
                  <label for="inputZip">Precio</label>
                  <div class="input-group mb-2">
                    <div class="input-group-prepend">
                      <div class="input-group-text">$</div>
                    </div>
                    <input type="text" id="precio" name="precio" class="form-control" placeholder="precio..." >
                    {{-- scrip punto decimal --}}

                   

                  </div>
                </div>
              </div>

              <script>
                $('#precio').keypress(function(eve) {
                    if ((eve.which != 46 || $(this).val().indexOf('.') != -1) && (eve.which < 48 || eve
                            .which > 57) || (eve.which == 46 && $(this).caret().start == 0)) {
                        eve.preventDefault();
                    }
                    // this part is when left part of number is deleted and leaves a . in the leftmost position. For example, 33.25, then 33 is deleted
                    $('#precio').keyup(function(eve) {
                        if ($(this).val().indexOf('.') == 0) {
                            $(this).val($(this).val().substring(1));
                        }
                    });
                });
            </script>
             
           
            
          </form> 
    </div>
</div>
@endsection