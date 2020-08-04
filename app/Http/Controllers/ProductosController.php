<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\productos;
use App\unidad;
use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/* export excel */
use Maatwebsite\Excel\Facades\Excel;

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
    public function exportExcel(){
        $date = new DateTime();
        $forma = (String) date_format($date, 'd-m-Y H:i:s');
        Excel::create('Productos-'.$forma, function($excel) {
           
            $excel->sheet('Productos', function($sheet) {
                
               // $products = Product::select('id','name','description','serial','quantity')->get();
               // $products = productos::all();
                $products = productos::select('id','nombre','codigo','unidad','precio','created_at')->get();
 
                $sheet->fromArray($products);
 
            });
        })->export('xlsx');
    }

    public function importExcel(Request $request){

        if($request->hasFile('file')){
            Excel::load($request->file('file')->getRealPath(), function ($reader) {
                foreach ($reader->toArray() as $key => $row) {
                  

                    if(!array_key_exists('nombre',$row)){
                        return redirect('productos')->with('error','No existe columna nombre');
                    }
                    if(!array_key_exists('codigo',$row)){
                        return redirect('productos')->with('error','No existe columna codigo');
                    }
                    if(!array_key_exists('unidad',$row)){
                        return redirect('productos')->with('error','No existe columna unidad');
                    }
                    if(!array_key_exists('precio',$row)){
                        return redirect('productos')->with('error','No existe columna precio');
                    }

                    $data['nombre'] = $row['nombre'];
                    $data['codigo'] = $row['codigo'];
                    $data['unidad'] = $row['unidad'];
                    $data['precio'] = $row['precio'];
                    
                    if(!empty($data)) {
                   productos::updateOrCreate([
                            'codigo'=>$row['codigo'] /*  si el codigo es igual solo se actualiza los datos sino se agrega */
                        ],
                        [
                            'nombre'=>$row['nombre'],
                            'unidad'=>$row['unidad'],
                            'codigo'=>$row['codigo'],
                            'precio'=>$row['precio']
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

        return redirect('productos')->with('success','Se a importado los datos correctamente!');
    }
}
