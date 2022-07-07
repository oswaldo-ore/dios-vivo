@extends('layout.template')

@section('page-menu-title')
    Dashboard
@endsection

@section('menu-top')
    <!--begin::Item-->
    <li class="breadcrumb-item text-dark">Dashboard</li>
    <!--end::Item-->
@endsection

@section('content')
    <h2 class="text-uppercase text-center fs-1 mb-5 text-gray-600"> Informe de la Iglesia del dios vivo </h2>
    <div class="row mb-6">
        <div class="col-auto m-auto">
            <div class="card">
                <!--begin::Header-->
                <div class="card-header py-5">
                    <!--begin::Title-->
                    <div class="card-title d-flex flex-column">
                        <!--begin::Info-->
                        <div class="d-flex align-items-center">
                            @if ($year['total_year'] > 0)
                            <span class="svg-icon svg-icon-3 svg-icon-success me-2">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1" transform="rotate(90 13 6)" fill="currentColor"></rect>
                                    <path d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z" fill="currentColor"></path>
                                </svg>
                            </span>
                            @else
                            <span class="svg-icon svg-icon-3 svg-icon-danger me-2">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect opacity="0.5" x="11" y="18" width="13" height="2" rx="1" transform="rotate(-90 11 18)" fill="currentColor"></rect>
                                    <path d="M11.4343 15.4343L7.25 11.25C6.83579 10.8358 6.16421 10.8358 5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75L11.2929 18.2929C11.6834 18.6834 12.3166 18.6834 12.7071 18.2929L18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25C17.8358 10.8358 17.1642 10.8358 16.75 11.25L12.5657 15.4343C12.2533 15.7467 11.7467 15.7467 11.4343 15.4343Z" fill="currentColor"></path>
                                </svg>
                            </span>
                            @endif
                            <!--begin::Currency-->
                            {{--<span
                                class="fs-3 fw-bold  me-1 align-self-start {{ $year['total_year'] < 0 ? 'text-danger' : 'text-primary' }}">Bs.</span>--}}
                            <!--end::Currency-->
                            <!--begin::Amount-->
                            <span data-kt-countup="true" data-kt-countup-value="{{ $year['total_year'] }}" data-kt-countup-prefix="Bs. "
                                class="fs-2hx fw-bolder {{ $year['total_year'] < 0 ? 'text-danger' : 'text-primary' }} me-2 lh-1 " data-kt-countup-decimal-places="2">0</span>
                            <!--end::Amount-->
                        </div>
                        <!--end::Info-->
                        <!--begin::Subtitle-->
                        <span class="text-gray-400 fw-bolder pt-1 fw-bold fs-3 align-self-center">Saldo total
                            {{ $year['year'] }}</span>
                        <!--end::Subtitle-->
                    </div>
                    <!--end::Title-->
                </div>
                <!--end::Header-->

            </div>
        </div>
    </div>
    <div class="row">
        @foreach ($year['categories'] as $categories)
            <div class="col-md-6 mb-6">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            {{ $categories->name }}
                        </div>
                        <div class="card-toolbar">
                            <div
                                class="fs-5 badge {{ $categories->total_ingreso > 0 ? 'badge-primary' : 'badge-danger' }} "
                                data-kt-countup="true" data-kt-countup-decimal-places="2"
                                data-kt-countup-value="{{$categories->total_ingreso}}" data-kt-countup-prefix="Bs. "
                                >Bs.
                                </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="dataTables-wrapper dt-bootstrap4 no-footer">
                            <div class="table-responsive">
                                <table class="table align-middle table-row-dashed fs-6 gy-3 dataTable no-footer">
                                    <thead>
                                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                            <th>Categoria</th>
                                            <th class="text-end">Saldo Total Bs:</th>
                                        </tr>
                                    </thead>
                                    <tbody class="fw-bolder text-gray-600">
                                        @foreach ($categories->categories as $category)
                                            <tr class="odd">
                                                <td>{{ $category->name }}</td>
                                                <td class="text-end"> Bs. {{ $category-> books_sum_haber + $category-> books_sum_debe}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
@push('js')
    <script>
        $(document).ready(function (){
            $("#menu-estadisticas").addClass('active open');
        });
    </script>
@endpush
