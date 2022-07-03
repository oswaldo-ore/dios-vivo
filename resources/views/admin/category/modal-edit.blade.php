<div id="categoria_edit{{ $category->id }}" class="modal fade" tabindex="-1" aria-modal="true" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="fw-bolder modal-title"> Editar categoria</h2>
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

            <form action="{{ route('category.update', $category->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">

                    <div class="form-group mb-4">
                        <label for="" class="form-label"> Id </label>
                        <input type="text" class="form-control form-control-sm form-control-solid"
                            value="{{ $category->id }}" name="id" readonly>
                    </div>


                    <div class="form-group mb-4">
                        <label for="" class="form-label required"> Nombre </label>
                        <input type="text" class="form-control form-control-sm form-control-solid"
                            value="{{ $category->name }}" name="name">
                    </div>
                    <div class="form-group mb-4">
                        <select class="form-select form-select-solid" data-control="select2"
                            data-placeholder="Select an option" name="category_id">
                            <option></option>
                            @forelse ($categories as $cat)
                                <option value="{{ $cat->id }}"
                                    {{ $cat->id == $category->category_id ? 'selected' : '' }}>
                                    {{ $cat->name }}</option>
                            @empty
                            @endforelse
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light btn-sm " data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary btn-sm">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>
