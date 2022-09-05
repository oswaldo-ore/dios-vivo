@extends('layout.template')

@push('css')
@endpush

@section('page-menu-title')
    Gestionar administradores
@endsection

@section('menu-top')
    <!--begin::Item-->
    <li class="breadcrumb-item text-dark">Administrador</li>
    <!--end::Item-->
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="card-title">
                Gestionar administrador
            </div>
            <!--begin::Card toolbar-->
            <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                <!--begin::Add product-->
                <a href="javascrip::void" data-bs-toggle="modal" data-bs-target="#user_nuevo"
                    class="btn btn-primary btn-sm">Agregar</a>
                <!--end::Add product-->
            </div>
            <!--end::Card toolbar-->
        </div>
        <div class="card-body">

            <div class="row">
                <div class="table-responsive  mb-6">
                    <div class="form-check form-check-custom form-check-solid form-check-sm justify-content-end">
                        <input class="form-check-input" type="checkbox" value="" id="show_eliminados"/>
                        <label class="form-check-label" for="show_eliminados">
                            Mostrar usuarios eliminados
                        </label>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-rounded border gy-4 gs-4">
                        <thead>
                            <tr class="fw-bold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                                <th>CI</th>
                                <th>Nombre completo</th>
                                <th>Rol</th>
                                <th>Correo</th>
                                <th>Telefono</th>
                                <th>Estado</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody id="cuerpo" style="vertical-align: middle;">
                            @include('admin.users.search')
                        </tbody>
                        <tfoot>

                        </tfoot>
                    </table>
                </div>
                {{ $users->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
    @include('admin.users.modal-user')
@endsection
@push('js')
    <script>
        $(document).ready(function() {
            $("#menu-users").addClass('active open');
        });

        function changeStateUser(id) {
            url = "{{url('/')}}/users/" + id + "/changeState";
            $.ajax({
                type: "GET",
                url: url,
                success: function(response) {
                    toastr.success(response.mensaje, 'usuario actualizada');
                    toastr.options.closeDuration = 10000;
                    toastr.options.timeOut = 10000;
                    toastr.options.extendedTimeOut = 10000;
                    window.location = "{{route('users.index')}}";
                },
                dataType: 'json',
                error: function(xhr, ajaxOptions, thrownError) {
                    console.log(xhr);
                    var errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        toastr.error(value[0], 'Datos invalidos!');
                        toastr.options.closeDuration = 10000;
                        toastr.options.timeOut = 10000;
                        toastr.options.extendedTimeOut = 10000;
                    });
                }
            });
        }

        $('#show_eliminados').on('change',function(){
            if($(this).is(':checked')){
                $('.eliminado').show();
            }else{
                $('.eliminado').hide();
            }
        });
    </script>
@endpush
