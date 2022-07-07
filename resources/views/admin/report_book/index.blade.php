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
                Libro Diario
            </div>
        </div>
        <div class="card-body">
            <form id="form-book" action="{{ route('report.getBookRange') }}">
                <div class="row mb-6 align-items-end">
                    <div class="mb-3 fv-row fv-plugins-icon-container col-md-4">
                        <!--begin::Label-->
                        <label class="required form-label">Fecha :</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input class="form-control form-control-sm form-control-solid" autocomplete="off"
                            placeholder="Seleccione una fecha" id="date" name="date" required />
                        <!--end::Input-->
                    </div>
                    <div class="mb-3 fv-row fv-plugins-icon-container col-md-5">
                        <!--begin::Label-->
                        <label class="required form-label">Categoria: </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <select class="form-select form-select-sm form-select-solid" data-control="select2"
                            data-placeholder="Seleccione una categoria" id="category" name="category" required>
                            <option></option>
                            <optgroup label="Todos">
                                <option value="0">Todas Categoria</option>
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
                    <div class="col-auto mb-6">
                        <div class="form-check form-check-custom form-check-solid form-check-sm">
                            <input class="form-check-input" type="checkbox" value="1" id="flexCheckChecked"
                                checked="checked" />
                            <label class="form-check-label" for="flexCheckChecked">
                                Solo mes
                            </label>
                        </div>
                    </div>
                    <div class="col mb-3 text-end">
                        <button class="btn btn-sm btn-primary" type="submit"> Buscar </button>
                    </div>
                </div>
            </form>
            <div class="row">
                <div class="table-responsive">
                    <table class="table table-hover table-rounded border gy-4 gs-4">
                        <thead>
                            <tr class="fw-bold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                                <th>Fecha</th>
                                <th>Descripción</th>
                                <th>Categoria</th>
                                <th>Tipo</th>
                                <th>Debe</th>
                                <th>Haber</th>
                            </tr>
                        </thead>
                        <tbody id="cuerpo" style="vertical-align: middle;">
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="col-auto text-end">
                        <a id="Reportar" class="btn btn-sm btn-primary"> Reporte </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('flatpickr-locale-es.js') }}"></script>
    <script>
        var books = [];
        $(document).ready(function() {
            $("#menu-reportes").addClass('active open');
            $("#date").flatpickr({
                altInput: true,
                altFormat: "F j, Y",
                dateFormat: "Y-m-d",
                mode: "range",
                locale: "es",
            });

            $("#date").prop('readonly', false);

            $('#form-book').on('submit', function(e) {
                e.preventDefault();
                var date = document.getElementById("date");
                var categoria = document.getElementById("category");
                $.ajax({
                    url: this.action,
                    type: 'GET',
                    data: {
                        "date": document.getElementById("date").value,
                        "category_id": document.getElementById("category").value
                    },
                    success: function(response) {
                        console.log(response.books);
                        books = response.books;
                        console.log(books);
                        updateList();
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr);
                    }

                });

                console.log(this.action);
                //updateList();
                //clearInput();
            });


            $('#guardar').on('click', function() {
                var myForm = $(document.createElement('form'));
                $(myForm).attr("action", "{{ route('book.store') }}");
                $(myForm).attr("method", "POST");

                var input = $("<input>").attr("type", "hidden").attr("name", "books").val(JSON.stringify(
                    libroDiario));

                var csrf = $("<input>").attr("type", "hidden").attr("name", "_token").val(
                    "{{ csrf_token() }}");

                $(myForm).append($(input));
                $(myForm).append($(csrf));
                $(document.body).append(myForm);
                $(myForm).submit();
            });

        });

        function clearInput() {
            var descripcion = document.getElementById("description");
            var amount = document.getElementById("amount");
            var date = document.getElementById("date");
            descripcion.value = "";
            amount.value = "";
            date.value = "";
        }


        function updateList() {
            var tr = "";
            var contador = 0;
            var total_debe = 0;
            var total_haber = 0;
            books.forEach(function(book, index) {
                //activo y gasto => debe --> pasivo e ingresos --> haber
                tr += `<tr id="book_${book.id}">`;
                tr += `
                                <td class="fw-bolder fs-6">${book.date }</td>
                                <td class="col-md-3">${book.description}</td>
                                <td class="fw-bolder text-uppercase">${book.category.name}</td>
                                <td class="text-capitalize">${book.type}</td>
                                <td><span class="fw-bold fs-6  badge badge-light-danger">${ book.debe.toFixed(2)} </span></td>
                                <td><span class="fw-bold fs-6  badge badge-light-primary">${book.haber.toFixed(2)} </span></td>
                                `;
                tr += "</tr>";
                total_debe += parseFloat(book.debe);
                total_haber += parseFloat(book.haber);
            });

            tr += `
                <tr>
                    <td colspan="3"></td>
                    <td class="fw-bold">Total debe-haber: </td>
                    <td ><span class="fw-bold fs-6  badge badge-danger">Bs ${total_debe.toFixed(2)} </span> </td>
                    <td> <span  class="fw-bold fs-6  badge badge-primary " >Bs ${total_haber.toFixed(2)}</span> </td>
                </tr>
                <tr>
                    <td colspan="3"></td>
                    <td class="fw-bold text-uppercase">Saldo total: </td>
                    <td colspan="2" > <span class="fw-bold fs-6 ${total_haber + total_debe > 0?  "badge badge-primary": "badge badge-danger"}" >Bs ${(total_haber + total_debe).toFixed(2)} </span></td>
                </tr>
            `;
            $("#cuerpo").html(tr);
        }
    </script>
@endpush
