@extends('layouts.app')
@section('content')


<div class="container-fluid">
    <h1 class="mt-4">Datos Físcales</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item "><a href="/home">Dashboard</a></li>
        <li class="breadcrumb-item active">Datos fiscales</li>
    </ol>
    <span class="help-block">
        @if(count($errors)>0)
        @foreach ($errors->all() as $error)
        <strong style="color: red">{{ $error }}</strong> <br>
            
        @endforeach
        @endif  
      </span>
</div>


<div class="card-body">
{{-- formulario de impuesto --}}
<div >
      
<script>
    $(function () {
  $('[data-toggle="tooltip"]').tooltip()
});
</script>
<form class="form-inline" role="form" method="get" action="/impuesto/{{$impuesto->id}}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
       
    <div class=" form-row align-items-center">
      
      <div class="col-auto">
        <label class="sr-only" for="inlineFormInputGroup"></label>
        <div class="input-group md-2">
          <div class="input-group-prepend">
            <div class="input-group-text">I.V.A. (%)</div>
          </div>
          <input type="text" class="form-control" style="text-align:right" id="impuesto" name="impuesto" placeholder="Impuesto" value="{{$impuesto->cantidad}}">
          <div class="input-group-prepend">
            <div class="input-group-text">%</div>
          </div>
        </div>
      </div>
      <div class="col-3">
        <label class="sr-only" for="inlineFormInputGroup"></label>
        <div class="input-group md-2" data-toggle="tooltip" data-placement="top" title="Porcentaje de utilidad (syscom)">
            <input type="text" class="form-control" style="text-align:right" id="utilidad" name="utilidad" placeholder="utilidad" value="{{$impuesto->utilidad}}">
              <div class="input-group-prepend">
                <div class="input-group-text">(%)</div>
              </div>
        </div>
      </div>
    
      <div class="col-auto">
        <label class="sr-only" for="inlineFormInputGroup"></label>
        <div class="input-group md-2">
            <button type="submit" class="btn btn-primary mb-2">Guardar</button>
        </div>
      </div>
    </div>
  </form>
</div>

{{-- fin del formulario de impuesto --}}
  
    <form  role="form" method="POST" action="{{ route('datos.store') }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div class="form-group">
            <label for="inputAddress">Nombre fiscal</label>
            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ejemplo: Enlances de datos....">
          </div>
          <div class="form-group">
            <label for="inputAddress">Dirección</label>
            <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Ejemplo: Av. Franscico I...">
            <small id="passwordHelpBlock" class="form-text text-muted">
                Puedes poner el correo y el WhatsApp  esto sera el encabezado de la cotización o nota de venta. 
              </small>
        </div>
      
    
        <div class="form-row">
         
          <div class="form-group col-md-2">
            <label for="inputZip">R.F.C.</label>
            <input type="text" class="form-control" id="rfc" name="rfc">
          
          </div>
        </div>
      
        <button type="submit" class="btn btn-primary">Guardar</button>
      </form>
      <div style="margin: 15px"></div>
      <div class="card-md">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Dirección</th>
                    <th>R.F.C.</th>
                    <th>Acciones</th>
                    

                </tr>
            </thead>
            <tfoot>
                <tr>
                  
                    <th>Nombre</th>
                    <th>Dirección</th>
                    <th>R.F.C.</th>
                    <th>Acciones</th>

                </tr>
            </tfoot>
            <tbody>
                @foreach($datos as $item)
                    <tr>

                      {{--   <td>{{ $item->id }}</td> --}}
                        <td class="nombre">{{ $item->nombre }}</td>
                        <td class="direccion">{{ $item->direccion }}</td>
                        <td class="rfc">{{ $item->rfc }}</td>
                        
                        
                       
                        
                        <td>
                            <button type="button" class="btn btn-primary" data-toggle="modal"
                            data-target="#exampleModal" data-whatever="{{ $item->id }}"
                            data-href="{{ route('datos.update', $item->id) }}"><i class="fa fa-edit"
                                aria-hidden="true"></i></button>
                        <button type="button" class="btn btn-danger" data-toggle="modal"
                            data-target="#Modal_eliminar" data-id_eliminar="{{ $item->id }}"
                            data-href="{{ route('datos.destroy', $item->id) }}"><i class="fa fa-trash"
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
                    <h5 class="modal-title" id="exampleModalLabel">Actualizar Datos</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formedit" role="form" method="get" action="{{ route('datos.update', '') }}">
                  
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Nombre:</label>
                            <input type="text" class="form-control" id="nombre" name="nombre">
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Direccion:</label>
                            <input type="text" class="form-control" id="direccion" name="direccion">
                        </div>
                        
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">R.F.C.:</label>
                            <input id="rfc" name="rfc" type="text"  class="form-control" >
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
                    ¿Esta seguro que desea eliminar estos datos?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <form id="formdestroy" class="form-horizontal" role="form" method="get"
                        action="{{ route('datos.destroy', '') }}">
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
                    var direccion = parentTr.find('.direccion').text();
                    var rfc = parentTr.find('.rfc').text();
                    
                    console.log(recipient); // Extract info from data-* attributes
                    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                    var modal = $(this)
                    modal.find('.modal-title').text('Actualizar ' + recipient) /* titulo */
                    modal.find('#nombre').val(recipient); /* input del modal */
                    modal.find('#direccion').val(direccion); /* input del modal */
                    modal.find('#rfc').val(rfc); /* input del DE LA UNIDAD SELECCIONADA */
                   
                    
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