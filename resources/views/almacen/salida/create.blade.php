@extends('layouts.admin')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('salidas.index') }}">Salidas</a></li>
    <li class="breadcrumb-item active">Nueva Salida</li>
@endsection
@section('contenido')
    <section class="card shadow-lg w-100">
        <form action="{{ route('salidas.store') }}" method="POST">
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
                    <div class="form-group col-md-6">
                        <label for="selectUnidad">Unidad:</label>
                        <select class="form-select" name="id_unidad" id="selectUnidad">
                            <option></option>
                            @foreach ($unidades as $item)
                                <option value="{{ $item->id_unidad }}">{{ $item->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="n_hoja_ruta">N° de Hoja de Ruta:</label>
                        <input type="text" class="form-control" name="n_hoja_ruta">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="n_pedido">N° de Pedido:</label>
                        <input type="text" class="form-control" name="n_pedido">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="selectProducto">Lote - Producto:</label>
                        <select class="form-select" name="selectProducto" id="selectProducto">
                            <option></option>
                            @foreach ($productos as $item)
                                <option value="{{ $item->id_producto }}" data-costo="{{ $item->costo_u }}" data-stock="{{ $item->stock }}"
                                    data-cantidad="{{ $item->cantidad_disponible }}">
                                    {{ $item->producto_lote }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-1">
                        <label for="txtCantidad">Cantidad:</label>
                        <input type="number" class="form-control" name="txtCantidad" id="txtCantidad" min="1"
                            max="{{ $item->cantidad_disponible }}" placeholder="0">
                    </div>
                    <div class="form-group col-md-1">
                        <label for="txtStock">Stock:</label>
                        <input type="number" class="form-control" name="stock" id="txtStock" disabled>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="txtCostoU">Costo:</label>
                        <input type="number" class="form-control" name="costo_u" id="txtCostoU" disabled>
                    </div>
                    <div class="form-group col-md-2 d-flex justify-content-end">
                        <button type="button" id="btnAgregar" class="btn btn-primary btn-labeled mt-auto">
                            <span class="btn-label"><i class="bi bi-cart-plus-fill"></i></span>Agregar</button>
                    </div>
                </div>
                <!-- Tabla Responsiva -->
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
                <div class="mt-auto d-flex justify-content-between">
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
                $('#txtCantidad').on('input', function() {
                    validarCantidad();
                });
                $('select').select2();
            });
            var cont = 0;
            var total = 0;
            var subTotal = [];
            var stockTemp = {};

            $('#btnGuardar').hide();
            $('#selectProducto').on('change', mostrarValores);

            function mostrarValores() {
                var selectedOption = $('#selectProducto option:selected');
                var costo = selectedOption.data('costo');
                var stock = selectedOption.data('stock');
                var cantidad = selectedOption.data('cantidad');
                var idProducto = selectedOption.val();

                if (stockTemp[idProducto] !== undefined) {
                    stock = stockTemp[idProducto];
                }

                $('#txtCostoU').val(costo);
                $('#txtStock').val(stock);
                $('#txtCantidad').val(cantidad);
                $('#txtCantidad').attr('max', stock);
            }

            function validarCantidad() {
                var cantidadDisponible = $('#selectProducto option:selected').data('cantidad');
                var cantidadIngresada = $('#txtCantidad').val();
                if (parseInt(cantidadIngresada) > parseInt(cantidadDisponible)) {
                    alert('La cantidad ingresada no puede ser mayor que la cantidad disponible.');
                    $('#txtCantidad').val(cantidadDisponible);
                }
            }

            function agregar() {
                var idProducto = $('#selectProducto').val();
                var producto = $('#selectProducto option:selected').text();
                var cantidad = $('#txtCantidad').val();
                var costo_u = $('#selectProducto option:selected').data('costo');
                var stock = $('#txtStock').val();

                if (idProducto != "" && producto != "" && cantidad != "" && costo_u != "") {
                    subTotal[cont] = (cantidad * costo_u);
                    total = total + subTotal[cont];
                    var fila =
                        '<tr class="text-center" id="filaSalida' + cont + '">' +
                        '<td>' +
                        '<button type="button" class="btn btn-danger btn-small" onclick="eliminar(' + cont + ', ' + idProducto + ', ' + cantidad +
                        ')"><i class="bi bi-x-circle-fill"></i></button>' +
                        '</td>' +
                        '<td>' +
                        '<input type="hidden" name="id_producto[]" value="' + idProducto + '">' + producto +
                        '</td>' +
                        '<td>' +
                        '<input type="hidden" name="cantidad[]" value="' + cantidad + '" >' + cantidad +
                        '</td>' +
                        '<td>' +
                        '<span>' + costo_u + '</span>' +
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

                    // Update stock temporarily
                    stockTemp[idProducto] = stock - cantidad;
                    $('#txtStock').val(stockTemp[idProducto]);
                    $('#txtCantidad').attr('max', stockTemp[idProducto]);
                } else {
                    alert('Error al ingresar el detalle de la Salida, revise los datos del Producto');
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
                $('#txtStock').val("");
                $('#selectProducto').val("").trigger('change');
            }

            function eliminar(index, idProducto, cantidad) {
                total = total - subTotal[index];
                $('#labelTotal').html('Bs. ' + total);
                $('#filaSalida' + index).remove();
                evaluar();

                // Restore stock temporarily
                stockTemp[idProducto] = stockTemp[idProducto] + cantidad;
                $('#txtStock').val(stockTemp[idProducto]);
                $('#txtCantidad').attr('max', stockTemp[idProducto]);
            }
        </script>
    @endpush
@endsection
