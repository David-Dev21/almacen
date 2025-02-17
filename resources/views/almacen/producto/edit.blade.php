@extends('layouts.admin')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('productos.index') }}">Productos</a></li>
    <li class="breadcrumb-item active">Editar Producto</li>
@endsection
@section('contenido')
    <section class="card shadow-lg col-md-8 mb-auto">
        <div class="card-header d-flex justify-content-between bg-gradient-green">
            <h3 class="text-white my-auto">Editar Producto</h3>
            <button class="btn btn-labeled btn-danger" data-bs-toggle="modal" data-bs-target="#modal-delete-{{ $producto->id_producto }}">
                <span class="btn-label"><i class="bi bi-trash-fill"></i></span>Eliminar
            </button>
            @include('almacen.producto.destroy-modal', ['producto' => $producto])
        </div>
        <form action="{{ route('productos.update', $producto->id_producto) }}" method="POST" enctype="multipart/form-data" class="form-control">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-4">
                        <label for="inputCodigo">Código:</label>
                        <input type="text" class="form-control" name="codigo" id="inputCodigo" value="{{ $producto->codigo }}">
                        @if ($errors->has('codigo'))
                            <div class="text-danger">{{ $errors->first('codigo') }}</div>
                        @endif
                    </div>
                    <div class="form-group col-4">
                        <label for="selectUnidad">Unidad:</label>
                        <select class="form-select" name="unidad" id="selectUnidad">
                            <option value="">Seleccionar</option>
                            <option value="Pieza" {{ $producto->unidad == 'Pieza' ? 'selected' : '' }}>Pieza</option>
                            <option value="Rollo" {{ $producto->unidad == 'Rollo' ? 'selected' : '' }}>Rollo</option>
                            <option value="Paquete" {{ $producto->unidad == 'Paquete' ? 'selected' : '' }}>Paquete</option>
                        </select>
                        @if ($errors->has('unidad'))
                            <div class="text-danger">{{ $errors->first('unidad') }}</div>
                        @endif
                    </div>
                    <div class="form-group col-4">
                        <label>Estado:</label>
                        <div class="d-flex flex-row mt-1 justify-content-between">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="estado" id="inputEstadoActivo" value="1"
                                    {{ $producto->estado == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="inputEstadoActivo">Activo</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="estado" id="inputEstadoInactivo" value="0"
                                    {{ $producto->estado == 0 ? 'checked' : '' }}>
                                <label class="form-check-label" for="inputEstadoInactivo">Inactivo</label>
                            </div>
                        </div>
                        @if ($errors->has('estado'))
                            <div class="text-danger">{{ $errors->first('estado') }}</div>
                        @endif
                    </div>
                    <div class="form-group col-12">
                        <label for="inputDescripcion">Descripción:</label>
                        <textarea class="form-control" name="descripcion" id="inputDescripcion" rows="3">{{ $producto->descripcion }}</textarea>
                        @if ($errors->has('descripcion'))
                            <div class="text-danger">{{ $errors->first('descripcion') }}</div>
                        @endif
                    </div>
                    <div class="form-group col-6">
                        <label for="selectCategoria">Categoría:</label>
                        <select class="form-select" name="id_categoria" id="selectCategoria">
                            <option value="">Seleccionar</option>
                            @foreach ($categorias as $cat)
                                <option value="{{ $cat->id_categoria }}" {{ $producto->id_categoria == $cat->id_categoria ? 'selected' : '' }}>
                                    {{ $cat->descripcion }}
                                </option>
                            @endforeach
                        </select>
                        @if ($errors->has('id_categoria'))
                            <div class="text-danger">{{ $errors->first('id_categoria') }}</div>
                        @endif
                    </div>
                    <div class="form-group col-6">
                        <label for="fileImagen">Seleccionar Imagen:</label>
                        <input type="file" class="form-control " name="imagen" id="fileImagen">
                        @if ($errors->has('imagen'))
                            <div class="text-danger">{{ $errors->first('imagen') }}</div>
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
