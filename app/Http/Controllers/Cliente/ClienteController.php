<?php

namespace App\Http\Controllers\Cliente;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TmCliente;

class ClienteController extends Controller
{
    //
    public function index(){
        
        $clientes = DB::table('v_clientes')->Where('id_cliente','<>','1')
                                            ->get();

        $data = [
            'clientes' => $clientes
        ];

        return view('contents.cliente.tm_cliente')->with($data);

    }

    public function index_e($id){

        $cliente = TmCliente::Where('id_cliente',$id)
                            ->first();
        
        $data= [
            'cliente' => $cliente
        ];
        //dd($cliente);
        return view('contents.cliente.tm_cliente_e')->with($data);
    }

    
}
