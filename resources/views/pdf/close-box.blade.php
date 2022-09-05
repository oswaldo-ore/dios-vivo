<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Reportes de pagos Dios vivo</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('layout.parts.link')
</head>
<style>
    .row {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
        margin-right: -15px;
        margin-left: -15px;
    }

    .table th,
    .table td {
        vertical-align: middle !important;
    }
</style>

<body style="background-color: white;">
    @php
        \Jenssegers\Date\Date::setLocale('es');
    @endphp
    <div class="  @isset($background) p-0 @endisset ">

        <div class="card-body">
            <div class="row" style="margin-bottom: 15px;">
                <div class="col-lg-4 col-sm-4  col-md-4 col-4 ">
                    <div>
                        <strong style="text-transform: uppercase;">{{ $business->name }}</strong>
                    </div>
                    <div>Ubicacion: {{ $business->location }}</div>
                    <div>Correo: {{ $business->email }}</div>
                    <div>Telefono: {{ $business->code_number . ' ' . $business->phone_number }}</div>
                </div>
                <div class="col-lg-4 col-sm-4 col-md-4 col-4 text-center">
                    @if (isset($background))
                        <img src="{{ public_path('assets/media/dios_vivo_fondo_blanco.jpeg') }}" alt=""
                            height="170">
                    @else
                        <img src="{{ asset('assets/media/dios_vivo_fondo_blanco.jpeg') }}" alt=""
                            height="170">
                    @endif

                </div>
                <div class="col-lg-4 col-sm-4 col-md-4 col-4 ml-auto">
                    <table class="table table-clear">
                        <tbody>
                            <tr>
                                <td class="left">
                                    <strong>Total ingreso</strong>
                                </td>
                                <td class="right" style="padding: 5px !important;color: green">
                                    <strong style="text-transform: capitalize;"> {{ $business->currency }}
                                        {{ number_format($books->totales['total_ingreso'], 2, ',', '.') }}</strong>
                                </td>
                            </tr>
                            <tr>
                                <td class="left">
                                    <strong>Total egreso</strong>
                                </td>
                                <td class="right" style="padding: 5px !important;color: red">
                                    <strong style="text-transform: capitalize;"> {{ $business->currency }}
                                        {{ number_format($books->totales['total_egreso'], 2, ',', '.') }}</strong>
                                </td>
                            </tr>
                            <tr>
                                <td class="left">
                                    <strong>Total</strong>
                                </td>
                                <td class="right">
                                    <strong style="text-transform: capitalize;"> {{ $business->currency }}
                                        {{ number_format($books->totales['total'], 2, ',', '.') }}</strong>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card-header d-flex justify-content-between bg-gray-200
                @isset($background) p-0 @endisset"
                style="border-bottom: 0; margin-bottom: 15px">
                <div class="col-auto">
                    Cerrar caja desde
                    <strong>{{ ucwords(\Jenssegers\Date\Date::parse($dateInicio)->format('j F Y')) }}</strong>
                    al
                    <strong>{{ ucwords(\Jenssegers\Date\Date::parse($dateFin)->format('j F Y')) }}</strong>
                </div>
                <div class="col-auto">
                    <span class="float-right"> <strong>Categoria:</strong>
                        {{ $category_id == 0 ? 'Todas las categorias' : $category->name }}</span>
                </div>

            </div>
            <h6>
                Detalle de la transacciones
            </h6>
            <br>
            <div class="table-responsive-sm">
                <table class="table border" style="text-align: start;">
                    <thead>
                        <tr class="" style=" background-color: rgba(0, 0, 0, 0.03);">
                            <th class="center">#</th>
                            <th>Fecha</th>
                            <th class="col-md-4">Description</th>

                            <th class="right">Categoria</th>
                            <th class="center">Tipo</th>
                            <th class="right">Saldo</th>
                        </tr>
                    </thead>
                    <tbody>

                        @forelse ($books as $book)
                            <tr>
                                <td class="center">{{ $loop->iteration }}</td>
                                @php
                                    $moreDescriptionString = '';
                                    if (count($book->moreDescription) > 0) {
                                        $moreDescriptionString = ': <br>Detalle:<br>';
                                        foreach ($book->moreDescription as $key => $description) {
                                            $moreDescriptionString = $moreDescriptionString . ($key + 1) . ': ' . $description->nombre . ' ( Bs. ' . $description->precio . ' ) <br>';
                                        }
                                    }
                                @endphp
                                <td class="left strong" style="font-weight: 700;">{{ $book->date }}</td>
                                <td class="left">
                                    {{ $book->description == '' ? 'Sin descripcion' : $book->description }}{!! html_entity_decode($moreDescriptionString) !!}
                                </td>

                                <td class="right" style="font-weight: 700;text-transform: uppercase;">
                                    {{ $book->category->name }}</td>
                                <td class="center" style="    text-transform: capitalize;">{{ $book->type }}</td>
                                <td class="right"
                                    style="font-weight: 600 ;text-transform: capitalize ;color:{{ $book->type == 'ingreso' ? 'green' : 'red' }}; ">
                                    {{ $business->currency }}
                                    {{ $book->type == 'ingreso' ? $book->haber : $book->debe }}</td>
                            </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>

    </div>
    <br>
    <br>


    <div class="position-relative">
        <div class="position-absolute top-0 start-0">
            <a type="button" class="btn btn-sm btn-info" id="close_box"
                style="
                        position: fixed;
                        top: 130px;
                        left: 10px; font-size: 18px; color: white">
                Cerrar caja </a>
        </div>
    </div>
    <br>
</body>
@include('layout.parts.scripts')
<script>
    var year = @json($year);
    $("#close_box").click(function() {

        Swal.fire({
            html: `Estas seguro que desea cerrar caja de la <strong>GESTION ${year}</strong>`,
            icon: "warning",
            buttonsStyling: false,
            showCancelButton: true,
            allowOutsideClick: false,
            allowEscapeKey: false,
            confirmButtonText: "Si!",
            cancelButtonText: 'No, cancelar',
            customClass: {
                confirmButton: "btn btn-primary",
                cancelButton: 'btn btn-secondary'
            }
        }).then(function(result) {
            console.log(result);
            if (result.isConfirmed) {
                closeBox();
            }
        });
    });

    function closeBox() {
        var url = "{{ route('close.box.year.confirm.index') }}";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: url,
            type: "POST",
            data: {
                year: year
            },
            dataType: 'json',
            success: function(response) {
                if (response.codigo == 1) {
                    Swal.fire({
                        html: `CAJA CERRADA <strong>GESTION ${year}</strong>`,
                        icon: "success",
                        buttonsStyling: false,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        confirmButtonText: "Cerrar ventana",
                        customClass: {
                            confirmButton: "btn btn-primary",
                        }
                    }).then(function(result) {
                        console.log(result);
                        if (result.isConfirmed) {
                            window.top.close();
                        }
                    });
                }
            },
            error: function(xhr, status, error) {
                console.log(xhr);
            }
        });
    }
</script>

</html>
