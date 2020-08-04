@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <h1 class="mt-4">Clientes</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item "><a href="/home">Dashboard</a></li>
            <li class="breadcrumb-item active">Clientes</li>
        </ol>

        <div class="row">
            <div class="col clearfix">
                <div class="">
                    <div class="float-right">

                        <button type="button" data-toggle="modal" data-target="#ModalExcel" data-id_eliminar="1"
                            class="btn btn-outline-success  btn-xs  ml-auto"><i class="fas fa-file-import"
                                aria-hidden="true"></i> Importar Excel</button>
                        <a href="/cliente/exportExcel" style="margin: 25px"
                            class="btn btn-outline-primary  btn-xs  ml-auto"><i class="fas fa-file-download "
                                aria-hidden="true"></i> Descargar Excel</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body">
            <a href="{{ url('clientes/create') }}" class="btn btn-success btn-xs"> <i class="fas fa-user-plus" aria-hidden="true"></i> Agregar Cliente </a>
           <div style="margin: 10px"></div>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nombre</th>
                            <th>Telefono</th>
                            <th>Dirección</th>
                            <th>Descuento</th>
                            <th>Fecha de creación</th>
                            <th>R.F.C.</th>
                            <th>Acciones</th>

                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Id</th>
                            <th>Nombre</th>
                            <th>Telefono</th>
                            <th>Dirección</th>
                            <th>Descuento</th>
                            <th>Fecha de creación</th>
                            <th>R.F.C.</th>
                            <th>Acciones</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach($clientes as $item)
                            <tr>

                                <td>{{ $item->id }}</td>
                                <td>{{ $item->nombre }}</td>
                                <td>{{ $item->telefono }}</td>
                                <td>{{ $item->direccion }}</td>
                                <td>{{ $item->descuento}}%</td>
                                <td>{{ $item->created_at }}</td>
                                <td>{{ $item->rfc }}</td>
                               
                                
                                <td><a href="{{ route('clientes.edit',['id'=>$item->id]) }}" class="btn btn-info btn-xs"> <i class="fa fa-edit" aria-hidden="true"></i> </a>
                                   {{--  <a href="{{ route('usuarios.destroy',$item->id) }}" class="btn btn-danger btn-xs"> <i class="fa fa-trash" aria-hidden="true" onclick="return confirm('Deseas eliminarlo')"></i> </a> --}}
                                    
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
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
                    action="{{ URL::to('cliente/importExcel') }}" enctype="multipart/form-data">
                    <div class="modal-body">
                        Sube un archivo en formato Excel de acuerdo a la plantilla
                        <small id="passwordHelpBlock" class="form-text text-muted">
                         Si un cliente  actualizo su rfc, se creará como <strong>nuevo registro</strong> 
                          </small>
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

    <script>
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
