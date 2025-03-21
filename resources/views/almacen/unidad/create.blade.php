@extends('layouts.admin')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('unidades.index') }}" class="link">Unidades</a></li>
    <li class="breadcrumb-item active">Crear Unidad</li>
@endsection
@section('contenido')
    <section class="card shadow-lg col-md-8 mb-auto">
        <div class="card-header bg-gradient-green">
            <h3 class="text-white m-0 fw-bold">Crear Unidad</h3>
        </div>
        <div class="card-body">
            <form id="unidadForm" action="{{ route('unidades.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="form-group col-sm-12">
                        <label for="txtNombre">Nombre Unidad: <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nombre') is-invalid @enderror" name="nombre" id="txtNombre"
                            value="{{ old('nombre') }}">
                        @error('nombre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-sm-7">
                        <label for="txtJefe">Jefe: <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('jefe') is-invalid @enderror" name="jefe" id="txtJefe"
                            value="{{ old('jefe') }}">
                        @error('jefe')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-sm-5">
                        <label for="numbertelefono">Teléfono:</label>
                        <input class="form-control @error('telefono') is-invalid @enderror" type="number" name="telefono" id="numbertelefono"
                            value="{{ old('telefono') }}">
                        @error('telefono')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-sm-12">
                        <label for="txtDireccion">Dirección: <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('direccion') is-invalid @enderror" type="text" rows="3" name="direccion" id="txtDireccion">{{ old('direccion') }}</textarea>
                        @error('direccion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="mt-3 d-flex justify-content-between">
                    <a href="{{ route('unidades.index') }}" class="btn btn-danger btn-labeled">
                        <span class="btn-label"><i class="bi bi-x-circle-fill"></i></span>Cancelar</a>
                    <button type="button" class="btn btn-success btn-labeled" onclick="confirmSubmit()">
                        <span class="btn-label"><i class="bi bi-floppy2-fill"></i></span>Guardar</button>
                </div>
            </form>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        function confirmSubmit() {
            const nombre = document.getElementById('txtNombre').value;
            const jefe = document.getElementById('txtJefe').value;
            const direccion = document.getElementById('txtDireccion').value;
            const telefono = document.getElementById('numbertelefono').value;

            Swal.fire({
                title: '¿Está seguro de guardar?',
                html: `<p><strong>Nombre de la Unidad:</strong> ${nombre}</p>
                       <p><strong>Jefe:</strong> ${jefe}</p>
                       <p><strong>Dirección:</strong> ${direccion}</p>
                       <p><strong>Teléfono:</strong> ${telefono}</p>`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#157347',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, guardar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true,
                allowOutsideClick: false,
                allowEscapeKey: false
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('unidadForm').submit();
                }
            });
        }
    </script>
@endpush
