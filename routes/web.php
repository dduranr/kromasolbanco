<?php

use Illuminate\Support\Facades\Route;
use App\User;
use App\Cliente;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes([
    'register' => false, // Deshabilitar Reset Register
    'reset' => false,    // Deshabilitar Reset Password
    'verify' => false,   // Deshabilitar Verification de email
]);

// $usuario = Auth::user();
// $usuarioTipo = null;
// $usuarioID = null;
// $clientes = Cliente::all();
// if (!is_null($usuario)) {
//     $usuarioTipo = $usuario->tipo;
//     $usuarioID = $usuario->id;
// }
// $data = array('usuarioID' => $usuarioID, 'tipoDeUsuario' => $usuarioTipo, 'clientes' => $clientes);





Route::get('/home', 'HomeController@index')->name('home');
Route::resource('clientes', 'ClienteController');
Route::resource('tarjetas', 'TarjetaController');
Route::any('tarjetas/beneficiarios/{tarjeta}', 'TarjetaController@beneficiarios')->name('addBeneficiarios');
Route::resource('ejecutivos', 'EjecutivoController');
Route::resource('movimientos', 'MovimientoController');
