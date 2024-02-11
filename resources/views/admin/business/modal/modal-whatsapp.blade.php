<div class="modal fade" id="whatsappConnect" tabindex="-1" aria-labelledby="whatsappConnect" aria-hidden="true" data-bs-backdrop="static" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="whatsappConnect">Generar QR</h5>
                <a type="button"  class="btn-close" data-bs-dismiss="modal"  aria-label="Close"></a>
            </div>
            <div class="modal-body text-center">
                <!-- Botones -->
                <div class="mb-3">
                    <div class="" id="imagenContainer"></div>
                </div>
                <!-- Botón para generar QR -->
                <button type="button" class="btn btn-primary btn-lg generar_qr generar" href="javascript::void(0)" onclick="generateQR()">
                    <span class="indicator-label">
                        Generar QR
                    </span>
                    <span class="indicator-progress">
                        Espere por favor... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                    </span>
                </button>
                {{-- <button type="button" href="javascript::void(0)" onclick="generateQR()" class="btn btn-primary btn-lg generar">Generar QR</button> --}}
                <button type="button" href="javascript::void(0)" onclick="verificarQr()" class="btn btn-primary btn-lg verificar d-none">Verificar QR</button>
                <!-- Espacio para mostrar el QR -->
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        $(document).ready(function() {
            let btnVerificar = $('.generar_qr');
            generateQR = () => {
                btnVerificar.attr("data-kt-indicator", "on");
                $.ajax({
                    url: "{{ route('admin.business.whatsapp.getImageQr') }}",
                    type: 'GET',
                    success: function(response) {
                        var img = $('<img>');
                        img.attr('src', 'data:image/png;base64,' + response);
                        $('#imagenContainer').append(img);
                        $('.generar').addClass('d-none');
                        $('.verificar').removeClass('d-none');
                        btnVerificar.removeAttr("data-kt-indicator");
                    },
                    error: function() {
                        btnVerificar.removeAttr("data-kt-indicator");
                    }
                });
            }

            verificarQr = () => {
                $.ajax({
                    url: "{{ route('admin.business.whatsapp.verifySession') }}",
                    type: 'GET',
                    success: function(response) {
                        if(response.success ){
                            window.location.reload();
                        }
                    }
                });
            }
            function sendPdf(id){
                window.open(`{{ url('admin/close-monthly-box/report/pdf') }}?monthly_id=${id},category_id=0`, "_blank");
            }
        })
    </script>
@endpush
