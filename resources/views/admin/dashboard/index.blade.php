@extends('layout.app')

@section('page-menu-title')
    Dashboard
@endsection

@section('menu-top')
    <!--begin::Item-->
    <li class="breadcrumb-item text-dark">Dashboard</li>
    <!--end::Item-->
@endsection

@section('content')
    <h2 class="text-uppercase text-center"> Informe de la Iglesia del dios vivo </h2>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <!--begin::Header-->
                <div class="card-header py-5">
                    <!--begin::Title-->
                    <div class="card-title d-flex flex-column">
                        <!--begin::Info-->
                        <div class="d-flex align-items-center">
                            <!--begin::Currency-->
                            <span class="fs-4 fw-bold text-gray-400 me-1 align-self-start">$</span>
                            <!--end::Currency-->
                            <!--begin::Amount-->
                            <span class="fs-2hx fw-bolder text-dark me-2 lh-1">69,700</span>
                            <!--end::Amount-->
                        </div>
                        <!--end::Info-->
                        <!--begin::Subtitle-->
                        <span class="text-gray-400 pt-1 fw-bold fs-6">Expected Earnings</span>
                        <!--end::Subtitle-->
                    </div>
                    <!--end::Title-->
                </div>
                <!--end::Header-->

            </div>
        </div>
    </div>
@endsection
