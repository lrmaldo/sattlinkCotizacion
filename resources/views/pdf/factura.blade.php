   @php
      $impuesto = App\impuestos::where('id', 1)->first();
      $iva = ($impuesto->cantidad) / 100; //impuesto del 16 %  
      $folio = App\cotizaciones::find($id)->folio;
      
     
   @endphp

 
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>Cotizacion {{$folio}}</title>
<style>
    /** Define the margins of your page **/
    @page {
        margin: 110px 28px;
    }

    header {
        position: fixed;
        top: -90px;
        left: 0px;
        right: 0px;
        height:35px;
        padding-bottom: 1%;
       

        /** Extra personal styles **/
        background-color: #ffffff;
        color: rgb(0, 0, 0);
        text-align: center;
        line-height: 35px;
    }
    body {
        margin: 3mm 4mm 2mm 4mm;
            }
    footer {
        position: fixed; 
        bottom: 0px; 
        left: 0px; 
        right: 0px;
        height: 0px; 

        /** Extra personal styles **/
        background-color: #ffffff;
        color: rgb(0, 0, 0);
        text-align: center;
        line-height: 0px;
    }
</style>
 
</head>
<body>

    <header>
        <?php $datos = App\datosfiscales::where('id',$id_datosfiscales)->first()?>
        <table cellspacing="0" style="width: 100%; white-space:nowrap;">
            <tr>
        
                <td style="width: 25%; color: #444444;">
                    <img style="width: 200px;" src="./img/logo.png" alt="Logo"><br>
                    
                </td>
                <td style="width: 50%;text-align:center">
                    <p>{{$datos->nombre}}</p>
                    <p>{{$datos->rfc}}</p>
              
                    {{-- <p>{{$datos}}</p> --}}
                   
                    
                </td>
                <td style="width: 25%;text-align:right">
                Folio Nº {{$folio}}
                </td>
                
            </tr>
        </table>
    </header>

   
  
<main  style="font-size: 12pt; font-family: arial; margin-top:17px" >
  {{--   <page_footer>
    <table class="page_footer">
        <tr>

            <td style="width: 50%; text-align: left">
                P&aacute;gina [[page_cu]]/[[page_nb]]
            </td>
            <td style="width: 50%; text-align: right">
                &copy; {{date('Y')}} 
            </td>
        </tr>
    </table>
</page_footer> --}}



