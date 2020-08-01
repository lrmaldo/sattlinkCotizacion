@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <h1 class="mt-4">Unidad de medida</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item "><a href="/home">Dashboard</a></li>
            <li class="breadcrumb-item active">Unidad</li>
        </ol>

        <div class="card-body">
           {{--  <a href="{{ url('usuarios/create') }}" class="btn btn-success btn-xs"> <i class="fas fa-user-plus" aria-hidden="true"></i> Agregar usuario </a> --}}

           <form class="form-inline" role="form" method="POST"  action="{{ route('unidad.store') }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            
            <label class="sr-only" for="inlineFormInputGroupUsername2">Unidad de medida</label>
            <div class="input-group mb-2 mr-sm-2">
              <div class="input-group-prepend">
                <div class="input-group-text">U.M.</div>
              </div>
              <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Unidad">
             
             {{--  <span class="help-block">
                @if(count($errors)>0)
                @foreach ($errors->all() as $error)
                <strong style="color: red">{{ $error }}</strong> <br>
                    
                @endforeach
                @endif  
              </span> --}}
            </div>
          
           
          
            <button type="submit" class="btn btn-primary mb-2">Guardar</button>
          </form>

           <div style="margin: 10px"></div>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                           
                            <th>Nombre</th>
                            <th>Acción</th>

                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            
                            <th>Nombre</th>
                           
                            <th>Acción</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach($unidad as $item)
                            <tr>

                               
                                <td class="nombre" >{{ $item->nombre }}</td>
                            
                                <td>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="{{$item->id}}" data-href="{{ route('unidad.update', $item->id) }}"><i class="fa fa-edit" aria-hidden="true"></i></button>
                                  {{--   <a href="{{ route('usuarios.edit',['id'=>$item->id]) }}" class="btn btn-info btn-xs"> <i class="fa fa-edit" aria-hidden="true"></i> </a> --}}
                                <a href="{{ route('usuarios.destroy',$item->id) }}" class="btn btn-danger btn-xs"> <i class="fa fa-trash" aria-hidden="true" onclick="return confirm('Deseas eliminarlo')"></i> </a>
                                <a href="#" data-href="{{ route('unidad.destroy', $item->id) }}" data-toggle="modal" data-target="#modaldelete"><i class="fa fa-trash" style="margin-left:10px"></i></a>   
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>

        </div>
    </div>


    {{-- modal --}}
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Actualizar Unidad de medida</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <form id="formedit" role="form" method="get" action="{{ route('unidad.update', '' ) }}">
                  {{--   <input type="hidden" name="_method" value="PUT"> --}}
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group">
                  <label for="recipient-name" class="col-form-label">Nombre:</label>
                  <input type="text" class="form-control" id="nombre" name="nombre">
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


    <script>
$('#exampleModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var id = button.data('whatever')

  var parentTr = button.closest('tr');
  var recipient =  parentTr.find('.nombre').text(); 
  console.log(recipient);// Extract info from data-* attributes
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  var modal = $(this)
  modal.find('.modal-title').text('Actualizar ' + recipient +" "+id)
  modal.find('.modal-body input').val(recipient);
  modal.find('#formedit').attr('action', function (i,old) {
       return old + '/' + id;
    });
});

    </script>

 
@endsection
