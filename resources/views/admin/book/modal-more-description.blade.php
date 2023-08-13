<div id="modal_more_description" class="modal fade" tabindex="-1" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="fw-bolder modal-title"> Agregar descripcion</h2>
                <div class="btn btn-icon btn-active-icon-primary" data-bs-dismiss="modal">
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
                <div class="mb-6" id="body_more_description">
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-auto text-center">
                            <a id="add_new_name_price" class="btn btn-light-info primary btn-icon "> <i
                                    class="fas fa-plus-circle"></i> </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light " data-bs-dismiss="modal">Cerrar</button>
                <a onclick="guardarNameAndPrice()" class="btn btn-primary">Guardar</a>
            </div>
        </div>
    </div>
</div>

<div class="" style="display: none" id="esquema">
    <div class="row description_more">
        <div class="col-md-6">
            <div class="form-group mb-4">
                <label for="" class="form-label required"> Nombre: </label>
                <input type="text" class="form-control form-control-solid"
                    placeholder="Ej. Pollo, Pernos, Arroz, etc." name="description_name" required autocomplete="off">
            </div>
        </div>
        <div class="col-md-5">
            <div class="form-group mb-4">
                <label for="" class="form-label required"> Precio: </label>
                <input type="text" class="form-control form-control-solid" value="0"
                    placeholder="Ingrese un precio" name="price_description"  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required autocomplete="off">
            </div>
        </div>
        <div class="col-md-1 align-self-end text-end mb-4">
            <a class="btn btn-icon btn-light-danger btn-sm" onclick="removeParent(this)">
                <i class="fas fa-trash"></i>
            </a>
        </div>
    </div>
</div>
@push('js')
    <script>
        let more_description_list = [];
        function removeParent(element) {
            console.log($(this).closest('div.description_more'));
            $(element).closest('div.description_more').remove();
        }
        $('a[name="removeParent"]').click(function() {
            console.log($(this).closest('div.description_more'));
            $(this).closest('div.description_more').remove();
        });
        $('#add_new_name_price').click(function() {
            var clone = $('#esquema').html();
            $('#body_more_description').append(clone);
        });

        function guardarNameAndPrice() {
            var description_list = getMoreDescriptionList();
            if (description_list != null) {
                var precio_total = 0;
                var description_cad = "";
                description_list.forEach((description, index, array) => {
                    description_cad +=
                        `${description.name} ( ${description.price} ) ${index == array.length-1 ? ".": ", "}`;
                    precio_total += parseFloat(description.price);
                });
                $('#more_description').text(description_cad);
                $('#amount').val(precio_total.toFixed(2));
                $('#modal_more_description').modal('hide');
            }

        }

        function getMoreDescriptionList() {
            more_description_list = [];
            var listadenombres = $(`input[name="description_name"]`).map(function() {
                return $(this).val();
            }).get();

            var listadeprecios = $(`input[name="price_description"]`).map(function() {
                return $(this).val();
            }).get();
            if (listadenombres.length == listadeprecios.length) {
                for (let index = 0; index < listadenombres.length - 1 && index < listadeprecios.length - 1; index++) {
                    if (listadenombres[index] == "") {
                        toastr.error('El campo nombre no debe estar vacio', "Datos incorrectos");
                        return null;
                    }
                    if (listadeprecios[index] <= 0) {
                        toastr.error('El campo precio debe ser mayor a 0', "Datos incorrectos");
                        return null;
                    }
                    more_description_list.push({
                        name: listadenombres[index],
                        price: listadeprecios[index],
                    });
                }
            } else {
                console.log("Error");
            }
            return more_description_list;
        }
    </script>
@endpush
