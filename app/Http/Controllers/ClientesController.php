<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\clientes;
use DateTime;
use Illuminate\Cache\RetrievesMultipleKeys;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
/* export excel */
use Maatwebsite\Excel\Facades\Excel;

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
            'email' => 'email|unique:clientes',
            'rfc' =>'required'
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



    public function exportExcel(){
        $date = new DateTime(); 
        $forma = (String) date_format($date, 'd-m-Y H:i:s');
        Excel::create('Clientes-'.$forma, function($excel) {
           
            $excel->sheet('Clientes', function($sheet) {
                
               // $products = Product::select('id','name','description','serial','quantity')->get();
               // $products = productos::all();
                $clientes = clientes::select('id','nombre','telefono','direccion','descuento','email' ,'rfc','created_at')->get();
 
                $sheet->fromArray($clientes);
 
            });
        })->export('xlsx');
    }

    public function importExcel(Request $request){

        if($request->hasFile('file')){
            Excel::load($request->file('file')->getRealPath(), function ($reader) {
                foreach ($reader->toArray() as $key => $row) {
                  

                    if(!array_key_exists('nombre',$row)){
                        return redirect('clientes')->with('error','No existe columna nombre');
                    }
                    if(!array_key_exists('telefono',$row)){
                        return redirect('clientes')->with('error','No existe columna telefono');
                    }
                    if(!array_key_exists('descuento',$row)){
                        return redirect('clientes')->with('error','No existe columna descuento');
                    }
                    if(!array_key_exists('rfc',$row)){
                        return redirect('clientes')->with('error','No existe columna rfc');
                    }
                    
                    if(!array_key_exists('direccion',$row)){
                        return redirect('clientes')->with('error','No existe columna direccion');
                    }

                                        
                    if(!empty($row)) {
                   clientes::updateOrCreate(
                       [
                            'rfc'=>$row['rfc'] //  si el rfc es igual solo se actualiza los datos sino se agrega 
                        ],
                        [
                            'nombre'=>$row['nombre'],
                            'telefono'=>$row['telefono'],
                            'direccion'=>$row['direccion'],
                            'descuento'=>$row['descuento'],
                            'email'=>$row['email'],
                            'rfc'=>$row['rfc']
                        ]);
                    }
                   /*  $producto = new productos();
                    $producto->nombre = $row['nombre'];
                    $producto->codigo = $row['codigo'];
                    $producto->unidad = $row['unidad'];
                    $producto->precio = $row['precio'];
                    $producto->save(); */
                  
                   /*  if(!empty($data)) {
                        DB::table('productos')->insert($data);
                    } */
                }
              
            });
        }

        return redirect('clientes')->with('success','Se a importado los datos correctamente!');
    }
}
