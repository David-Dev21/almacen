<!-- Modal -->
<div class="modal fade" id="modal-delete-{{ $proveedor->id_proveedor }}">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Header del Modal -->
            <div class="modal-header bg-danger text-white">
                <h4 class="modal-title">Eliminar Proveedor</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <!-- Formulario del Modal -->
            <form action="{{ route('proveedores.destroy', $proveedor->id_proveedor) }}" method="POST">
                @csrf
                @method('DELETE')
                <!-- Cuerpo del Modal -->
                <div class="modal-body">
                    <p>Confirme si desea eliminar el proveedor <strong>"{{ $proveedor->nombre }}"</strong></p>
                </div>
                <!-- Footer del Modal -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-outline-danger">Eliminar</button>
                </div>
            </form>
        </div>
    </div>
</div>
