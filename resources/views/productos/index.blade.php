@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <h1 class="mt-4">Productos o Servicios</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item "><a href="/home">Dashboard</a></li>
            <li class="breadcrumb-item active">Productos o Servicios</li>
        </ol>
        <span class="help-block">
            @if (count($errors) > 0)
                @foreach ($errors->all() as $error)
                    <strong style="color: red">{{ $error }}</strong> <br>

                @endforeach
            @endif
        </span>

        <div class="row">
            <div class="col clearfix">
                <div class="">
                    <div class="float-right">

                        <button type="button" data-toggle="modal" data-target="#ModalExcel" data-id_eliminar="1"
                            class="btn btn-outline-success  btn-xs  ml-auto"><i class="fas fa-file-import"
                                aria-hidden="true"></i> Importar Excel</button>
                        <a href="/producto/exportExcel" style="margin-right: 25px"
                            class="btn btn-outline-primary  btn-xs  ml-auto"><i class="fas fa-file-download "
                                aria-hidden="true"></i> Descargar Excel</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body">
            <a href="{{ route('productos.create') }}" class="btn btn-success btn-xs"> <i class="fas fa-pen"
                    aria-hidden="true"></i> Agregar Producto o Servicio </a>
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
                        @foreach ($productos as $item)
                            <tr>

                                <td>{{ $item->id }}</td>
                                <td class="nombre">{{ $item->nombre }}</td>
                                <td class="codigo">{{ $item->codigo }}</td>
                                <td class="unidad">{{ $item->unidad }}</td>
                                <td class="precio">{{ $item->precio }}</td>
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
                                    {{-- <a
                                        href="{{ route('productos.edit', ['id' => $item->id]) }}"
                                        class="btn btn-info btn-xs"> <i class="fa fa-edit" aria-hidden="true"></i> </a>
                                    --}}
                                    {{-- <a href="{{ route('usuarios.destroy', $item->id) }}"
                                        class="btn btn-danger btn-xs"> <i class="fa fa-trash" aria-hidden="true"
                                            onclick="return confirm('Deseas eliminarlo')"></i> </a>
                                    --}}

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
                                    <option value="{{ $item->nombre }}">{{ $item->nombre }}</option>

                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Precio:</label>
                            <input id="precio" name="precio" type="text"  class="form-control">
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
                        {{-- <input type="hidden" name="_method" value="DELETE">
                        --}}
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input class="btn btn-danger btn-xs" type="submit" value="Eliminar" />
                        
                    </form>


                </div>
            </div>
        </div>
    </div>

    {{-- modal de importacion de excel --}}
    <div class="modal fade" id="ModalExcel" role="dialog" aria-labelledby="exampleModalLabel3" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Eliminar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="formfile" class="form-horizontal" role="form" method="POST"
                    action="{{ URL::to('producto/importExcel') }}" enctype="multipart/form-data">
                    <div class="modal-body">
                        Sube un archivo en formato Excel de acuerdo a la plantilla
                        {{-- <input type="hidden" name="_method" value="DELETE">
                        --}}
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group">
                           
                            
                            <input type="file" class="form-control" name="file" 
                            accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <input class="btn btn-primary btn-xs" type="submit" value="Subir" />

                    </div>
                </form>
            </div>
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



        $('#ModalExcel').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var id = button.data('id_eliminar')


            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this)

            modal.find('#formdestroy').attr('action', function(i, old) {
                /*URL del modal */
                return old + '/';
            });
        });

    </script>



@endsection
