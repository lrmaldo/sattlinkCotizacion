<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\unidad;
use Illuminate\Support\Facades\Validator;

class UnidadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $unidad = unidad::all();
        return view('unidad.index',compact('unidad'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      
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
         
        ];
        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
         
        ],$messages);


 
        if ($validator->fails()) {
            return redirect('unidad')
                        ->withErrors($validator)
                        ->withInput();
        }

        $unidad = new unidad();
        $unidad->nombre = $request->nombre;
        $unidad->save();
        return redirect('unidad')->with('success','¡Se guardo correctamente la unidad!');
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
        $unidad = unidad::find($id);
        $unidad->nombre = $request->nombre;
        $unidad->save();
        /* Falta poner la validacion del input del modal */
        return redirect('unidad');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        unidad::destroy($id);
         return redirect('unidad')->with('success','¡Se elimino la unidad de medida correctamente!');
    }
}
