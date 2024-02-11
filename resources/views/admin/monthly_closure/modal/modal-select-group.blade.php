<div class="modal fade" id="whatsappGetContacts" tabindex="-1" aria-labelledby="whatsappGetContacts" aria-hidden="true"
    data-bs-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="whatsappGetContacts">Contactos del Whtasapp</h5>
                <a type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
            </div>
            <div class="modal-body ">
                <div class="mb-3 text-center">
                    <form action="" id="contactsSelected" method="get">
                        <div class="chats"></div>
                    </form>
                </div>
                <div class="my-4 d-none contactSelected">
                    <label for="">Contactos seleccionados</label>
                    <div class="border  p-2 list_number ">
                    </div>
                </div>
                <button type="button" class="btn btn-primary btn-lg verificar d-none" href="javascript::void(0)"
                    style="float: right" onclick="enviar()">
                    <span class="indicator-label">
                        Enviar a contactos
                    </span>
                    <span class="indicator-progress">
                        Espere por favor... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                    </span>
                </button>
                <!-- Espacio para mostrar el QR -->
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        $(document).ready(function() {
            let stateLoading = 0; //0 no cargado, 1 cargando, 2 cargado
            let selected = 0;
            let btnVerificar = $('.verificar');
            selectedInforme = (selectedId) => {
                selected = selectedId;
                if (stateLoading == 0) {
                    getChats();
                }
            }
            getChats = () => {
                stateLoading = 1;
                $.ajax({
                    url: "{{ route('admin.business.whatsapp.getContactsHtml') }}",
                    type: 'GET',
                    success: function(response) {
                        $('.chats').html(response.html);
                        stateLoading = 2;
                        $('.verificar').removeClass('d-none');
                    },
                    error: function() {
                        stateLoading = 0;
                    }
                });
            }

            enviar = () => {
                let selectedContacts = $('input[name="contactsSelected[]"]:checked').map(function() {
                    return $(this).val();
                }).get();
                btnVerificar.attr("data-kt-indicator", "on");
                $.ajax({
                    url: "{{ route('monthly.closure.report.pdf.send') }}",
                    type: 'POST',
                    data: {
                        monthly_id: selected,
                        contacts: selectedContacts,
                        category_id: 0,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#contactsSelected input[type="checkbox"]').prop('checked', false);
                            $('.list_number').html('');
                            $('#whatsappGetContacts').modal('hide');
                            toastr.success('Se envio el informe a los contactos seleccionados',
                                'Reporte enviado');
                            toastr.options.closeDuration = 10000;
                            toastr.options.timeOut = 10000;
                            toastr.options.extendedTimeOut = 10000;
                            btnVerificar.removeAttr("data-kt-indicator");
                        } else {
                            toastr.error('No se pudo enviar el informe');
                            toastr.options.closeDuration = 10000;
                            toastr.options.timeOut = 10000;
                            toastr.options.extendedTimeOut = 10000;
                            btnVerificar.removeAttr("data-kt-indicator");

                        }
                    },
                    error: function() {
                        toastr.error('No se pudo enviar el informe');
                        toastr.options.closeDuration = 10000;
                        toastr.options.timeOut = 10000;
                        toastr.options.extendedTimeOut = 10000;
                        btnVerificar.removeAttr("data-kt-indicator");
                    }
                });
            }
        })

        function toggleCheckbox(tr, index, name, isGroup) {
            let checkbox = $(tr).find('input[type="checkbox"]');
            checkbox.prop('checked', !checkbox.prop('checked'));
            if (checkbox.prop('checked')) {
                $('.list_number').append(
                    `<span class=" me-2 mb-2 badge badge-${isGroup?'success':"info" } tr_${index}">${name}</span>`);
            } else {
                $('.list_number').find(`.tr_${index}`).remove();
            }
            if ($('.list_number').children().length > 0) {
                $('.contactSelected').removeClass('d-none');
            } else {
                $('.contactSelected').addClass('d-none');
            }
        }
        function searchByTrNameNumber(){
            console.log("yoooooo");
            let value = $('input[name="search_name_phone"]').val().toLowerCase();
            console.log(value);
            if (value === '') {
                $('#contactsSelected table tbody tr').removeClass('d-none');
                return;
            }
            $('#contactsSelected table tbody tr').each(function() {
                let name = $(this).attr('name').toLowerCase();
                let number = $(this).attr('number').toLowerCase();
                let matchName = name.indexOf(value) > -1;
                let matchNumber = number.indexOf(value) > -1;
                if (matchName || matchNumber) {
                    $(this).removeClass('d-none');
                } else {
                    $(this).addClass('d-none');
                }
            });
        }
    </script>
@endpush
