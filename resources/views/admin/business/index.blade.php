@extends('layout.template')

@section('page-menu-title')
    Dashboard
@endsection

@section('menu-top')
    <!--begin::Item-->
    <li class="breadcrumb-item text-dark">Libro diario</li>
    <!--end::Item-->
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="card-title">
                Configuracion de la empresa
            </div>
        </div>
        <div class="card-body">
            <form action="{{route('business.update',$business->id)}}" method="POST">
                @csrf
                @method("put")
                <div class="row mb-6">
                    <div class="mb-6 fv-row fv-plugins-icon-container col-md-6">
                        <!--begin::Label-->
                        <label class="required form-label">Nombre de la empresa:</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input class="form-control form-control-sm form-control-solid" autocomplete="new-name"
                            placeholder="Ingrese nombre de la institucion" id="name" name="name"  maxlength="70" value="{{$business->name}}" required />
                        <!--end::Input-->
                    </div>
                    <div class="mb-6 fv-row fv-plugins-icon-container col-md-6">
                        <!--begin::Label-->
                        <label class="required form-label">Correo Electronico: </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input class="form-control form-control-sm form-control-solid" type="email" autocomplete="off"
                            placeholder="Ingrese el correo electronico" required id="email" name="email" maxlength="30" value="{{$business->email }}" />
                        <!--end::Input-->
                    </div>
                    <div class="mb-6 fv-row fv-plugins-icon-container col-md-12">
                        <!--begin::Label-->
                        <label class="required form-label">Ubicacion: </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input class="form-control form-control-sm form-control-solid" type="text" autocomplete="off"
                            placeholder="Ingrese el la ubicacion" required id="location" name="location" maxlength="100" value="{{$business->location}}" />
                        <!--end::Input-->
                    </div>
                    <div class="mb-6 fv-row fv-plugins-icon-container col-md-4">
                        <!--begin::Label-->
                        <label class="required form-label"> Seleccione un pais:</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <select class="form-select form-select-sm form-select-solid" data-control="select2"
                            data-placeholder="Seleccione un pais" id="code_number" name="code_number" required>
                            <option></option>
                            @forelse ($countryCodeNumber as $country )
                                <option value="{{$country->dial_code}}" {{$country->dial_code == $business->code_number ? "selected":""}} >{{$country->name}}</option>
                            @empty

                            @endforelse
                        </select>
                        <!--end::Input-->
                    </div>
                    <div class="mb-6 fv-row fv-plugins-icon-container col-md-4">
                        <!--begin::Label-->
                        <label class="required form-label">Telefono</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                      <div class="input-group flex-nowrap input-group-sm input-group-solid ">
                        <span class="input-group-text" id="span_code_number">{{$business->code_number}}</span>
                        <input class="form-control form-control-sm form-control-solid" autocomplete="off"
                        placeholder="Introduzca un numero" maxlength="15" id="phone_number" value="{{$business->phone_number}}" name="phone_number" required />
                      </div>
                        <!--end::Input-->
                    </div>

                    <div class="mb-6 fv-row fv-plugins-icon-container col-md-4">
                        <!--begin::Label-->
                        <label class="required form-label">Moneda: </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <select class="form-select form-select-sm form-select-solid" data-control="select2"
                            data-placeholder="Seleccione su moneda" id="currency" name="currency" required>
                            <option></option>
                            @forelse ($countryCurrency  as $currency )
                                <option value="{{$currency->symbol}}" {{ strtolower(trim($currency->symbol)) == strtolower(trim($business->currency)) ? "selected":""}}>{{$currency->name}} {{$currency->symbol}}</option>
                            @empty

                            @endforelse
                        </select>
                        <!--end::Input-->
                    </div>


                    <div class="col-md-12">
                        <div class="col-auto text-end">
                            <button class="btn btn-sm btn-primary"> Actualizar datos </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('flatpickr-locale-es.js') }}"></script>
    <script>
        $(document).ready(function() {
            $("#menu-business").addClass('active open');
        });

        $('#code_number').on('change',function(){
            $('#span_code_number').text($(this).val());
        });
    </script>
@endpush
