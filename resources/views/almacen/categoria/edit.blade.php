@extends('layouts.admin')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('categorias.index') }}" class="link">Categorías</a></li>
    <li class="breadcrumb-item active">Editar Categoría</li>
@endsection
@section('contenido')
    <section class="card shadow-lg col-md-6 mb-auto">
        <div class="card-header d-flex justify-content-between bg-gradient-green">
            <h3 class="text-white m-0">Editar Categoría</h3>
        </div>
        <div class="card-body">
            <form id="categoriaForm" action="{{ route('categorias.update', $categoria->id_categoria) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="txtCodigo">Código:</label>
                        <input type="text" class="form-control @error('codigo') is-invalid @enderror" name="codigo" id="txtCodigo"
                            value="{{ $categoria->codigo }}" readonly>
                        @error('codigo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-12">
                        <label for="txtDescripcion">Descripción</label>
                        <textarea class="form-control @error('descripcion') is-invalid @enderror" type="text" rows="3" name="descripcion" id="txtDescripcion">{{ $categoria->descripcion }}</textarea>
                        @error('descripcion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="mt-3 d-flex justify-content-between">
                    <a href="{{ route('categorias.index') }}" class="btn btn-danger btn-labeled">
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
            const codigo = document.getElementById('txtCodigo').value;
            const descripcion = document.getElementById('txtDescripcion').value;

            Swal.fire({
                title: '¿Está seguro de guardar?',
                html: `<p><strong>Código:</strong> ${codigo}</p><p><strong>Descripción:</strong> ${descripcion}</p>`,
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
                    document.getElementById('categoriaForm').submit();
                }
            });
        }
    </script>
@endpush
