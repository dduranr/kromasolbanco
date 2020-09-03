<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tarjeta;
use Auth;

class TarjetaController extends Controller
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
        $this->validate($request, [
            'cliente' => 'required',
            'numero' => 'required|unique:tarjetas',
            'tipo' => 'required',
            'sucursal' => 'required',
        ]);
        try {
            $usuario = Auth::user();
            if (!is_null($usuario)) {
                $beneficiarios = $request->get('beneficiarios');
                $beneficiarios = explode(',', $beneficiarios);
                $beneficiarios = json_encode($beneficiarios, JSON_UNESCAPED_UNICODE);

                $enTramite = false;
                if ((int)$usuario->tipo===2) $enTramite = true;
                Tarjeta::create([
                    'cliente' => $request->get('cliente'),
                    'numero' => $request->get('numero'),
                    'tipo' => $request->get('tipo'),
                    'sucursal' => $request->get('sucursal'),
                    'en_tramite' => $enTramite,
                    'beneficiarios' => $beneficiarios,
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
        return back()->with('msg_success', 'La tarjeta fue creada correctamente');
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
    public function update(Request $request, Tarjeta $tarjeta)
    {
        $this->validate($request, [
            'cliente' => 'required',
            'numero' => 'required',
            'tipo' => 'required',
            'sucursal' => 'required',
        ]);
        try {
            $usuario = Auth::user();
            if (!is_null($usuario)) {
                $tarjeta->update([
                    'en_tramite' => 0,
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
        return back()->with('msg_success', 'Tarjeta actualizada correctamente.');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function beneficiarios(Request $request, Tarjeta $tarjeta)
    {
        $this->validate($request, [
            'cliente' => 'required',
            'numero' => 'required',
            'tipo' => 'required',
            'sucursal' => 'required',
        ]);
        try {
            $usuario = Auth::user();
            if (!is_null($usuario)) {
                $tarjeta->update([
                    'beneficiarios' => [$request->get('beneficiarios')]
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
        return back()->with('msg_success', 'Beneficiarios actualizados correctamente.');
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
