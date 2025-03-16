@extends('layouts.admin')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('ingresos.index') }}" class="link">Ingresos</a></li>
    <li class="breadcrumb-item active">Nuevo Ingreso</li>
@endsection
@section('contenido')
    <section class="card shadow-lg w-100">
        <form id="ingresoForm" action="{{ route('ingresos.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label for="selectProveedor">Proveedor:</label>
                        <select class="form-control @error('id_proveedor') is-invalid @enderror" name="id_proveedor" id="selectProveedor">
                            <option value=""></option>
                            @foreach ($proveedores as $item)
                                <option value="{{ $item->id_proveedor }}" {{ old('id_proveedor') == $item->id_proveedor ? 'selected' : '' }}>
                                    {{ $item->nombre }}</option>
                            @endforeach
                        </select>
                        @error('id_proveedor')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-sm-2">
                        <label for="numberFactura">Nº de Factura:</label>
                        <input type="number" class="form-control @error('n_factura') is-invalid @enderror" name="n_factura" id="numberFactura"
                            value="{{ old('n_factura') }}">
                        @error('n_factura')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-sm-2">
                        <label for="numberPedido">Nº de Pedido</label>
                        <input type="number" class="form-control @error('n_pedido') is-invalid @enderror" name="n_pedido" id="numberPedido"
                            value="{{ old('n_pedido') }}">
                        @error('n_pedido')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-sm-2">
                        <label for="txtLote">Lote:</label>
                        <input type="text" class="form-control" name="lote" id="txtLote" value="{{ $siguienteLote }}" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label for="selectProducto">Producto:</label>
                        <select class="form-control" name="id_producto" id="selectProducto">
                            <option value=""></option>
                            @foreach ($productos as $item)
                                <option value="{{ $item->id_producto }}" data-unidad="{{ $item->unidad }}">{{ $item->descripcion }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-sm-2">
                        <label for="numberCantidad">Cantidad:</label>
                        <input type="number" class="form-control" name="cantidad" id="numberCantidad" min="1">
                    </div>
                    <div class="form-group col-sm-2">
                        <label for="numberCostoU">Costo por Unidad:</label>
                        <div class="input-group">
                            <span class="input-group-text">Bs:</span>
                            <input type="number" class="form-control" name="costo_u" id="numberCostoU" min="0.00" step="0.01">
                        </div>
                    </div>
                    <div class="form-group col-sm-2 d-flex justify-content-end">
                        <button type="button" id="btnAgregar" class="btn btn-primary btn-labeled mt-auto">
                            <span class="btn-label"><i class="bi bi-cart-plus-fill"></i></span>Agregar</button>
                    </div>
                </div>
                <div class="table-responsive overflow-auto">
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr class="text-center align-middle">
                                <th>Opciones</th>
                                <th>Producto</th>
                                <th>Unidad</th>
                                <th>Lote</th>
                                <th>Cantidad</th>
                                <th>Costo <br> Unidad</th>
                                <th>Costo <br> Total</th>
                            </tr>
                        </thead>
                        <tbody id="tableBodyDetalles" class="align-middle">
                            @if (!empty($productosOld))
                                @foreach ($productosOld as $index => $producto)
                                    <tr id="filaSalida{{ $index }}">
                                        <td class="text-center">
                                            <button type="button" class="btn btn-danger btn-small" onclick="eliminar({{ $index }})"><i
                                                    class="bi bi-x-circle-fill"></i> Quitar</button>
                                        </td>
                                        <td>
                                            <input type="hidden" name="id_producto[]"
                                                value="{{ $producto['id_producto'] }}">{{ $producto['producto'] }}
                                        </td>
                                        <td>
                                            <input type="hidden" name="unidad[]" value="{{ $producto['unidad'] }}">{{ $producto['unidad'] }}
                                        </td>
                                        <td>
                                            <input type="hidden" name="lote[]" value="{{ $producto['lote'] }}">{{ $producto['lote'] }}
                                        </td>
                                        <td class="text-end">
                                            <input type="hidden" name="cantidad[]" value="{{ $producto['cantidad'] }}">{{ $producto['cantidad'] }}
                                        </td>
                                        <td class="text-end">
                                            <input type="hidden" name="costo_u[]" value="{{ number_format($producto['costo_u'], 2, '.', '') }}">
                                            {{ number_format($producto['costo_u'], 2, '.', '') }}
                                        </td>
                                        <td class="text-end">
                                            {{ number_format($producto['cantidad'] * $producto['costo_u'], 2, '.', '') }}
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                        <tfoot id="tableFooter">
                            <tr>
                                <th colspan="4" class="text-center">TOTAL GENERAL</th>
                                <th class="text-end">
                                    <span id="totalCantidad">0</span>
                                </th>
                                <th class="text-end">
                                    <span id="totalCostoUnidad">Bs. 0.00</span>
                                </th>
                                <th class="text-end">
                                    <span id="totalCosto">Bs. 0.00</span>
                                </th>
                            </tr>
                        </tfoot>

                    </table>
                </div>
                <div class="mt-auto d-flex justify-content-between align-items-end">
                    <a href="{{ route('ingresos.index') }}" class="btn btn-danger btn-labeled">
                        <span class="btn-label"><i class="bi bi-x-circle-fill"></i></span>Cancelar</a>
                    <button type="button" class="btn btn-success btn-labeled" id="btnGuardar" onclick="confirmSubmit()">
                        <span class="btn-label"><i class="bi bi-floppy2-fill"></i></span>Guardar</button>
                </div>
            </div>
        </form>
    </section>

    @push('scripts')
        <script src="{{ asset('js/jquery-3.7.1.js') }}"></script>
        <script>
            $(document).ready(function() {

                const selectProveedor = new TomSelect('#selectProveedor', {
                    create: false,
                    render: {
                        no_results: function(data) {
                            return '<div class="no-results">No se encontraron resultados</div>';
                        }
                    }
                });
                const selectProducto = new TomSelect('#selectProducto', {
                    create: false,
                    render: {
                        no_results: function(data) {
                            return '<div class="no-results">No se encontraron resultados</div>';
                        }
                    }
                });
                $('#btnAgregar').click(function() {
                    agregar();
                });

                if ($('#tableBodyDetalles tr').length > 0) {
                    recalcularTotal();
                    evaluar();
                }
            });
            var cont = 0;
            var total = 0;
            var subTotal = [];

            $('#btnGuardar').hide();
            $('#tableFooter').hide();

            function agregar() {
                var idProducto = $('#selectProducto').val();
                var producto = $('#selectProducto option:selected').text();
                var cantidad = parseFloat($('#numberCantidad').val());
                var costo_u = parseFloat($('#numberCostoU').val());
                var lote = $('#txtLote').val();
                var unidad = $('#selectProducto option:selected').data('unidad');

                if (idProducto == '') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Debe seleccionar un producto.'
                    });
                    return;
                }

                if (isNaN(cantidad) || cantidad <= 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Debe ingresar una cantidad válida.'
                    });
                    return;
                }
                if (isNaN(costo_u) || costo_u <= 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Debe ingresar un costo válido.'
                    });
                    return;
                }

                subTotal[cont] = (cantidad * costo_u);
                total = total + subTotal[cont];
                var fila =
                    '<tr id="filaIngreso' + cont + '">' +
                    '<td class="text-center">' +
                    '<button type="button" class="btn btn-danger btn-small" onclick="eliminar(' + cont +
                    ')"><i class="bi bi-x-circle-fill"></i> Quitar</button>' +
                    '</td>' +
                    '<td>' +
                    '<input type="hidden" name="id_producto[]" value="' + idProducto + '">' + producto +
                    '</td>' +
                    '<td>' +
                    '<input type="hidden" name="unidad[]" value="' + unidad + '">' + unidad +
                    '</td>' +
                    '<td>' +
                    '<input type="hidden" name="lote[]" value="' + lote + '">' + lote +
                    '</td>' +
                    '<td class="text-end">' +
                    '<input type="hidden" name="cantidad[]" value="' + cantidad + '">' + cantidad +
                    '</td>' +
                    '<td class="text-end">' +
                    '<input type="hidden" name="costo_u[]" value="' + costo_u + '">' + costo_u.toFixed(2) +
                    '</td>' +
                    '<td class="text-end">' +
                    subTotal[cont].toFixed(2) +
                    '</td>' +
                    '</tr>';

                $('#tableBodyDetalles').append(fila);
                cont++;
                limpiar();
                recalcularTotal();
                evaluar();
            }

            function evaluar() {
                if (total > 0) {
                    $('#btnGuardar').show();
                    $('#tableFooter').show();
                } else {
                    $('#btnGuardar').hide();
                    $('#tableFooter').hide();
                }
            }

            function limpiar() {
                $('#numberCantidad').val("");
                $('#numberCostoU').val("");
                const selectProductoInstance = document.querySelector('#selectProducto').tomselect;
                selectProductoInstance.clear();
            }

            function eliminar(index) {
                $('#filaIngreso' + index).remove();
                recalcularTotal();
                limpiar();
                evaluar();
            }

            function recalcularTotal() {
                total = 0;
                var totalCantidad = 0;
                var totalCostoUnidad = 0;

                $('#tableBodyDetalles tr').each(function() {
                    var cantidad = parseFloat($(this).find('td:eq(4)').text());
                    var costoUnidad = parseFloat($(this).find('td:eq(5)').text());
                    var costoTotal = parseFloat($(this).find('td:eq(6)').text());

                    totalCantidad += cantidad;
                    totalCostoUnidad += costoUnidad;
                    total += costoTotal;
                });

                $('#totalCantidad').html(totalCantidad);
                $('#totalCostoUnidad').html('Bs. ' + totalCostoUnidad.toFixed(2)); // Formatea totalCostoUnidad a 0.00
                $('#totalCosto').html('Bs. ' + total.toFixed(2)); // Formatea total a 0.00
            }

            function confirmSubmit() {
                const proveedor = document.getElementById('selectProveedor').selectedOptions[0].text;
                const nroFactura = document.getElementById('numberFactura').value;
                const lote = document.getElementById('txtLote').value;
                const totalCantidad = document.getElementById('totalCantidad').innerText;
                const totalGeneral = document.getElementById('totalCosto').innerText;

                Swal.fire({
                    title: '¿Está seguro de guardar?',
                    html: `<p><strong>Proveedor:</strong> ${proveedor}</p>
                           <p><strong>Nro. de Factura:</strong> ${nroFactura}</p>
                           <p><strong>Lote:</strong> ${lote}</p>
                           <p><strong>Total de Productos:</strong> ${totalCantidad}</p>
                           <p><strong>Total General:</strong> ${totalGeneral}</p>`,
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
                        document.getElementById('ingresoForm').submit();
                    }
                });
            }
        </script>
        <script>
            // Variable para rastrear si hay cambios sin guardar
            let hasUnsavedChanges = true;

            // Función para mostrar la alerta personalizada
            function showCustomAlert(event, action) {
                event.preventDefault(); // Prevenir la acción predeterminada

                Swal.fire({
                    title: '¿Estás seguro?',
                    text: 'Tienes cambios sin guardar. Si continuas, perderás estos cambios.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#157347',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, continuar',
                    cancelButtonText: 'Cancelar',
                }).then((result) => {
                    if (result.isConfirmed) {
                        hasUnsavedChanges = false; // Desactivar la protección
                        if (action === 'reload') {
                            location.reload(); // Forzar la recarga
                        } else if (action === 'close') {
                            window.close(); // Cerrar la pestaña
                        }
                    }
                });
            }
            // Intercepta la tecla F5 o Ctrl+R para recargar la página
            document.addEventListener('keydown', function(event) {
                if (hasUnsavedChanges && (event.key === 'F5' || (event.ctrlKey && event.key === 'r'))) {
                    showCustomAlert(event, 'reload');
                }
            });

            // Intercepta clics en enlaces (`<a>`) o botones que puedan causar navegación
            document.addEventListener('click', function(event) {
                if (hasUnsavedChanges && event.target.tagName === 'A') {
                    event.preventDefault(); // Prevenir la navegación

                    Swal.fire({
                        title: '¿Estás seguro?',
                        text: 'Tienes cambios sin guardar. Si sales, perderás estos cambios.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#157347',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Sí, salir',
                        cancelButtonText: 'Cancelar',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            hasUnsavedChanges = false; // Desactivar la protección
                            window.location.href = event.target.href; // Continuar con la navegación
                        }
                    });
                }
            });

            // Detectar cambios en el formulario (opcional)
            document.addEventListener('input', function() {
                hasUnsavedChanges = true; // Marcar como cambios sin guardar
            });
        </script>
    @endpush
@endsection
