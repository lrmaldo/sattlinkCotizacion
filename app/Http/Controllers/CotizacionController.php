<?php

namespace App\Http\Controllers;

use App\clientes;
use Illuminate\Http\Request;
use App\cotizaciones;
use Illuminate\Support\Facades\DB;
use App\datosfiscales;
use App\productos;
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
        $productos = productos::all();
        $datos ="";
        foreach ($productos as $item){
            $datos= $datos."<tr>

            <td>".$item->unidad."</td>
            <td>1</td>
            <td>".$item->nombre."</td>
            <td>".$item->precio."</td>
            <td>".($item->precio*1)."</td>
            
            <td><a class='btn btn-info btn-xs'> <i class='fa fa-edit' aria-hidden='true'></i> </a>                  
        </tr>";
        }
       
       
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
