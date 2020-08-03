<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\productos;
use App\unidad;
use Illuminate\Support\Facades\Validator;

class ProductosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productos = productos::all();
        $unidades = unidad::all();
        return view('productos.index',compact('productos','unidades'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $unidades = unidad::all();
        return view('productos.create',compact('unidades'));
    }

    /**
     * Store a newly created resource in storage.
     *glyphicon glyphicon-floppy-saved
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
            'precio'=> 'required',
            'unidad'=> 'required',
            
        ],$messages);


 
        if ($validator->fails()) {
            return redirect('productos/create')
                        ->withErrors($validator)
                        ->withInput();
        }
     
      $producto = new productos();
      $producto->nombre  = $request->nombre;
      $producto->codigo = $request->codigo;
      $producto->precio = $request->precio;
      $producto->unidad = $request->unidad;
      $producto->save();

      return redirect('productos')->with('success','¡Se creo correctamente el producto!');
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
        $messages = [
            'required' => 'el :attribute es requerido',
            'unique' =>'el codigo existe'
        ];
        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
            'precio'=> 'required',
            'unidad'=> 'required',
            
        ],$messages);


 
        if ($validator->fails()) {
            return redirect('productos')
                        ->withErrors($validator)
                        ->withInput();
        }
     
        $producto = productos::find($id);
        $producto->nombre  = $request->nombre;
        $producto->codigo = $request->codigo;
        $producto->precio = $request->precio;
        $producto->unidad = $request->unidad;
        $producto->save();

      return redirect('productos')->with('info','¡Se Actualizo correctamente el producto');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        productos::destroy($id);
        return redirect('productos')->with('info','¡Producto eliminado correctamente!');
    }
}
