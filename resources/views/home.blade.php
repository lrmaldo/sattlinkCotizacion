@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="mt-4">Dashboard</h1>
    <ol class="breadcrumb mb-4">
        
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>
    
    
    <div class="card-body">
        <a href="{{ route('cotizador.create') }}" class="btn btn-success btn-xs"> <i class="fas fa-file"
            aria-hidden="true"></i> Crear nueva cotización </a>
    <div style="margin: 10px"></div>
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Folio</th>
                        <th>Cliente</th>
                       <th>Vendedor</th>
                        <th>Total</th>
                        <th>Creado</th>
                      {{--   <th>Actualizado</th> --}}
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Folio</th>
                        <th>Cliente</th>
                       <th>Vendedor</th>
                        <th>Total</th>
                        <th>Creado</th>
                      {{--   <th>Actualizado</th> --}}
                        <th>Acciones</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach ($cotizaciones as $item)
                        <tr>
                        <td>{{$item->folio}}</td>
                        
                        @if (isset($item->cliente->nombre))
                        <td>{{ $item->cliente->nombre}}</td>
                        @else
                        <td>**Cliente eliminado**</td>
                        @endif
                        
                        <td style="width: 5%">{{$item->vendedor->name}}</td>
                        <td style="text-align:right;"><script> var pesos = {{$item->total}};document.write(currencyFormat(pesos));</script></td>
                        <td style="text-align:right;">{{date_format($item->created_at,'d/m/Y h:i:s A')}}</td>
                       {{--  <td style="text-align:center;">{{date_format($item->updated_at,'d/m/Y h:i:s A')}}</td> --}}
                        <td>
                            
                            {{-- boton pdf --}}
                        <button type="button" onclick="pdf_ventana('{{$item->id}}')" class="btn btn-info btn-sm" data-toggle="modal"
                          ><i class="fa fa-file-pdf"
                                aria-hidden="true"></i></button>
                                {{-- boton email --}}
                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                        data-target="#ModalCorreo{{$item->id}}"><i class="fa fa-envelope"
                                aria-hidden="true"></i></button>
                              
                                {{-- editar --}}
                        <a href="{{route('cotizador.edit',$item->id)}}" type="button" class="btn btn-primary btn-sm" 
                            ><i class="fa fa-edit"
                                aria-hidden="true"></i></a>
                                {{-- eliminar --}}
                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                            data-target="#modal_eliminar{{$item->id}}" ><i class="fa fa-trash"aria-hidden="true"></i></button>
                        </td>
                      


                        </tr>
                       @include('cotizador.modal.modal_enviar_correo')
                       @include('cotizador.modal.modal_eliminar')
                    @endforeach
                </tbody>
            </table>
        </div>
    
    </div>
</div> 




@endsection

{{-- <div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
            </div>
        </div>
    </div>
</div> --}}

<script>
    function currencyFormat(num) {
  return '$' + num.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
}
function pdf_ventana(id){
    VentanaCentrada('/pdf/'+id,'Cotizacion','','1024','768','true');
    location.href="/home";
}



/* vista de la ventana */
function VentanaCentrada(theURL,winName,features, myWidth, myHeight, isCenter) { //v3.0
  if(window.screen)if(isCenter)if(isCenter=="true"){
    var myLeft = (screen.width-myWidth)/2;
    var myTop = (screen.height-myHeight)/2;
    features+=(features!='')?',':'';
    features+=',left='+myLeft+',top='+myTop;
  }
  window.open(theURL,winName,features+((features!='')?',':'')+'width='+myWidth+',height='+myHeight);
} 
</script>