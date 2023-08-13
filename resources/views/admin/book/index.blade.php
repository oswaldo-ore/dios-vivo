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
            <div class="card-toolbar">
                <a data-bs-toggle="modal" data-bs-target="#modal_search_book" class="btn btn-success">Buscar</a>
            </div>
        </div>
        <div class="card-body">
            <form id="form-book" class="mb-6">
                <div class="row">
                    <div class="mb-6 fv-row fv-plugins-icon-container col-md-4">
                        <!--begin::Label-->
                        <label class="required form-label">Fecha :</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input class="form-control form-control-solid" autocomplete="off"
                            placeholder="Seleccione una fecha" id="date" value="" name="date" required />
                        <!--end::Input-->
                    </div>
                    <div class="mb-6 fv-row fv-plugins-icon-container col-md-5">
                        <!--begin::Label-->
                        <label class="required form-label">Categoria: </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <select class="form-select form-select-solid" data-control="select2"
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
                    <div class="mb-6 fv-row fv-plugins-icon-container col-md-3">
                        <!--begin::Label-->
                        <label class="required form-label">Tipo</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <select class="form-select form-select-solid" data-control="select2"
                            data-placeholder="Seleccione una tipo" name="type" id="type" required disabled>
                            <option></option>
                            <option value="ingreso" id="1"> Ingreso</option>
                            <option value="egreso" id="2">Egreso</option>
                        </select>
                        <!--end::Input-->
                    </div>

                    <div class="mb-6 fv-row fv-plugins-icon-container col-md-8">
                        <!--begin::Label-->
                        <label class="required form-label">Descripción</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input class="form-control form-control-solid" autocomplete="off"
                            placeholder="Ingrese una descripcion Ej. Pago mes abril" id="description" name="description"
                            value="" />
                        <!--end::Input-->
                    </div>
                    <div class="mb-6 fv-row fv-plugins-icon-container col-md-4">
                        <!--begin::Label-->
                        <label class="required form-label">Cantidad: </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input class="form-control form-control-solid" type="number" autocomplete="off"
                            placeholder="" required id="amount" min="0" value="0" step=".10"
                            name="amount" />
                        <!--end::Input-->
                    </div>
                    <div class="col-md-8 ">
                        <div class="col-md-12 mb-4" id="more_description_text_area" style="display: none;">
                            <textarea name="more_description" class="form-control form-control-solid" id="more_description"
                                placeholder="Aqui se mostrara las demas descripciones" cols="30" readonly rows="3"></textarea>
                        </div>
                        <div class="col-md-12 d-flex">
                            <div class="form-check form-check-custom form-check-solid col-auto me-3">
                                <input class="form-check-input" type="checkbox" value=""
                                    id="active_more_description" />
                                <label class="form-check-label" for="active_more_description">
                                    Desea agregar mas descripcion
                                </label>
                            </div>
                            <div class="col-auto text-start" id="button_more_description" style="display: none;">
                                <a class="btn p-2 btn-light-info" data-bs-toggle="modal"
                                    data-bs-target="#modal_more_description"> Mas descripcion </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-auto text-end">
                            <button class="btn btn-primary"> registrar </button>
                        </div>
                    </div>
                </div>
            </form>
            <div class="alerta_de_no_guardado" style="display: none">
                <div class="alert alert-dismissible bg-light-info d-flex flex-column flex-sm-row w-100 p-5 mb-10">
                    <!--begin::Icon-->
                    <div class="me-3">
                        <span class="svg-icon svg-icon-info svg-icon-2hx"><svg width="24" height="24" viewBox="0 0 24 24"
                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path opacity="0.3"
                                    d="M12 22C13.6569 22 15 20.6569 15 19C15 17.3431 13.6569 16 12 16C10.3431 16 9 17.3431 9 19C9 20.6569 10.3431 22 12 22Z"
                                    fill="currentColor" />
                                <path
                                    d="M19 15V18C19 18.6 18.6 19 18 19H6C5.4 19 5 18.6 5 18V15C6.1 15 7 14.1 7 13V10C7 7.6 8.7 5.6 11 5.1V3C11 2.4 11.4 2 12 2C12.6 2 13 2.4 13 3V5.1C15.3 5.6 17 7.6 17 10V13C17 14.1 17.9 15 19 15ZM11 10C11 9.4 11.4 9 12 9C12.6 9 13 8.6 13 8C13 7.4 12.6 7 12 7C10.3 7 9 8.3 9 10C9 10.6 9.4 11 10 11C10.6 11 11 10.6 11 10Z"
                                    fill="currentColor" />
                            </svg>
                        </span>
                    </div>
                    <!--end::Icon-->

                    <!--begin::Content-->
                    <div class="d-flex flex-column pe-0 pe-sm-10">
                        <h4 class="fw-semibold">Datos sin guardar.</h4>
                        <span>Se ha cargado <strong class="cantidad_sin_guardar"></strong> datos sin guardar.</span>
                    </div>
                    <!--end::Content-->

                    <!--begin::Close-->
                    <button type="button"
                        class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto"
                        data-bs-dismiss="alert">
                        <span class="svg-icon svg-icon-info svg-icon-2hx"><svg width="24" height="24"
                                viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2"
                                    rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                                <rect x="7.41422" y="6" width="16" height="2" rx="1"
                                    transform="rotate(45 7.41422 6)" fill="currentColor" />
                            </svg>

                        </span>
                    </button>
                    <!--end::Close-->
                </div>
            </div>
            <div class="row">
                <div class="table-responsive">
                    <table class="table table-hover table-rounded  border gy-3 gs-7">
                        <thead>
                            <tr class="fw-bold fs-6 text-muted border-bottom-2 border-gray-200">
                                <th>Fecha</th>
                                <th>Categoria</th>
                                <th>Tipo</th>
                                <th>Descripción</th>
                                <th>Saldo (Bs.)</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody id="cuerpo" class="fs-6">
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="col-auto text-end">
                        <a id="guardar" class="btn btn-primary"> Guardar </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.book.modal-more-description')
    @include('admin.book.search-category')
