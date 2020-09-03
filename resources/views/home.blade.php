@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <h1>Cliente actual: {{ $data['usuarioID'] }}</h1>

        <div class="col-md-12">
            <!-- Esto se encarga de mostrar errores de validación -->
            @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <!-- Esto se encarga de mostrar el mensaje de éxito en caso que se haya generado correctamente el book -->
            @if(session('msg_success'))
            <div class="alert alert-success">
                {{ session('msg_success') }}
            </div>
            @endif

            <!-- Esto se encarga de mostrar el mensaje de error en caso que se haya generado correctamente el book -->
            @if(session('msg_error'))
            <div class="alert alert-danger">
                {{ session('msg_error') }}
            </div>
            @endif
        </div>


        <!-- Si el usuario es EJECUTIVO -->
        <!-- Si el usuario es EJECUTIVO -->
        <!-- Si el usuario es EJECUTIVO -->
        @if($data['tipoDeUsuario']===1)

            <div id="accordion1" class="w-100">
                <div class="card">
                    <div class="card-header" id="headingOne">
                        <h5 class="mb-0">
                            <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            TARJETAS EN TRÁMITE
                            </button>
                        </h5>
                    </div>
                    <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion1">
                        <div class="card-body">
                            <div class="col-md-12 my-5">
                                <h2 class="text-center">TARJETAS EN TRÁMITE</h2>
                                <table class="table table-sm table-striped">
                                    <thead>
                                        <th>ID</th>
                                        <th>CLIENTE</th>
                                        <th>NÚMERO DE TARJETA</th>
                                        <th>TIPO</th>
                                        <th>SUCURSAL</th>
                                        <th>BENEFICIARIOS</th>
                                        <th></th>
                                    </thead>
                                    <tbody>
                                        @foreach($data['tarjetas'] as $tarjeta)
                                            @if($tarjeta->en_tramite === 1)
                                                @php
                                                    $beneficiarios = json_decode($tarjeta->beneficiarios,true);
                                                    $beneficiarios = implode(', ', $beneficiarios);
                                                @endphp
                                                <tr>
                                                    <td>{{ $tarjeta->id }}</td>
                                                    <td>{{ $tarjeta->cliente }}</td>
                                                    <td>{{ $tarjeta->numero }}</td>
                                                    <td>{{ $tarjeta->tipo }}</td>
                                                    <td>{{ $tarjeta->sucursal }}</td>
                                                    <td>{{ $beneficiarios }}</td>
                                                    <td>
                                                        <form action="{{ route('tarjetas.update', $tarjeta->id) }}" method="POST">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="accion" value="activar_tarjeta">
                                                            <input type="hidden" name="id" value="{{ $tarjeta->id }}">
                                                            <input type="hidden" name="cliente" value="{{ $tarjeta->cliente }}">
                                                            <input type="hidden" name="numero" value="{{ $tarjeta->numero }}">
                                                            <input type="hidden" name="tipo" value="{{ $tarjeta->tipo }}">
                                                            <input type="hidden" name="sucursal" value="{{ $tarjeta->sucursal }}">
                                                            <input type="submit" value="Activar tarjeta" class="form-control btn btn-success" />
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingTwo">
                        <h5 class="mb-0">
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Crear EJECUTIVO
                            </button>
                        </h5>
                    </div>
                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion1">
                        <div class="card-body">
                            <div class="col-md-12 my-5">
                                <h2 class="text-center">Crear EJECUTIVO</h2>
                                <form action="{{ route('ejecutivos.store') }}" method="POST">
                                    @csrf
                                    @method('POST')

                                    <div class="form-group">
                                        <input type="text" name="nombre" placeholder="Nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre') }}" />
                                        @error('nombre')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <input type="email" name="email" placeholder="Email (Recuerda: El email será también el usuario del ejecutivo)" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" />
                                        @error('email')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <input type="password" name="contrasena" placeholder="Contraseña" class="form-control @error('contrasena') is-invalid @enderror" value="{{ old('contrasena') }}" />
                                        @error('contrasena')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <select type="text" name="sucursales[]" class="form-control @error('sucursales') is-invalid @enderror" multiple="multiple">
                                            <option value="">:: Elige sucursales ::</option>
                                            <option value="1">Sucursal 1</option>
                                            <option value="2">Sucursal 2</option>
                                            <option value="3">Sucursal 3</option>
                                        </select>
                                        @error('sucursales')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>

                                    <input type="submit" value="Crear" class="form-control btn btn-success" />
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingThree">
                        <h5 class="mb-0">
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            Crear CLIENTE
                            </button>
                        </h5>
                    </div>
                    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion1">
                        <div class="card-body">
                            <div class="col-md-12">
                                <h2 class="text-center">Crear CLIENTE</h2>
                                <form action="{{ route('clientes.store') }}" method="POST">
                                    @csrf
                                    @method('POST')

                                    <div class="form-group">
                                        <input type="text" name="nombre" placeholder="Nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre') }}" />
                                        @error('nombre')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <input type="text" name="direccion" placeholder="Dirección" class="form-control @error('direccion') is-invalid @enderror" value="{{ old('direccion') }}" />
                                        @error('direccion')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <input type="number" name="telefono" placeholder="Teléfono" class="form-control @error('telefono') is-invalid @enderror" value="{{ old('telefono') }}" />
                                        @error('telefono')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <input type="email" name="email" placeholder="Email (Recuerda: El email será también el usuario del ejecutivo)" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" />
                                        @error('email')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <input type="password" name="contrasena" placeholder="Contraseña" class="form-control @error('contrasena') is-invalid @enderror" value="{{ old('contrasena') }}" />
                                        @error('contrasena')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>

                                    <input type="submit" value="Crear" class="form-control btn btn-success" />
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingFour">
                        <h5 class="mb-0">
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                            Crear TARJETA
                            </button>
                        </h5>
                    </div>
                    <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordion1">
                        <div class="card-body">
                            <div class="col-md-12">
                                <h2 class="text-center">Crear TARJETA</h2>
                                <form action="{{ route('tarjetas.store') }}" method="POST">
                                    @csrf
                                    @method('POST')

                                    <div class="form-group">
                                        <select name="cliente" class="form-control @error('cliente') is-invalid @enderror" value="{{ old('cliente') }}">
                                            <option value="">:: Selecciona cliente ::</option>
                                            @foreach($data['clientes'] as $cliente)
                                            <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
                                            @endforeach
                                        </select>
                                        @error('cliente')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <input type="number" name="numero" placeholder="Número" class="form-control @error('numero') is-invalid @enderror" value="{{ old('numero') }}" />
                                        @error('numero')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <select type="text" name="tipo" class="form-control @error('tipo') is-invalid @enderror" value="{{ old('tipo') }}">
                                            <option value="">:: Elige tipo ::</option>
                                            <option value="debito">Débito</option>
                                            <option value="credito">Crédito</option>
                                            <option value="ahorro">Ahorro</option>
                                            <option value="nomina">Nómina</option>
                                        </select>
                                        @error('sucursal')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <select type="text" name="sucursal" class="form-control @error('sucursal') is-invalid @enderror" value="{{ old('sucursal') }}">
                                            <option value="">:: Elige sucursal ::</option>
                                            <option value="1">Sucursal 1</option>
                                            <option value="2">Sucursal 2</option>
                                            <option value="3">Sucursal 3</option>
                                        </select>
                                        @error('sucursal')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>

                                    <input type="submit" value="Crear" class="form-control btn btn-success" />
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="card">
                    <div class="card-header" id="headingFive">
                        <h5 class="mb-0">
                            <button class="btn btn-link" data-toggle="collapse" data-target="#collapseFive" aria-expanded="true" aria-controls="collapseFive">
                            ASIGNAR BENEFICIARIOS
                            </button>
                        </h5>
                    </div>

                    <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordion1">
                        <div class="card-body">
                            <div class="col-md-12 my-5">
                                <h2 class="text-center">ASIGNAR BENEFICIARIOS</h2>
                                <table class="table table-sm table-striped">
                                    <thead>
                                        <th>CLIENTE</th>
                                        <th>NÚMERO DE TARJETA</th>
                                        <th>TIPO</th>
                                        <th>BENEFICIARIOS</th>
                                        <th></th>
                                    </thead>
                                    <tbody>
                                        @foreach($data['tarjetas'] as $tarjeta)
                                            @php
                                                $beneficiarios = json_decode($tarjeta->beneficiarios,true);
                                                $beneficiarios = implode(', ', $beneficiarios);
                                            @endphp
                                            <tr>
                                                <td>{{ $tarjeta->cliente }}</td>
                                                <td>{{ $tarjeta->numero }}</td>
                                                <td>{{ $tarjeta->tipo }}</td>
                                                <td>
                                                    <form action="{{ route('addBeneficiarios', $tarjeta->id) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="text" name="beneficiarios" value="{{ $beneficiarios }}" class="form-control" />
                                                        <input type="hidden" name="accion" value="agregar_beneficiarios">
                                                        <input type="hidden" name="id" value="{{ $tarjeta->id }}">
                                                        <input type="hidden" name="cliente" value="{{ $tarjeta->cliente }}">
                                                        <input type="hidden" name="numero" value="{{ $tarjeta->numero }}">
                                                        <input type="hidden" name="tipo" value="{{ $tarjeta->tipo }}">
                                                        <input type="hidden" name="sucursal" value="{{ $tarjeta->sucursal }}">
                                                        <input type="submit" value="Agregar" class="form-control btn btn-success" />
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>


                </div>

            </div>







































        <!-- Si el usuario es CLIENTE -->
        <!-- Si el usuario es CLIENTE -->
        <!-- Si el usuario es CLIENTE -->
        @elseif($data['tipoDeUsuario']===2)

            <div id="accordion2" class="w-100">
                <div class="card">
                    <div class="card-header" id="headingOne">
                        <h5 class="mb-0">
                            <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Tramitar TARJETA
                            </button>
                        </h5>
                    </div>
                    <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion2">
                        <div class="card-body">
                            <div class="col-md-12 my-5">
                                <h2 class="text-center">Tramitar TARJETA</h2>
                                <form action="{{ route('tarjetas.store') }}" method="POST">
                                    @csrf
                                    @method('POST')
                                    <input type="hidden" name="cliente" value="{{ $data['usuarioID'] }}">

                                    <div class="form-group">
                                        <input type="number" name="numero" placeholder="Número" class="form-control @error('numero') is-invalid @enderror" value="{{ old('numero') }}" />
                                        @error('numero')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <select type="text" name="tipo" class="form-control @error('tipo') is-invalid @enderror" value="{{ old('tipo') }}">
                                            <option value="">:: Elige tipo ::</option>
                                            <option value="debito">Débito</option>
                                            <option value="credito">Crédito</option>
                                            <option value="ahorro">Ahorro</option>
                                            <option value="nomina">Nómina</option>
                                        </select>
                                        @error('sucursal')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <select type="text" name="sucursal" class="form-control @error('sucursal') is-invalid @enderror" value="{{ old('sucursal') }}">
                                            <option value="">:: Elige sucursal ::</option>
                                            <option value="1">Sucursal 1</option>
                                            <option value="2">Sucursal 2</option>
                                            <option value="3">Sucursal 3</option>
                                        </select>
                                        @error('sucursal')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <input type="text" name="beneficiarios" placeholder="Beneficiarios (Coloca sus nombres separados por comas)" class="form-control @error('beneficiarios') is-invalid @enderror" value="{{ old('beneficiarios') }}" />
                                        @error('beneficiarios')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                    <input type="submit" value="Crear" class="form-control btn btn-success" />
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingTwo">
                        <h5 class="mb-0">
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            LISTADO DE TARJETAS
                            </button>
                        </h5>
                    </div>
                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion2">
                        <div class="card-body">
                            <div class="col-md-12 my-5">
                                <h2 class="text-center">LISTADO DE TARJETAS</h2>
                                <table class="table table-sm table-striped">
                                    <thead>
                                        <th>NÚMERO DE TARJETA</th>
                                        <th>SALDO DISPONIBLE</th>
                                        <th style="padding: 0 30px">DEPÓSITOS</th>
                                        <th style="padding: 0 30px">RETIROS</th>
                                        <th style="padding: 0 0 0 30px">TRANSFERENCIAS</th>
                                    </thead>
                                    <tbody>
                                        @php
                                            $movimientosXtarjeta = array();
                                        @endphp

                                        @foreach($data['movimientos'] as $movimiento)
                                            @if($movimiento->cliente === $data['usuarioID'] && $movimiento->tipo === 'deposito')
                                                @php
                                                    $movimientosXtarjeta[$movimiento->tarjeta]['depositos'] = 0;
                                                    $movimientosXtarjeta[$movimiento->tarjeta]['depositosHTML'] = '';
                                                @endphp
                                            @endif
                                            @if($movimiento->cliente === $data['usuarioID'] && $movimiento->tipo === 'retiro')
                                                @php
                                                    $movimientosXtarjeta[$movimiento->tarjeta]['retiros'] = 0;
                                                    $movimientosXtarjeta[$movimiento->tarjeta]['retirosHTML'] = '';
                                                @endphp
                                            @endif
                                            @if($movimiento->cliente === $data['usuarioID'] && $movimiento->tipo === 'transferencia')
                                                @php
                                                    $movimientosXtarjeta[$movimiento->tarjeta]['transferencias'] = 0;
                                                    $movimientosXtarjeta[$movimiento->tarjeta]['transferenciasHTML'] = '';
                                                @endphp
                                            @endif
                                        @endforeach

                                        @foreach($data['movimientos'] as $movimiento)
                                            @if($movimiento->cliente === $data['usuarioID'] && $movimiento->tipo === 'deposito')
                                                @php
                                                    $movimientosXtarjeta[$movimiento->tarjeta]['depositos'] += $movimiento->monto;
                                                    $movimientosXtarjeta[$movimiento->tarjeta]['depositosHTML'] .= '<li>'.$movimiento->monto.'</li>';
                                                @endphp
                                            @endif
                                            @if($movimiento->cliente === $data['usuarioID'] && $movimiento->tipo === 'retiro')
                                                @php
                                                    $movimientosXtarjeta[$movimiento->tarjeta]['retiros'] += $movimiento->monto;
                                                    $movimientosXtarjeta[$movimiento->tarjeta]['retirosHTML'] .= '<li>'.$movimiento->monto.'</li>';
                                                @endphp
                                            @endif
                                            @if($movimiento->cliente === $data['usuarioID'] && $movimiento->tipo === 'transferencia')
                                                @php
                                                    $movimientosXtarjeta[$movimiento->tarjeta]['transferencias'] += $movimiento->monto;
                                                    $movimientosXtarjeta[$movimiento->tarjeta]['transferenciasHTML'] .= '<li>'.$movimiento->monto.' para cliente #'.$movimiento->para.'</li>';
                                                @endphp
                                            @endif
                                        @endforeach

                                        @foreach($movimientosXtarjeta as $tarjetaNumero => $tarjeta)
                                            @php
                                                $depositosTotales = 0;
                                                $retirosTotales = 0;
                                                $transferenciasTotales = 0;

                                                if(isset($tarjeta['depositos'])) $depositosTotales = $tarjeta['depositos'];
                                                if(isset($tarjeta['retiros'])) $retirosTotales = $tarjeta['retiros'];
                                                if(isset($tarjeta['transferencias'])) $transferenciasTotales = $tarjeta['transferencias'];

                                                $deduccionesTotales = $retirosTotales + $transferenciasTotales;
                                                $saldoFinal = $depositosTotales - $deduccionesTotales;
                                            @endphp

                                            <tr>
                                                <td>{{ $tarjetaNumero }}</td>
                                                <td>{{ $saldoFinal }}</td>
                                                <td>
                                                    <ul class="">{!! $tarjeta['depositosHTML'] !!}</ul>
                                                    <p><strong>TOTAL: </strong>@if(isset($tarjeta['depositos'])) {{ $tarjeta['depositos'] }} @else 0 @endif</p
                                                </td>
                                                <td>
                                                    <ul class="">@if(isset($tarjeta['retirosHTML'])) {!! $tarjeta['retirosHTML'] !!} @endif</ul>
                                                    <p><strong>TOTAL: </strong>@if(isset($tarjeta['retiros'])) {{ $tarjeta['retiros'] }} @else 0 @endif</p
                                                </td>
                                                <td>
                                                    <ul class="">@if(isset($tarjeta['transferenciasHTML'])) {!! $tarjeta['transferenciasHTML'] !!} @endif</ul>
                                                    <p><strong>TOTAL: </strong>@if(isset($tarjeta['transferencias'])) {{ $tarjeta['transferencias'] }} @else 0 @endif</p
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingThree">
                        <h5 class="mb-0">
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            MOVIMIENTOS
                            </button>
                        </h5>
                    </div>
                    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion2">
                        <div class="card-body">
                            <h2 class="text-center">MOVIMIENTOS</h2>
                            <div class="col-md-12 my-5">
                                <div class="row">
                                    <div class="col-md-4">
                                        <form action="{{ route('movimientos.store') }}" method="POST">
                                            @csrf
                                            @method('POST')
                                            <input type="hidden" name="tipo" value="deposito" />
                                            <input type="hidden" name="cliente" value="{{ $data['usuarioID'] }}">

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <select type="text" name="tarjeta" class="form-control @error('tarjeta') is-invalid @enderror">
                                                            <option value="">:: Tarjeta ::</option>
                                                            @foreach($data['tarjetas'] as $tarjeta)
                                                                @if($tarjeta->cliente === $data['usuarioID'])
                                                                    <option value="{{ $tarjeta->numero }}">{{ $tarjeta->numero }}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input type="number" name="monto" placeholder="Monto" class="form-control @error('monto') is-invalid @enderror" value="{{ old('monto') }}" />
                                                        @error('monto')
                                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="submit" value="Depositar" class="form-control btn btn-success" />
                                        </form>
                                    </div>
                                    <div class="col-md-4">
                                        <form action="{{ route('movimientos.store') }}" method="POST">
                                            @csrf
                                            @method('POST')
                                            <input type="hidden" name="tipo" value="retiro" />
                                            <input type="hidden" name="cliente" value="{{ $data['usuarioID'] }}">

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <select type="text" name="tarjeta" class="form-control @error('tarjeta') is-invalid @enderror">
                                                            <option value="">:: Tarjeta ::</option>
                                                            @foreach($data['tarjetas'] as $tarjeta)
                                                                @if($tarjeta->cliente === $data['usuarioID'])
                                                                    <option value="{{ $tarjeta->numero }}">{{ $tarjeta->numero }}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input type="number" name="monto" placeholder="Monto" class="form-control @error('monto') is-invalid @enderror" value="{{ old('monto') }}" />
                                                        @error('monto')
                                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="submit" value="Retirar" class="form-control btn btn-success" />
                                        </form>
                                    </div>
                                    <div class="col-md-4">
                                        <form action="{{ route('movimientos.store') }}" method="POST">
                                            @csrf
                                            @method('POST')
                                            <input type="hidden" name="tipo" value="transferencia" />
                                            <input type="hidden" name="cliente" value="{{ $data['usuarioID'] }}">

                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <select type="text" name="tarjeta" class="form-control @error('tarjeta') is-invalid @enderror">
                                                            <option value="">:: Tarjeta ::</option>
                                                            @foreach($data['tarjetas'] as $tarjeta)
                                                                @if($tarjeta->cliente === $data['usuarioID'])
                                                                    <option value="{{ $tarjeta->numero }}">{{ $tarjeta->numero }}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <input type="number" name="monto" placeholder="Monto" class="form-control @error('monto') is-invalid @enderror" value="{{ old('monto') }}" />
                                                        @error('monto')
                                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <select name="para" class="form-control @error('para') is-invalid @enderror" value="{{ old('para') }}">
                                                            <option value="">:: Para ::</option>
                                                            @foreach($data['clientes'] as $cliente)
                                                            @if($cliente->email !== $data['usuarioEmail'])
                                                            <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
                                                            @endif
                                                            @endforeach
                                                        </select>
                                                        @error('para')
                                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <input type="submit" value="Transferir" class="form-control btn btn-success" />
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingFour">
                        <h5 class="mb-0">
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                            ESTADO DE CUENTA
                            </button>
                        </h5>
                    </div>
                    <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordion2">
                        <div class="card-body">
                            <div class="col-md-12 my-5">
                                <h2 class="text-center">ESTADO DE CUENTA</h2>
                                <table class="table table-sm table-striped">
                                    <thead>
                                        <th>ID</th>
                                        <th>NÚMERO DE TARJETA</th>
                                        <th>TIPO</th>
                                        <th>BENEFICIARIOS</th>
                                        <th>SALDO DISPONIBLE</th>
                                        <th>DEPÓSITOS</th>
                                        <th>RETIROS</th>
                                        <th>TRANSFERENCIAS</th>
                                    </thead>
                                    <tbody>
                                        @foreach($data['tarjetas'] as $tarjeta)
                                            @php
                                                $depositosTotales = 0;
                                                $retirosTotales = 0;
                                                $transferenciasTotales = 0;

                                                if(isset($movimientosXtarjeta[$tarjeta->numero]['depositos'])) $depositosTotales = $movimientosXtarjeta[$tarjeta->numero]['depositos'];
                                                if(isset($movimientosXtarjeta[$tarjeta->numero]['retiros'])) $retirosTotales = $movimientosXtarjeta[$tarjeta->numero]['retiros'];
                                                if(isset($movimientosXtarjeta[$tarjeta->numero]['transferencias'])) $transferenciasTotales = $movimientosXtarjeta[$tarjeta->numero]['transferencias'];

                                                $deduccionesTotales = $retirosTotales + $transferenciasTotales;
                                                $saldoFinal = $depositosTotales - $deduccionesTotales;
                                            @endphp

                                            @if($tarjeta->cliente === $data['usuarioID'])
                                                @php
                                                    $beneficiarios = json_decode($tarjeta->beneficiarios,true);
                                                    $beneficiarios = implode(', ', $beneficiarios);
                                                @endphp
                                                <tr>
                                                    <td>{{ $tarjeta->id }}</td>
                                                    <td>{{ $tarjeta->numero }}</td>
                                                    <td>{{ $tarjeta->tipo }}</td>
                                                    <td>{{ $beneficiarios }}</td>
                                                    <td><strong>$</strong>{{ $saldoFinal }}</td>
                                                    <td> <strong>$</strong>{{ $depositosTotales }} </td>
                                                    <td> <strong>$</strong>{{ $retirosTotales }} </td>
                                                    <td> <strong>$</strong>{{ $transferenciasTotales }} </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingFive">
                        <h5 class="mb-0">
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                            CONSULTA DE MOVIMIENTOS
                            </button>
                        </h5>
                    </div>
                    <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordion2">
                        <div class="card-body">
                            <div class="col-md-12 my-5">
                                <h2 class="text-center">CONSULTA DE MOVIMIENTOS</h2>
                                <form action="javascript:void(0)" method="POST" id="consulta_de_movimientos">
                                    @csrf
                                    @method('GET')
                                    <select type="text" id="select_consulta_movimientos" name="tarjeta" class="form-control @error('tarjeta') is-invalid @enderror">
                                        <option value="">:: Tarjeta ::</option>
                                        @foreach($data['tarjetas'] as $tarjeta)
                                            @if($tarjeta->cliente === $data['usuarioID'])
                                                <option value="{{ $tarjeta->numero }}">{{ $tarjeta->numero }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </form>
                                <div id="wrapper_resultado_consulta_de_movimientos" class="mt-5"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        @endif


    </div>
</div>

@endsection