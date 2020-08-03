<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\impuestos;
use App\datosfiscales;
use Illuminate\Support\Facades\Validator;
class DatosfiscalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datos = datosfiscales::all();
        $impuesto = impuestos::find(1);
        return view('datos.index',compact('impuesto',"datos"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $messages = [
            'required' => 'el :attribute es requerido',
            'unique' =>'el codigo existe'
        ];
        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
            'direccion' => 'required',
            'rfc' => 'required|unique:datosfiscales',
           
            
        ],$messages);


 
        if ($validator->fails()) {
            return redirect('datos')
                        ->withErrors($validator)
                        ->withInput();
        }

        $datos = new datosfiscales();
        $datos->nombre = $request->nombre;
        $datos->direccion =$request->direccion;
        $datos->rfc = $request->rfc;
        $datos->save();
        return redirect('datos')->with('success',"Datos fiscales guardado");
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
    public function impuesto(Request $request, $id)
    {
        
        $messages = [
            'required' => 'el :attribute es requerido',
            'unique' =>'el codigo existe'
        ];
        $validator = Validator::make($request->all(), [
            'impuesto' => 'required',
           
            
        ],$messages);


 
        if ($validator->fails()) {
            return redirect('datos')
                        ->withErrors($validator)
                        ->withInput();
        }

         $impuesto = impuestos::find($id);
         $impuesto->cantidad = $request->impuesto;
         $impuesto->save();
         //return $request->all();
         return redirect('datos')->with('info',"I.V.A. actualizado");

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
        $messages = [
            'required' => 'el :attribute es requerido',
            'unique' =>'el codigo existe'
        ];
        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
            'direccion' => 'required',
            'rfc' => 'required|unique:datosfiscales',
           
            
        ],$messages);


 
        if ($validator->fails()) {
            return redirect('datos')
                        ->withErrors($validator)
                        ->withInput();
        }

        $datos =datosfiscales::find($id);
        $datos->nombre =$request->nombre;
        $datos->direccion =$request->direccion;
        $datos->rfc=$request->rfc;
        $datos->save();
        return redirect('datos')->with('info',"Datos actualizados");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        datosfiscales::destroy($id);
        return redirect('datos')->with('info',"Se elimino los datos");
    }
}
