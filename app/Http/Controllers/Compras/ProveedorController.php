<?php

namespace App\Http\Controllers\Compras;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TmProveedor;
class ProveedorController extends Controller
{
    //

    public function index(){
        
        $proveedores = TmProveedor::all();

        $data =[
            'proveedores' => $proveedores
        ];

        return view('contents.proveedor.index')->with($data);
    }
    public function crear(){
        
        $proveedor = new TmProveedor();

        $data =[
            'proveedor' => $proveedor
        ];

        return view('contents.proveedor.editar')->with($data);
    }
    public function editar($id){
        
        $proveedor = TmProveedor::find($id);

        $data =[
            'proveedor' => $proveedor
        ];

        return view('contents.proveedor.editar')->with($data);
    }
}
