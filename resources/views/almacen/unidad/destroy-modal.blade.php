<!-- Modal -->
<div class="modal fade" id="modal-delete-{{ $unidad->id_unidad }}">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Header del Modal -->
            <div class="modal-header bg-danger text-white">
                <h4 class="modal-title">Eliminar Unidad</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <!-- Formulario del Modal -->
            <form action="{{ route('unidades.destroy', $unidad->id_unidad) }}" method="POST">
                @csrf
                @method('DELETE')
                <!-- Cuerpo del Modal -->
                <div class="modal-body">
                    <p>Confirme si desea eliminar la Unidad <strong>"{{ $unidad->nombre }}"</strong></p>
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
