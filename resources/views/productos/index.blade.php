@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <h1 class="mt-4">Productos o Servicios</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item "><a href="/home">Dashboard</a></li>
            <li class="breadcrumb-item active">Productos o Servicios</li>
        </ol>
        <span class="help-block">
            @if(count($errors)>0)
            @foreach ($errors->all() as $error)
            <strong style="color: red">{{ $error }}</strong> <br>
                
            @endforeach
            @endif  
          </span>

        <div class="card-body">
            <a href="{{ route('productos.create') }}" class="btn btn-success btn-xs"> <i class="fas fa-pen" aria-hidden="true"></i> Agregar Producto o Servicio </a>
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
                                <td class="nombre">{{ $item->nombre }}</td>
                                <td class="codigo">{{ $item->codigo }}</td>
                                <td class="unidad">{{ $item->unidad }}</td>
                                <td class="precio">{{ $item->precio}}</td>
                                <td>{{ $item->created_at }}</td>
                                
                               
                                
                                <td>
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#exampleModal" data-whatever="{{ $item->id }}"
                                    data-href="{{ route('productos.update', $item->id) }}"><i class="fa fa-edit"
                                        aria-hidden="true"></i></button>
                                <button type="button" class="btn btn-danger" data-toggle="modal"
                                    data-target="#Modal_eliminar" data-id_eliminar="{{ $item->id }}"
                                    data-href="{{ route('productos.destroy', $item->id) }}"><i class="fa fa-trash"
                                        aria-hidden="true"></i></button>
                                    {{-- <a href="{{ route('productos.edit',['id'=>$item->id]) }}" class="btn btn-info btn-xs"> <i class="fa fa-edit" aria-hidden="true"></i> </a> --}}
                                   {{--  <a href="{{ route('usuarios.destroy',$item->id) }}" class="btn btn-danger btn-xs"> <i class="fa fa-trash" aria-hidden="true" onclick="return confirm('Deseas eliminarlo')"></i> </a> --}}
                                    
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>

        </div>
    </div>



    {{-- modal --}}
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Actualizar Unidad de medida</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formedit" role="form" method="get" action="{{ route('productos.update', '') }}">
                  
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Nombre:</label>
                            <input type="text" class="form-control" id="nombre" name="nombre">
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Código:</label>
                            <input type="text" class="form-control" id="codigo" name="codigo">
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Unidad de Medida:</label>
                            <select id="unidad" name="unidad" class="form-control">
                                <option id='select_unidad' value="" selected></option>
                                @foreach ($unidades as $item)
                              <option value="{{$item->nombre}}">{{$item->nombre}}</option>
                                    
                                @endforeach
                              </select>
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Precio:</label>
                            <input id="precio" name="precio" type="number" min="0" step="0.01" class="form-control" >
                        </div>


                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>

                </div>
                </form>
            </div>
        </div>
    </div>
    {{-- Modal para eliminar --}}


    <!-- Modal -->
    <div class="modal fade" id="Modal_eliminar" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Eliminar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ¿Esta seguro que desea eliminar este producto?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <form id="formdestroy" class="form-horizontal" role="form" method="get"
                        action="{{ route('productos.destroy', '') }}">
                        {{-- <input type="hidden" name="_method" value="DELETE"> --}}
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input class="btn btn-danger btn-xs" type="submit" value="Eliminar" />

                    </form>


                </div>
            </div>




            {{-- script del modal para obtener los datos --}}

            <script>
                $('#exampleModal').on('show.bs.modal', function(event) {
                    var button = $(event.relatedTarget) // Button that triggered the modal
                    var id = button.data('whatever')

                    var parentTr = button.closest('tr');
                    var recipient = parentTr.find('.nombre').text();
                    var codigo = parentTr.find('.codigo').text();
                    var unidad = parentTr.find('.unidad').text();
                    var precio = parentTr.find('.precio').text();
                    console.log(recipient); // Extract info from data-* attributes
                    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                    var modal = $(this)
                    modal.find('.modal-title').text('Actualizar ' + recipient) /* titulo */
                    modal.find('#nombre').val(recipient); /* input del modal */
                    modal.find('#codigo').val(codigo); /* input del modal */
                    modal.find('#select_unidad').val(unidad); /* input del DE LA UNIDAD SELECCIONADA */
                   
                    document.getElementById('select_unidad').innerHTML = unidad; /* ENVIA EL VALOR ENTRE LOS OPTIONS */
                   
                    modal.find('#precio').val(precio); 
                    modal.find('#formedit').attr('action', function(i, old) {
                        /*URL del modal */
                        return old + '/' + id;
                    });
                });


                /* script para eliminar unidad */

                $('#Modal_eliminar').on('show.bs.modal', function(event) {
                    var button = $(event.relatedTarget) // Button that triggered the modal
                    var id = button.data('id_eliminar')


                    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                    var modal = $(this)

                    modal.find('#formdestroy').attr('action', function(i, old) {
                        /*URL del modal */
                        return old + '/' + id;
                    });
                });

            </script>



@endsection
