@extends('layouts.admin')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('proveedores.index') }}" class="link">Proveedores</a></li>
    <li class="breadcrumb-item active">Crear Proveedor</li>
@endsection
@section('contenido')
    <section class="card shadow-lg col-md-8 mb-auto">
        <div class="card-header bg-gradient-green">
            <h3 class="text-white m-0">Crear Proveedor</h3>
        </div>
        <div class="card-body">
            <form id="proveedorForm" action="{{ route('proveedores.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="form-group col-sm-7">
                        <label for="txtRazonSocial">Razón Social: <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('razon_social') is-invalid @enderror" name="razon_social" id="txtRazonSocial"
                            value="{{ old('razon_social') }}">
                        @error('razon_social')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-sm-5">
                        <label for="txtNit">N° de Nit: <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nit') is-invalid @enderror" name="nit" id="txtNit"
                            value="{{ old('nit') }}">
                        @error('nit')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-sm-7">
                        <label for="txtNombre">Nombre Proveedor: <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nombre') is-invalid @enderror" name="nombre" id="txtNombre"
                            value="{{ old('nombre') }}">
                        @error('nombre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-sm-5">
                        <label for="txtTelefono">Teléfono:</label>
                        <input type="text"class="form-control @error('telefono') is-invalid @enderror" name="telefono" id="txtTelefono"
                            value="{{ old('telefono') }}">
                        @error('telefono')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-sm-12">
                        <label for="txtDireccion">Dirección: <span class="text-danger">*</span></label>
                        <textarea type="text" class="form-control @error('direccion') is-invalid @enderror" rows="3" name="direccion" id="txtDireccion">{{ old('direccion') }}</textarea>
                        @error('direccion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="mt-3 d-flex justify-content-between">
                    <a href="{{ route('proveedores.index') }}" class="btn btn-danger btn-labeled">
                        <span class="btn-label"><i class="bi bi-x-circle-fill"></i></span>Cancelar</a>
                    <button type="button" class="btn btn-success btn-labeled" onclick="confirmSubmit()">
                        <span class="btn-label"><i class="bi bi-floppy2-fill"></i></span>Guardar</button>
                </div>
            </form>
        </div>
    </section>

    @push('scripts')
        <script>
            function confirmSubmit() {
                const razonSocial = document.getElementById('txtRazonSocial').value;
                const nit = document.getElementById('txtNit').value;
                const nombre = document.getElementById('txtNombre').value;
                const direccion = document.getElementById('txtDireccion').value;
                const telefono = document.getElementById('txtTelefono').value;

                Swal.fire({
                    title: '¿Está seguro de guardar?',
                    html: `<p><strong>Razón Social:</strong> ${razonSocial}</p>
                           <p><strong>Nro. de Nit:</strong> ${nit}</p>
                           <p><strong>Nombre Proveedor:</strong> ${nombre}</p>
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
                        document.getElementById('proveedorForm').submit();
                    }
                });
            }
        </script>
    @endpush
@endsection
