@extends('layout.template')

@push('css')
    <link rel='stylesheet' href='{{ asset('css/yearpicker.css') }}' />
@endpush

@section('page-menu-title')
    Dashboard
@endsection

@section('menu-top')
    <!--begin::Item-->
    <li class="breadcrumb-item text-dark">Reportes anuales</li>
    <!--end::Item-->
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="card-title">
                Reportes anual
            </div>
        </div>
        <div class="card-body">
            <form id="form-book" action="{{ route('report.getBookRange') }}">
                <div class="row mb-6 align-items-end">
                    <div class="mb-3 fv-row fv-plugins-icon-container col-md-3">
                        <!--begin::Label-->
                        <label class="required form-label">Seleccione una gestion :</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input class="form-control form-control-sm form-control-solid yearpicker" autocomplete="off"
                            placeholder="Seleccione una gestion" id="year" name="year" required />
                        <!--end::Input-->
                    </div>
                    <div class="mb-3 fv-row fv-plugins-icon-container col-md-3">
                        <!--begin::Label-->
                        <label class="required form-label">Categoria: </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <select class="form-select form-select-sm form-select-solid search" data-control="select2"
                            data-placeholder="Seleccione una categoria" id="category" name="category" required disabled>
                            <option></option>
                            <optgroup label="Todos">
                                <option value="0" selected>Todas Categoria</option>
                                <option value="1">Todos Ingresos</option>
                                <option value="2">Todos Egresos</option>
                            </optgroup>
                            @forelse ($categories as $category)
                                <optgroup label="{{ $category->name }}">
                                    @forelse ($category->categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @empty
                                        <option disabled> No tiene una categoria.</option>
                                    @endforelse
                                </optgroup>
                            @empty
                            @endforelse
                        </select>
                        <!--end::Input-->
                    </div>
                    <div class="col-auto mb-6 show_category_bloc"  style="display: none">
                        <div class="form-check form-check-custom form-check-solid form-check-sm">
                            <input class="form-check-input search" type="checkbox" id="show_category" />
                            <label class="form-check-label" for="show_category">
                                Mostrar las categorias
                            </label>
                        </div>
                    </div>
                    <div class="col mb-3 text-end">
                        <button class="btn btn-sm btn-primary"  style="display: none" type="button" id="generate_report_year"> Generar reporte anual </button>
                    </div>
                </div>
            </form>
            <div class="row show_category_bloc mb-6 " style="display: none">
                <div class="col-auto "  >
                    <div class="form-check form-check-custom form-check-solid form-check-sm">
                        <input class="form-check-input search" type="checkbox" id="include_previous_management" />
                        <label class="form-check-label" for="include_previous_management">
                            Incluir la gestion anterior
                        </label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="table-responsive">
                    <table class="table table-hover table-rounded border gy-4 gs-4">
                        <thead>
                            <tr class="fw-bold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                                <th>Fecha</th>
                                <th>Categoria</th>
                                <th>Ingreso</th>
                                <th>Gasto</th>
                                <th>Monto</th>
                            </tr>
                        </thead>
                        <tbody id="cuerpo" style="vertical-align: middle;">
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
        var gestionYear = [];

        function getGestion(value) {
            if (value != null) {
                $('#category').prop('disabled',false);
                $('.show_category_bloc').show();
                $('#generate_report_year').show();
                getGestionOnlyMonth();
            }
        }
        function getGestionOnlyMonth(){
            var year = $('#year').val();
            var category_id = $('#category').val();
            var show_category = $('#show_category').is(':checked');
            var include_previous_management = $('#include_previous_management').is(':checked') ? 1 : 2;
            $.ajax({
                url:"{{route('report.getBookRangeYear')}}",
                type:"GET",
                data:{
                    category_id: category_id,
                    year: year,
                    show_category: show_category? 1:0,
                    previous_management: include_previous_management,
                },
                success: function(response){
                    $('#cuerpo').html(response.view);
                },
                error: function(xhr,status,error){
                    console.log(xhr);
                }
            });
        }
        $("#year").yearpicker({
            startYear: "{{ $minYear }}",
            endYear: '{{ $maxYear }}',
            onChange: getGestion
        });
        $('.search').on('change',function(){
            var category_id = $('#category').val();
            if(category_id != 0){
                $('#show_category').prop('checked',false);
                $('#include_previous_management').prop('checked',false);
                $('.show_category_bloc').hide();
            }else{
                $('.show_category_bloc').show();
            }
            getGestionOnlyMonth();
        });

        $('#generate_report_year').click(function(){
            var year = $('#year').val();
            var category_id = $('#category').val();
            var show_category = $('#show_category').is(':checked');
            var include_previous_management = $('#include_previous_management').is(':checked') ? 1 : 2;
            var url = `?category_id=${category_id}&year=${year}&show_category=${show_category?1:2}&imprimir=true&previous_management=${include_previous_management}`;
            url = "{{route('report.getBookRangeYear')}}"+url;
            window.open(url,'_blank');
        });
        $(document).ready(function() {
            $("#menu-yearly").addClass('active open');
        });
    </script>
@endpush
