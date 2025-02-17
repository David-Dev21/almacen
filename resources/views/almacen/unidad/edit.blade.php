@extends('layouts.admin')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('unidades.index') }}">Unidades</a></li>
    <li class="breadcrumb-item active">Editar Unidad</li>
@endsection
@section('contenido')
    <section class="card shadow-lg col-md-8 mb-auto">
        <div class="card-header d-flex justify-content-between bg-gradient-green">
            <h3 class="text-white my-auto">Editar Unidad</h3>
            <button class="btn btn-labeled btn-danger" data-bs-toggle="modal" data-bs-target="#modal-delete-{{ $unidad->id_unidad }}">
                <span class="btn-label"><i class="bi bi-trash-fill"></i></span>Eliminar
            </button>
            @include('almacen.unidad.destroy-modal', ['unidad' => $unidad])
        </div>
        <form action="{{ route('unidades.update', $unidad->id_unidad) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-12">
                        <label for="inputNombre">Nombre Unidad: </label>
                        <input type="text" class="form-control" name="nombre" id="inputNombre" value="{{ $unidad->nombre }}">
                        @if ($errors->has('nombre'))
                            <div class="text-danger">{{ $errors->first('nombre') }}</div>
                        @endif
                    </div>
                    <div class="form-group col-8">
                        <label for="inputJefe">Jefe: </label>
                        <input type="text" class="form-control" name="jefe" id="inputJefe" value="{{ $unidad->jefe }}">
                        @if ($errors->has('jefe'))
                            <div class="text-danger">{{ $errors->first('jefe') }}</div>
                        @endif
                    </div>
                    <div class="form-group col-4">
                        <label>Estado:</label>
                        <div class="d-flex flex-row mt-1 justify-content-between">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="estado" id="inputEstadoActivo" value="1"
                                    {{ $unidad->estado == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="inputEstadoActivo">Activo</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="estado" id="inputEstadoInactivo" value="0"
                                    {{ $unidad->estado == 0 ? 'checked' : '' }}>
                                <label class="form-check-label" for="inputEstadoInactivo">Inactivo</label>
                            </div>
                        </div>
                        @if ($errors->has('estado'))
                            <div class="text-danger">{{ $errors->first('estado') }}</div>
                        @endif
                    </div>
                    <div class="form-group col-12">
                        <label for="inputDireccion">Dirección:</label>
                        <textarea class="form-control" type="text" rows="3" name="direccion" id="inputDireccion">{{ $unidad->direccion }}</textarea>
                        @if ($errors->has('direccion'))
                            <div class="text-danger">{{ $errors->first('direccion') }}</div>
                        @endif
                    </div>
                    <div class="form-group col-6">
                        <label for="inputTelefono">Telefono:</label>
                        <input class="form-control" type="text" name="telefono" id="inputTelefono" value="{{ $unidad->telefono }}">
                        @if ($errors->has('telefono'))
                            <div class="text-danger">{{ $errors->first('telefono') }}</div>
                        @endif
                    </div>
                </div>
                <div class="mt-3 d-flex justify-content-between">
                    <button type="reset" class="btn btn-secondary btn-labeled" onclick="history.back()">
                        <span class="btn-label"><i class="bi bi-x-circle-fill"></i></span>Cancelar</button>
                    <button type="submit" class="btn btn-success btn-labeled">
                        <span class="btn-label"><i class="bi bi-floppy2-fill"></i></span>Guardar</button>
                </div>
            </div>
        </form>
    </section>
@endsection
