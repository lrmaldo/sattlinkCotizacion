@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <h1 class="mt-4">Nuevo Cliente</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item "><a href="/clientes">Clientes</a></li>
        <li class="breadcrumb-item active">Crear Cliente</li>
    </ol>

    <div class="card-body">
        <form  role="form" method="POST"  action="{{ route('clientes.store') }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                  <button type="submit" class="btn btn-lg btn-circle btn-primary">
                    Crear
                  </button>
                  <!--button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#exampleModal"> <i class="far fa-trash-alt"></i>
                                                      Eliminar
                                                      </button-->
                                                      
                </div>
                <span class="help-block">
                  @if(count($errors)>0)
                  @foreach ($errors->all() as $error)
                  <strong style="color: red">{{ $error }}</strong> <br>
                      
                  @endforeach
                  @endif  
                </span>
              </div>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="inputEmail4">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Escribe el nombre completo del cliente" >
              </div>
              <div class="form-group col-md-6">
                <label for="inputPassword4">Correo electrónico</label>
                <input type="email" class="form-control" id="correo" name="correo" placeholder="Correo Electrónico" >
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="inputEmail4">Teléfono</label>
                <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Escribe el teléfono del cliente" >
              </div>

              <div class="form-group col-md-6">
                <label for="inputPassword4">RFC</label>
                <input type="text" class="form-control" id="rfc" name="rfc" placeholder="RFC del cliente" >
              </div>
              
            </div>
            <div class="form-group">
              <label for="inputAddress">Dirección</label>
              <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Escribe la dirección del cliente" >
            </div>
          
            <div class="form-row">
              
              <div class="form-group col-md-4">
                <label for="inputState">Porcentaje de descuento</label>
                <input type="number" min="0"  step="0.01" class="form-control" id="porcentaje" name="porcentaje" placeholder="Ejem. 20 ó 30 (numero entero)" >
                                        
                </div>

              
              
              
            </div>
           
            
          </form> 
    </div>
</div>
@endsection