<br>
    <table cellspacing="0" style="width: 100%; text-align: left; font-size: 10pt;">
		<tr>
		<td style="width:50%; "><strong>Dirección:</strong> <br>{{$datos->direccion}}<br> Teléfono.: (287)8757734  / (229) 173 8806 </td>
		
		</tr>
	</table>
	
	<table cellspacing="0" style="width: 100%; text-align: rigth; font-size: 11pt;">
		<tr>
            <td style="width:15%; "></td>
            <td style="width:50%"></td>
			<td style="width:15%;text-align:right"> </td>
		
            <td style="width: 39%;">
               <?php  $fecha = new Datetime($updated_at)?> 
			Fecha: {{$fecha->format("d-m-Y g:i A")}} 
			</td>
		</tr>
    </table>
    
    
    <table cellspacing="0" style="width: 100%; text-align: left; font-size: 11pt;">

        <tr>
           <?php $vendedor =App\User::where('id',$id_vendedor)->first(); ?>
            <td style="width:15%; ">Vendedor:</td>
            <td style="width:50%">{{$vendedor->name}}   Correo: {{$vendedor->email}}</td>
            <td style="width:50%">Correo: {{$vendedor->email}}</td>
			<td style="width:15%;text-align:right"> </td>
			<td style="width:20%">&nbsp;  </td>
        </tr>
        <tr>
            @php
                $cliente= App\clientes::where('id',$id_cliente)->first();
            @endphp
            <td style="width:15%; ">Cliente:</td>
            <td style="width:50%">{{$cliente->nombre}}</td>
			<td style="width:15%;text-align:right"> Teléfono:</td>
			<td style="width:20%">&nbsp;{{$cliente->telefono}} </td>
        </tr>
        <tr>
            
            <td style="width:15%; ">Dirección:</td>
        <td style="width:50%">{{$cliente->direccion}}</td>
        </tr>
   
    </table>
    <br>

   {{--  <table cellspacing="0" style="width: 100%; text-align: left;font-size: 11pt">
        <tr>
             <td style="width:100%;  text-align:center">A continuación Presentamos nuestra oferta que esperamos sea de su conformidad.</td>
        </tr>
    </table> --}}

    <table cellspacing="0" style="width: 100%; border: solid 1px black; background: #E7E7E7; text-align: center; font-size: 10pt;padding:1mm;">
        <tr>
            <th style="width: 5%">U.M.</th>
            <th style="width: 5%">CANT.</th>
            <th style="width: 60%">DESCRIPCION</th>
            <th style="width: 15%">PRECIO UNIT.</th>
            <th style="width: 15%">PRECIO TOTAL</th>
            
        </tr>
    </table>
    <table cellspacing="0" style="width: 100%; border: solid 1px black;  text-align: center; font-size: 11pt;padding:1mm;">
        @php
            $detalle_cotizacion = App\detalle_cotizacion::where('id_cotizacion',$id)->get();
            $sumador=0;
        @endphp
        @foreach ($detalle_cotizacion as $item)
            
        <tr>
        <td style="width: 5%; text-align: center">{{$item->producto->unidad}}</td>
        <td style="width: 5%; text-align: center">{{$item->cantidad}}</td>
        <td style="width: 60%; text-align: left">{{$item->producto->nombre}}</td>
            <td style="width: 15%; text-align: right">${{number_format($item->producto->precio,2)}}</td>
        <td style="width: 15%; text-align: right">${{number_format($item->producto->precio*$item->cantidad,2)}}</td>
            
        </tr>
        {{-- sumador de productos --}}
            @php
                $sumador+=($item->producto->precio*$item->cantidad)
                
            @endphp
        @endforeach

        {{-- si exite productos syscom --}}

        @php
            $detalle_syscom = App\detalle_cotizacion_syscom::where('id_cotizacion',$id)->get();
        @endphp
        
        @foreach ($detalle_syscom as $syscom)
        <tr>
            <td style="width: 5%; text-align: center">{{$syscom->unidad_syscom}}</td>
            <td style="width: 5%; text-align: center">{{$syscom->cantidad}}</td>
            <td style="width: 60%; text-align: left">*{{$syscom->titulo_syscom}}</td>
                <td style="width: 15%; text-align: right">${{number_format(($syscom->precio),2)}}</td>
            <td style="width: 15%; text-align: right">${{number_format(($syscom->precio*$syscom->cantidad),2)}}</td>
                
            </tr>

            @php
            $sumador+=($syscom->precio*$syscom->cantidad);
            
        @endphp
        @endforeach
    </table>
      {{-- calcular iba y el descuento --}}
      @php
         /*  $impuesto = App\impuestos::where('id', 1)->first();
          $iva = ($impuesto->cantidad) / 100; //impuesto del 16 % */


          
          $importe= $sumador;
          $total_precio_costo =($importe-(($impuesto->utilidad/100)*$importe));
        
          //$conversion +($conversion *($iva/100))
          // $subtotal = $sumador;
          //$totalcondescuento = $subtotal - ($subtotal * $descuento_cliente)
          
          
          $descuento_cliente = $importe*($cliente->descuento/100);
          $subtotal = $importe - $descuento_cliente;
          $total_del_iva = $subtotal*$iva;
          
          //$total_neto = ($subtotal-$descuento_cliente)+$total_del_iva; 
          $total_neto = $subtotal + $total_del_iva;
         
          /* guardar el total */
          $guardar_coti = App\cotizaciones::find($id);
          $guardar_coti->total = $descuento_cliente;
          $guardar_coti->total = $total_neto;
          $guardar_coti->save();
          
          
      @endphp
    <table cellspacing="0" style="width: 100%; border: solid 1px black; background: #E7E7E7; text-align: center; font-size: 11pt;padding:1mm;">
        
        <tr>
            <th style="width: 87%; text-align: right;">IMPORTE: </th>
        <th style="width: 13%; text-align: right;">&#36;{{number_format($importe,2)}}</th>
        </tr>
         @if ($cliente->descuento)
         <tr>
            <th style="width: 87%; text-align: right;">DESCUENTO({{$cliente->descuento}}%): </th>
        <th style="width: 13%; text-align: right;">&#36;{{number_format($descuento_cliente,2)}}</th>
        </tr>
         @endif

        <tr>
            <th style="width: 87%; text-align: right;">SUB-TOTAL: </th>
        <th style="width: 13%; text-align: right;">&#36;{{number_format($subtotal,2)}}</th>
        </tr>
        <tr>
            <th style="width: 87%; text-align: right;">I.V.A. : </th>
            <th style="width: 13%; text-align: right;">&#36;{{number_format($total_del_iva,2)}}</th>
        </tr>


        <tr>
            <th style="width: 87%; text-align: right;">TOTAL : </th>
        <th style="width: 13%; text-align: right;">&#36;{{number_format($total_neto,2)}}</th>
        </tr>
    </table>
	*** Precios incluyen IVA ***
	
	<br>
          <table cellspacing="0" style="width: 100%; text-align: center; font-size: 11pt;">
            <tr>
                    <td style="width:50%;"><?php echo $comentario ?> </td>
                  
            </tr>
			
        </table>
    <br><br><br><br>
    </main>
    <footer>
        Copyright  Sattlink &copy; <?php echo date("Y");?> 
        <br>
        <p>Para mayor información: &nbsp; Tel: (287)8756019 &nbsp; 
             <a href="mailto:info@sattlink.com">info@sattlink.com</a> &nbsp;
            Horario de atención 9:00am a 7:00pm</p>

        
    </footer>
</body>
</html>




{{-- <!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Cotización</title>
        <style>
        h1{
        text-align: center;
        text-transform: uppercase;
        }
        .contenido{
        font-size: 20px;
        }
        #primero{
        background-color: #ccc;
        }
        #segundo{
        color:#44a359;
        }
        #tercero{
        text-decoration:line-through;
        }
    </style>
    </head>
    <body>
        <h1>{{$folio}}</h1>
        <h2>{{$id_datosfiscales}}</h2>
        <hr>
        <div class="contenido">
            <p id="primero">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Labore nihil illo odit aperiam alias rem voluptatem odio maiores doloribus facere recusandae suscipit animi quod voluptatibus, laudantium obcaecati quisquam minus modi.</p>
            <p id="segundo">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Labore nihil illo odit aperiam alias rem voluptatem odio maiores doloribus facere recusandae suscipit animi quod voluptatibus, laudantium obcaecati quisquam minus modi.</p>
            <p id="tercero">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Labore nihil illo odit aperiam alias rem voluptatem odio maiores doloribus facere recusandae suscipit animi quod voluptatibus, laudantium obcaecati quisquam minus modi.</p>
        </div>
    </body>
</html> --}}