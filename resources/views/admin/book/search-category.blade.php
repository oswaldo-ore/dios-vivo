<div id="modal_search_book" class="modal fade" tabindex="-1" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="fw-bolder modal-title"> Buscar por categoria</h2>
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                    <span class="svg-icon svg-icon-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2"
                                rx="1" transform="rotate(-45 6 17.3137)" fill="black"></rect>
                            <rect x="7.41422" y="6" width="16" height="2" rx="1"
                                transform="rotate(45 7.41422 6)" fill="black"></rect>
                        </svg>
                    </span>
                </div>
            </div>

            <div class="modal-body">
                <div class="row mb-3">
                    <div class="mb-3 fv-row fv-plugins-icon-container col-md-5">
                        <!--begin::Label-->
                        <label class="required form-label">Categoria: </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <select class="form-select form-select-sm form-select-solid" data-control="select2"
                            data-placeholder="Seleccione una categoria" id="search_category" name="search_category" required>
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
                </div>
                <div class="row mb-3">
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
                            <tbody id="search_cuerpo" style="vertical-align: middle;">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light btn-sm " data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        let booksSearch = [];
        $('#search_category').on('change',function(){
            $.ajax({
                type: "GET",
                url: "{{ route('report.getBookRange.v2') }}",
                data:{
                    category_id: $(this).val()
                },
                success: function(response) {
                    booksSearch = response.books;
                    updateListSearch();
                },
                dataType: 'json',
                error: function(xhr, ajaxOptions, thrownError) {
                    console.log(xhr);
                    let errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        toastr.error(value[0], 'Datos invalidos!');
                        toastr.options.closeDuration = 10000;
                        toastr.options.timeOut = 10000;
                        toastr.options.extendedTimeOut = 10000;
                    });
                }
            });
        });

        function updateListSearch() {
            console.log(booksSearch);
            let tr = "";
            let contador = 0;
            let total_debe = 0;
            let total_haber = 0;

            if(booksSearch.length == 0){
                tr = `
                <tr class="text-center">
                    <td colspan="5"> No se encontraron registro en esta categoria </td>
                </tr>
                `;
            }

            booksSearch.forEach(function(book, index) {
                let more_description_string = "";
                if (book.more_description.length > 0) {
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
                <td class="col-md-3 col-sm-5">${book.description==""?"Sin descripcion":book.description}${more_description_string}</td>
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

            // tr += `
            //     <tr>
            //         <td colspan="3"></td>
            //         <td class="fw-bold">Total ingreso: </td>
            //         <td> <span  class="fw-bold fs-6  badge badge-primary " >Bs ${getFormatNumber(total_haber.toFixed(2))}</span> </td>
            //     </tr>
            //     <tr>
            //         <td colspan="3"></td>
            //         <td class="fw-bold">Total egreso: </td>
            //         <td ><span class="fw-bold fs-6  badge badge-danger">Bs ${getFormatNumber(total_debe.toFixed(2))} </span> </td>

            //     </tr>
            //     <tr>
            //         <td colspan="3"></td>
            //         <td class="fw-bolder text-uppercase">Saldo total: </td>
            //         <td  > <span class="fw-bolder fs-6 ${total_haber - total_debe > 0?  "badge badge-primary": "badge badge-danger"}" >Bs ${getFormatNumber((total_haber - total_debe).toFixed(2))< 0 ?getFormatNumber((total_haber - total_debe).toFixed(2))*-1 :getFormatNumber((total_haber - total_debe).toFixed(2)) } </span></td>
            //     </tr>
            // `;
            $("#search_cuerpo").html(tr);
        }
    </script>
@endpush
