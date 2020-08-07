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
        return view('home',compact('cotizaciones'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$num_cotizacion = cotizaciones::all()->last();
        $folio = DB::select("SELECT CASE WHEN COUNT(*) > 0 THEN CONCAT('FOLIO-',LPAD(SUBSTR(folio,7,11)+1,4,'0'), '/', YEAR(NOW())) ELSE CONCAT('FOLIO-00001', '/', YEAR(NOW())) END AS folio FROM folios WHERE year(created_at) = YEAR(NOW()) ORDER BY folio DESC LIMIT 1");
        $clientes = clientes::all();
        $datosfiscales = datosfiscales::all();
        $productos = productos::all();
        return view('cotizador.create',compact('folio',
        'clientes',
        'datosfiscales',
        'productos'));
    }

    public function add(Request $request){
            $impuesto = impuestos::where('id',1)->first();
            $iva = ($impuesto->cantidad)/100;//impuesto del 16 %
            $descuento_cliente = ((int)$request->descuento_cliente)/100;
            session_start();
            $session_id= session_id();
        
        $producto = productos::where("id",$request->id_producto)->first();
        $tmp = new tmp_detalle_cotizacion();
        $tmp->tmp_cantidad= $request->cantidad;
        $tmp->tmp_precio=$producto->precio;
        $tmp->tmp_id_producto= $producto->id;
        $tmp->session_id =$session_id;
        $tmp->save();
        $datos ="";

        $fortmp = tmp_detalle_cotizacion::all();
        $sumador_total=0;
        foreach ($fortmp as $item){
            $prod = productos::where('id',$item->tmp_id_producto)->first();
            $preciototal= $item->tmp_precio*$item->tmp_cantidad;
            $sumador_total+=$preciototal;//sumador de totales

            $datos= $datos."<tr>
            <td style='text-align: center'>".$prod->unidad."</td>
            <td style='text-align: center'>".$item->tmp_cantidad."</td>
            <td>".$prod->nombre."</td>
            <td style='text-align: center'>$".number_format($item->tmp_precio,2)."</td>
            <td style='text-align: center'>$".number_format(($item->tmp_precio*$item->tmp_cantidad),2)."</td>
            
            <td><a class='btn btn-info '> <i class='fa fa-edit' aria-hidden='true'></i> </a> 
            <a class='btn btn-info ' > <i class='fa fa-edit' aria-hidden='true'></i> </a></td>                 
        </tr>";
        }
        $datos=$datos."<tr>
        <td colspan=4><span class='float-right'>SUB-TOTAL </span></td>
        <td style='text-align: center'><span >$".number_format($sumador_total,2)."</span></td>
       
        </tr>";
      

        $totalcondescuento = $sumador_total-($sumador_total*$descuento_cliente);
        $descuento= ($sumador_total*$descuento_cliente); 
       $datos=$datos."<tr>
        <td colspan=4><span class='float-right'>Descuento %</span></td>
        <td style='text-align: center'><span >$".$descuento."</span></td>
        </tr>";
        $total_con_iva = $sumador_total - ($sumador_total/($iva+1));//calcula el iva del total neto mes el
        $datos=$datos."<tr>
        <td colspan=4><span class='float-right'>I.V.A.</span></td>
        <td style='text-align: center'><span >$".number_format($total_con_iva,2)."</span></td>
        
        </tr>";
        $datos=$datos."<tr>
        <td colspan=4><span class='float-right'>TOTAL </span></td>
        <td style='text-align: center'><span >$".number_format($totalcondescuento,2)."</span></td>
        
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
    public function destroy($id)
    {
        //
    }
}
