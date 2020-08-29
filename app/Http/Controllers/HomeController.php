<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\cotizaciones;
use App\impuestos;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cotizaciones = cotizaciones::all();
        return view('home',compact('cotizaciones'));
    }
    public function tipocambio(Request $request){
        $tipo = impuestos::find(1);
        $tipo->tipo_cambio_syscom= $request->tipocambio;
        $tipo->save();
        return $request->all();
    }
}
