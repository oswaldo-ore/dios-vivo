@extends('layout.template')

@push('css')
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
                Cierre mensual
            </div>
            <div class="card-toolbar">
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#cerrarMes">
                    Cerrar Caja
                  </button>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-hover table-rounded border gy-4 gs-4">
                            <thead>
                                <tr class="fw-bold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                                    <th>#</th>
                                    <th>Fecha inicio</th>
                                    <th>Fecha fin</th>
                                    <th>Total Haber</th>
                                    <th>Total Debe</th>
                                    <th>Total Cierre </th>
                                    <th>Cierre anterior </th>
                                    <th>Total hasta fecha fin</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($closures as $closure)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $closure->start_date }}</td>
                                        <td>{{ $closure->end_date }}</td>
                                        <td>{{ $closure->total_haber }}</td>
                                        <td> {{ $closure->total_debe }}</td>
                                        <td>
                                            <span class="badge badge-light-{{$closure->total_debe_haber <0?"danger":"primary"}} fs-6">
                                                {{ $closure->total_debe_haber }}
                                            </span>
                                        </td>
                                        <td>{{ $closure->total_anterior }}</td>
                                        <td>{{ $closure->total_cierre }}</td>
                                        <td>
                                            <a onclick="downloadPdf('{{$closure->id}}')" class="btn btn-icon btn-sm btn-circle btn-light-primary fs-5">
                                                <i class="far fa-file-pdf"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9"> No se encontro cierres Mensuales </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('admin.monthly_closure.modal-monthly-closure')
@endsection

@push('js')
    <script src="{{ asset('flatpickr-locale-es.js') }}"></script>
    <script>
        $("#monthly-closure-box").addClass('active open');
        let fechas = @json($lastRecordedDate);
        $("#date_start").flatpickr({
            altInput: true,
            altFormat: "F j, Y",
            dateFormat: "Y-m-d",
            locale: "es",
            enable: [
                function(date) {
                    return date > new Date(fechas.min);
                }
            ]
        });
        $("#date_end").flatpickr({
            altInput: true,
            altFormat: "F j, Y",
            dateFormat: "Y-m-d",
            locale: "es",
            enable: [
                function(date) {
                    return date > new Date(fechas.min);
                }
            ]
        });

        function downloadPdf(id){
            window.open(`{{ url('admin/close-monthly-box/report/pdf') }}?monthly_id=${id},category_id=0`, "_blank");
        }
    </script>
@endpush
