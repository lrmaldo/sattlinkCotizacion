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
                    <label for="inputEmail4">
                        <h4>Detalle fiscal:</h4>
                    </label>
                    @foreach ($datosfiscales as $item)

                        <div class="form-check">
                        <input class="form-check-input" type="radio" name="id_datosfiscales" id="id_datosfiscales-{{$item->id}}"
                                value="{{ $item->id }}">
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
                        <input type="text" class="form-control" name="vendedor" id="vendedor" value="{{ Auth::user()->name }}"
                            placeholder="Nombre del vendedor" >
                    </div>
                    <div class="form-group col-md-2">
                        <label for="inputEmail4">Folio</label>
                       

                            <input type="text" class="form-control"  id='folio' name="folio" value="{{ $folio }}"
                                placeholder="folio" disabled>
                       
                    </div>
                    <div class="form-group col-md-4">




                        <label for="inlineFormInput">Selecciona el cliente</label>
                        <select id='id_cliente' class='mi-selector form-control' name='id_cliente'>
                            <option value=''>Seleccionar un cliente</option>
                            @foreach ($clientes as $item)
                                <option value='{{ $item->id }}'>{{ $item->nombre }}</option>

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
                                    <td id="nombre_cliente" style="width:50%"> </td>
                                    <td style="width:15%;text-align:right"></td>
                                    <td style="width:20%"></td>
                                </tr>
                                <tr>

                                    <td style="width:15%; ">Dirección:</td>
                                    <td id="direccion" style="width:50%"></td>

                                </tr>
                                <tr>

                                    <td style="width:15%; ">Teléfono:</td>
                                    <td id="telefono" style="width:50%"></td>
                                </tr>
                                <tr>

                                    <td style="width:15%; ">R.F.C.:</td>
                                    <td id="rfc" style="width:50%"></td>
                                </tr>
                                <tr>

                                    <td style="width:15%; ">Descuento:</td>
                                    <td id="descuentoCliente" style="width:50%"></td>
                                </tr>

                            </table>
                        </div>

                    </div>
                </div>



            </form>
            <div class="">
                <div class="form-group row float-right">
                    <div class="col-xs-2 mx-sm-3">
                        <label for="ex1">Buscar producto</label>

                        <select class="js-example-responsive form-control" style="width: 100%; height: 55%"
                            name='id_producto' id='id_producto'>
                            <option value=''>Seleccionar un producto</option>
                            @foreach ($productos as $item)
                                <option value='{{ $item->id }}'>{{ $item->nombre }}</option>

                            @endforeach

                        </select>
                    </div>
                    <div class="col-xs-3 mx-sm-3 ">
                        <label for="ex2">Cantidad</label>
                        <input class="form-control  " style="width: 70%" id="cantidad_producto" type="text"
                            name="cantidad_producto">
                    </div>
                    <div class="col-xs-2">
                        <label for="ex3"></label>
                        {{-- <input class="form-control" id="ex3" type="text">
                        --}}
                        <button type="button" class="btn btn-outline-primary  form-control " onclick="add()">Agregar
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
					<h1>titulo</h1>
					<p>ejemplo.</p>
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

    <script>
        /* iniciar el ckeditor.js */
        initSample();
        /* fin del ckeditor */
        jQuery(document).ready(function($) {
            $(document).ready(function() {
                $('.mi-selector').select2();
            });
        });
        const clientes = {!!$clientes!!};
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
        var id_producto = $('#id_producto').select2()
            .on("select2:select", function(e) {
                var selected_element = $(e.currentTarget);
                id_producto = selected_element.val();
                console.log(parseInt(id_producto));


            });
        /* rescata la tabla del  de cotizacion del cliente  */
        function select() {
            var token = '{{ csrf_token() }}'; // ó $("#token").val() si lo tienes en una etiqueta html.
            //var id_producto;
            var cantidad = $("#cantidad_producto").val();

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
                url: '/cotizador/add_cliente',
                data: data,
                success: function(datos) {
                    document.getElementById('resultado').innerHTML = datos;
                    //$('#resultado').html(datos);
                }
            })
        }


        /* funcion de agregar productos */
        function add() {
            var token = '{{ csrf_token() }}'; // ó $("#token").val() si lo tienes en una etiqueta html.
            //var id_producto;
            var cantidad = $("#cantidad_producto").val();

            var quitarp = document.getElementById('descuentoCliente').innerHTML;
            var descuentoC = quitarp.replace('%', '');
           /*  console.log("sd " + descuentoC);


            console.log(token);
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
                url: '/cotizador/add',
                data: data,
                success: function(datos) {
                    document.getElementById('resultado').innerHTML = datos;
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
                id: id
            };
            $.ajax({

                type: 'post',
                url: '/cotizador/destroy_tmp',
                data: data,
                success: function(datos) {
                    document.getElementById('resultado').innerHTML = datos;
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
            url: '/cotizador/generar',
            data: data,
            success: function(datos) {
               // document.getElementById('resultado').innerHTML = datos;
                //$('#resultado').html(datos);
                VentanaCentrada('/pdf/'+datos,'Cotizacion','','1024','768','true');
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
@endsection
