@extends('layouts.app')
@section('content')
    {{-- @foreach ($folio as $item)
        {{ $item->folio }}
    @endforeach --}}
    @php
    $impuesto = App\impuestos::where('id', 1)->first();
    $iva = ($impuesto->cantidad) / 100; //impuesto del 16 %  
    
    @endphp

    <div class="container-fluid">
        <h1 class="mt-4">Editar</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item "><a href="/home">Cotizador</a></li>
        <li class="breadcrumb-item active">{{$cotizacion->folio}}</li>
        </ol>

        <div class="card-body">

            <form>
                <div class="form-group">
                    <label for="inputEmail4">
                        <h4>Detalle fiscal:</h4>
                    </label>
                    @foreach (App\datosfiscales::get() as $item)
                        @php
                            if($item->id == $cotizacion->id_datosfiscales){
                                $selected = 'checked';
                                }else{
                                $selected = '';
                                }

                        @endphp
                        <div class="form-check">
                        <input class="form-check-input" type="radio" name="id_datosfiscales" id="id_datosfiscales-{{$item->id}}"
                                value="{{ $item->id }}" {{$selected}}>
                            <label class="form-check-label" for="exampleRadios1">
                                <small>{{ $item->nombre }}/ Direccion: {{ $item->direccion }}/ R.F.C:
                                    {{ $item->rfc }}</small><br>
                            </label>
                        </div>
                    @endforeach
                </div>




                <div class="row">

                    <div class="form-group col-md-4">
                        <label for="inputEmail4">Vendedor:</label>
                        <input type="text" class="form-control" name="vendedor" id="vendedor" value="{{ $cotizacion->vendedor->name }}"
                            placeholder="Nombre del vendedor" >
                    </div>
                    <div class="form-group col-md-2">
                        <label for="inputEmail4">Folio</label>
                       

                            <input type="text" class="form-control"  id='folio' name="folio" value="{{ $cotizacion->folio }}"
                                placeholder="folio" disabled>
                       
                    </div>
                    <div class="form-group col-md-4">




                        <label for="inlineFormInput">Selecciona el cliente</label>
                        <select id='id_cliente' class='mi-selector form-control' name='id_cliente'>
                            <option value=''>Seleccionar un cliente</option>
                            @foreach (App\clientes::get() as $item)
                                @php
                                    if($item->id == $cotizacion->cliente->id){
                                        $select = "selected";
                                    }else{
                                        $select ="";
                                    }
                                    
                                @endphp
                                <option value='{{ $item->id }}' {{$select}}>{{ $item->nombre }}</option>

                            @endforeach

                        </select>



                    </div>


                </div>
                <label>
                    <h4>Detalle del cliente:</h4>
                </label>
                <div class="row">
                   
                    <div class="form-group col-md-4">


                   
                        <div class="table-responsive">
                            <table cellspacing="0" style="width: 100%; text-align: left; font-size: 11pt;">
                                <tr>

                                    <td style="width:15%; ">Nombre:</td>
                                <td id="nombre_cliente" style="width:50%">{{isset($cotizacion->cliente->nombre)?$cotizacion->cliente->nombre:''}}</td>
                                    <td style="width:15%;text-align:right"></td>
                                    <td style="width:20%"></td>
                                    
                                </tr>
                                <tr>

                                    <td style="width:15%; ">Dirección:</td>
                                <td id="direccion" style="width:50%">{{isset($cotizacion->cliente->direccion)?$cotizacion->cliente->direccion:''}}</td>

                                </tr>
                                <tr>

                                    <td style="width:15%; ">Teléfono:</td>
                                <td id="telefono" style="width:50%">{{isset($cotizacion->cliente->telefono)?$cotizacion->cliente->telefono:''}}</td></td>
                                </tr>
                                <tr>

                                    <td style="width:15%; ">R.F.C.:</td>
                                <td id="rfc" style="width:50%">{{isset($cotizacion->cliente->rfc)?$cotizacion->cliente->rfc:''}}</td></td>
                                </tr>
                                <tr>

                                    <td style="width:15%; ">Descuento:</td>
                                <td id="descuentoCliente" style="width:50%">{{isset($cotizacion->cliente->descuento)?$cotizacion->cliente->descuento:''}}</td></td>
                                </tr>

                            </table>
                        </div>

                    </div>
                </div>



            </form>
            <div class="">
                <div class="form-group row float-right">
                  
                   {{--  <div class="col-md-12 ">
                        <label for="ex2">Buscar producto</label>
                        
                            <input class="typeahead form-control  " style="" id="nombre_producto" type="text"
                                name="nombre_producto">

                        
                    </div>

                    <div class="col-xs-3 mx-sm-3 ">
                        <label for="ex2">Cantidad</label>
                        <input class="form-control  " style="width: 70%" id="cantidad_producto" type="text"
                            name="cantidad_producto">
                    </div> --}}
                    <div class="col-xs-2">
                        <label for="ex3"></label>
                        {{-- <input class="form-control" id="ex3" type="text">
                        --}}
                       
                        <button type="button" class="btn btn-outline-info  form-control " data-toggle="modal" data-target="#myModalSyscom">Agregar
                            Syscom</button>
                    </div>
                    <div style="padding-right: 10px"></div>
                    <div class="col-xs-2">
                        <label for="ex3"></label>
                        {{-- <input class="form-control" id="ex3" type="text">
                        --}}
                       
                        <button type="button" class="btn btn-outline-primary  form-control " data-toggle="modal" data-target="#myModalProductos">Agregar
                            productos</button>
                    </div>
                    <div style="padding-right: 5px"></div>
                    <div class="col-xs-4">
                        <label for="ex3"></label>
                        {{-- <input class="form-control" id="ex3" type="text">
                        --}}
                        <button type="button" class="btn btn-outline-success  form-control mx-sm-2" onclick="guardar()">Guardar cotización
                        </button>
                        
                    </div>
                </div>





            </div>

            <div class="table-responsive">
                <table class="table " style="width: 100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style="width: 5%">U.M.</th>
                            <th style="width: 5%">CANT.</th>
                            <th style="width: 45%">DESCRIPCIÓN</th>
                            <th style="width: 15%">PRECIO UNIT.</th>
                            <th style="width: 15%">IMPORTE</th>

                            <th style="width: 15%">Acciones</th>
                        </tr>
                    </thead>

                    {{-- @if ($cout)

                    @endif --}}
                    <tbody id="resultado">

                    </tbody>

                </table>
            </div>


            <div class="grid-width-100">
                <h2>Observaciones:</h2>
                
				<div id="editor">
					{!!$cotizacion->comentario!!}
				</div>
			</div>

        </div>
    </div>

    <!-- Modal para eliminar -->
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
                        action="{{ route('cotizador.destroy_tmp', '') }}">
                        {{-- <input type="hidden" name="_method" value="DELETE">
                        --}}
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input class="btn btn-danger btn-xs" type="submit" value="Eliminar" />

                    </form>


                </div>
            </div>
        </div>
    </div>

    {{-- modal productos --}}
    @include('cotizador.modal_productos')

    {{-- modal de syscom --}}
    @include('cotizador.modal_syscom')

    <script>
        /* iniciar el ckeditor.js */
        initSample();
        const clientes = {!!$clientes!!};//clientes 
        const  id_cotizacion = {!!$cotizacion->id!!};//obtener id de la cotizacion

        /* fin del ckeditor */
        $(document).ready(function(){
            select()/* inicia el cotizador si es que hay productos agregados */
            var select_val =$('#id_cliente').val(); //obtiene el valor del value en el selector
                console.log(parseInt(select_val))
                 id_num = parseInt(select_val); //convierte se valor en integer

                $matriz = clientes.filter(x => x.id === id_num); //busca en el objeto los datos del cliente
                console.log($matriz[0].nombre)
                var nombre_cliente = $matriz[0].nombre
                var direccion_cliente = $matriz[0].direccion;
                var email_cliente = $matriz[0].email;
                var rfc_cliente = $matriz[0].rfc;
                var telefono = $matriz[0].telefono;
                descuento_cliente = $matriz[0].descuento;
                document.getElementById('nombre_cliente').innerHTML = nombre_cliente;
                document.getElementById('direccion').innerHTML = direccion_cliente;
                document.getElementById('rfc').innerHTML = rfc_cliente;
                document.getElementById('telefono').innerHTML = telefono;
                document.getElementById('descuentoCliente').innerHTML = descuento_cliente + "%";
        });

        jQuery(document).ready(function($) {
            $(document).ready(function() {
                $('.mi-selector').select2();
            });
        });
        console.log(clientes);
        var id_num;
        var id = $('#id_cliente').select2()
            .on("select2:select", function(e) {
                var selected_element = $(e.currentTarget);
                var select_val = selected_element.val(); //obtiene el valor del value en el selector
                console.log(parseInt(select_val))
                 id_num = parseInt(select_val); //convierte se valor en integer

                $matriz = clientes.filter(x => x.id === id_num); //busca en el objeto los datos del cliente
                console.log($matriz[0].nombre)
                var nombre_cliente = $matriz[0].nombre
                var direccion_cliente = $matriz[0].direccion;
                var email_cliente = $matriz[0].email;
                var rfc_cliente = $matriz[0].rfc;
                var telefono = $matriz[0].telefono;
                descuento_cliente = $matriz[0].descuento;
                document.getElementById('nombre_cliente').innerHTML = nombre_cliente;
                document.getElementById('direccion').innerHTML = direccion_cliente;
                document.getElementById('rfc').innerHTML = rfc_cliente;
                document.getElementById('telefono').innerHTML = telefono;
                document.getElementById('descuentoCliente').innerHTML = descuento_cliente + "%";
                select();

            });
        /* select2 de productos */
        jQuery(document).ready(function($) {
            $(document).ready(function() {
                $(".js-example-responsive").select2({
                    width: 'resolve',
                    heigth: "resolve" // need to override the changed default
                });
            });
        });
      /*   var id_producto = $('#id_producto').select2()
            .on("select2:select", function(e) {
                var selected_element = $(e.currentTarget);
                id_producto = selected_element.val();
                console.log(parseInt(id_producto));


            }); */

            /* buscador de productos */
            var path = "{{ route('cotizador.autocomplete') }}";
                        $('.typeahead').typeahead({
                            source:  function (query, process) {
                            return $.get(path, { query: query }, function (data) {
                                    return process(data);
                                });
                            }
                        });

        /* rescata la tabla del  de cotizacion del cliente  */
        function select() {
            var token = '{{ csrf_token() }}'; // ó $("#token").val() si lo tienes en una etiqueta html.
            //var id_producto;
            var cantidad = $("#cantidad_producto").val();
           /*  var id_cotizacion = {!!$cotizacion->id!!}; */
            var quitarp = document.getElementById('descuentoCliente').innerHTML;
            var descuentoC = quitarp.replace('%', ''); //le quita el simbolo porcentaje
           
            /* console.log("sd " + descuentoC);


            console.log(token);
            console.log(id_producto)
            console.log(cantidad) */
            var data = {
                _token: token,
                descuento_cliente: descuentoC
            };
            $.ajax({

                type: 'post',
                url: '/cotizador/add_cliente_edit/'+id_cotizacion,
                data: data,
                success: function(datos) {
                    document.getElementById('resultado').innerHTML = datos;
                    //$('#resultado').html(datos);
                }
            })
        }


        /* funcion de agregar productos */
        function add(id) {


            var token = '{{ csrf_token() }}'; // ó $("#token").val() si lo tienes en una etiqueta html.
         
            var cantidad = document.getElementById("cantidad-"+id).value; /* obtienen el valor del input de la tabla de productos */
          
            var id_producto = id; ///obtiene el id de producto
           
            console.log(id)
            var quitarp = document.getElementById('descuentoCliente').innerHTML; //obtiene el descuento del cliente
            var descuentoC = quitarp.replace('%', ''); // le quita el signo de porcentaje
             if(isNaN(cantidad)){
                 alert("Esto no es un número");
                 document.getElementById("cantidad-"+id).focus();
                 return false;
             } 
             if(cantidad===""){
                 alert("no hay un valor númerico")
                 document.getElementById("cantidad-"+id).value;
                 return false;
             }


            /* console.log(token);
            console.log(id_producto)
            console.log(cantidad) */
           
            var data = {
                id_producto: id_producto,
                cantidad: cantidad,
                _token: token,
                descuento_cliente: descuentoC
            };
            $.ajax({

                type: 'post',
                url: '/cotizador/edit_producto/'+id_cotizacion,
                data: data,
                success: function(datos) {
                    document.getElementById('resultado').innerHTML = datos;
                    $('.toast').toast('show');
                    //$('#resultado').html(datos);
                }
            })
        }

        //eliminar producto de la tabla de contizaciones
       function eliminar(){
           
       var token = '{{ csrf_token() }}'; // ó $("#token").val() si lo tienes en una etiqueta html.
            //var id_producto;
            var cantidad = $("#cantidad_producto").val();

            var id = $('#id_eliminar').val(); //id del producto en tmp
           /*  console.log(id); */
            var quitarp = document.getElementById('descuentoCliente').innerHTML;
            var descuentoC = quitarp.replace('%', ''); //le quita el simbolo porcentaje
            /* console.log("sd " + descuentoC); */


            /* console.log(token);
            console.log(id_producto)
            console.log(cantidad) */
            var data = {
                _token: token,
                descuento_cliente: descuentoC,
                id: id,
                id_cotizacion: id_cotizacion
            };
            $.ajax({

                type: 'post',
                url: '/cotizador/destroy_producto',
                data: data,
                success: function(datos) {
                  /*   document.getElementById('resultado').innerHTML = datos; */
                  select();
                    //$('#resultado').html(datos);
                }
            })
       }









       ///validacion  de los elementos a enviar 
       function guardar(){
      var id_datosfiscales, vendedor, folio, id_cliente, observaciones;
        
        //obtener el id de datos fiscales *************************
     

        id_datosfiscales = $('input:radio[name="id_datosfiscales"]:checked').val();
        console.log(id_datosfiscales)
            //obtener id del cliente *****************************
            id_cliente = id_num;
          /*   console.log(id_cliente); */
            //obtener vendedor*************************************

            vendedor = document.getElementById('vendedor').value;
            //obtener folio 
            folio = document.getElementById('folio').value;
           /*  console.log(folio) */

            //obtener observaciones

            observaciones = CKEDITOR.instances['editor'].getData();
            ///****************************


            /* validacion ********************** */

            if(isNaN(id_datosfiscales)){
                alert("No has seleccionado los datos fiscales");
                //document.getElementById('id_datosfiscales').focus();
                return false
            }
            if(isNaN(id_cliente)){
                alert("No has seleccionado el cliente");
                //document.getElementById('id_cliente').focus();
                return false;
            }


            var data = {
                _token:'{{ csrf_token() }}',
                id_datosfiscales: id_datosfiscales,
                id_cliente:id_cliente,
                vendedor: vendedor,
                folio:folio,
                observaciones: observaciones

            }
            $.ajax({

            type: 'get',
            url: '/cotizador/guardar/'+id_cotizacion,
            data: data,
            success: function(datos) {
               // document.getElementById('resultado').innerHTML = datos;
                //$('#resultado').html(datos);
                VentanaCentrada('/pdf/'+datos,'Cotizacion','','1024','768','true');
                /* hay que redireccionar al home */
                location.href="/home"
            }
            })
            //console.log(data);
            //VentanaCentrada('/cotizador/generar/'+JSON.stringify(data),'Cotizacion','','1024','768','true');
            
            //VentanaCentrada('/cotizador/generar/'+id_datosfiscales+'/'+observaciones,'Cotizacion','','1024','768','true');


     } 
        function VentanaCentrada(theURL,winName,features, myWidth, myHeight, isCenter) { //v3.0
  if(window.screen)if(isCenter)if(isCenter=="true"){
    var myLeft = (screen.width-myWidth)/2;
    var myTop = (screen.height-myHeight)/2;
    features+=(features!='')?',':'';
    features+=',left='+myLeft+',top='+myTop;
  }
  window.open(theURL,winName,features+((features!='')?',':'')+'width='+myWidth+',height='+myHeight);
}    

       /* $(document).ready(function()
        {
            console.log("hola")
            
        }); */

       //enviar a la url 

       
    </script>
    <script src="{{asset('js/modulosyscom/syscom_edit.js')}}"></script>
@endsection
