<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Cliente;
use App\User;
use App\Ejecutivo;
use Auth;
use Illuminate\Support\Str;

class EjecutivoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $sucursales = $request->get('sucursales');
        $sucursales = json_encode($sucursales);

        $this->validate($request, [
            'nombre' => 'required',
            'email' => 'required|unique:users',
            'sucursales' => 'required',
        ]);
        try {
            $usuario = Auth::user();
            if (!is_null($usuario)) {
                User::create([
                    'name' => $request->get('nombre'),
                    'email' => $request->get('email'),
                    'password' => Hash::make($request->get('contrasena')),
                    'tipo' => 1,
                ]);
                Ejecutivo::create([
                    'nombre' => $request->get('nombre'),
                    'email' => $request->get('email'),
                    'sucursales' => $sucursales,
                ]);
            } else {
                $msg_error = 'You are probably NOT LOGGED into the system yet. Please login and try again.';
                return back()->with('msg_error', $msg_error);
            }
        } catch (\Throwable $th) {
            $msg_error = $th->getMessage();
            if (strpos($msg_error, 'non-object') !== false) {
                $msg_error = $msg_error . '. You are probably NOT LOGGED into the system yet. Please login and try again.';
            }
            return back()->with('msg_error', $msg_error);
        }
        return back()->with('msg_success', 'El ejecutivo fue creado correctamente');
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
