<?php

namespace App\Http\Controllers;

use App\clientes;
use Illuminate\Http\Request;
use App\cotizaciones;
use Illuminate\Support\Facades\DB;
use App\datosfiscales;
use App\impuestos;
use App\productos;
use App\tmp_detalle_cotizacion;
use DateTime;

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
        $session_id = session_id();

        $producto = productos::where("id", $request->id_producto)->first();
        
        $exite_prod = tmp_detalle_cotizacion::where('tmp_id_producto',$request->id_producto)->first();
        if($exite_prod){
             $cantidadpre = tmp_detalle_cotizacion::find($exite_prod->id);
             $cantidadpre->tmp_cantidad = $request->cantidad;
             $cantidadpre->save();
                                    
                                    
        }else{
            
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
            $producto = productos::where('id', $update->tmp_id_producto)->first();
            tmp_detalle_cotizacion::where('tmp_id_producto', $producto->id)
                ->update(['tmp_precio' => $producto->precio,]);
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
            <td style='text-align: center'>$" . number_format($item->tmp_precio, 2) . "</td>
            <td style='text-align: center'>$" . number_format(($item->tmp_precio * $item->tmp_cantidad), 2) . "</td>
            
            <td>
            <input type='hidden' id='id_eliminar' name='id_eliminar' value='$item->id' />
        <button type='button' class='btn btn-danger' onclick='eliminar()' 'value='$item->id' id='btn-eliminar'  > <i class='fa fa-trash' aria-hidden='true'></i> </button> 
            </td>                 
        </tr>";
        }
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




    /*  esta funcion es cuando se selecciona el cliente  y muestra la tabla  */
    public function add_cliente(Request $request)
    {
        $impuesto = impuestos::where('id', 1)->first();
        $iva = ($impuesto->cantidad) / 100; //impuesto del 16 %
        $descuento_cliente = ((int) $request->descuento_cliente) / 100;
        session_start();
        $session_id = session_id();


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
        <td style='text-align: center'>$" . number_format($item->tmp_precio, 2) . "</td>
        <td style='text-align: center'>$" . number_format(($item->tmp_precio * $item->tmp_cantidad), 2) . "</td>
        
        <td>
        <input type='hidden' id='id_eliminar' name='id_eliminar' value='$item->id' />
        <button type='button' class='btn btn-danger' onclick='eliminar()' 'value='$item->id' id='btn-eliminar'  > <i class='fa fa-trash' aria-hidden='true'></i> </button> 
        </td>                 
    </tr>";
        }
        $datos = $datos . "<tr>
    <td colspan=4><span class='float-right'>SUB-TOTAL </span></td>
    <td style='text-align: center'><span >$" . number_format(($sumador_total / ($iva + 1)), 2) . "</span></td>
   
    </tr>";
        $total_con_iva = $sumador_total - ($sumador_total / ($iva + 1)); //calcula el iva del total neto mes el
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
        //
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
        //
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
        <td style='text-align: center'>$" . number_format($item->tmp_precio, 2) . "</td>
        <td style='text-align: center'>$" . number_format(($item->tmp_precio * $item->tmp_cantidad), 2) . "</td>
        
        <td>
        <input type='hidden' id='id_eliminar' name='id_eliminar' value='$item->id' />
        <button type='button' class='btn btn-danger' onclick='eliminar()' 'value='$item->id' id='btn-eliminar'  > <i class='fa fa-trash' aria-hidden='true'></i> </button> 
        </td>                 
    </tr>";
        }
        $datos = $datos . "<tr>
    <td colspan=4><span class='float-right'>SUB-TOTAL </span></td>
    <td style='text-align: center'><span >$" . number_format(($sumador_total / ($iva + 1)), 2) . "</span></td>
   
    </tr>";


        $totalcondescuento = $sumador_total - ($sumador_total * $descuento_cliente);
        $descuento = ($sumador_total * $descuento_cliente);
        $datos = $datos . "<tr>
    <td colspan=4><span class='float-right'>Descuento %</span></td>
    <td style='text-align: center'><span >$" . $descuento . "</span></td>
    </tr>";
        $total_con_iva = $sumador_total - ($sumador_total / ($iva + 1)); //calcula el iva del total neto mes el
        $datos = $datos . "<tr>
    <td colspan=4><span class='float-right'>I.V.A.</span></td>
    <td style='text-align: center'><span >$" . number_format($total_con_iva, 2) . "</span></td>
    
    </tr>";
        $datos = $datos . "<tr>
    <td colspan=4><span class='float-right'>TOTAL </span></td>
    <td style='text-align: center'><span >$" . number_format($totalcondescuento, 2) . "</span></td>
    
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
    public function destroy($id)
    {
        //
    }
}
