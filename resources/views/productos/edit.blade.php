@extends('layouts.app')

@section('content')

<div class="container-fluid">
  <h1 class="mt-4">Editar Producto o Servicio</h1>
  <ol class="breadcrumb mb-4">
    <li class="breadcrumb-item "><a href="/home">Dashboard</a></li>
      <li class="breadcrumb-item "><a href="/productos">Productos</a></li>
      <li class="breadcrumb-item active">Crear producto o servicio</li>
  </ol>

    <div class="card-body">
      <form role="form" method="POST" action="{{ route('clientes.update', $cliente->id) }}">
        <input type="hidden" name="_method" value="PUT">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                  <button type="submit" class="btn btn-xs btn-circle btn-success"><i class="far fa-save"></i>
                    Guardar
                </button>
                <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#exampleModal">
                    <i class="far fa-trash-alt"></i>
                    Eliminar
                </button>
               
                                                      
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
              <input type="text" class="form-control" id="nombre" name="nombre" value="{{$cliente->nombre}}" placeholder="Escribe el nombre completo del cliente" >
              </div>
              <div class="form-group col-md-6">
                <label for="inputPassword4">Correo electrónico</label>
                <input type="email" class="form-control" id="correo" name="correo" value="{{$cliente->email}}" placeholder="Correo Electrónico" >
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="inputEmail4">Teléfono</label>
                <input type="text" class="form-control" id="telefono" name="telefono" value="{{$cliente->telefono}}" placeholder="Escribe el teléfono del cliente" >
              </div>
              <div class="form-group col-md-6">
                <label for="inputPassword4">RFC</label>
                <input type="text" class="form-control" id="rfc" name="rfc" value="{{$cliente->rfc}}" placeholder="RFC del cliente" >
              </div>
            </div>
            <div class="form-group">
              <label for="inputAddress">Dirección</label>
              <input type="text" class="form-control" id="direccion" name="direccion" value="{{$cliente->direccion}}" placeholder="Escribe la dirección del cliente" >
            </div>
          
            <div class="form-row">
              
              <div class="form-group col-md-4">
                <label for="inputState">Porcentaje de descuento</label>
                <input type="number" min="0"  step="0.01" class="form-control" id="porcentaje" name="porcentaje" value="{{$cliente->descuento}}" placeholder="Porcentaje de descuento Ejem. 0.20 o 0.10" >
                                        
                </div>

              
              
              
            </div>
           
            
          </form> 
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
      <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Eliminar</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
          </button>
      </div>
      <div class="modal-body">
          ¿Esta seguro que desea eliminar este cliente?
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <form class="form-horizontal" role="form" method="post" action="{{ route('clientes.destroy', $cliente->id) }}">
          <input type="hidden" name="_method" value="DELETE">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <input class="btn btn-danger btn-xs" type="submit" value="Eliminar" />
      
      </form>
          
          
      </div>
      </div>



@endsection