<?php

namespace App\Http\Controllers;

use App\Movimiento;
use Illuminate\Http\Request;
use App\Tarjeta;
use Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class MovimientoController extends Controller
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
            'tarjeta' => 'required',
            'monto' => 'required',
            'tipo' => 'required',
            'cliente' => 'required',
            'para' => Rule::requiredIf($request->get('tipo')==='transferencia'),
        ]);
        try {
            
            if($request->get('tipo')==='transferencia') {
                $tarjeta = DB::table('tarjetas')
                    ->selectRaw('beneficiarios')
                    ->where('numero', $request->get('tarjeta'))
                    ->whereNotNull('beneficiarios')
                    ->get();
                $bene = null;
                $tieneBene = true;
                foreach ($tarjeta as $value) {
                    $bene = $value->beneficiarios;
                    break;
                }
                $bene = json_decode($bene, true);
                if(count($bene)===1 && strlen($bene[0])===0) $tieneBene = false;
                if(!$tieneBene) return back()->with('msg_error', 'Imposible realizar transferencias porque la tarjeta no tiene beneficiarios asignados. Solicita a tu ejecutivo de cuenta que los asigne');
            }

            $usuario = Auth::user();
            if (!is_null($usuario)) {
                Movimiento::create([
                    'tarjeta' => $request->get('tarjeta'),
                    'monto' => $request->get('monto'),
                    'tipo' => $request->get('tipo'),
                    'cliente' => $request->get('cliente'),
                    'para' => $request->get('para'),
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
        return back()->with('msg_success', 'El movimiento fue registrado correctamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $movimientos = DB::table('movimientos')
        ->selectRaw('monto')
        ->selectRaw('tipo')
        ->selectRaw('cliente')
        ->selectRaw('para')
        ->selectRaw('tarjeta')
        ->where('tarjeta', $id)
            ->get();


        $resultado = '
            <table class="table table-sm table-striped">
                <thead>
                    <tr>
                        <th>MONTO</th>
                        <th>TIPO</th>
                        <th>CLIENTE</th>
                        <th>PARA</th>
                        <th>TARJETA</th>
                    </tr>
                </thead>
                <tbody>';
        foreach ($movimientos as $value) {
            $para = (is_null($value->para)) ? null : 'Cliente #' . $value->para;
            $resultado .= '
                <tr>
                    <td>' . $value->monto . '</td>
                    <td>' . $value->tipo . '</td>
                    <td>' . $value->cliente . '</td>
                    <td>' . $para . '</td>
                    <td>' . $value->tarjeta . '</td>
                </tr>';
        }
        $resultado .= '
                </tbody>
            </table>';
        return response()->json(['resultado' => $resultado]);
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
