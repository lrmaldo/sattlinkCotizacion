@extends('layouts.app')
@section('content')

    <div class="container-fluid">
        <h1 class="mt-4">Usuarios</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item "><a href="/usuarios">Usuarios</a></li>
            <li class="breadcrumb-item active">Editar usuario {{ $user->name }}</li>
        </ol>

        <div class="card-body">
            <form role="form" method="POST" action="{{ route('usuarios.update', $user->id) }}">
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
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">Correo Electrónico</label>
                        <input type="email" class="form-control" id="correo" name="correo" value="{{ $user->email }}"
                            placeholder="Correo Electrónico">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputPassword4">Contraseña</label>
                        <input type="text" class="form-control" id="contra" name="contra" placeholder="Contraseña">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputAddress">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $user->name }}"
                        placeholder="Escribe el nombre completo" required>
                </div>

                <div class="form-row">

                    <div class="form-group col-md-4">
                        <label for="inputState">Rol de usuario</label>
                        <select id="rol" class="form-control" name="rol">
                            <option value="{{ $user->rol_user($user->id)->name }}" selected>
                                {{ $user->rol_user($user->id)->name }}</option>
                            @foreach ($roles as $rol)

                                <option value="{{ $rol->name }}">{{ $rol->name }}</option>
                            @endforeach
                        </select>
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
            ¿Esta seguro que desea eliminar este usuario?
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <form class="form-horizontal" role="form" method="post" action="{{ route('usuarios.destroy', $user->id) }}">
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input class="btn btn-danger btn-xs" type="submit" value="Eliminar" />
        
        </form>
            
            
        </div>
        </div>

@endsection
