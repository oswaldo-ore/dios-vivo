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
                    <div class="mb-3 fv-row fv-plugins-icon-container col-md-3">
                        <!--begin::Label-->
                        <label class="required form-label">Fecha inicio :</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input class="form-control form-control-sm form-control-solid" autocomplete="off"
                            placeholder="Seleccione una fecha" id="date_start" name="date_inicio" required />
                        <!--end::Input-->
                    </div>
                    <div class="mb-3 fv-row fv-plugins-icon-container col-md-3">
                        <!--begin::Label-->
                        <label class="required form-label">Fecha fin:</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input class="form-control form-control-sm form-control-solid" autocomplete="off"
                            placeholder="Seleccione una fecha" id="date_end" name="date_fin" required />
                        <!--end::Input-->
                    </div>
                    <div class="mb-3 fv-row fv-plugins-icon-container col-md-3">
                        <!--begin::Label-->
                        <label class="required form-label">Categoria: </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <select class="form-select form-select-sm form-select-solid" data-control="select2"
                            data-placeholder="Seleccione una categoria" id="category" name="category" required>
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
                    <div class="col-auto mb-6">
                        {{--<div class="form-check form-check-custom form-check-solid form-check-sm">
                            <input class="form-check-input" type="checkbox" value="1" id="flexCheckChecked"
                                checked="checked" />
                            <label class="form-check-label" for="flexCheckChecked">
                                Solo mes
                            </label>
                        </div>--}}
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
                                <th>Monto</th>
                            </tr>
                        </thead>
                        <tbody id="cuerpo" style="vertical-align: middle;">
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row" style="display: none" id="button_reporte">
                <div class="col-md-12">
                    <div class="col-auto text-end">
                        <form action="{{route('show.book.web.pdf')}}" method="get">
                            <input hidden id="date_start_report" name="date_start_report" />
                            <input hidden  id="date_end_report" name="date_end_report" />
                            <input type="hidden" id="category_report" name="category_report">
                        <button  type="submit" class="btn btn-sm btn-primary" formtarget="_blank"> Reporte </button >
                        </form>
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
            $("#date_start").flatpickr({
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

            $("#date_start").prop('readonly', false);
            $("#date_end").prop('readonly', false);

            $('#form-book').on('submit', function(e) {
                e.preventDefault();
                var date_start = document.getElementById("date_start");
                var date_end = document.getElementById("date_end");
                var categoria = document.getElementById("category");
                $("#date_start_report").val(date_start.value);
                $("#date_end_report").val(date_end.value);
                $('#category_report').val(categoria.value);


                $.ajax({
                    url: this.action,
                    type: 'GET',
                    data: {
                        "date_start": date_start.value,
                        "date_end": date_end.value,
                        "category_id": categoria.value
                    },
                    success: function(response) {
                        books = response.books;
                        console.log(books);
                        updateList();
                        $('#button_reporte').show();
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr);
                        $('#button_reporte').hide();
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
            var more_description_string = "";

            books.forEach(function(book, index) {
                if(book.more_description.length > 0 ){
                    more_description_string = ":<br>";
                    book.more_description.forEach((moreDescription, index, array) => {
                        more_description_string +=
                            `${moreDescription.nombre} (Bs. ${moreDescription.precio} ) ${index == array.length-1 ? ".": ", <br>"}`;
                    });
                }

                //activo y gasto => debe --> pasivo e ingresos --> haber
                tr += `<tr id="book_${book.id}">`;
                tr += `
                                <td class="fw-bolder fs-6">${book.date }</td>
                                <td class="col-md-3">${book.description==""?"Sin descripcion":book.description}${more_description_string}</td>
                                <td class="fw-bolder text-uppercase">${book.category.name}</td>
                                <td class="text-capitalize">${book.type}</td>
                                <td>
                                    <span class="fw-bold fs-6  badge ${book.type == "egreso" ? "badge-light-danger":"badge-light-primary" }">
                                        ${ getFormatNumber(book.saldo.toFixed(2))}
                                    </span>
                                </td>
                                `;
                tr += "</tr>";
                total_debe += parseFloat(book.debe);
                total_haber += parseFloat(book.haber);
            });

            tr += `
                <tr>
                    <td colspan="3"></td>
                    <td class="fw-bold">Total ingreso: </td>
                    <td> <span  class="fw-bold fs-6  badge badge-primary " >Bs ${getFormatNumber(total_haber.toFixed(2))}</span> </td>
                </tr>
                <tr>
                    <td colspan="3"></td>
                    <td class="fw-bold">Total egreso: </td>
                    <td ><span class="fw-bold fs-6  badge badge-danger">Bs ${getFormatNumber(total_debe.toFixed(2))} </span> </td>

                </tr>
                <tr>
                    <td colspan="3"></td>
                    <td class="fw-bolder text-uppercase">Saldo total: </td>
                    <td  > <span class="fw-bolder fs-6 ${total_haber - total_debe > 0?  "badge badge-primary": "badge badge-danger"}" >Bs ${getFormatNumber((total_haber - total_debe).toFixed(2))< 0 ?getFormatNumber((total_haber - total_debe).toFixed(2))*-1 :getFormatNumber((total_haber - total_debe).toFixed(2)) } </span></td>
                </tr>
            `;
            $("#cuerpo").html(tr);
        }
    </script>
@endpush
