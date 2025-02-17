@extends('layouts.admin')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('proveedores.index') }}">Proveedores</a></li>
    <li class="breadcrumb-item active">Editar Proveedor</li>
@endsection
@section('contenido')
    <section class="card shadow-lg col-md-8 mb-auto">
        <div class="card-header d-flex justify-content-between bg-gradient-green">
            <h3 class="text-white my-auto">Editar Proveedor</h3>
            <button class="btn btn-labeled btn-danger" data-bs-toggle="modal" data-bs-target="#modal-delete-{{ $proveedor->id_proveedor }}">
                <span class="btn-label"><i class="bi bi-trash-fill"></i></span>Eliminar
            </button>
            @include('almacen.proveedor.destroy-modal', ['proveedor' => $proveedor])
        </div>
        <form action="{{ route('proveedores.update', $proveedor->id_proveedor) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-7">
                        <label for="inputRazonSocial">Razón Social: </label>
                        <input type="text" class="form-control" name="razon_social" id="inputRazonSocial" value="{{ $proveedor->razon_social }}">
                        @if ($errors->has('razon_social'))
                            <div class="text-danger">{{ $errors->first('razon_social') }}</div>
                        @endif
                    </div>
                    <div class="form-group col-5">
                        <label for="inputNit">Nro. de Nit: </label>
                        <input type="text" class="form-control" name="nit" id="inputNit" value="{{ $proveedor->nit }}">
                        @if ($errors->has('nit'))
                            <div class="text-danger">{{ $errors->first('nit') }}</div>
                        @endif
                    </div>
                    <div class="form-group col-7">
                        <label for="inputNombre">Nombre Proveedor: </label>
                        <input type="text" class="form-control" name="nombre" id="inputNombre" value="{{ $proveedor->nombre }}">
                        @if ($errors->has('nombre'))
                            <div class="text-danger">{{ $errors->first('nombre') }}</div>
                        @endif
                    </div>
                    <div class="form-group col-4">
                        <label>Estado:</label>
                        <div class="d-flex flex-row mt-1 justify-content-between">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="estado" id="inputEstadoActivo" value="1"
                                    {{ $proveedor->estado == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="inputEstadoActivo">Activo</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="estado" id="inputEstadoInactivo" value="0"
                                    {{ $proveedor->estado == 0 ? 'checked' : '' }}>
                                <label class="form-check-label" for="inputEstadoInactivo">Inactivo</label>
                            </div>
                        </div>
                        @if ($errors->has('estado'))
                            <div class="text-danger">{{ $errors->first('estado') }}</div>
                        @endif
                    </div>
                    <div class="form-group col-12">
                        <label for="inputDireccion">Dirección:</label>
                        <textarea class="form-control" type="text" rows="3" name="direccion" id="inputDireccion">{{ $proveedor->direccion }}</textarea>
                        @if ($errors->has('direccion'))
                            <div class="text-danger">{{ $errors->first('direccion') }}</div>
                        @endif
                    </div>
                    <div class="form-group col-7">
                        <label for="inputEmail">Email:</label>
                        <input class="form-control" type="email" name="email" id="inputEmail" value="{{ $proveedor->email }}">
                        @if ($errors->has('email'))
                            <div class="text-danger">{{ $errors->first('email') }}</div>
                        @endif
                    </div>
                    <div class="form-group col-5">
                        <label for="inputTelefono">Telefono:</label>
                        <input class="form-control" type="text" name="telefono" id="inputTelefono" value="{{ $proveedor->telefono }}">
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
