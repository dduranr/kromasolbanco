@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">

        @if($data['tipoDeUsuario']===1)
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
        @endif


    </div>
</div>
@endsection