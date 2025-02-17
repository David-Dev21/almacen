<!-- Modal -->
<div class="modal fade" id="modal-delete-{{ $producto->id_producto }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-white">Eliminar Producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('productos.destroy', $producto->id_producto) }}" method="post">
                <div class="modal-body">
                    @csrf
                    @method('DELETE')
                    <p>¿Está seguro de que desea eliminar este producto? {{ $producto->codigo }}</p>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </div>
            </form>
        </div>
    </div>
</div>