@endsection

@push('js')
    <script src="{{ asset('flatpickr-locale-es.js') }}"></script>
    <script>
        var libroDiario = [];
        $('#active_more_description').on('change', function() {
            if ($(this).is(':checked')) {
                $('#button_more_description').show();
                $('#amount').prop('readonly', true);
                $('#more_description_text_area').show();
            } else {
                $('#button_more_description').hide();
                $('#amount').prop('readonly', false);
                $('#more_description_text_area').hide();
            }
        })
        $(document).ready(function() {
            $('#kt_aside_toggle').click();
            $("#menu-registrar-book").addClass('active open');
            $("#date").flatpickr({
                altInput: true,
                altFormat: "j F, Y",
                dateFormat: "Y-m-d",
                locale: "es",
                defaultDate: 'today'
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
                var more_description = [];
                var have_more_description = false;
                if ($('#active_more_description').is(':checked')) {
                    more_description = more_description_list;
                    have_more_description = true;
                }
                if (amount.value > 0) {
                    libroDiario.push({
                        date: date.value,
                        category_id: category.value,
                        category_name: category.options[category.selectedIndex].text,
                        type: tipo.value,
                        description: description.value,
                        amount: amount.value,
                        have_more_description: have_more_description,
                        more_description: more_description,
                    });
                    saveBook(libroDiario);
                    updateList();
                    clearInput();
                } else {
                    toastr.error("Cantidad no puede estar en 0", 'Datos invalidos!');
                }
            });


            $('#guardar').on('click', function() {
                // var myForm = $(document.createElement('form'));
                // $(myForm).attr("action", "{{ route('book.store') }}");
                // $(myForm).attr("method", "POST");

                // var input = $("<input>").attr("type", "hidden").attr("name", "books").val(JSON.stringify(
                //     libroDiario));

                // var csrf = $("<input>").attr("type", "hidden").attr("name", "_token").val(
                //     "{{ csrf_token() }}");

                // $(myForm).append($(input));
                // $(myForm).append($(csrf));
                // $(document.body).append(myForm);
                $.ajax({
                    url:"{{ route('book.store') }}",
                    type:"POST",
                    data:{
                        _token: "{{ csrf_token() }}",
                        books:JSON.stringify(libroDiario),
                    },
                    success:function(response){
                        toastr.success(response.message, 'Registro guardados');
                        clearBooks();
                        setTimeout(() => {
                            location.reload();
                        }, 2000);
                    },
                    error:function(err,err1,err2){
                        var errors = err.responseJSON.message;
                        toastr.error( errors, "Ocurrio un error.");
                    }
                });
                // $(myForm).submit();
            });

            libroDiario = getBooks() ?? [];
            if (libroDiario.length > 0) {
                $('.cantidad_sin_guardar').text(libroDiario.length);
                updateList();
                $(".alerta_de_no_guardado").show();
                setTimeout(() => {
                    $(".alerta_de_no_guardado").hide();
                }, 60000);
                // toastr.error("Tienes datos sin registrar", ' Datos Cargado.');
            }
        });

        function clearInput() {
            var descripcion = document.getElementById("description");
            var amount = document.getElementById("amount");
            descripcion.value = "";
            amount.value = "";
            $('#more_description').text("");
            $('#body_more_description').html("");
            $('#button_more_description').hide();
            $('#amount').prop('readonly', false);
            $('#more_description_text_area').hide();
            $('#active_more_description').prop('checked', false);
        }

        function deleteItem(index) {
            libroDiario.splice(index, 1);
            document.getElementById("book_" + index).remove();
            updateList();
            saveBook(libroDiario);
        }

        function updateList() {
            var tr = "";
            var contador = 0;
            libroDiario.forEach(function(book, index) {
                //activo y gasto => debe --> pasivo e ingresos --> haber
                var debe = book.type == "egreso" ? book.amount : 0;
                var haber = book.type == "ingreso" ? book.amount : 0;
                var more_description_string = "";
                if (book.have_more_description) {
                    more_description_string = ": ";
                    book.more_description.forEach((moreDescription, index, array) => {
                        more_description_string +=
                            `${moreDescription.name} ( ${moreDescription.price} ) ${index == array.length-1 ? ".": ", "}`;
                    });
                }

                tr += `<tr id="book_${index}" style="vertical-align: middle;">`;
                tr += `<td>${book.date }</td>
                                <td>${book.category_name}</td>
                                <td>${book.type}</td>
                                <td>${book.description}${more_description_string}</td>
                                <td>
                                    <span class="badge ${book.type == "egreso" ? 'badge-light-danger fs-6' : 'badge-light-primary fs-6'} ">
                                        ${debe > 0 ? (-1*debe): (haber)}
                                    </span>
                                </td>

                                <td>
                                    <a onclick="deleteItem(${index})" class="btn btn-icon btn-danger">
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

        function saveBook(books) {
            localStorage.setItem('books', JSON.stringify(books));
        }

        function getBooks() {
            return JSON.parse(localStorage.getItem('books'));
        }

        function clearBooks() {
            localStorage.removeItem('books');
        }
    </script>
@endpush
