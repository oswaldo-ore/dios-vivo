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
                                <strong style="text-transform: uppercase;">{{ $business->name }}</strong>
                            </div>
                            <div>Ubicacion: {{ $business->location }}</div>
                            <div>Correo: {{ $business->email }}</div>
                            <div>Telefono: {{ $business->code_number . ' ' . $business->phone_number }}</div>
                        </td>
                        <td style="width: 50%;text-align: right;">
                            <img src="data:image/png;base64,{{ $business->logoBase64() }}" alt=""
                                height="110">

                        </td>

                    </tr>

                </tbody>
            </table>
            <div class="card-header px-1 py-2" style="border-bottom: 0; margin-bottom: 15px; font-size: 14px">
                Reporte de la gestión
                <strong>{{ $year }}</strong>
                <span class="float-right"> <strong>Categoria:</strong>
                    {{ $category_id == 0 ? 'Todas las categorias' : $category->name }}</span>

            </div>
            @php
                $previous_year = Carbon\Carbon::parse($year . '-01-01')
                    ->subYear()
                    ->format('Y');
            @endphp
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
                                                <strong style="text-transform: capitalize;"> {{ $business->currency }}
                                                    {{ number_format($saldo->saldo_haber, 2, ',', '.') }}</strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="left"
                                                style="padding: 3px !important; background-color: rgba(239, 239, 239, 0.3)">
                                                <strong>Total egreso</strong>
                                            </td>
                                            <td class="right" style="padding: 3px !important; color: red;">
                                                <strong style="text-transform: capitalize;"> {{ $business->currency }}
                                                    {{ number_format($saldo->saldo_debe, 2, ',', '.') }}</strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="left"
                                                style="padding: 3px !important;background-color: rgba(232, 232, 232, 0.3)">
                                                <strong>Saldo total</strong>
                                            </td>
                                            <td class="right" style="padding: 3px !important;">
                                                <strong style="text-transform: capitalize;"> {{ $business->currency }}
                                                    {{ number_format($saldo->saldo_anual, 2, ',', '.') }}</strong>
                                            </td>
                                        </tr>
                                        @if (!is_null($close))
                                            <tr>
                                                <td colspan="2" class="left"
                                                    style="padding: 3px !important; background-color: rgba(254, 254, 254, 0.3);text-align: center">
                                                    <strong>Gestion {{ $close->year }} - no incluido en saldo
                                                        total</strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="left"
                                                    style="padding: 3px !important; background-color: rgba(226, 226, 226, 0.3)">
                                                    <strong>Monto Gestion {{ $close->year }}</strong>
                                                </td>
                                                <td class="right text-info"
                                                    style="padding: 5px !important;color: rgb(96, 86, 243)">
                                                    <strong style="text-transform: capitalize;">
                                                        {{ $business->currency }}
                                                        {{ number_format($close->total_saldo, 2, ',', '.') }}</strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" class="left"
                                                    style="padding: 3px !important; background-color: rgba(254, 254, 254, 0.3);text-align: center">
                                                    <strong>
                                                        Monto total hasta:
                                                        {{ \Jenssegers\Date\Date::parse(Carbon\Carbon::parse($books->first()->new_date . '-01')->endOfYear())->format(
                                                            'F Y',
                                                        ) }}
                                                    </strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="left"
                                                    style="padding: 3px !important; background-color: rgba(226, 226, 226, 0.3)">
                                                    <strong>Total {{ $close->year }}
                                                        -
                                                        {{ Carbon\Carbon::parse($books->first()->new_date . '-01')->format('Y') }}
                                                    </strong>
                                                </td>
                                                <td class="right text-info" style="padding: 5px !important;">
                                                    <strong
                                                        style="text-transform: capitalize; color: {{ $close->total_saldo + $saldo->saldo_anual > 0 ? 'rgb(96, 86, 243)' : 'red' }}">
                                                        {{ $business->currency }}
                                                        {{ number_format($close->total_saldo + $saldo->saldo_anual, 2, ',', '.') }}</strong>
                                                </td>
                                            </tr>
                                        @endif
                                        @if ($previousManagement == 1 && is_null($close))
                                            <tr>
                                                <td colspan="2" class="left"
                                                    style="padding: 3px !important; background-color: rgba(254, 254, 254, 0.3);text-align: center">
                                                    <strong>Gestion {{ $previous_year }} - no incluido en el saldo
                                                        total</strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="left"
                                                    style="padding: 3px !important; background-color: rgba(226, 226, 226, 0.3)">
                                                    <strong>Total Gestion</strong>
                                                </td>
                                                <td class="right" style="padding: 5px !important;color: rgb(1, 1, 1)">
                                                    <strong style="text-transform: capitalize;">
                                                        -</strong>
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="card-header px-1 py-2" style="border-bottom: 0; margin-bottom: 15px; font-size: 14px">
                Detalle de la gestión
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
                            <th>Categoria</th>

                            <th class="right">Ingreso</th>
                            <th class="center">Gasto</th>
                            <th class="right" style="width: 18%">Monto </th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!is_null($close))
                            <tr style="background-color: rgb(252, 240, 240)">
                                <td>1</td>
                                <td class="fw-bolder fs-6" style="font-weight: 600; ">{{ $close->year }}</td>
                                <td class="fw-bolder text-uppercase" style="font-weight: 600; ">GESTION
                                    {{ $close->year }}</td>
                                <td>
                                    <span class="badge badge-light-primary fs-7  "
                                        style="font-weight: 600 ;  color: {{ $close->total_haber > 0 ? 'green' : '' }}'; ">
                                        {{ $business->currency }}
                                        {{ number_format($close->total_haber, 2, ',', '.') }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-light-danger fs-7 "
                                        style="font-weight: 600 ; color:{{ $close->total_debe > 0 ? 'red' : '' }}'">
                                        {{ $business->currency }} -
                                        {{ number_format($close->total_debe, 2, ',', '.') }}
                                    </span>
                                </td>
                                <td>
                                    <span
                                        class="fw-bold fs-6 badge badge-light-{{ $close->total_saldo < 0 ? 'danger' : 'primary' }}"
                                        style="font-weight: 600 ;  color:{{ $close->total_saldo < 0 ? 'red' : 'green' }}; ">
                                        {{ $business->currency }}
                                        {{ number_format($close->total_saldo, 2, ',', '.') }}
                                    </span>
                                </td>
                            </tr>
                        @endif

                        @if ($previousManagement == 1 && is_null($close))
                            <tr>

                                <td> - </td>
                                <td class="fw-bolder fs-6">{{ $previous_year }}</td>
                                <td class="fw-bolder text-uppercase">GESTION {{ $previous_year }}</td>
                                <td colspan="3">
                                    <span>
                                        Este año no tiene cierre de caja, verifique en <a
                                            href="{{ route('close.box.index') }}" class="text-success"
                                            target="_blank">Cierre
                                            anual</a>
                                    </span>
                                </td>
                            </tr>
                        @endif

                        @forelse ($books as $book)
                            <tr>
                                <td class="center">{{ $loop->iteration + (!is_null($close) ? 1 : 0) }}</td>
                                <td class="left strong" style="font-weight: 700;">
                                    {{ ucwords(\Jenssegers\Date\Date::parse($book->new_date . '-01')->format('F')) }}
                                </td>
                                <td class="left" style="font-weight: 600; ">
                                    {{ !isset($book->category_id) ? 'Todos' : $book->category->name }}
                                </td>

                                <td class="right"
                                    style="font-weight: 600 ;  color: {{ $book->haber_saldo > 0 ? 'green' : '' }}'; ">
                                    {{ $book->haber_saldo > 0 ? $business->currency . ' ' . number_format($book->haber_saldo, 2, ',', '.') : '-' }}
                                </td>

                                <td class="right"
                                    style="font-weight: 600 ; color:{{ $book->debe_saldo > 0 ? 'red' : '' }}'">
                                    {{ $book->debe_saldo > 0 ? $business->currency . ' ' . number_format($book->debe_saldo, 2, ',', '.') : '-' }}
                                </td>
                                <td class="right"
                                    style="font-weight: 600 ;  color:{{ $book->total_saldo < 0 ? 'red' : 'green' }}; ">
                                    {{ $business->currency }}
                                    {{ number_format($book->total_saldo, 2, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="center">
                                    No se encontraron registros
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
    <br>
    <br>
    <br>

</body>

</html>
