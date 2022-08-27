<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Reportes de pagos Dios vivo</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<style>
    /*!
 * Bootstrap v4.0.0-beta.2 (https://getbootstrap.com)
 * Copyright 2011-2017 The Bootstrap Authors
 * Copyright 2011-2017 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 */
    :root {
        --blue: #007bff;
        --indigo: #6610f2;
        --purple: #6f42c1;
        --pink: #e83e8c;
        --red: #dc3545;
        --orange: #fd7e14;
        --yellow: #ffc107;
        --green: #28a745;
        --teal: #20c997;
        --cyan: #17a2b8;
        --white: #fff;
        --gray: #868e96;
        --gray-dark: #343a40;
        --primary: #007bff;
        --secondary: #868e96;
        --success: #28a745;
        --info: #17a2b8;
        --warning: #ffc107;
        --danger: #dc3545;
        --light: #f8f9fa;
        --dark: #343a40;
        --breakpoint-xs: 0;
        --breakpoint-sm: 576px;
        --breakpoint-md: 768px;
        --breakpoint-lg: 992px;
        --breakpoint-xl: 1200px;
        --font-family-sans-serif: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
        --font-family-monospace: "SFMono-Regular", Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
    }

    @media print {

        *,
        *::before,
        *::after {
            text-shadow: none !important;
            box-shadow: none !important;
        }

        a,
        a:visited {
            text-decoration: underline;
        }

        abbr[title]::after {
            content: " ("attr(title) ")";
        }

        pre {
            white-space: pre-wrap !important;
        }

        pre,
        blockquote {
            border: 1px solid #999;
            page-break-inside: avoid;
        }

        thead {
            display: table-header-group;
        }

        tr,
        img {
            page-break-inside: avoid;
        }

        p,
        h2,
        h3 {
            orphans: 3;
            widows: 3;
        }

        h2,
        h3 {
            page-break-after: avoid;
        }

        .navbar {
            display: none;
        }

        .badge {
            border: 1px solid #000;
        }

        .table {
            border-collapse: collapse !important;
        }

        .table td,
        .table th {
            background-color: #fff !important;
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid #ddd !important;
        }
    }

    *,
    *::before,
    *::after {
        box-sizing: border-box;
    }

    html {
        font-family: sans-serif;
        line-height: 1.15;
        -webkit-text-size-adjust: 100%;
        -ms-text-size-adjust: 100%;
        -ms-overflow-style: scrollbar;
        -webkit-tap-highlight-color: transparent;
    }

    @-ms-viewport {
        width: device-width;
    }

    article,
    aside,
    dialog,
    figcaption,
    figure,
    footer,
    header,
    hgroup,
    main,
    nav,
    section {
        display: block;
    }

    body {
        margin: 0;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: #212529;
        text-align: left;
        background-color: #fff;
    }

    .row {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
        margin-right: -15px;
        margin-left: -15px;
    }



    .card-body {
        -ms-flex: 1 1 auto;
        flex: 1 1 auto;
        padding: 1.25rem;
    }

    .card-header {
        padding: 0.75rem 1.25rem;
        margin-bottom: 0;
        background-color: rgba(0, 0, 0, 0.03);
        border-bottom: 1px solid rgba(0, 0, 0, 0.125);
    }

    h6,
    .h6 {
        font-size: 1rem;
    }

    h1,
    h2,
    h3,
    h4,
    h5,
    h6,
    .h1,
    .h2,
    .h3,
    .h4,
    .h5,
    .h6 {
        margin-bottom: 0.5rem;
        font-family: inherit;
        font-weight: 500;
        line-height: 1.2;
        color: inherit;
    }

    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
        margin-top: 0;
        margin-bottom: 0.5rem;
    }

    *,
    *::before,
    *::after {
        box-sizing: border-box;
    }

    h6 {
        display: block;
        font-size: 0.67em;
        margin-block-start: 2.33em;
        margin-block-end: 2.33em;
        margin-inline-start: 0px;
        margin-inline-end: 0px;
        font-weight: bold;
    }

    .border {
        border: 1px solid #e9ecef !important;
    }

    .table {
        width: 100%;
        max-width: 100%;
        margin-bottom: 1rem;
        background-color: transparent;
    }

    table {
        border-collapse: collapse;
    }

    thead {
        display: table-header-group;
        vertical-align: middle;
        border-color: inherit;
    }

    .table thead th {
        vertical-align: bottom;
        border-bottom: 2px solid #e9ecef;
    }

    .table th,
    .table td {
        padding: 0.75rem;
        vertical-align: top;
        border-top: 1px solid #e9ecef;
    }

    th {
        text-align: inherit;
    }

    tbody {
        display: table-row-group;
        vertical-align: middle;
        border-color: inherit;
    }

    .table th,
    .table td {
        vertical-align: middle !important;
    }

    .card-header {
        padding: 0.5rem 0.5rem !important;
    }
    .float-right {
    float: right !important;
}
</style>

