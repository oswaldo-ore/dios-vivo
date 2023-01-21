@if (count($books) > 0)
    @php
        $total_ingreso = 0;
        $total_egreso = 0;
        $saldo_anual = 0;
        \Jenssegers\Date\Date::setLocale('es');
    @endphp

    @if (!is_null($close))
        @php
            $total_ingreso = $close->total_haber;
            $total_egreso = $close->total_debe;
            $saldo_anual = $close->total_saldo;
        @endphp
        <tr>
            <td class="fw-bolder fs-6">{{ $close->year }}</td>
            <td class="fw-bolder text-uppercase">GESTION {{$close->year}}</td>
            <td>
                <span class="badge badge-light-primary fs-7  ">
                    {{ number_format($close->total_haber, 2, ',', '.') }}
                </span>
            </td>
            <td>
                <span class="badge badge-light-danger fs-7 ">
                    - {{ number_format($close->total_debe, 2, ',', '.') }}
                </span>
            </td>
            <td>
                <span class="fw-bold fs-6 badge badge-light-{{ $close->total_saldo < 0 ? 'danger' : 'primary' }}">
                    {{ number_format($close->total_saldo, 2, ',', '.') }}
                </span>
            </td>
        </tr>
    @endif
    @if ($previousManagement == 1 && is_null($close))
    <tr>
        @php
            $previous_year = Carbon\Carbon::parse($books->first()->new_date . '-01')->subYear()->format('Y');
        @endphp

        <td class="fw-bolder fs-6">{{ $previous_year }}</td>
        <td class="fw-bolder text-uppercase">GESTION {{$previous_year}}</td>
        <td colspan="3">
            <span >
                Este año no tiene cierre de caja, verifique en <a href="{{route('close.box.index')}}" target="_blank">Cierre anual</a>
            </span>
        </td>
    </tr>
    @endif
    @foreach ($books as $book)
        @php
            $total_ingreso += $book->haber_saldo;
            $total_egreso += $book->debe_saldo;
            $saldo_anual += $book->total_saldo;
        @endphp
        <tr>
            <td class="fw-bolder fs-6">{{ ucwords(\Jenssegers\Date\Date::parse($book->new_date . '-01')->format('Y - F ')) }}</td>
            <td class="fw-bolder text-uppercase">{{ !isset($book->category_id) ? 'Todos' : $book->category->name }}</td>
            <td>
                <span class="badge badge-light-primary fs-7  ">
                    {{ number_format($book->haber_saldo, 2, ',', '.') }}
                </span>
            </td>
            <td>
                <span class="badge badge-light-danger fs-7 ">
                    - {{ number_format($book->debe_saldo, 2, ',', '.') }}
                </span>
            </td>
            <td>
                <span class="fw-bold fs-6 badge badge-light-{{ $book->total_saldo < 0 ? 'danger' : 'primary' }}">
                    {{ number_format($book->total_saldo, 2, ',', '.') }}
                </span>
            </td>
        </tr>
    @endforeach
    <tr>
        <td colspan="3"></td>
        <td class="fw-bold fs-6">Total haber:</td>
        <td>
            <span class="badge badge-light-primary fs-6  ">
                {{ $business->currency }} {{ number_format($total_ingreso, 2, ',', '.') }}
            </span>
        </td>
    </tr>
    <tr>
        <td colspan="3"></td>
        <td class="fw-bold fs-6">Total Egreso: </td>
        <td>
            <span class="badge badge-light-danger fs-6 ">
                {{ $business->currency }} - {{ number_format($total_egreso, 2, ',', '.') }}
            </span>
        </td>
    </tr>
    <tr>
        <td colspan="3"></td>
        <td class="fw-bold fs-6"> Saldo total anual: </td>
        <td>
            <span class="fw-bold fs-6 badge badge-light-{{ $saldo_anual < 0 ? 'danger' : 'primary' }}">
                {{ $business->currency }} {{ number_format($saldo_anual, 2, ',', '.') }}
            </span>
        </td>
    </tr>
@else
    <tr>
        <td colspan="4"> No se encontraron registros en estas fechas</td>
    </tr>
@endif
