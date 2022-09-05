@extends('layout.template')

@push('css')
    <link rel='stylesheet' href='{{ asset('css/yearpicker.css') }}' />
@endpush

@section('page-menu-title')
    Dashboard
@endsection

@section('menu-top')
    <!--begin::Item-->
    <li class="breadcrumb-item text-dark">Cerrar Gestión</li>
    <!--end::Item-->
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="card-title">
                Cerrar gestión anual
            </div>
        </div>
        <div class="card-body">
            <form id="form-book" action="{{ route('report.getBookRange') }}">
                <div class="row mb-6 align-items-end">
                    <div class="mb-3 fv-row fv-plugins-icon-container col-md-3">
                        <!--begin::Label-->
                        <label class="required form-label">Seleccione una año :</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input class="form-control form-control-sm form-control-solid yearpicker" autocomplete="off"
                            placeholder="Seleccione una gestión" id="year" name="year" required />
                        <!--end::Input-->
                    </div>
                    <div class="col-auto mb-6 show_only_month_bloc" style="display: none">
                        <div class="form-check form-check-custom form-check-solid form-check-sm">
                            <!--<input class="form-check-input search" type="checkbox" value="1" id="show_only_month" />-->
                            <label class="form-check-label" for="show_only_month">
                                Este año no tiene cierre de caja
                            </label>
                        </div>
                    </div>
                    <div class="col mb-3 text-end">
                        <button class="btn btn-sm btn-primary" style="display: none" type="button"
                            id="generate_close_box"> Cerrar gestión </button>
                    </div>
                </div>
            </form>
            <div class="row">
                <div class="table-responsive">
                    <table class="table table-hover table-rounded border gy-4 gs-4">
                        <thead>
                            <tr class="fw-bold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                                <th>Año</th>
                                <th>Descripcion</th>
                                <th class="fw-bold">Ingreso Total</th>
                                <th class="fw-bold">Egreso Total</th>
                                <th class="fw-bold">Saldo total</th>
                            </tr>
                        </thead>
                        <tbody id="cuerpo" style="vertical-align: middle;">
                            @forelse ($closeBoxes as $closeBox)
                                <tr>
                                    <td class="fw-bold">{{ $closeBox->year }}</td>
                                    <td>{{ $closeBox->description }}</td>
                                    <td class="fw-bold">{{$business->currency}} {{ number_format($closeBox->total_haber,2,",",".") }}</td>
                                    <td class="fw-bold">{{$business->currency}} {{ number_format($closeBox->total_debe,2,",",".")  }}</td>
                                    <td class="fw-bold">{{$business->currency}} {{ number_format($closeBox->total_saldo ,2,",",".") }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center" colspan="5"> No se encontraron registros</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('flatpickr-locale-es.js') }}"></script>
    <script src="{{ asset('yearpicker.js') }}"></script>
    <script>
        var yearsWithManagement = @json($yearsWithManagement);

        function verifyYear(year) {
            $('#generate_close_box').hide();
            $('.show_only_month_bloc').hide();
            if (year != null) {
                var haveGestion = false;
                console.log(year);
                for (let index = 0; index < yearsWithManagement.length && !haveGestion; index++) {
                    const element = yearsWithManagement[index];
                    if(element == year){
                        haveGestion = true;

                    }
                }
                if(!haveGestion){
                    $('.show_only_month_bloc').show();
                    $('#generate_close_box').show();
                }
            }
        }

        $("#year").yearpicker({
            startYear: '{{ $years[0] }}',
            endYear: "{{ $years[count($years) - 1] }}",
            onChange: verifyYear
        });

        $('#generate_close_box').click(function(){
            var year = $('#year').val();
            url = "{{url('close-box/close')}}/"+year;
            window.open(url,'_blank');
        });

        $(document).ready(function() {
            $("#menu-close-box").addClass('active open');
        });
    </script>
@endpush
