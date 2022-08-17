@extends('layout.template')

@section('page-menu-title')
    Dashboard
@endsection

@section('menu-top')
    <!--begin::Item-->
    <li class="breadcrumb-item text-dark">Categoria</li>
    <!--end::Item-->
@endsection

@section('content')
    @include('admin.category.modal-category')
    <div class="card">
        <div class="card-header align-items-center py-5 gap-2 gap-md-5">
            <!--begin::Card title-->
            <div class="card-title">
                Categoria
            </div>
            <!--end::Card title-->
            <!--begin::Card toolbar-->
            <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                <!--begin::Add product-->
                <a href="javascrip::void" data-bs-toggle="modal" data-bs-target="#categoria_nuevo"
                    class="btn btn-primary btn-sm">Agregar</a>
                <!--end::Add product-->
            </div>
            <!--end::Card toolbar-->
        </div>
        <div class="card-body">
            <div class="col-md-10 col-sm-12">
                <div class="table-responsive">
                    <table
                        class="table table-striped table-rounded border border-gray-300 table-row-bordered table-row-gray-300 gy-4 gs-4">
                        {{-- <thead>
                            <tr class="fw-bold fs-6 text-dark border-bottom border-gray-200">
                                <th></th>
                                <th></th>
                            </tr>
                        </thead> --}}
                        <tbody>
                            @forelse ($categories as $category)
                                <tr id="category_{{ $category->id }}" class="text-dark fw-bold fs-5">
                                    <td> {{ $category->id }}</td>
                                    <td> {{ $category->name }}</td>
                                </tr>
                                <tr id="category_{{ $category->id }}">
                                    <td colspan="4" class="pe-3">
                                        <div class="table-responsive ps-8">
                                            <table class="table table-row-dashed table-row-gray-500 gy-2 gs-2 mb-0">
                                                <tbody>
                                                    @forelse ($category->categories as $category)
                                                        <tr>
                                                            {{-- <td class="align-middle fs-5">{{ $category->id }}</td> --}}
                                                            <td class="min-w-150px align-middle fs-5">{{ $category->name }}
                                                            </td>
                                                            <td class="align-middle"><span class="badge badge-primary ">
                                                                    Activo</span></td>
                                                            <td>

                                                                <a href="#"
                                                                    class="btn btn-sm {{ $category->is_enabled ? 'btn-danger ' : 'btn-primary ' }}  btn-icon"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#categoria_change_state{{ $category->id }}">
                                                                    <i
                                                                        class="fas {{ $category->is_enabled ? 'fa-thumbs-down' : 'fa-thumbs-up ' }}  "></i>
                                                                </a>
                                                                <a href="#"
                                                                    class="btn btn-sm btn-light-primary btn-icon pe-1"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#categoria_edit{{ $category->id }}">
                                                                    <span class="svg-icon svg-icon-primary svg-icon">
                                                                        <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo8/dist/../src/media/svg/icons/Design/Edit.svg--><svg
                                                                            xmlns="http://www.w3.org/2000/svg"
                                                                            xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                            width="24px" height="24px"
                                                                            viewBox="0 0 24 24" version="1.1">
                                                                            <g stroke="none" stroke-width="1"
                                                                                fill="none" fill-rule="evenodd">
                                                                                <rect x="0" y="0"
                                                                                    width="24" height="24" />
                                                                                <path
                                                                                    d="M8,17.9148182 L8,5.96685884 C8,5.56391781 8.16211443,5.17792052 8.44982609,4.89581508 L10.965708,2.42895648 C11.5426798,1.86322723 12.4640974,1.85620921 13.0496196,2.41308426 L15.5337377,4.77566479 C15.8314604,5.0588212 16,5.45170806 16,5.86258077 L16,17.9148182 C16,18.7432453 15.3284271,19.4148182 14.5,19.4148182 L9.5,19.4148182 C8.67157288,19.4148182 8,18.7432453 8,17.9148182 Z"
                                                                                    fill="#000000" fill-rule="nonzero"
                                                                                    transform="translate(12.000000, 10.707409) rotate(-135.000000) translate(-12.000000, -10.707409) " />
                                                                                <rect fill="#000000" opacity="0.3"
                                                                                    x="5" y="20"
                                                                                    width="15" height="2"
                                                                                    rx="1" />
                                                                            </g>
                                                                        </svg>
                                                                        <!--end::Svg Icon-->
                                                                    </span>
                                                                </a>




                                                                <a href="#"
                                                                    class="btn btn-sm btn-light-danger btn-icon"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#categoria_delete{{ $category->id }}">
                                                                    <span class="svg-icon svg-icon-primary svg-icon">
                                                                        <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo8/dist/../src/media/svg/icons/Home/Trash.svg--><svg
                                                                            xmlns="http://www.w3.org/2000/svg"
                                                                            xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                            width="24px" height="24px"
                                                                            viewBox="0 0 24 24" version="1.1">
                                                                            <g stroke="none" stroke-width="1"
                                                                                fill="none" fill-rule="evenodd">
                                                                                <rect x="0" y="0"
                                                                                    width="24" height="24" />
                                                                                <path
                                                                                    d="M6,8 L18,8 L17.106535,19.6150447 C17.04642,20.3965405 16.3947578,21 15.6109533,21 L8.38904671,21 C7.60524225,21 6.95358004,20.3965405 6.89346498,19.6150447 L6,8 Z M8,10 L8.45438229,14.0894406 L15.5517885,14.0339036 L16,10 L8,10 Z"
                                                                                    fill="#000000" fill-rule="nonzero" />
                                                                                <path
                                                                                    d="M14,4.5 L14,3.5 C14,3.22385763 13.7761424,3 13.5,3 L10.5,3 C10.2238576,3 10,3.22385763 10,3.5 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z"
                                                                                    fill="#000000" opacity="0.3" />
                                                                            </g>
                                                                        </svg>
                                                                        <!--end::Svg Icon-->
                                                                    </span>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        @include('admin.category.modal-edit')
                                                        @include('admin.category.modal-delete')
                                                        @include('admin.category.modal-is-enable')
                                                    @empty
                                                        <tr>
                                                            <td colspan="4"> No hay resultados</td>
                                                        </tr>
                                                    @endforelse

                                                </tbody>
                                            </table>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2"> No existe Categorias</td>
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
    <script>
        $(document).ready(function() {
            $("#menu-categoria").addClass('active open');
        });

        function changeStateCategory(id) {
            url = "{{url('/')}}/category/" + id + "/changeState";
            $.ajax({
                type: "GET",
                url: url,
                success: function(response) {
                    toastr.success(response.mensaje, 'Categoria actualizada');
                    toastr.options.closeDuration = 10000;
                    toastr.options.timeOut = 10000;
                    toastr.options.extendedTimeOut = 10000;
                    window.location = "{{route('category.index')}}";
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
    </script>
@endpush
