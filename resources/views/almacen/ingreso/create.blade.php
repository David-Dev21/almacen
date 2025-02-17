@extends('layouts.admin')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('ingresos.index') }}">Ingresos</a></li>
    <li class="breadcrumb-item active">Nuevo Ingreso</li>
@endsection
@section('contenido')
    <section class="card shadow-lg w-100">
        <form action="{{ route('ingresos.store') }}" method="POST">
            @csrf
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="card-body d-flex flex-column" style="height: calc(100vh - 80px);">
                <div class="row">
                    <div class="form-group col-4">
                        <label for="selectProveedor">Proveedor:</label>
                        <select class="form-select" name="id_proveedor" id="selectProveedor">
                            <option></option>
                            @foreach ($proveedores as $item)
                                <option value="{{ $item->id_proveedor }}">{{ $item->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-2">
                        <label for="txtNroComprobante">Nro. de Factura:</label>
                        <input type="text" class="form-control" name="n_factura">
                    </div>
                    <div class="form-group col-2">
                        <label for="txtLote">Lote:</label>
                        <input type="text" class="form-control" name="lote">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-4">
                        <label for="selectProducto">Producto:</label>
                        <select class="form-select" name="id_producto" id="selectProducto">
                            <option value=""></option>
                            @foreach ($productos as $item)
                                <option value="{{ $item->id_producto }}">{{ $item->descripcion }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-2">
                        <label for="txtCantidad">Cantidad:</label>
                        <input type="number" class="form-control" name="cantidad" id="txtCantidad" min="1" placeholder="0">
                    </div>
                    <div class="form-group col-2">
                        <label for="txtCostoU">Costo por Unidad:</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" class="form-control" name="costo_u" id="txtCostoU" min="0.00" step="0.01">
                        </div>
                    </div>
                    <div class="form-group col-4 d-flex justify-content-end">
                        <button type="button" id="btnAgregar" class="btn btn-primary btn-labeled mt-auto">
                            <span class="btn-label"><i class="bi bi-cart-plus-fill"></i></span>Agregar</button>
                    </div>
                </div>
                <div class="table-responsive overflow-auto flex-grow-1">
                    <table class="table table-hover table-bordered">
                        <thead class="table-secondary table-sm">
                            <tr class="text-center sticky-top">
                                <th>Opciones</th>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Costo Unidad</th>
                                <th>Sub Total</th>
                            </tr>
                        </thead>
                        <tbody id="tableBodyDetalles">
                        </tbody>
                        <tfoot>
                            <tr class="text-center sticky-bottom">
                                <th colspan="3"></th>
                                <th>TOTAL</th>
                                <th>
                                    <span id="labelTotal">
                                        Bs. 0.00</span>
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="mt-auto d-flex justify-content-between align-items-end">
                    <button type="reset" class="btn btn-secondary btn-labeled" onclick="history.back()">
                        <span class="btn-label"><i class="bi bi-x-circle-fill"></i></span>Cancelar</button>
                    <button type="submit" class="btn btn-success btn-labeled" id="btnGuardar">
                        <span class="btn-label"><i class="bi bi-floppy2-fill"></i></span>Guardar</button>
                </div>
            </div>
        </form>
    </section>

    @push('scripts')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <script>
            $(document).ready(function() {
                $('#btnAgregar').click(function() {
                    agregar();
                });
                $('select').select2();
            });
            var cont = 0;
            var total = 0;
            var subTotal = [];

            $('#btnGuardar').hide();

            function agregar() {
                var idProducto = $('#selectProducto').val();
                var producto = $('#selectProducto option:selected').text();
                var cantidad = $('#txtCantidad').val();
                var costo_u = $('#txtCostoU').val();

                if (idProducto != "" && producto != "" && cantidad != "" && costo_u != "") {
                    subTotal[cont] = (cantidad * costo_u);
                    total = total + subTotal[cont];
                    var fila =
                        '<tr class="text-center" id="filaIngreso' + cont + '">' +
                        '<td>' +
                        '<button type="button" class="btn btn-danger btn-small" onclick="eliminar(' + cont +
                        ')"><i class="bi bi-x-circle-fill"></i></button>' +
                        '</td>' +
                        '<td>' +
                        '<input type="hidden" name="id_producto[]" value="' + idProducto + '">' + producto +
                        '</td>' +
                        '<td>' +
                        '<input type="hidden" name="cantidad_original[]" value="' + cantidad + '" >' + cantidad +
                        '</td>' +
                        '<td>' +
                        '<input type="hidden" name="costo_u[]" value="' + costo_u + '">' + costo_u +
                        '</td>' +
                        '<td>' +
                        subTotal[cont] +
                        '</td>' +
                        '</tr>';
                    cont++;
                    limpiar();
                    $('#labelTotal').html('Bs: ' + total);
                    evaluar();
                    $('#tableBodyDetalles').append(fila);
                } else {
                    alert('Error al ingresar el detalle del Ingreso, revise los datos del Producto');
                }
            }

            function evaluar() {
                if (total > 0) {
                    $('#btnGuardar').show();
                } else {
                    $('#btnGuardar').hide();
                }
            }

            function limpiar() {
                $('#txtCantidad').val("");
                $('#txtCostoU').val("");
            }

            function eliminar(index) {
                total = total - subTotal[index];
                $('#labelTotal').html('Bs. ' + total);
                $('#filaIngreso' + index).remove();
                evaluar();
            }
        </script>
    @endpush
@endsection
