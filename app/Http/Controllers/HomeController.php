<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Cliente;
use App\Tarjeta;
use App\Movimiento;
use Auth;

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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $usuario = Auth::user();
        $usuarioTipo = $usuario->tipo;
        $usuarioID = $usuario->id;
        $usuarioEmail = $usuario->email;

        $clientes = Cliente::all();
        $tarjetas = Tarjeta::all();
        $movimientos = Movimiento::all();

        $data = array('usuarioID'=> $usuarioID, 'usuarioEmail'=> $usuarioEmail, 'tipoDeUsuario'=>$usuarioTipo, 'clientes' =>$clientes, 'tarjetas' => $tarjetas, 'movimientos'=> $movimientos);
        return view('home', compact('data'));
    }
}
