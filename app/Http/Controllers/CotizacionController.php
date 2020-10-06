<?php

namespace App\Http\Controllers;

use App\clientes;
use Illuminate\Http\Request;
use App\cotizaciones;
use Illuminate\Support\Facades\DB;
use App\datosfiscales;
use App\detalle_cotizacion;
use App\detalle_cotizacion_syscom;
use App\impuestos;
use App\productos;
use App\tmp_cotizacion_syscom;
use App\tmp_detalle_cotizacion;
use App\User;
use DateTime;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Mail;

class CotizacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $cotizaciones = cotizaciones::all();
        return view('home', compact('cotizaciones'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$num_cotizacion = cotizaciones::all()->last();
        //$folio = DB::select("SELECT CASE WHEN COUNT(*) > 0 THEN CONCAT('FOLIO-',LPAD(SUBSTR(folio,7,11)+1,4,'0'), '/', YEAR(NOW())) ELSE CONCAT('FOLIO-00001', '/', YEAR(NOW())) END AS folio FROM folios WHERE year(created_at) = YEAR(NOW()) ORDER BY folio DESC LIMIT 1");
        $consuta_folio = DB::table('cotizaciones')
            ->selectRaw('LAST_INSERT_ID(id) as folio')
            ->get();
        $folio = "";
        foreach ($consuta_folio as $cons) {

            $folio = str_pad($cons->folio + 1, 4, "0", STR_PAD_LEFT) . "/" . date("Y");
        }
        if (count($consuta_folio) == 0) {
            $folio = str_pad(1, 4, "0", STR_PAD_LEFT) . "/" . date("Y");
        }



        $clientes = clientes::all();
        $datosfiscales = datosfiscales::all();
        $productos = productos::all();
        $tmp = tmp_detalle_cotizacion::all();
        return view('cotizador.create', compact(
            'folio',
            'clientes',
            'datosfiscales',
            'productos',
            'tmp'
        ));
    }

    public function add(Request $request)
    {
        $impuesto = impuestos::where('id', 1)->first();
        $iva = ($impuesto->cantidad) / 100; //impuesto del 16 %
        $descuento_cliente = ((int) $request->descuento_cliente) / 100;
        session_start();
        $session_id = Auth::user()->id;



        //cambiar por un like
        $producto = productos::where("id", '=', $request->id_producto)->first();

        $exite_prod = tmp_detalle_cotizacion::where('tmp_id_producto', $producto->id)->first();
        if ($exite_prod) {
            $cantidadpre = tmp_detalle_cotizacion::find($exite_prod->id);
            $cantidadpre->tmp_cantidad = $request->cantidad;
            $cantidadpre->save();
        } else {


            $tmp = new tmp_detalle_cotizacion();
            $tmp->tmp_cantidad = $request->cantidad;
            $tmp->tmp_precio = $producto->precio;
            $tmp->tmp_id_producto = $producto->id;
            $tmp->session_id = $session_id;

            $tmp->save();
        }


        //actualizar precios en la tabla temporal de detalle cotizaciones 
        $actualizacion = tmp_detalle_cotizacion::all();

        foreach ($actualizacion as $update) {
            if ($update->tmp_id_producto) {

                $producto = productos::where('id', $update->tmp_id_producto)->first();
                tmp_detalle_cotizacion::where('tmp_id_producto', $producto->id)
                    ->update(['tmp_precio' => $producto->precio,]);
            }
        }
        //fin de actualizacion de precios

        //actualizar cantidad 
        /*  $updat_catidad =tmp_detalle_cotizacion::where('tmp_id_producto',$request->id_producto)
        ->update(['tmp_cantidad'])  */

        $datos = "";

        $fortmp = tmp_detalle_cotizacion::all();
        $sumador_total = 0;
        foreach ($fortmp as $item) {
            $prod = productos::where('id', $item->tmp_id_producto)->first();

            $preciototal = $item->tmp_precio * $item->tmp_cantidad;
            $sumador_total += $preciototal; //sumador de totales

            $datos = $datos . "<tr>
            <td style='text-align: center'>" . $prod->unidad . "</td>
            <td style='text-align: center'>" . $item->tmp_cantidad . "</td>
            <td>" . $prod->nombre . "</td>
            <td style='text-align: center'>$" . number_format(($item->tmp_precio ), 2) . "</td>
            <td style='text-align: center'>$" . number_format((($item->tmp_precio) * $item->tmp_cantidad), 2) . "</td>
            
            <td>
            <input type='hidden' id='id_eliminar' name='id_eliminar' value='$item->id' />
        <button type='button' class='btn btn-danger' onclick='eliminar()' 'value='$item->id' id='btn-eliminar'  > <i class='fa fa-trash' aria-hidden='true'></i> </button> 
            </td>                 
        </tr>";
        }

        /* agregar syscom si es que hay */
        if (tmp_cotizacion_syscom::all()) {
            $syscom =  tmp_cotizacion_syscom::where('session_id', Auth::user()->id)->get();
            foreach ($syscom as $producto_syscom) {
                $sumador_total += ($producto_syscom->tmp_precio_syscom * $producto_syscom->tmp_cantidad_syscom);
                $datos = $datos . "<tr>
                <td style='text-align: center'>" . $producto_syscom->tmp_unidad_syscom . "</td>
                <td style='text-align: center'>" . $producto_syscom->tmp_cantidad_syscom . "</td>
                <td>*" . $producto_syscom->tmp_titulo_syscom . "</td>
                <td style='text-align: center'>$" . number_format($producto_syscom->tmp_precio_syscom, 2) . "</td>
                <td style='text-align: center'>$" . number_format(($producto_syscom->tmp_precio_syscom * $producto_syscom->tmp_cantidad_syscom), 2) . "</td>
                
                <td>
                <input type='hidden' id='id_eliminar_syscom' name='id_eliminar_syscom' value='$producto_syscom->tmp_id_producto_syscom' />
                <button type='button' class='btn btn-danger' onclick='eliminar_syscom()' value='$producto_syscom->tmp_id_syscom' id='btn-eliminar'  > <i class='fa fa-trash' aria-hidden='true'></i> </button> 
                </td>                
            </tr>";
            }
        }

        /* *********************fin de agregar productos syscom******************************** */
        $datos = $datos . "<tr>
        <td colspan=4><span class='float-right'>SUB-TOTAL </span></td>
        <td style='text-align: center'><span >$" . number_format(($sumador_total / ($iva + 1)), 2) . "</span></td>
       
        </tr>";
        $total_con_iva = $sumador_total - ($sumador_total / ($iva + 1)); //calcula el iva del total neto
        $datos = $datos . "<tr>
        <td colspan=4><span class='float-right'>I.V.A.</span></td>
        <td style='text-align: center'><span >$" . number_format($total_con_iva, 2) . "</span></td>
        
        </tr>";


        $totalcondescuento = $sumador_total - ($sumador_total * $descuento_cliente);
        $descuento = ($sumador_total * $descuento_cliente);
        $datos = $datos . "<tr>
        <td colspan=4><span class='float-right'>Descuento %</span></td>
        <td style='text-align: center'><span >$" . $descuento . "</span></td>
        </tr>";

        $datos = $datos . "<tr>
        <td colspan=4><span class='float-right'>TOTAL </span></td>
        <td style='text-align: center'><span >$" . number_format($totalcondescuento, 2) . "</span></td>
        
        </tr>";

        //return  var_dump($request->all());
        return $datos;
    }


    /* buscador de nombre de productos para el input de busqueda */

    public function autocompleteProducto(Request $request)
    {
        //$data = Item::select("title as name")->where("title","LIKE","%{$request->input('query')}%")->get();
        $data = productos::select('nombre as name')->where('nombre', 'LIKE', "%" . $request->input('query') . "%")->get();
        return response()->json($data);
    }




    /*  esta funcion es cuando se selecciona el cliente  y muestra la tabla  */
    public function add_cliente(Request $request)
    {
        $impuesto = impuestos::where('id', 1)->first();
        $iva = ($impuesto->cantidad) / 100; //impuesto del 16 %
        $descuento_cliente = ((int) $request->descuento_cliente) / 100;



        //actualizar precios en la tabla temporal de detalle cotizaciones 
        $actualizacion = tmp_detalle_cotizacion::all();

        foreach ($actualizacion as $update) {
            $producto = productos::where('id', $update->tmp_id_producto)->first();
            tmp_detalle_cotizacion::where('tmp_id_producto', $producto->id)
                ->update(['tmp_precio' => $producto->precio]);
        }
        //fin de actualizacion de precios

        $datos = "";



        $fortmp = tmp_detalle_cotizacion::all();
        $sumador_total = 0;
        foreach ($fortmp as $item) {

            $prod = productos::where('id', $item->tmp_id_producto)->first();

            $preciototal = $item->tmp_precio * $item->tmp_cantidad;
            $sumador_total += $preciototal; //sumador de totales

            $datos = $datos . "<tr>
        <td style='text-align: center'>" . $prod->unidad . "</td>
        <td style='text-align: center'>" . $item->tmp_cantidad . "</td>
        <td>" . $prod->nombre . "</td>
        <td style='text-align: center'>$" . number_format(($item->tmp_precio ), 2) . "</td>
        <td style='text-align: center'>$" . number_format((($item->tmp_precio ) * $item->tmp_cantidad), 2) . "</td>
        
        <td>
        <input type='hidden' id='id_eliminar' name='id_eliminar' value='$item->id' />
        <button type='button' class='btn btn-danger' onclick='eliminar()' 'value='$item->id' id='btn-eliminar'  > <i class='fa fa-trash' aria-hidden='true'></i> </button> 
        </td>                 
    </tr>";
        }

        if (tmp_cotizacion_syscom::all()) {
            $syscom =  tmp_cotizacion_syscom::where('session_id', Auth::user()->id)->get();
            foreach ($syscom as $producto_syscom) {
                $sumador_total += ($producto_syscom->tmp_precio_syscom * $producto_syscom->tmp_cantidad_syscom);
                $total_precio_cantidad = $producto_syscom->tmp_precio_syscom * $producto_syscom->tmp_cantidad_syscom;
                $datos = $datos . "<tr>
                <td style='text-align: center'>" . $producto_syscom->tmp_unidad_syscom . "</td>
                <td style='text-align: center'>" . $producto_syscom->tmp_cantidad_syscom . "</td>
                <td>*" . $producto_syscom->tmp_titulo_syscom . "</td>
                <td style='text-align: center'>$" . number_format(($producto_syscom->tmp_precio_syscom ), 2) . "</td>
                <td style='text-align: center'>$" . number_format(($total_precio_cantidad), 2) . "</td>
                
                <td>
                <input type='hidden' id='id_eliminar_syscom' name='id_eliminar_syscom' value='$producto_syscom->tmp_id_producto_syscom' />
                <button type='button' class='btn btn-danger' onclick='eliminar_syscom()' value='$producto_syscom->tmp_id_syscom' id='btn-eliminar'  > <i class='fa fa-trash' aria-hidden='true'></i> </button> 
                </td>                 
            </tr>";
            }
        }
        /*  ************************fin de agregacion de productos syscom */
        $importe = $sumador_total ;//suma de todo los productos que estan en el cotizador sin iba
        $datos = $datos . "<tr>
    <td colspan=4><span class='float-right'>IMPORTE TOTAL </span></td>
    <td style='text-align: center'><span >$" . number_format($importe, 2) . "</span></td>
   
    </tr>";
        $total_con_iva = $sumador_total - ($sumador_total / ($iva + 1)); //calcula el iva del total neto mes el
        /* calcular el descuento si hay */

        $descuento = bcdiv(($importe * $descuento_cliente), '1', '2');
        $datos = $datos . "<tr>
<td colspan=4><span class='float-right'>Descuento %</span></td>
<td style='text-align: center'><span >$" . $descuento . "</span></td>
</tr>";
        /* IMPORTE MENOS EL DESCUENTO */

        $subtotal = $importe - $descuento;
        $datos = $datos . "<tr>
<td colspan=4><span class='float-right'>SUB-TOTAL </span></td>
<td style='text-align: center'><span >$" . number_format($subtotal, 2) . "</span></td>

</tr>";
        /* el iva del total  */
        $impuestoIVA = $subtotal * $iva;
        $datos = $datos . "<tr>
<td colspan=4><span class='float-right'>I.V.A.</span></td>
<td style='text-align: center'><span >$" . number_format($impuestoIVA, 2) . "</span></td>

</tr>";


        $total = $subtotal + $impuestoIVA;
        $datos = $datos . "<tr>
    <td colspan=4><span class='float-right'>TOTAL </span></td>
    <td style='text-align: center'><span >$" . number_format($total, 2) . "</span></td>
    
    </tr>";

        //return  var_dump($request->all());
        return $datos;
    }

    public function add_syscom(Request $request)
    {

        /* exite producto actualizar cantidad y precio */
        // $exite_producto  = tmp_cotizacion_syscom::all();
        $impuesto = impuestos::find(1)->cantidad;
        $tipo_cambio = impuestos::find(1)->tipo_cambio_syscom;
        $utilidad = impuestos::find(1)->utilidad;
        $actualizacion =  tmp_cotizacion_syscom::where('tmp_id_producto_syscom', $request->id_producto_syscom)->first();
        if ($request->id_producto_syscom == $actualizacion['tmp_id_producto_syscom']) {

            $conversion = ($request->precio_syscom * $tipo_cambio);/* conversion e impuesto */
            //$precio_iva = $conversion + ($conversion * ($impuesto / 100));
            /* ============================================================== */
            $precio_con_utilidad = ($conversion + ($conversion * ($utilidad / 100))) * 1.082;
            /* $precio_con_utilidad = $precio_iva + ($precio_iva *($utilidad/100)); */  /* formula de utilidad  */
            /* ============================================================  */
            /* var precio_con_iva = conversion + (conversion*0.16); */
            tmp_cotizacion_syscom::where('tmp_id_producto_syscom', $request->id_producto_syscom)
                ->update([
                    'tmp_cantidad_syscom' => $request->cantidad,
                    'tmp_precio_syscom' => $precio_con_utilidad,
                    'tmp_precio_dolar_syscom' => $request->precio_syscom
                ]);
        } else {
            $session_id = Auth::user()->id;

            $conversion = ($request->precio_syscom * $tipo_cambio);/* conversion e impuesto */
            $precio_iva = $conversion + ($conversion * ($impuesto / 100));
            /* ============================================================== */
            $precio_con_utilidad = ($conversion + ($conversion * ($utilidad / 100))) * 1.082; /* formula de utilidad  */
            /* ============================================================  */
            $tmp = new tmp_cotizacion_syscom();
            $tmp->tmp_cantidad_syscom = $request->cantidad;
            $tmp->tmp_precio_syscom = $precio_con_utilidad;
            $tmp->tmp_precio_dolar_syscom = $request->precio_syscom;
            $tmp->tmp_id_producto_syscom = $request->id_producto_syscom;
            $tmp->session_id = $session_id;
            $tmp->tmp_titulo_syscom = $request->titulo_syscom;
            $tmp->tmp_unidad_syscom = $request->unidad_syscom;
            $tmp->save();
        }
    }
  

    


    public function guardarCoti(Request $request)
    {
        session_start();
        $session_id = session_id();
        $tmp = tmp_detalle_cotizacion::where('session_id', Auth::user()->id)->get();
        //guardar los productos  cotizados
        $user = User::where('name', 'like', '%' . $request->vendedor . '%')->first();
        /* guarda los datos para un nueva cotizacion */
        $cotizacion = new cotizaciones();
        $cotizacion->folio = $request->folio;
        $cotizacion->forma = 'null';
        $cotizacion->id_datosfiscales = $request->id_datosfiscales;
        $cotizacion->descuento = "0";
        $cotizacion->id_cliente = $request->id_cliente;
        $cotizacion->id_vendedor = $user->id;
        $cotizacion->comentario = $request->observaciones;
        $cotizacion->save();
        $sumador_total = 0;

        foreach ($tmp as $item) {

            $preciototal = $item->tmp_precio * $item->tmp_cantidad;
            $sumador_total += $preciototal; //sumador de totales


            $detalle_cotizacion = new detalle_cotizacion();
            $detalle_cotizacion->cantidad = $item->tmp_cantidad;
            $detalle_cotizacion->precio = $item->tmp_precio;
            $detalle_cotizacion->id_producto = $item->tmp_id_producto;
            $detalle_cotizacion->id_cotizacion = $cotizacion->id;
            $detalle_cotizacion->save();
        }
        if (tmp_cotizacion_syscom::where('session_id', Auth::user()->id)) {
            $syscom = tmp_cotizacion_syscom::where('session_id', Auth::user()->id)->get();
            foreach ($syscom as $tmp_syscom) {

                $sumador_total += $tmp_syscom->tmp_precio_syscom * $tmp_syscom->tmp_cantidad_syscom;/* suma de productos su existe en syscom */

                $detalle_cotizacion_syscom = new detalle_cotizacion_syscom();
                $detalle_cotizacion_syscom->cantidad = $tmp_syscom->tmp_cantidad_syscom;
                $detalle_cotizacion_syscom->id_producto_syscom = $tmp_syscom->tmp_id_producto_syscom;
                $detalle_cotizacion_syscom->titulo_syscom = $tmp_syscom->tmp_titulo_syscom;
                $detalle_cotizacion_syscom->unidad_syscom = $tmp_syscom->tmp_unidad_syscom;
                $detalle_cotizacion_syscom->precio = $tmp_syscom->tmp_precio_syscom;
                $detalle_cotizacion_syscom->precio_dolar = $tmp_syscom->tmp_precio_dolar_syscom;
                $detalle_cotizacion_syscom->session_id = $tmp_syscom->session_id;
                $detalle_cotizacion_syscom->id_cotizacion = $cotizacion->id;
                $detalle_cotizacion_syscom->save();
            }
            //$detalle_cotizacion_syscom->

        }

        /* ============== iva  */
      
        //$cotizacion->total= $sumador_total;}
        $Cliente = clientes::where('id', $request->id_cliente)->first();
        $descuentoCliente = $Cliente->descuento / 100;
      
        $totalcondescuento = ($sumador_total - ($sumador_total * $descuentoCliente));
        $cotizacion->total = $totalcondescuento;
        $cotizacion->descuento = $sumador_total * $descuentoCliente;
        $cotizacion->save();

        tmp_detalle_cotizacion::where('session_id', Auth::user()->id)->delete();
        if (tmp_cotizacion_syscom::where('session_id', Auth::user()->id)) {
            tmp_cotizacion_syscom::where('session_id', Auth::user()->id)->delete();
        }

        return $cotizacion->id;

        //fin de los productoss cotizados

        /*    'id', 'folio', 'forma', 'comentario', 'id_datosfiscales',
        'descuento','total','id_vendedor',
        'id_cliente',
        'id_detalle_cotizacion'  */
    }


    public function generadorPdf($id)
    {
        $exite = cotizaciones::where('id', $id)->first();
        if (isset($exite)) {

            $pdf = app('dompdf.wrapper');
            $data = cotizaciones::where('id', $id)->first();

            $tipo_cambio = impuestos::find(1)->tipo_cambio_syscom;/* tipo de cambio */
            $iva = impuestos::find(1)->iva;
            $utilidad = impuestos::find(1)->utilidad;
            $actualizar = detalle_cotizacion_syscom::where('id_cotizacion', $id)->get();


            foreach ($actualizar as $item) {
                $conversion = $tipo_cambio * $item->precio_dolar;
                $precio_iva = $conversion + ($iva / 100);
                /* ======================================================================== formula con utilidad y un plus */
                $precio_con_utilidad = ($precio_iva + ($precio_iva * ($utilidad / 100))) * 1.082;
                /* ============================================================================ */
                detalle_cotizacion_syscom::where('id_producto_syscom', $item->id_producto_syscom)
                    ->update([
                        'precio' => $precio_con_utilidad/* actualiza el precio de acuerdo al tipo del dolar del dia */
                    ]);
            }



            return \PDF::loadView('pdf.factura', $data)
                ->setPaper('letter', 'portrait')
                ->stream('archivo.pdf');
        } else {
            return response()->view('errors.error', [], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cotizacion = cotizaciones::find($id);
        $productos = productos::all();
        $clientes = clientes::all();

        return view('cotizador.edit', compact('cotizacion', 'productos', 'clientes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $cotizacion = cotizaciones::find($id);


        return view('cotizacion.edit', compact('cotizacion'));/* debe de ir a la vista de cotizacion */
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy_tmp(Request $request)
    {
        tmp_detalle_cotizacion::destroy($request->id);
        $impuesto = impuestos::where('id', 1)->first();
        $iva = ($impuesto->cantidad) / 100; //impuesto del 16 %
        $descuento_cliente = ((int) $request->descuento_cliente) / 100;
        session_start();
        $session_id = session_id();



        $datos = "";

        $fortmp = tmp_detalle_cotizacion::all();
        $sumador_total = 0;
        foreach ($fortmp as $item) {
            //actualizar precios si es que existe

            $prod = productos::where('id', $item->tmp_id_producto)->first();
            $preciototal = $item->tmp_precio * $item->tmp_cantidad;
            $sumador_total += $preciototal; //sumador de totales

            $datos = $datos . "<tr>
        <td style='text-align: center'>" . $prod->unidad . "</td>
        <td style='text-align: center'>" . $item->tmp_cantidad . "</td>
        <td>" . $prod->nombre . "</td>
        <td style='text-align: center'>$" . number_format(($item->tmp_precio ), 2) . "</td>
        <td style='text-align: center'>$" . number_format((($item->tmp_precio ) * $item->tmp_cantidad), 2) . "</td>
        
        <td>
        <input type='hidden' id='id_eliminar' name='id_eliminar' value='$item->id' />
        <button type='button' class='btn btn-danger' onclick='eliminar()' 'value='$item->id' id='btn-eliminar'  > <i class='fa fa-trash' aria-hidden='true'></i> </button> 
        </td>                 
    </tr>";
        }
        /*  agregar productos syscom si es que existe */
        if (tmp_cotizacion_syscom::all()) {
            $syscom =  tmp_cotizacion_syscom::where('session_id', Auth::user()->id)->get();
            foreach ($syscom as $producto_syscom) {
                $sumador_total += ($producto_syscom->tmp_precio_syscom * $producto_syscom->tmp_cantidad_syscom);
                $total_precio_cantidad = $producto_syscom->tmp_precio_syscom * $producto_syscom->tmp_cantidad_syscom;
                $datos = $datos . "<tr>
                <td style='text-align: center'>" . $producto_syscom->tmp_unidad_syscom . "</td>
                <td style='text-align: center'>" . $producto_syscom->tmp_cantidad_syscom . "</td>
                <td>*" . $producto_syscom->tmp_titulo_syscom . "</td>
                <td style='text-align: center'>$" . number_format(($producto_syscom->tmp_precio_syscom / ($iva + 1)), 2) . "</td>
                <td style='text-align: center'>$" . number_format(($total_precio_cantidad / ($iva + 1)), 2) . "</td>
                
                <td>
                <input type='hidden' id='id_eliminar_syscom' name='id_eliminar_syscom' value='$producto_syscom->tmp_id_producto_syscom' />
                <button type='button' class='btn btn-danger' onclick='eliminar_syscom()' value='$producto_syscom->tmp_id_syscom' id='btn-eliminar'  > <i class='fa fa-trash' aria-hidden='true'></i> </button> 
                </td>                 
            </tr>";
            }
        }
        /* *******************fin de agregacion de productos syscom ****************** */
        $importe = ($sumador_total / ($iva + 1));
        $datos = $datos . "<tr>
    <td colspan=4><span class='float-right'>IMPORTE TOTAL </span></td>
    <td style='text-align: center'><span >$" . number_format($importe, 2) . "</span></td>
   
    </tr>";
        $total_con_iva = $sumador_total - ($sumador_total / ($iva + 1)); //calcula el iva del total neto mes el
        /* calcular el descuento si hay */

        $descuento = bcdiv(($importe * $descuento_cliente), '1', '2');
        $datos = $datos . "<tr>
<td colspan=4><span class='float-right'>Descuento %</span></td>
<td style='text-align: center'><span >$" . $descuento . "</span></td>
</tr>";
        /* IMPORTE MENOS EL DESCUENTO */

        $subtotal = $importe - $descuento;
        $datos = $datos . "<tr>
<td colspan=4><span class='float-right'>SUB-TOTAL </span></td>
<td style='text-align: center'><span >$" . number_format($subtotal, 2) . "</span></td>

</tr>";
        /* el iva del total  */
        $impuestoIVA = $subtotal * $iva;
        $datos = $datos . "<tr>
<td colspan=4><span class='float-right'>I.V.A.</span></td>
<td style='text-align: center'><span >$" . number_format($impuestoIVA, 2) . "</span></td>

</tr>";


        $total = $subtotal + $impuestoIVA;
        $datos = $datos . "<tr>
    <td colspan=4><span class='float-right'>TOTAL </span></td>
    <td style='text-align: center'><span >$" . number_format($total, 2) . "</span></td>
    
    </tr>";

        //return  var_dump($request->all());
        return $datos;
    }


    public function destroy_tmp_syscom(Request $request)
    {
        tmp_cotizacion_syscom::where('tmp_id_producto_syscom', $request->id)->delete();

        $impuesto = impuestos::where('id', 1)->first();
        $iva = ($impuesto->cantidad) / 100; //impuesto del 16 %
        $descuento_cliente = ((int) $request->descuento_cliente) / 100;
        session_start();
        $session_id = session_id();



        $datos = "";

        $fortmp = tmp_detalle_cotizacion::all();
        $sumador_total = 0;
        foreach ($fortmp as $item) {
            //actualizar precios si es que existe

            $prod = productos::where('id', $item->tmp_id_producto)->first();
            $preciototal = $item->tmp_precio * $item->tmp_cantidad;
            $sumador_total += $preciototal; //sumador de totales

            $datos = $datos . "<tr>
        <td style='text-align: center'>" . $prod->unidad . "</td>
        <td style='text-align: center'>" . $item->tmp_cantidad . "</td>
        <td>" . $prod->nombre . "</td>
        <td style='text-align: center'>$" . number_format(($item->tmp_precio ), 2) . "</td>
        <td style='text-align: center'>$" . number_format((($item->tmp_precio ) * $item->tmp_cantidad), 2) . "</td>
        
        <td>
        <input type='hidden' id='id_eliminar' name='id_eliminar' value='$item->id' />
        <button type='button' class='btn btn-danger' onclick='eliminar()' 'value='$item->id' id='btn-eliminar'  > <i class='fa fa-trash' aria-hidden='true'></i> </button> 
        </td>                 
    </tr>";
        }
        /*  agregar productos syscom si es que existe */
        if (tmp_cotizacion_syscom::all()) {
            $syscom =  tmp_cotizacion_syscom::where('session_id', Auth::user()->id)->get();
            foreach ($syscom as $producto_syscom) {
                $sumador_total += ($producto_syscom->tmp_precio_syscom * $producto_syscom->tmp_cantidad_syscom);
                $total_precio_cantidad = $producto_syscom->tmp_precio_syscom * $producto_syscom->tmp_cantidad_syscom;
                $datos = $datos . "<tr>
                <td style='text-align: center'>" . $producto_syscom->tmp_unidad_syscom . "</td>
                <td style='text-align: center'>" . $producto_syscom->tmp_cantidad_syscom . "</td>
                <td>*" . $producto_syscom->tmp_titulo_syscom . "</td>
                <td style='text-align: center'>$" . number_format(($producto_syscom->tmp_precio_syscom / ($iva + 1)), 2) . "</td>
                <td style='text-align: center'>$" . number_format(($total_precio_cantidad / ($iva + 1)), 2) . "</td>
                
                <td>
                <input type='hidden' id='id_eliminar_syscom' name='id_eliminar_syscom' value='$producto_syscom->tmp_id_producto_syscom' />
                <button type='button' class='btn btn-danger' onclick='eliminar_syscom()' value='$producto_syscom->tmp_id_syscom' id='btn-eliminar'  > <i class='fa fa-trash' aria-hidden='true'></i> </button> 
                </td>                 
            </tr>";
            }
        }
        /* *******************fin de agregacion de productos syscom ****************** */
        $importe = ($sumador_total / ($iva + 1));
        $datos = $datos . "<tr>
    <td colspan=4><span class='float-right'>IMPORTE TOTAL </span></td>
    <td style='text-align: center'><span >$" . number_format($importe, 2) . "</span></td>
   
    </tr>";
        $total_con_iva = $sumador_total - ($sumador_total / ($iva + 1)); //calcula el iva del total neto mes el
        /* calcular el descuento si hay */

        $descuento = bcdiv(($importe * $descuento_cliente), '1', '2');
        $datos = $datos . "<tr>
<td colspan=4><span class='float-right'>Descuento %</span></td>
<td style='text-align: center'><span >$" . $descuento . "</span></td>
</tr>";
        /* IMPORTE MENOS EL DESCUENTO */

        $subtotal = $importe - $descuento;
        $datos = $datos . "<tr>
<td colspan=4><span class='float-right'>SUB-TOTAL </span></td>
<td style='text-align: center'><span >$" . number_format($subtotal, 2) . "</span></td>

</tr>";
        /* el iva del total  */
        $impuestoIVA = $subtotal * $iva;
        $datos = $datos . "<tr>
<td colspan=4><span class='float-right'>I.V.A.</span></td>
<td style='text-align: center'><span >$" . number_format($impuestoIVA, 2) . "</span></td>

</tr>";


        $total = $subtotal + $impuestoIVA;
        $datos = $datos . "<tr>
    <td colspan=4><span class='float-right'>TOTAL </span></td>
    <td style='text-align: center'><span >$" . number_format($total, 2) . "</span></td>
    
    </tr>";

        //return  var_dump($request->all());
        return $datos;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /* eliminar cotizacion */
    public function destroy($id)
    {
        cotizaciones::destroy($id);
        detalle_cotizacion_syscom::where('id_cotizacion', $id)->delete();
        detalle_cotizacion::where('id_cotizacion', $id)->delete();
        return redirect('cotizador')->with('success', 'Cotizacion eliminada correctamente');
    }





    /* envio de correo con adjunto del  archvivo pdf */
    public function email_pdf(Request $request, $id)
    {


        $exite = cotizaciones::where('id', $id)->first();
        if (isset($exite)) {


            $data = cotizaciones::where('id', $id)->first();
            $folio = $data->folio;

            $tipo_cambio = impuestos::find(1)->tipo_cambio_syscom;/* tipo de cambio */
            $iva = impuestos::find(1)->iva;
            $utilidad = impuestos::find(1)->utilidad;
            $actualizar = detalle_cotizacion_syscom::where('id_cotizacion', $id)->get();


            foreach ($actualizar as $item) {
                $conversion = $tipo_cambio * $item->precio_dolar;
                $precio_iva = $conversion + ($iva / 100);
                /* ======================================================================== formula con utilidad y un plus */
                $precio_con_utilidad = ($precio_iva + ($precio_iva * ($utilidad / 100))) * 1.082;
                /* ============================================================================ */
                detalle_cotizacion_syscom::where('id_producto_syscom', $item->id_producto_syscom)
                    ->update([
                        'precio' => $precio_con_utilidad/* actualiza el precio de acuerdo al tipo del dolar del dia */
                    ]);
            }

            $email_cliente = $request['email' . $id];
            $asunto = $request['asunto' . $id];
            $msj = $request['comentario' . $id];
            $datos = array(

                'mensaje' => $msj,
            );




            $pdf =  PDF::loadView('pdf.factura', $data)
                ->setPaper('letter', 'portrait');

            Mail::send('email.enviar_pdf', $datos, function ($mail) use ($pdf, $asunto, $email_cliente, $folio) {
                $mail->attachData($pdf->output(), 'cotizacion-folio-' . $folio . '.pdf');
                $mail->from('info@sattlink', 'Soporte Sattlink');
                $mail->subject($asunto);
                $mail->to($email_cliente);
            });
            return redirect('home')->with('success', 'Correo enviado exitosamente');
        } else {
            return response()->view('errors.error', [], 500);
        }

        /*  Mail::send('emails/templates/send-invoice', $messageData, function ($mail) use ($pdf) {
            $mail->from('john@styde.net', 'John Doe');
            $mail->to('user@styde.net');
            $mail->attachData($pdf->output(), 'test.pdf');
        }); */
    }

    /* ======================================================================== */
    /* add_cliente en el modulo de editar cotizacion */

    /*  esta funcion es cuando se selecciona el cliente  y muestra la tabla  */
    public function add_cliente_edit(Request $request, $id)
    {
        $impuesto = impuestos::where('id', 1)->first();
        $iva = ($impuesto->cantidad) / 100; //impuesto del 16 %
        $descuento_cliente = ((int) $request->descuento_cliente) / 100;

        $cotizacion_edit = cotizaciones::find($id);

        //actualizar precios en la tabla temporal de detalle cotizaciones 
        $actualizacion = detalle_cotizacion::all();

        foreach ($actualizacion as $update) {
            $producto = productos::where('id', $update->id_producto)->first();
            detalle_cotizacion::where('id_producto', $producto->id)
                ->update(['precio' => $producto->precio]);
        }
        //fin de actualizacion de precios

        $datos = "";



        $fortmp = detalle_cotizacion::where('id_cotizacion', $id)->get();
        $sumador_total = 0;
        if ($fortmp) {
            foreach ($fortmp as $item) {

                $prod = productos::where('id', "=", $item->id_producto)->first();

                $preciototal = $item->precio * $item->cantidad;
                $sumador_total += $preciototal; //sumador de totales

                $datos = $datos . "<tr>
            <td style='text-align: center'>" . $prod->unidad . "</td>
            <td style='text-align: center'>" . $item->cantidad . "</td>
            <td>" . $prod->nombre . "</td>
            <td style='text-align: center'>$" . number_format(($item->precio), 2) . "</td>
            <td style='text-align: center'>$" . number_format((($item->precio) * $item->cantidad), 2) . "</td>
            
            <td>
            <input type='hidden' id='id_eliminar' name='id_eliminar' value='$item->id' />
            <button type='button' class='btn btn-danger' onclick='eliminar()' 'value='$item->id' id='btn-eliminar'  > <i class='fa fa-trash' aria-hidden='true'></i> </button> 
            </td>                 
        </tr>";
            }
        }



        $syscom =  detalle_cotizacion_syscom::where('id_cotizacion', $id)->get();
        foreach ($syscom as $producto_syscom) {
            $sumador_total += ($producto_syscom->precio * $producto_syscom->cantidad);
            $total_precio_cantidad = $producto_syscom->precio * $producto_syscom->cantidad;
            $datos = $datos . "<tr>
                 <td style='text-align: center'>" . $producto_syscom->unidad_syscom . "</td>
                 <td style='text-align: center'>" . $producto_syscom->cantidad . "</td>
                 <td>*" . $producto_syscom->titulo_syscom . "</td>
                 <td style='text-align: center'>$" . number_format(($producto_syscom->precio), 2) . "</td>
                 <td style='text-align: center'>$" . number_format(($total_precio_cantidad), 2) . "</td>
                 
                 
                 <td>
                 <input type='hidden' id='id_eliminar_syscom' name='id_eliminar_syscom' value='$producto_syscom->id_producto_syscom' />
                 <button type='button' class='btn btn-danger' onclick='eliminar_syscom()' value='$producto_syscom->id_syscom' id='btn-eliminar'  > <i class='fa fa-trash' aria-hidden='true'></i> </button> 
                 </td>                 
             </tr>";
        }

        /*  ************************fin de agregacion de productos syscom */
        $importe = $sumador_total;
        $datos = $datos . "<tr>
     <td colspan=4><span class='float-right'>IMPORTE TOTAL </span></td>
     <td style='text-align: center'><span >$" . number_format($importe, 2) . "</span></td>
    
     </tr>";
      

        $descuento = bcdiv(($importe * $descuento_cliente), '1', '2');
        $datos = $datos . "<tr>
 <td colspan=4><span class='float-right'>Descuento %</span></td>
 <td style='text-align: center'><span >$" . $descuento . "</span></td>
 </tr>";
        /* IMPORTE MENOS EL DESCUENTO */

        $subtotal = $importe - $descuento;
        $datos = $datos . "<tr>
 <td colspan=4><span class='float-right'>SUB-TOTAL </span></td>
 <td style='text-align: center'><span >$" . number_format($subtotal, 2) . "</span></td>
 
 </tr>";
        /* el iva del total  */
        $impuestoIVA = $subtotal * $iva;
        $datos = $datos . "<tr>
 <td colspan=4><span class='float-right'>I.V.A.</span></td>
 <td style='text-align: center'><span >$" . number_format($impuestoIVA, 2) . "</span></td>
 
 </tr>";


        $total = $subtotal + $impuestoIVA;
        $datos = $datos . "<tr>
     <td colspan=4><span class='float-right'>TOTAL </span></td>
     <td style='text-align: center'><span >$" . number_format($total, 2) . "</span></td>
     
     </tr>";

        //return  var_dump($request->all());
        return $datos;
    }


    /* ===== editar producto del servidor */

    public function edit_producto(Request $request, $id)
    {
        $impuesto = impuestos::where('id', 1)->first();
        $iva = ($impuesto->cantidad) / 100; //impuesto del 16 %
        $descuento_cliente = ((int) $request->descuento_cliente) / 100;
        session_start();
        $session_id = Auth::user()->id;



        //cambiar por un like
        $producto = productos::where("id", '=', $request->id_producto)->first();

        $exite_prod = detalle_cotizacion::where('id_cotizacion', $id)->where('id_producto','=',$request->id_producto)->first();/* si exite en el cotizador y en el producto */
        if ($exite_prod) {
            $cantidadpre = detalle_cotizacion::find($exite_prod->id);
            $cantidadpre->cantidad = $request->cantidad;
            $cantidadpre->save();
        } else {


            $tmp = new detalle_cotizacion();
            $tmp->cantidad = $request->cantidad;
            $tmp->precio = $producto->precio;
            $tmp->id_producto = $producto->id;
           
            $tmp->id_cotizacion = $id;

            $tmp->save();
        }


        //actualizar precios en la tabla temporal de detalle cotizaciones 
        $actualizacion = detalle_cotizacion::all();

        foreach ($actualizacion as $update) {
            if ($update->id_producto) {

                $producto = productos::where('id', $update->id_producto)->first();
                detalle_cotizacion::where('id_producto', $producto->id)
                    ->update(['precio' => $producto->precio,]);
            }
        }
        //fin de actualizacion de precios

        //actualizar cantidad 
        /*  $updat_catidad =tmp_detalle_cotizacion::where('tmp_id_producto',$request->id_producto)
        ->update(['tmp_cantidad'])  */

        $datos = "";

        $fortmp = detalle_cotizacion::where('id_cotizacion',$id)->get();
        $sumador_total = 0;
        foreach ($fortmp as $item) {
            $prod = productos::where('id', $item->id_producto)->first();

            $preciototal = $item->precio * $item->cantidad;
            $sumador_total += $preciototal; //sumador de totales

            $datos = $datos . "<tr>
            <td style='text-align: center'>" . $prod->unidad . "</td>
            <td style='text-align: center'>" . $item->cantidad . "</td>
            <td>" . $prod->nombre . "</td>
            <td style='text-align: center'>$" . number_format(($item->precio ), 2) . "</td>
            <td style='text-align: center'>$" . number_format((($item->precio ) * $item->cantidad), 2) . "</td>
            
            <td>
            <input type='hidden' id='id_eliminar' name='id_eliminar' value='$item->id' />
        <button type='button' class='btn btn-danger' onclick='eliminar()' 'value='$item->id' id='btn-eliminar'  > <i class='fa fa-trash' aria-hidden='true'></i> </button> 
            </td>                 
        </tr>";
        }

        /* agregar syscom si es que hay */
        $syscom =  detalle_cotizacion_syscom::where('id_cotizacion', $id)->get();
        foreach ($syscom as $producto_syscom) {
            $sumador_total += ($producto_syscom->precio * $producto_syscom->cantidad);
            $total_precio_cantidad = $producto_syscom->precio * $producto_syscom->cantidad;
            $datos = $datos . "<tr>
                 <td style='text-align: center'>" . $producto_syscom->unidad_syscom . "</td>
                 <td style='text-align: center'>" . $producto_syscom->cantidad . "</td>
                 <td>*" . $producto_syscom->titulo_syscom . "</td>
                 <td style='text-align: center'>$" . number_format(($producto_syscom->precio), 2) . "</td>
                 <td style='text-align: center'>$" . number_format(($total_precio_cantidad), 2) . "</td>
                 
                 
                 <td>
                 <input type='hidden' id='id_eliminar_syscom' name='id_eliminar_syscom' value='$producto_syscom->id_producto_syscom' />
                 <button type='button' class='btn btn-danger' onclick='eliminar_syscom()' value='$producto_syscom->id_syscom' id='btn-eliminar'  > <i class='fa fa-trash' aria-hidden='true'></i> </button> 
                 </td>                 
             </tr>";
        }

        /*  ************************fin de agregacion de productos syscom */
        $importe = $sumador_total;
        $datos = $datos . "<tr>
     <td colspan=4><span class='float-right'>IMPORTE TOTAL </span></td>
     <td style='text-align: center'><span >$" . number_format($importe, 2) . "</span></td>
    
     </tr>";
        $total_con_iva = $sumador_total - ($sumador_total / ($iva + 1)); //calcula el iva del total neto mes el
        /* calcular el descuento si hay */

        $descuento = bcdiv(($importe * $descuento_cliente), '1', '2');
        $datos = $datos . "<tr>
 <td colspan=4><span class='float-right'>Descuento %</span></td>
 <td style='text-align: center'><span >$" . $descuento . "</span></td>
 </tr>";
        /* IMPORTE MENOS EL DESCUENTO */

        $subtotal = $importe - $descuento;
        $datos = $datos . "<tr>
 <td colspan=4><span class='float-right'>SUB-TOTAL </span></td>
 <td style='text-align: center'><span >$" . number_format($subtotal, 2) . "</span></td>
 
 </tr>";
        /* el iva del total  */
        $impuestoIVA = $subtotal * $iva;
        $datos = $datos . "<tr>
 <td colspan=4><span class='float-right'>I.V.A.</span></td>
 <td style='text-align: center'><span >$" . number_format($impuestoIVA, 2) . "</span></td>
 
 </tr>";


        $total = $subtotal + $impuestoIVA;
        $datos = $datos . "<tr>
     <td colspan=4><span class='float-right'>TOTAL </span></td>
     <td style='text-align: center'><span >$" . number_format($total, 2) . "</span></td>
     
     </tr>";

        //return  var_dump($request->all());
        return $datos;
    }


    public function edit_syscom(Request $request, $id)
    {

        /* exite producto actualizar cantidad y precio */
        // $exite_producto  = tmp_cotizacion_syscom::all();
       
        $tipo_cambio = impuestos::find(1)->tipo_cambio_syscom;
        $utilidad = impuestos::find(1)->utilidad;
        $actualizacion =  detalle_cotizacion_syscom::where('id_cotizacion', $id)->where('id_producto_syscom',$request->id_producto_syscom)->first();
        if ($request->id_producto_syscom == $actualizacion['id_producto_syscom']) {

            $conversion = ($request->precio_syscom * $tipo_cambio);/* conversion e impuesto */
           
            /* ============================================================== */
            $precio_con_utilidad = ($conversion + ($conversion * ($utilidad / 100))) * 1.082;
            /* $precio_con_utilidad = $precio_iva + ($precio_iva *($utilidad/100)); */  /* formula de utilidad  */
            /* ============================================================  */
            /* var precio_con_iva = conversion + (conversion*0.16); */
            detalle_cotizacion_syscom::where('id_producto_syscom', $request->id_producto_syscom)
                ->update([
                    'cantidad' => $request->cantidad,
                    'precio' => $precio_con_utilidad,
                    'precio_dolar' => $request->precio_syscom
                ]);
        } else {
            $session_id = Auth::user()->id;

            $conversion = ($request->precio_syscom * $tipo_cambio);/* conversion e impuesto */
            
            /* ============================================================== */
            $precio_con_utilidad = ($conversion + ($conversion * ($utilidad / 100))) * 1.082;
            /* ============================================================  */
            $tmp = new detalle_cotizacion_syscom();
            $tmp->cantidad = $request->cantidad;
            $tmp->precio = $precio_con_utilidad;
            $tmp->precio_dolar = $request->precio_syscom;
            $tmp->id_producto_syscom = $request->id_producto_syscom;
            $tmp->session_id = $session_id;
            $tmp->id_cotizacion = $id;
            $tmp->titulo_syscom = $request->titulo_syscom;
            $tmp->unidad_syscom = $request->unidad_syscom;
            $tmp->save();
        }
    }

    public function destroy_syscom(Request $request)
    {
        detalle_cotizacion_syscom::where('id_producto_syscom','=', $request->id)
                        ->where('id_cotizacion','=',$request->id_cotizacion)->delete();
                        return "se elimino producto";
        
        
    }
    public function destroy_producto(Request $request)
    {
        /* return $request->all(); */
        $elimino =detalle_cotizacion::where('id','=', $request->id)
                        ->where('id_cotizacion','=',$request->id_cotizacion)->delete();
                        return $elimino;
        
        
    }


    /* guardar la edicion de  la cotizacion */
    public function guardar_edit_cotizacion(Request $request,$id)
    {
       
        $tmp = detalle_cotizacion::where('id', $id)->get();
        //guardar los productos  cotizados
       
        /* guarda los datos para un nueva cotizacion */
        $cotizacion =  cotizaciones::find($id);
        //$cotizacion->folio = $request->folio;
        $cotizacion->forma = 'null';
        $cotizacion->id_datosfiscales = $request->id_datosfiscales;
        $cotizacion->descuento = "0";
        $cotizacion->id_cliente = $request->id_cliente;
        //$cotizacion->id_vendedor = $user->id;
        $cotizacion->comentario = $request->observaciones;
        $cotizacion->save();
        $sumador_total = 0;

        foreach ($tmp as $item) {

            $preciototal = $item->tmp_precio * $item->tmp_cantidad;//********************************* */
            $sumador_total += $preciototal; //sumador de totales


        }
        if (detalle_cotizacion_syscom::where('id_cotizacion','=', $id)) {
            $syscom = detalle_cotizacion_syscom::where('id_cotizacion','=', $id)->get();
            foreach ($syscom as $tmp_syscom) {
                $sumador_total += $tmp_syscom->precio * $tmp_syscom->cantidad;/* suma de productos su existe en syscom */
            }
            //$detalle_cotizacion_syscom->

        }

       
        $Cliente = clientes::where('id', $request->id_cliente)->first();
        $descuentoCliente = $Cliente->descuento / 100;
      
        $totalcondescuento = ($sumador_total - ($sumador_total * $descuentoCliente));
        $cotizacion->total = $totalcondescuento;
        $cotizacion->descuento = $sumador_total * $descuentoCliente;
        $cotizacion->save();

      /*   tmp_detalle_cotizacion::where('session_id', Auth::user()->id)->delete();
        if (tmp_cotizacion_syscom::where('session_id', Auth::user()->id)) {
            tmp_cotizacion_syscom::where('session_id', Auth::user()->id)->delete();
        } */

        return $cotizacion->id;

        //fin de los productoss cotizados

        /*    'id', 'folio', 'forma', 'comentario', 'id_datosfiscales',
        'descuento','total','id_vendedor',
        'id_cliente',
        'id_detalle_cotizacion'  */
    }
}
