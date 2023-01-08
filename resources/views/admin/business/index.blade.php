@extends('layout.template')

@push('css')
    <link rel='stylesheet' href='{{ asset('css/yearpicker.css') }}' />
@endpush

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
            <form action="{{ route('business.update', $business->id) }}" method="POST" id="form_business_update">
                @csrf
                @method('put')
                <div class="row mb-6">
                    <div class="mb-6 fv-row fv-plugins-icon-container col-md-6">
                        <!--begin::Label-->
                        <label class="required form-label">Nombre de la empresa:</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input class="form-control form-control-sm form-control-solid" autocomplete="new-name"
                            placeholder="Ingrese nombre de la institucion" id="name" name="name" maxlength="70"
                            value="{{ $business->name }}" required />
                        <!--end::Input-->
                    </div>
                    <div class="mb-6 fv-row fv-plugins-icon-container col-md-6">
                        <!--begin::Label-->
                        <label class="required form-label">Correo Electronico: </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input class="form-control form-control-sm form-control-solid" type="email" autocomplete="off"
                            placeholder="Ingrese el correo electronico" required id="email" name="email"
                            maxlength="70" value="{{ $business->email }}" />
                        <!--end::Input-->
                    </div>
                    <div class="mb-6 fv-row fv-plugins-icon-container col-md-12">
                        <!--begin::Label-->
                        <label class="required form-label">Ubicacion: </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input class="form-control form-control-sm form-control-solid" type="text" autocomplete="off"
                            placeholder="Ingrese el la ubicacion" required id="location" name="location" maxlength="100"
                            value="{{ $business->location }}" />
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
                            @forelse ($countryCodeNumber as $country)
                                <option value="{{ $country->dial_code }}"
                                    {{ $country->dial_code == $business->code_number ? 'selected' : '' }}>
                                    {{ $country->name }}
                                </option>
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
                            <span class="input-group-text" id="span_code_number">{{ $business->code_number }}</span>
                            <input class="form-control form-control-sm form-control-solid" autocomplete="off"
                                placeholder="Introduzca un numero" maxlength="15" id="phone_number"
                                value="{{ $business->phone_number }}" name="phone_number" required />
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
                            @forelse ($countryCurrency  as $currency)
                                <option value="{{ $currency->symbol }}"
                                    {{ strtolower(trim($currency->symbol)) == strtolower(trim($business->currency)) ? 'selected' : '' }}>
                                    {{ $currency->name }} {{ $currency->symbol }}</option>
                            @empty
                            @endforelse
                        </select>
                        <!--end::Input-->
                    </div>

                    <div class="col-md-12 mostrar_reportes mt-6">
                        <div class="col-md-12">
                            <h4>
                                Reporte Publico
                            </h4>
                        </div>

                        <div class="mb-6 fv-row fv-plugins-icon-container col-md-12">
                            <!--begin::Input-->
                            <div class="form-check form-check-custom form-check-solid">
                                <label class="required form-check-label ms-0 me-3" for="show_report_to_public_view">Mostrar
                                    reporte al publico: </label>
                                <input class="form-check-input me-3" type="checkbox"
                                    {{ $business->show_report_public || $business->show_report_yearly ? 'checked' : '' }}
                                    id="show_report_to_public_view" />
                            </div>
                            <!--end::Input-->
                        </div>


                        <div class="mb-6 fv-row fv-plugins-icon-container col-md-6 selected_type_report"
                            style="display: {{ !$business->show_report_public && !$business->show_report_yearly ? 'none' : '' }};">
                            <div class=" d-flex justify-content-around">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" value="1"
                                        onclick="changeTypeReport(this)" {{ $business->show_report_public ? 'checked' : '' }}
                                        id="show_for_dates" name="show_report_public">
                                    <label class="form-check-label" for="show_for_dates">Mostrar por fechas</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" value="2"
                                        onclick="changeTypeReport(this)" {{ $business->show_report_yearly ? 'checked' : '' }}
                                        id="show_for_ano" name="show_report_yearly">
                                    <label class="form-check-label" for="show_for_ano">Mostrar por año</label>
                                </div>
                            </div>
                        </div>

                        <div class=" col-md-12 mb-3 row show_for_dates_class "
                            style="display: {{ !$business->show_report_public ? 'none' : '' }};">
                            <div class="mb-3 fv-row fv-plugins-icon-container col-md-4">
                                <label class="required form-label">Fecha inicio :</label>
                                <input class="form-control form-control-sm form-control-solid" autocomplete="off"
                                    value="{{ is_null($business->start_date_report_public) ? '' : $business->start_date_report_public }}"
                                    placeholder="Seleccione una fecha" id="date_start" name="date_inicio" type="date" />
                            </div>
                            <div class="mb-3 fv-row fv-plugins-icon-container col-md-4">
                                <!--begin::Label-->
                                <label class="required form-label">Fecha fin:</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input class="form-control form-control-sm form-control-solid" autocomplete="off"
                                    value="{{ is_null($business->end_date_report_public) ? '' : $business->end_date_report_public }}"
                                    placeholder="Seleccione una fecha" id="date_end" name="date_fin" type="date" />
                                <!--end::Input-->
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="mb-6 fv-row fv-plugins-icon-container col-md-4 show_for_dates_year_class"
                                style="display: {{ !$business->show_report_yearly ? 'none' : '' }};">
                                <!--begin::Label-->
                                <label class="required form-label">Seleccione una año :</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input class="form-control form-control-sm form-control-solid yearpicker" autocomplete="off"
                                    value="{{ is_null($business->start_report_year) ? "" : $business->start_report_year }}"
                                    placeholder="Seleccione una gestion" id="year" name="year" />
                                <!--end::Input-->
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="mb-6 fv-row fv-plugins-icon-container col-md-4 date_close_show_class"
                                style="display: {{ is_null($business->date_close_show) ? 'none' : '' }};">
                                <label class="required form-label">Seleccione la fecha que se mostrara :</label>
                                <input class="form-control form-control-sm form-control-solid" autocomplete="off"
                                    value="{{ is_null($business->date_close_show) ? '' : $business->date_close_show }}"
                                    placeholder="Seleccione una fecha" id="date_close_show" name="date_close_show"
                                    type="date" />
                            </div>
                        </div>
                        <div class="col-md-12">
                            @if ($business->show_report_public || $business->show_report_yearly)
                                        <a id="report_public_cancel" class="btn btn-sm btn-danger"> Cancelar Reporte Publico </a>
                                    @endif
                        </div>
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
    <script src="{{ asset('yearpicker.js') }}"></script>

    <script>
        let business = @json($business);
        $("#year").yearpicker({
            year: business.start_report_year??"",
            startYear: "2020",
            endYear: '2030',
        });

        $("#date_start").flatpickr({
            altInput: true,
            altFormat: "F j, Y",
            dateFormat: "Y-m-d",
            locale: "es",
        });

        $("#date_close_show").flatpickr({
            altInput: true,
            altFormat: "F j, Y",
            dateFormat: "Y-m-d",
            locale: "es",
        });

        $("#date_end").flatpickr({
            altInput: true,
            altFormat: "F j, Y",
            dateFormat: "Y-m-d",
            locale: "es",
        });

        $('#show_report_to_public_view').on('change', function() {
            if ($(this).is(':checked')) {
                $('.selected_type_report').show('');
                $('.date_close_show_class').show();
                $('#date_close_show').prop('required', true);
            } else {
                $('.selected_type_report').hide('');
                $('.selected_type_report input[type="radio"]').prop('checked', false);
                $('.show_for_dates_class').hide();
                $('.show_for_dates_year_class').hide();
                $('.date_close_show_class').hide();
                $('#date_close_show').prop('required', false);
            }
        });

        $('#report_public_cancel').click(function(){
            $.ajax({
                type: "POST",
                url: "{{ route('business.clear.report.public') }}",
                data:{
                    _token:"{{csrf_token()}}"
                },
                success: function(response) {
                    toastr.success("Reporte publico limpiado", 'Categoria actualizada');
                    toastr.options.closeDuration = 10000;
                    toastr.options.timeOut = 10000;
                    toastr.options.extendedTimeOut = 10000;
                    location.reload();
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
        });

        $('#form_business_update').submit(function(event) {
            event.preventDefault();
            //let radio = $(radio).prop('checked', true);
            if (!$('#show_report_to_public_view').is(':checked')) {
                this.submit();
                return;
            }

            if( !$('.selected_type_report input[type="radio"]').is(':checked')){
                toastr.error('Seleccione un tipo de reporte publico',
                    "Datos incorrectos");
                return;
            }

            if ($('#date_close_show').val() == "") {
                toastr.error('El campo Seleccione la fecha que se mostrara no debe estar vacio',
                    "Datos incorrectos");
                return;
            }

            if ($('.selected_type_report input[type="radio"]:checked').val() == 1) {
                if ($('#date_end').val() == "" || $('#date_start').val() == "") {
                    toastr.error('El campo Fecha inicio y fecha fin no debe estar vacio', "Datos incorrectos");
                    return;
                }
            } else {
                if ($('#year').val() == "") {
                    toastr.error('El campo AÑO no debe estar vacio', "Datos incorrectos");
                    return;
                }
            }
            this.submit();
        });

        function changeTypeReport(radio) {
            $('.selected_type_report input[type="radio"]').prop('checked', false);
            $(radio).prop('checked', true);
            if ($(radio).val() == 1) {
                $('.show_for_dates_class').show();
                $('.show_for_dates_year_class').hide();
                $('#date_start').prop('required', true);
                $('#date_end').prop('required', true);
                $('#year').prop('reuired', false);
            } else {
                $('.show_for_dates_year_class').show();
                $('.show_for_dates_class').hide();
                $('#date_start').prop('required', false);
                $('#date_end').prop('required', false);
                $('#year').prop('reuired', true);
            }
        }

        $(document).ready(function() {
            $("#menu-business").addClass('active open');
            if(!business.show_report_public || !business.show_report_yearly){
                $('.mostrar_reportes input').prop('disabled',true);
            }
        });

        $('#code_number').on('change', function() {
            $('#span_code_number').text($(this).val());
        });
    </script>
@endpush
