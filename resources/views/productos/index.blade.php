@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <h1 class="mt-4">Productos o Servicios</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item "><a href="/home">Dashboard</a></li>
            <li class="breadcrumb-item active">Productos o Servicios</li>
        </ol>

        <div class="card-body">
            <a href="{{ url('productos/create') }}" class="btn btn-success btn-xs"> <i class="fas fa-pen" aria-hidden="true"></i> Agregar Producto o Servicio </a>
           <div style="margin: 10px"></div>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nombre</th>
                            <th>Codigo</th>
                            <th>Unidad</th>
                            <th>Precio</th>
                            <th>Fecha de creación</th>
                            <th>Acciones</th>

                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Id</th>
                            <th>Nombre</th>
                            <th>Codigo</th>
                            <th>Unidad</th>
                            <th>Precio</th>
                            <th>Fecha de creación</th>
                            <th>Acciones</th>

                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach($productos as $item)
                            <tr>

                                <td>{{ $item->id }}</td>
                                <td>{{ $item->nombre }}</td>
                                <td>{{ $item->codigo }}</td>
                                <td>{{ $item->unidad }}</td>
                                <td>{{ $item->precio}}</td>
                                <td>{{ $item->created_at }}</td>
                                
                               
                                
                                <td><a href="{{ route('productos.edit',['id'=>$item->id]) }}" class="btn btn-info btn-xs"> <i class="fa fa-edit" aria-hidden="true"></i> </a>
                                   {{--  <a href="{{ route('usuarios.destroy',$item->id) }}" class="btn btn-danger btn-xs"> <i class="fa fa-trash" aria-hidden="true" onclick="return confirm('Deseas eliminarlo')"></i> </a> --}}
                                    
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>

        </div>
    </div>


@endsection
