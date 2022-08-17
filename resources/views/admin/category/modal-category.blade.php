<div id="categoria_nuevo" class="modal fade" tabindex="-1" aria-modal="true" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="fw-bolder modal-title"> Crear nueva categoria</h2>
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                    <span class="svg-icon svg-icon-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2"
                                rx="1" transform="rotate(-45 6 17.3137)" fill="black"></rect>
                            <rect x="7.41422" y="6" width="16" height="2" rx="1"
                                transform="rotate(45 7.41422 6)" fill="black"></rect>
                        </svg>
                    </span>
                </div>
            </div>

            <form action="{{ route('category.store') }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group mb-4">
                        <label for="" class="form-label required"> Nombre </label>
                        <input type="text" class="form-control form-control-sm form-control-solid" name="name"
                            required autocomplete="off">
                    </div>
                    <select class="form-select form-select-solid form-select-sm" data-control="select2"
                        data-placeholder="Select an option" name="category_id" required>
                        <option></option>
                        @forelse ($categories as $category)
                            <option value="{{ $category->id }}"> {{ $category->name }}</option>
                        @empty
                        @endforelse
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light btn-sm " data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary btn-sm">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('js')
    <script></script>
@endpush
