@extends('layout.app')

@section('page-menu-title')
    File Manager - Blank
@endsection

@section('menu-top')
    <!--begin::Item-->
    <li class="breadcrumb-item text-muted">
        <a href="../../demo1/dist/index.html"
            class="text-muted text-hover-primary">Home</a>
    </li>
    <!--end::Item-->
    <!--begin::Item-->
    <li class="breadcrumb-item">
        <span class="bullet bg-gray-300 w-5px h-2px"></span>
    </li>
    <!--end::Item-->
    <!--begin::Item-->
    <li class="breadcrumb-item text-muted">File Manager</li>
    <!--end::Item-->
    <!--begin::Item-->
    <li class="breadcrumb-item">
        <span class="bullet bg-gray-300 w-5px h-2px"></span>
    </li>
    <!--end::Item-->
    <!--begin::Item-->
    <li class="breadcrumb-item text-dark">Blank Directory</li>
    <!--end::Item-->
@endsection