<body>
    @php
        \Jenssegers\Date\Date::setLocale('es');
    @endphp
    <div style="padding: 0">
        <div class="card-body">
            <table class="table">
                <tbody>
                    <tr>
                        <td class="left" style="width: 50%; font-size: 14px">

                            <div>
                                <strong style="text-transform: uppercase;">{{$business->name}}</strong>
                            </div>
                            <div>Ubicacion: {{$business->location}}</div>
                            <div>Correo: {{$business->email}}</div>
                            <div>Telefono: {{$business->code_number." ".$business->phone_number}}</div>
                        </td>
                        <td style="width: 50%;text-align: right;">
                            <img src="{{ public_path('assets/media/dios_vivo_fondo_blanco.jpeg') }}" alt=""
                                height="110">

                        </td>

                    </tr>

                </tbody>
            </table>
            <div class="card-header px-1 py-2" style="border-bottom: 0; margin-bottom: 15px; font-size: 14px">
                Reporte desde
                <strong>{{ ucwords(\Jenssegers\Date\Date::parse($dateInicio)->format('j F Y')) }}</strong>
                al
                <strong>{{ ucwords(\Jenssegers\Date\Date::parse($dateFin)->format('j F Y')) }}</strong>
                <span class="float-right"> <strong>Categoria:</strong>
                    {{ $category_id == 0 ? 'Todas las categorias' : $category->name }}</span>

            </div>

            <table style="width: 50%">
                <tbody>
                    <tr>
                        <td style="width: 100%">
                            <div class="table-responsive">
                                <table class="table" style="font-size: 13px;">
                                    <tbody>
                                        <tr>
                                            <td class="left"
                                                style="padding: 3px !important; background-color: rgba(226, 226, 226, 0.3)">
                                                <strong>Total ingreso</strong>
                                            </td>
                                            <td class="right" style="padding: 5px !important;color: green">
                                                <strong style="text-transform: capitalize;"> {{$business->currency}} {{ number_format($books->totales['total_ingreso'],2,",",".")}}</strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="left"
                                                style="padding: 3px !important; background-color: rgba(239, 239, 239, 0.3)">
                                                <strong>Total egreso</strong>
                                            </td>
                                            <td class="right" style="padding: 3px !important; color: red;">
                                                <strong style="text-transform: capitalize;"> {{$business->currency}} {{ number_format($books->totales['total_egreso'],2,",",".") }}</strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="left"
                                                style="padding: 3px !important;background-color: rgba(232, 232, 232, 0.3)">
                                                <strong>Saldo total</strong>
                                            </td>
                                            <td class="right" style="padding: 3px !important;">
                                                <strong style="text-transform: capitalize;"> {{$business->currency}} {{ number_format($books->totales['total'],2,",",".") }}</strong>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="card-header px-1 py-2" style="border-bottom: 0; margin-bottom: 15px; font-size: 14px">
                Detalle de la transacciones
            </div>
            <style>
                .table th,
                .table td {
                    padding: 7px !important;
                }
            </style>
            <div class="table-responsive">
                <table class="table border" style="text-align: start; font-size: 13px">
                    <thead>
                        <tr class="" style=" background-color: rgba(0, 0, 0, 0.03);">
                            <th class="center" style="width: 10px">#</th>
                            <th style="width: 15%">Fecha</th>
                            <th style="width: 40%">Descripción</th>

                            <th class="right">Categoria</th>
                            <th class="center">Tipo</th>
                            <th class="right" style="width: 18%">Saldo</th>
                        </tr>
                    </thead>
                    <tbody>

                        @forelse ($books as $book)
                            <tr>
                                <td class="center">{{ $loop->iteration }}</td>
                                <td class="left strong" style="font-weight: 700;">{{ $book->date }}</td>
                                <td class="left">{{ $book->description }}</td>

                                <td class="right" style="font-weight: 700;text-transform: capitalize; font-size: 13px">
                                    {{ $book->category->name }}</td>
                                <td class="center" style="    text-transform: capitalize;">{{ $book->type }}</td>
                                <td class="right"
                                    style="font-weight: 600 ; text-transform: capitalize; color:{{ $book->type == 'ingreso' ? 'green' : 'red' }}; ">
                                    {{$business->currency}}
                                    {{  number_format($book->type == 'ingreso' ? $book->saldo : $book->saldo,2,",",".") }}</td>
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
        <div class="">

            <form action="{{ route('download.book.pdf') }}" method="get">
                <input hidden class="form-control form-control-sm form-control-solid" autocomplete="off"
                    placeholder="Seleccione una fecha" id="date_reporte" name="date_reporte" required
                    value="{{ $dateInicio . ' a ' . $dateFin }}" />
                <input type="hidden" id="category_report" name="category_report" value="{{ $category_id }}">
                <button type="submit" class="btn btn-sm btn-primary"> Reporte </button>
            </form>
        </div>
    @else
    @endif

    <br>

</body>

</html>
