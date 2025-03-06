@extends('layouts.admin')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('categorias.index') }}">Categorías</a></li>
    <li class="breadcrumb-item active">Crear Categoría</li>
@endsection
@section('contenido')
    <section class="card shadow-lg col-md-6 mb-auto">
        <div class="card-header bg-gradient-green">
            <h3 class="text-white my-auto">Crear Categoría</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('categorias.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="inputCodigo">Código</label>
                        <input type="text" class="form-control" name="codigo" id="inputCodigo" value="{{ old('codigo') }}" placeholder="">
                        @if ($errors->has('codigo'))
                            <div class="text-danger">{{ $errors->first('codigo') }}</div>
                        @endif
                    </div>
                    <div class="form-group col-6 col-md-5">
                        <label>Estado</label>
                        <div class="d-flex flex-row mt-1 justify-content-between">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="estado" id="inputEstadoActivo" value="1"
                                    {{ old('estado') == '1' ? 'checked' : '' }} checked>
                                <label class="form-check-label" for="inputEstadoActivo">Activo</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="estado" id="inputEstadoInactivo" value="0"
                                    {{ old('estado') == '0' ? 'checked' : '' }}>
                                <label class="form-check-label" for="inputEstadoInactivo">Inactivo</label>
                            </div>
                        </div>
                        @if ($errors->has('estado'))
                            <div class="text-danger">{{ $errors->first('estado') }}</div>
                        @endif
                    </div>
                    <div class="form-group col-md-12">
                        <label for="inputDescripcion">Descripción</label>
                        <textarea class="form-control" type="text" rows="3" name="descripcion" id="inputDescripcion" placeholder="">{{ old('descripcion') }}</textarea>
                        @if ($errors->has('descripcion'))
                            <div class="text-danger">{{ $errors->first('descripcion') }}</div>
                        @endif
                    </div>
                </div>
                <div class="mt-3 d-flex justify-content-between">
                    <button type="reset" class="btn btn-secondary btn-labeled" onclick="history.back()">
                        <span class="btn-label"><i class="bi bi-x-circle-fill"></i></span>Cancelar</button>
                    <button type="submit" class="btn btn-success btn-labeled">
                        <span class="btn-label"><i class="bi bi-floppy2-fill"></i></span>Guardar</button>
                </div>
            </form>
        </div>
    </section>
@endsection
