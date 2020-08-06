@extends('layouts.app')
@section('content')
    {{-- @foreach ($folio as $item)
        {{ $item->folio }}
    @endforeach --}}
    <div class="container-fluid">
        <h1 class="mt-4">Nueva Cotización</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item "><a href="/home">Cotizador</a></li>
            <li class="breadcrumb-item active">Nueva Cotización</li>
        </ol>

        <div class="card-body">

            <form>
                <div class="form-group">
                <label for="inputEmail4"><h4>Detalle fiscal:</h4> </label>
                @foreach ($datosfiscales as $item)
                
                <div class="form-check">
                <input class="form-check-input" type="radio" name="id_datosfiscales" id="id_datosfiscales" value="{{$item->id}}" checked>
                    <label class="form-check-label" for="exampleRadios1">
                    <small>{{$item->nombre}}/ Direccion: {{$item->direccion}}/ R.F.C: {{$item->rfc}}</small><br>
                    </label>
                  </div>
                </div>
                @endforeach 
                 
              
                  
                <div class="row">
                  
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">Vendedor:</label>
                        <input type="text" class="form-control" name="vendedor" value="{{ Auth::user()->name }}"
                            placeholder="Nombre del vendedor">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">Folio</label>
                        @foreach ($folio as $item)

                            <input type="text" class="form-control" name="folio" value="{{ $item->folio }}"
                                placeholder="folio">
                        @endforeach
                    </div>

                    

                </div>
                <label ><h4>Detalle del cliente:</h4> </label>
                <div class="row">
                    <div class="form-group col-md-6">
                        

                            
                               
                                    <label for="inlineFormInput">Selecciona el cliente</label>
                                    <select id='id_cliente' class='mi-selector form-control' name='id_cliente'>
                                        <option value=''>Seleccionar un cliente</option>
                                        @foreach ($clientes as $item)
                                            <option value='{{ $item->id }}'>{{ $item->nombre }}</option>
    
                                        @endforeach
    
                                    </select>
                              
                                
    
                                {{-- <div class="col-auto">
                                    <button onclick="getCliete()" class="btn btn-primary mb-2">Buscar</button>
                                </div> --}}
                     
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">Nombre cliente:</label>
                        <input type="text" class="form-control" name="nombre_cliente" id="nombre_cliente" value=""
                            placeholder="Nombre del vendedor">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                      <label for="inputEmail4">Teléfono</label>
                      <input type="text" class="form-control" id="telefono" name="telefono" value="" placeholder="Escribe el teléfono del cliente" >
                    </div>
                    <div class="form-group col-md-6">
                      <label for="inputPassword4">RFC</label>
                      <input type="text" class="form-control" id="rfc" name="rfc" value="" placeholder="RFC del cliente" >
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputAddress">Dirección</label>
                    <input type="text" class="form-control" id="direccion" name="direccion" value="" placeholder="Escribe la dirección del cliente" >
                  </div>

            </form>
            <div class="float-right">

                <button type="button" class="btn btn-outline-primary" onclick="add()">Agregar productos</button>
            </div>
            
                     <div class="table-responsive">
                <table class="table table-bordered"  width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>U.M.</th>
                            <th>CANT.</th>
                            <th>DESCRIPCIÓN</th>
                            <th class="">PRECIO UNIT.</th>
                            <th class="">IMPORTE</th>
                            
                            <th>Acciones</th>
                        </tr>
                    </thead>
                 
                    <tbody id="resultado">
                       
                    </tbody>
                </table>
            </div>
                   
             
          
           

        </div>
    </div>

    <script>
        jQuery(document).ready(function($) {
            $(document).ready(function() {
                $('.mi-selector').select2();
            });
        });
        const clientes = {!!$clientes!!};
        console.log(clientes);
        //var id_cliente = parentTr.find('.cliente_id').text();
        var id = $('#id_cliente').select2()
        .on("select2:select", function (e) {
       var selected_element = $(e.currentTarget);
       var select_val = selected_element.val();
       console.log(parseInt(select_val))
       var id_num = parseInt(select_val);
       $matriz = clientes.filter(x => x.id === id_num);
         console.log($matriz[0].nombre) 
         var nombre_cliente = $matriz[0].nombre
         var direccion_cliente = $matriz[0].direccion;
         var email_cliente = $matriz[0].email;
         var rfc_cliente =$matriz[0].rfc;
         var telefono = $matriz[0].telefono;
         var descuento_cliente =$matriz[0].descuento;
         document.getElementById('nombre_cliente').value= nombre_cliente;
         document.getElementById('direccion').value= direccion_cliente;
         document.getElementById('rfc').value= rfc_cliente;
         document.getElementById('telefono').value= telefono;
      
});

      /* funcion de agregar productos */
      function add(){
        var token = '{{csrf_token()}}';// ó $("#token").val() si lo tienes en una etiqueta html.
        console.log(token);
        var data={nombre:"test",_token:token};
        $.ajax({

        type:'post',
        url:'/cotizador/add',
        data:data,
        success:function(datos){
            document.getElementById('resultado').innerHTML = datos;
            //$('#resultado').html(datos);
        }
        })
      }

      
    </script>
@endsection
