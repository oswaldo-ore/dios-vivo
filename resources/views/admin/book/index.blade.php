@extends('layout.template')

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
                Registrar Ingreso - Egreso
            </div>
        </div>
        <div class="card-body">
            <form id="form-book">
                <div class="row mb-6">


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
                            @forelse ($categories as $category)
                                <optgroup label="{{ $category->name }}">
                                    @forelse ($category->categories as $category)
                                        <option value="{{ $category->id }}" category_id={{ $category->category_id }}>
                                            {{ $category->name }}</option>
                                    @empty
                                        <option disabled> No tiene una categoria.</option>
                                    @endforelse
                                </optgroup>
                            @empty
                            @endforelse
                        </select>
                        <!--end::Input-->
                    </div>
                    <div class="mb-3 fv-row fv-plugins-icon-container col-md-3">
                        <!--begin::Label-->
                        <label class="required form-label">Tipo</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <select class="form-select form-select-sm form-select-solid" data-control="select2"
                            data-placeholder="Seleccione una tipo" name="type" id="type" required disabled>
                            <option></option>
                            <option value="ingreso" id="1"> Ingreso</option>
                            <option value="egreso" id="2">Egreso</option>
                        </select>
                        <!--end::Input-->
                    </div>

                    <div class="mb-3 fv-row fv-plugins-icon-container col-md-8">
                        <!--begin::Label-->
                        <label class="required form-label">Descripci??n</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input class="form-control form-control-sm form-control-solid" placeholder="" id="description"
                            name="description" required />
                        <!--end::Input-->
                    </div>

                    <div class="mb-3 fv-row fv-plugins-icon-container col-md-4">
                        <!--begin::Label-->
                        <label class="required form-label">Cantidad: </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input class="form-control form-control-sm form-control-solid" type="number" autocomplete="off"
                            placeholder="" required id="amount" name="amount" />
                        <!--end::Input-->
                    </div>
                    <div class="col-md-12">
                        <div class="col-auto text-end">
                            <button class="btn btn-sm btn-primary"> registrar </button>
                        </div>
                    </div>


                </div>
            </form>
            <div class="row">
                <div class="table-responsive">
                    <table class="table table-hover table-rounded table-striped border gy-7 gs-7">
                        <thead>
                            <tr class="fw-bold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                                <th>Fecha</th>
                                <th>Categoria</th>
                                <th>Tipo</th>
                                <th>Debe</th>
                                <th>Haber</th>
                                <th>Descripci??n</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody id="cuerpo">
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="col-auto text-end">
                        <a id="guardar" class="btn btn-sm btn-primary"> Guardar </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('flatpickr-locale-es.js') }}"></script>
    <script>
        var libroDiario = [];
        $(document).ready(function() {
            $("#menu-registrar-book").addClass('active open');
            $("#date").flatpickr({
                altInput: true,
                altFormat: "j F, Y",
                dateFormat: "Y-m-d",
                locale: "es",
            });

            $("#date").prop('readonly', false);

            $("#category").on('change', function() {
                var id = $(this).find(':selected').attr('category_id');
                if (id == 1) {
                    $(`#type`).val('ingreso').change();
                } else {
                    $(`#type`).val('egreso').change();
                }
            });

            $('#form-book').on('submit', function(e) {
                e.preventDefault();
                var date = document.getElementById("date");
                var categoria = document.getElementById("category");
                var tipo = document.getElementById("type");
                var descripcion = document.getElementById("description");
                var amount = document.getElementById("amount");
                libroDiario.push({
                    date: date.value,
                    category_id: category.value,
                    category_name: category.options[category.selectedIndex].text,
                    type: tipo.value,
                    description: description.value,
                    amount: amount.value,
                });
                console.log(libroDiario);
                updateList();
                clearInput();
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

        function deleteItem(index) {
            libroDiario.splice(index, 1);
            document.getElementById("book_" + index).remove();
            updateList();
        }

        function updateList() {
            var tr = "";
            var contador = 0;
            libroDiario.forEach(function(book, index) {
                //activo y gasto => debe --> pasivo e ingresos --> haber
                var debe = book.type == "egreso" ? book.amount : 0;
                var haber = book.type == "ingreso" ? book.amount : 0;

                tr += `<tr id="book_${index}">`;
                tr += `<td>${book.date }</td>
                                <td>${book.category_name}</td>
                                <td>${book.type}</td>
                                <td><span class="badge badge-light-danger">- ${debe} </span></td>
                                <td><span class="badge badge-light-primary">${haber} </span></td>
                                <td>${book.description}</td>
                                <td>
                                    <a onclick="deleteItem(${index})" class="btn btn-icon btn-danger btn-sm">
                                        <span class="svg-icon svg-icon-primary svg-icon">
                                            <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo8/dist/../src/media/svg/icons/Home/Trash.svg--><svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
                                                viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24" />
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
                                </td>`;
                tr += "</tr>"
            });
            $("#cuerpo").html(tr);
            contador += 1;
        }
    </script>
@endpush
