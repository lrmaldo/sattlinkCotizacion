@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <h1 class="mt-4">Usuarios</h1>
    <ol class="breadcrumb mb-4">
      <li class="breadcrumb-item "><a href="/home">Dashboard</a></li>
        <li class="breadcrumb-item "><a href="/usuarios">Usuarios</a></li>
        <li class="breadcrumb-item active">Crear usuario</li>
    </ol>

    <div class="card-body">
        <form  role="form" method="POST" {{-- enctype="multipart/form-data" --}} action="{{ route('usuarios.store') }}">
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
              </div>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="inputEmail4">Correo Electrónico</label>
                <input type="email" class="form-control" id="correo" name="correo" placeholder="Correo Electrónico" required>
              </div>
              <div class="form-group col-md-6">
                <label for="inputPassword4">Contraseña</label>
                <input type="text" class="form-control" id="contra" name="contra" placeholder="Contraseña" required>
              </div>
            </div>
            <div class="form-group">
              <label for="inputAddress">Nombre</label>
              <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Escribe el nombre completo" required>
            </div>
          
            <div class="form-row">
              
              <div class="form-group col-md-4">
                <label for="inputState">Rol de usuario</label>
                <select id="rol" class="form-control" name="rol" required>
                  <option selected>Seleciona...</option>
                  @foreach ($roles as $rol)
                      
                <option value="{{$rol->name}}">{{$rol->name}}</option>
                  @endforeach
                </select>
              </div>
              
            </div>
           
            
          </form> 
    </div>
</div>
@endsection