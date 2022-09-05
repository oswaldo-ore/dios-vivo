<div id="user_delete{{ $user->id }}" class="modal fade" tabindex="-1" aria-modal="true" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="fw-bolder modal-title"> Eliminar usuario</h2>
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                    <span class="svg-icon svg-icon-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                transform="rotate(-45 6 17.3137)" fill="black"></rect>
                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)"
                                fill="black"></rect>
                        </svg>
                    </span>
                </div>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <p>Estas seguro que desea eliminar <strong>{{ $user->name }}</strong>??</p>
                </div>
            </div>
            <form action="{{ route('user.destroy', $user->id) }}" method="post">
                @csrf
                @method('delete')

                <div class="modal-footer">
                    <button type="button" class="btn btn-light btn-sm " data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                </div>
            </form>
        </div>
    </div>
</div>
