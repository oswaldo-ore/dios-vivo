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
                Mi perfil
            </div>
            <!--begin::Card toolbar-->
            <div class="card-toolbar flex-row-fluid justify-content-end gap-5">

            </div>
            <!--end::Card toolbar-->
        </div>
        <div class="card-body">

            <form action="{{ route('user.profile.update', ['user'=>$user->id ]) }}" id="update_my_profile" method="post">
                @csrf
                @method('PUT')
                <div class="row mb-6">
                    <div class="form-group">
                        <label for="" class="form-label">Rol: <span class="badge badge-light-primary text-capitalize fs-6 ms-5"> {{$user->rol->name}}</span></label>
                    </div>
                </div>
                <div class="row mb-6">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="form-label required">Nombre: </label>
                            <input required type="text" class="form-control form-control-solid form-control-sm" value="{{$user->name}}" id="name" name="name">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="form-label required">Apellidos: </label>
                            <input required type="text" class="form-control form-control-solid form-control-sm" value="{{$user->last_name}}" id="last_name" name="last_name">
                        </div>
                    </div>
                </div>
                <div class="row mb-6">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="form-label required">Correo electronico: </label>
                            <input required type="text" class="form-control form-control-solid form-control-sm" value="{{$user->email}}" id="email" name="email">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="form-label required">Telefono: </label>
                            <input required type="text" class="form-control form-control-solid form-control-sm" value="{{$user->telephone}}" id="telephone" name="telephone">
                        </div>
                    </div>
                </div>
                <div class="row mb-6">
                   <div class="col-md-12">
                    <div class="form-check form-check-custom form-check-solid form-check-sm">
                        <input class="form-check-input" type="checkbox" value="" name="change_password" id="change_password"/>
                        <label for="change_password" class="form-check-label">Cambiar contraseña</label>
                    </div>
                   </div>
                </div>

                <div class="row mb-6 change_password" style="display: none;">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="form-label required">Contraseña nueva: </label>
                            <input type="password" class="form-control form-control-solid form-control-sm" value="" id="new_password" name="new_password">

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="form-label required">Confirmar contraseña: </label>
                            <input type="password" class="form-control form-control-solid form-control-sm" value="" id="confir_password" name="confir_password">
                        </div>
                    </div>
                </div>
                <div class="row mb-6">
                    <button class="btn btn-sm btn-primary" type="submit" > Actualizar</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $('#change_password').on('change',function(){

            if($(this).is(':checked')){
                $('.change_password').show();
                $('#new_password').attr('required',true);
                $('#confir_password').attr('required',true);
            }else{
                $('.change_password').hide();
                $('#new_password').val('');
                $('#confir_password').val('');
                $('#new_password').attr('required',false);
                $('#confir_password').attr('required',false);
            }
        })

        $('#update_my_profile').submit(function (evt){
            evt.preventDefault();
            let form = document.getElementById('update_my_profile');
            if($('#change_password').is(":checked") && $('#new_password').val() != $('#confir_password').val() ){
                toastr.error('Las contraseñas no coinciden','Error');
                return;
            }
            if(form.checkValidity()){
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                let formData =new FormData(form);
                formData.append('_method',"PUT");
                $.ajax({
                    url: form.action,
                    data: formData,
                    type:'POST',
                    processData: false,
                    contentType: false,
                    success: function (response){
                        if(response.codigo == 0){
                            toastr.success(response.message,"Consulta realizada con exito");
                            toastr.success("Redireccionando al Dashboard","Consulta realizada con exito");
                            setTimeout(function(){
                                window.location.replace("{{route('dashboard.index')}}");
                            },1000);
                        }else{
                            toastr.success(response.message,"Ocurrio un error");

                        }
                    },
                    error:function(xhr,content,a){
                        console.log("a");
                    }
                });
                console.log();
            }else{
                form.reportValidity();
            }
        });
        $(document).ready(function(){

        });
    </script>
@endpush
