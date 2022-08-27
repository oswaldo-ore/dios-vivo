<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Reportes de pagos Dios vivo</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    @if (isset($background))
        <link rel='stylesheet' href='{{ public_path('css/bootstrap.css') }}'>
    @else
        <link rel='stylesheet' href='{{ asset('css/bootstrap.css') }}'>
    @endif

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

<body>
    @php
        \Jenssegers\Date\Date::setLocale('es');
    @endphp
    <div class="  @isset($background) p-0 @endisset ">

        <div class="card-body">
            @if (!isset($background))
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
                                            {{ number_format($books->totales['total_ingreso'],2,",",".") }}</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="left">
                                        <strong>Total egreso</strong>
                                    </td>
                                    <td class="right" style="padding: 5px !important;color: red">
                                        <strong style="text-transform: capitalize;"> {{ $business->currency }}
                                            {{ number_format($books->totales['total_egreso'],2,",",".") }}</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="left">
                                        <strong>Total</strong>
                                    </td>
                                    <td class="right">
                                        <strong style="text-transform: capitalize;"> {{ $business->currency }}
                                            {{  number_format($books->totales['total'],2,",",".") }}</strong>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <table class="table table-clear">
                    <tbody>
                        <tr>
                            <td class="left">
                                <div>
                                    <strong style="text-transform: uppercase;">Iglesia evangelica del Dios
                                        Vivo:</strong>
                                </div>
                                <div>Ubicacion: Zona plan 3000</div>
                                <div>Email: info@dotnettec.com</div>
                                <div>Phone: +91 9800000000</div>
                            </td>
                            <td class="right">
                                @if (isset($background))
                                    <img src="{{ public_path('assets/media/dios_vivo_fondo_blanco.jpeg') }}"
                                        alt="" height="170">
                                @else
                                    <img src="{{ asset('assets/media/dios_vivo_fondo_blanco.jpeg') }}" alt=""
                                        height="170">
                                @endif
                            </td>
                            <td>
                                <table class="table table-clear">
                                    <tbody>
                                        <tr>
                                            <td class="left">
                                                <strong>Total ingreso</strong>
                                            </td>
                                            <td class="right">
                                                <strong style="text-transform: capitalize;"> {{ $business->currency }}
                                                    {{ number_format($books->totales['total_ingreso'] ,2,".",",")}}</strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="left">
                                                <strong>Total egreso</strong>
                                            </td>
                                            <td class="right">
                                                <strong style="text-transform: capitalize;"> {{ $business->currency }}
                                                    {{ number_format($books->totales['total_egreso'],2,",",".") }}</strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="left">
                                                <strong>Total</strong>
                                            </td>
                                            <td class="right">
                                                <strong style="text-transform: capitalize;"> {{ $business->currency }}
                                                    {{ number_format($books->totales['total'],2,",",".") }}</strong>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>

                    </tbody>
                </table>
            @endif
            <div class="card-header
                @isset($background) p-0 @endisset"
                style="border-bottom: 0; margin-bottom: 15px">
                Rango de fecha del reporte:
                <strong>{{ ucwords(\Jenssegers\Date\Date::parse($dateInicio)->format('j F Y')) }}</strong>
                al
                <strong>{{ ucwords(\Jenssegers\Date\Date::parse($dateFin)->format('j F Y')) }}</strong>
                <span class="float-right"> <strong>Categoria:</strong>
                    {{ $category_id == 0 ? 'Todas las categorias' : $category->name }}</span>

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
                                <td class="left strong" style="font-weight: 700;">{{ $book->date }}</td>
                                <td class="left">{{ $book->description }}</td>

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

    @if (!isset($background))
        <div class="position-relative">
            <div class="position-absolute top-0 start-0">
                <form action="{{ route('download.book.pdf') }}"  method="get">
                    <input hidden class="form-control form-control-sm form-control-solid" autocomplete="off"
                        placeholder="Seleccione una fecha" id="date_reporte" name="date_reporte" required
                        value="{{ $dateInicio . ' a ' . $dateFin }}" />
                    <input type="hidden" id="category_report" name="category_report" value="{{ $category_id }}">
                    <button type="submit" class="btn btn-sm btn-info" style="
                        position: fixed;
                        top: 130px;
                        left: 10px; font-size: 18px" formtarget="_blank"> Descargar </button>
                </form>
            </div>
        </div>
    @else
    @endif
    <br>

</body>

</html>
