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
                Transferir monto a una categoria
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('transfer.save') }}" method="POST" id="form_transfer_update">
                @csrf
                <div class="row mb-6">
                    <div class="mb-6 fv-row fv-plugins-icon-container col-md-4">
                        <!--begin::Label-->
                        <label class="required form-label"> Seleccione una categoría:</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <select name="category_id" id="category_id" data-placeholder="Seleccione una categoria"
                            placeholder="Seleccione una categoria" class="form-control form-control-sm ">
                            <option></option>
                            <optgroup label="{{ $category->name }}">
                                @forelse ($category->categories as $cate)
                                    <option value="{{ $cate->id }}">{{ $cate->name }}</option>
                                @empty
                                @endforelse
                            </optgroup>
                        </select>
                        <!--end::Input-->
                    </div>
                    <div class="mb-6 fv-row fv-plugins-icon-container col-md-4">
                        <!--begin::Label-->
                        <label class="required form-label">Monto</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="input-group flex-nowrap input-group-sm ">
                            <input type="number" class="form-control form-control-sm" autocomplete="off"
                                placeholder="Introduzca un monto" min="50" maxlength="15" id="amount"
                                value="0" name="amount" required />
                        </div>
                        <!--end::Input-->
                    </div>

                    <div class="col-auto mb-6 align-self-end">
                        <div class="col-auto text-end">
                            <button class="btn btn-sm btn-primary"> Transferir </button>
                        </div>
                    </div>
                </div>
            </form>
            <div class="row">
                <div class="col-md-10 col-sm-12">
                    <div class="table-responsive">
                        <table class="table table-row-bordered align-middle gy-4 gs-9">
                            <thead
                                class="border-bottom fw-bolder bg-success text-white">
                                <tr>
                                    <td>#</td>
                                    <td>Description</td>
                                    <td>Cantidad</td>
                                    <td>(Cod) Nombre</td>
                                </tr>
                            </thead>
                            <tbody class="fw-bold text-gray-800">
                                @foreach ($transactions as $transaction)
                                    <tr>
                                        <td>{{ $transaction->id }}</td>
                                        <td>{{ $transaction->description }}</td>
                                        <td>{{ $business->currency }} {{ $transaction->amount }}</td>
                                        <td>({{ $transaction->user->id }}) {{ $transaction->user->name }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $('#menu-transactions').addClass('open active');
        $('#category_id').select2();
        $('#form_transfer_update').submit(function(event) {
            event.preventDefault();

            if ($('#form_transfer_update')[0].checkValidity()) {
                let amount = $('#form_transfer_update input[id="amount"]').val();
                let categoryName = $('#form_transfer_update #category_id').find('option:selected').text();
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-primary',
                        cancelButton: 'btn btn-secondary'
                    },
                    buttonsStyling: false
                });
                swalWithBootstrapButtons.fire({
                    title: "",
                    html: `<p class="fs-2" >Estas seguro de transferir la cantidad de <strong>{{ $business->currency }} ${amount} </strong> a la categoria <strong class="text-uppercase">${categoryName}</strong></p>? <br>`,
                    icon: "question",
                    buttonsStyling: false,
                    showCancelButton: true,
                    confirmButtonText: "Confirmar",
                    cancelButtonText: "Cancelar",
                    reverseButtons: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: $('#form_transfer_update').attr('action'),
                            type: "POST",
                            data: $('#form_transfer_update').serialize(),
                            success: function(response) {
                                swalWithBootstrapButtons.fire({
                                    title: response.message,
                                    html: `<p class="fs-2" >Se ha transferido la cantidad de <strong>{{ $business->currency }} ${amount} </strong> a la categoria <strong class="text-uppercase">${categoryName}</strong></p>`,
                                    icon: 'success'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        location.reload();
                                    }
                                });
                                $('#form_transfer_update')[0].reset();
                                $('#category_id').select2();
                            },
                            error: function(xhr, ajaxOptions, thrownError) {
                                var error = JSON.parse(xhr.responseText);
                                swalWithBootstrapButtons.fire({
                                    title: error.message,
                                    html: `<p class="fs-2" >No se pudo transferir la cantidad de <strong>{{ $business->currency }} ${amount} </strong> a la categoria <strong class="text-uppercase">${categoryName}</strong></p>`,
                                    icon: 'error'
                                });
                            }
                        });
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        swalWithBootstrapButtons.fire(
                            'Cancelado',
                            'No se hizo ninguna transferencia :)',
                            'error'
                        )
                    }
                });
            } else {
                $('#form_transfer_update')[0].reportValidity();
            }
        });
    </script>
@endpush
