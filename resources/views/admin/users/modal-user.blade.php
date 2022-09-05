<div id="user_nuevo" class="modal fade" tabindex="-1" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="fw-bolder modal-title"> Crear un nuevo usuario</h2>
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

            <form action="{{ route('users.store') }}" id="form_user_store" method="post">
                @csrf
                <div class="modal-body">
                    <div class="row">
                    <div class="form-group mb-4 col-md-12">
                        <label for="" class="form-label required"> Seleccione un rol: </label>
                        <select class="form-select form-select-solid form-select-sm col-md-12" data-control="select2"
                            data-placeholder="Seleccione un rol" name="rol_id" required>
                            <option></option>
                            @forelse ($roles as $rol)
                                <option value="{{ $rol->id }}"> {{ $rol->name }}</option>
                            @empty
                            @endforelse
                        </select>
                    </div>
                        <div class="form-group mb-4 col-md-6">
                            <label for="" class="form-label required"> CI: </label>
                            <input type="text" oninput="this.value=this.value.replace(/[^0-9]/g,'');"
                                placeholder="Ej. 147852645" class="form-control form-control-sm form-control-solid"
                                name="ci" required autocomplete="off">
                        </div>
                        <div class="form-group mb-4 col-md-6">
                            <label for="" class="form-label required"> Complemento: </label>
                            <input type="text" placeholder="Ej. SC, CB, LP"
                                class="form-control form-control-sm form-control-solid" name="complement" required
                                autocomplete="off">
                        </div>
                        <div class="form-group mb-4 col-md-6">
                            <label for="" class="form-label required"> Nombre: </label>
                            <input type="text" placeholder="Ingrese un nombre"
                                class="form-control form-control-sm form-control-solid" name="name" required
                                autocomplete="off">
                        </div>
                        <div class="form-group mb-4 col-md-6">
                            <label for="" class="form-label required"> Apellidos: </label>
                            <input type="text" placeholder="Ingrese apellidos"
                                class="form-control form-control-sm form-control-solid" name="last_name" required
                                autocomplete="off">
                        </div>
                        <div class="form-group mb-4 col-md-6">
                            <label for="" class="form-label required"> Correo: </label>
                            <input type="email" placeholder="Ingrese un correo electronico"
                                class="form-control form-control-sm form-control-solid" name="email" required
                                autocomplete="off">
                        </div>
                        <div class="form-group mb-4 col-md-6">
                            <label for="" class="form-label "> Telefono: </label>
                            <input type="tel" placeholder="Ingrese un numero de telefono"
                                class="form-control form-control-sm form-control-solid" name="telephone"
                                autocomplete="off">
                        </div>
                        <div class="form-group mb-4 col-md-6">
                            <label for="" class="form-label required"> Contraseña: </label>
                            <input type="password" placeholder="Contraseña" value=""
                                class="form-control form-control-sm form-control-solid" name="password" required
                                autocomplete="new-password">
                        </div>
                        <div class="form-group mb-4 col-md-6">
                            <label for="" class="form-label required"> Confirmar contraseña: </label>
                            <input type="password" placeholder="Confirmar contraseña"
                                class="form-control form-control-sm form-control-solid" name="confirm_password"
                                required autocomplete="off">
                        </div>

                    </div>
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
    <script>
        $(document).ready(function() {

        });
        $('#form_user_store').submit(function(e) {
            e.preventDefault();
            password = $('input[name="password"]').val();
            confirmPassword = $('input[name="confirm_password"]').val();

            if (password != confirmPassword) {
                toastr.error('Las contrasenas no son iguales', 'Contrasena incorrectas');
                return;
            }
            e.currentTarget.submit();
        });
    </script>
@endpush
