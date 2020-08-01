<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\clientes;
use Illuminate\Cache\RetrievesMultipleKeys;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class ClientesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clientes = clientes::all();
        return view('clientes.index',compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('clientes.create');
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
            'unique' =>'el correo ya existe'
        ];
        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
            'telefono'=> 'required',
            'porcentaje' => 'required|min:0',
            'email' => 'email|unique:clientes'
        ],$messages);


 
        if ($validator->fails()) {
            return redirect('clientes/create')
                        ->withErrors($validator)
                        ->withInput();
        }
        $cliente = new clientes();
        $cliente->nombre = $request->nombre;
        $cliente->email = $request->correo;
        $cliente->direccion = $request->direccion;
        $cliente->telefono = $request->telefono;
        $cliente->descuento = $request->porcentaje;
        $cliente->rfc = $request->rfc;
        $cliente->save();
        return redirect('clientes')->with('success','¡Se creo correctamente el cliente!');


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
        $cliente = clientes::find($id);
        return view('clientes.edit',compact('cliente'));
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
            'email' =>'el correo ya existe'
        ];
        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
            'telefono' =>'required',
            'porcentaje' => 'required|min:0',
            'email' => 'email|unique:clientes'
        ],$messages);

        $cliente = clientes::find($id);
        $cliente->nombre = $request->nombre;
        $cliente->email = $request->correo;
        $cliente->direccion = $request->direccion;
        $cliente->telefono = $request->telefono;
        $cliente->descuento = $request->porcentaje;
        $cliente->rfc = $request->rfc;
        $cliente->save();
        return redirect('clientes')->with('success','¡Se a actualizado el cliente correctamente!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        clientes::destroy($id);
        return redirect('clientes')->with('success','¡Se a eliminado el cliente correctamente!');
    }
}
