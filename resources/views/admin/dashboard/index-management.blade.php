@extends('layout.template')

@section('page-menu-title')
    Dashboard
@endsection

@section('menu-top')
    <!--begin::Item-->
    <li class="breadcrumb-item text-dark">Dashboard</li>
    <!--end::Item-->
@endsection

@section('content')
    <h2 class="text-uppercase text-center fs-1 mb-5 text-gray-600"> Informe:
        {{ $business->name == '' ? 'No se encuentra nombre de la empresa' : $business->name }} </h2>
    @php
        \Jenssegers\Date\Date::setLocale('es');
    @endphp
    <div class="row mb-6">
        <div class="col-auto m-auto">
            <div class="card">
                <!--begin::Header-->
                <div class="card-header py-5">
                    <!--begin::Title-->
                    <div class="card-title d-flex flex-column align-items-center">
                        <!--begin::Info-->
                        <div class="d-flex align-items-center">
                            @if ($business->saldo_total > 0)
                                <span class="svg-icon svg-icon-3 svg-icon-success me-2">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <rect opacity="0.5" x="13" y="6" width="13" height="2"
                                            rx="1" transform="rotate(90 13 6)" fill="currentColor"></rect>
                                        <path
                                            d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z"
                                            fill="currentColor"></path>
                                    </svg>
                                </span>
                            @else
                                <span class="svg-icon svg-icon-3 svg-icon-danger me-2">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <rect opacity="0.5" x="11" y="18" width="13" height="2"
                                            rx="1" transform="rotate(-90 11 18)" fill="currentColor"></rect>
                                        <path
                                            d="M11.4343 15.4343L7.25 11.25C6.83579 10.8358 6.16421 10.8358 5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75L11.2929 18.2929C11.6834 18.6834 12.3166 18.6834 12.7071 18.2929L18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25C17.8358 10.8358 17.1642 10.8358 16.75 11.25L12.5657 15.4343C12.2533 15.7467 11.7467 15.7467 11.4343 15.4343Z"
                                            fill="currentColor"></path>
                                    </svg>
                                </span>
                            @endif
                            <!--begin::Currency-->
                            {{-- <span
                                class="fs-3 fw-bold  me-1 align-self-start {{ $year['total_year'] < 0 ? 'text-danger' : 'text-primary' }}">Bs.</span> --}}
                            <!--end::Currency-->
                            <!--begin::Amount-->
                            <span data-kt-countup="true" data-kt-countup-value="{{ $business->saldo_total }}"
                                data-kt-countup-prefix="{{ $business->currency }} "
                                class="fs-2hx fw-bolder text-capitalize {{ $business->saldo_total < 0 ? 'text-danger' : 'text-primary' }} me-2 lh-1 "
                                data-kt-countup-decimal-places="2">0</span>
                            <!--end::Amount-->
                        </div>
                        <!--end::Info-->
                        <!--begin::Subtitle-->
                        <span class="text-gray-400 fw-bolder pt-1 fw-bold fs-3 align-self-center">Saldo total hasta
                            {{ ucwords(\Jenssegers\Date\Date::parse(Carbon\Carbon::now())->format('F Y')) }}</span>
                        <!--end::Subtitle-->
                    </div>
                    <!--end::Title-->
                </div>
                <!--end::Header-->

            </div>
        </div>
    </div>
    <div class="row">

        <div class="col-md-12 mb-6">
            <div class="card">
                <div class="card-body">
                    <div class="dataTables-wrapper dt-bootstrap4 no-footer">
                        <div class="table-responsive">
                            <table class="table align-middle table-row-dashed fs-6 gy-3 dataTable no-footer">
                                <thead>
                                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                        <th>Gestiones</th>
                                        <th class="text-end text-capitalize">Saldo Total {{ $business->currency }} :</th>
                                    </tr>
                                </thead>
                                <tbody class="fw-bolder text-gray-600">

                                    @forelse ( $statisticsYear as $statis )
                                    <tr class="odd">
                                        <td>{{ $statis->new_date }}</td>
                                        <td class="text-end text-capitalize"> {{ $business->currency }}
                                            {{ number_format($statis->total_saldo, 2, ',', '.') }}
                                        </td>
                                    </tr>
                                    @empty
                                    <tr class="text-center">
                                        <td colspan="2">
                                            No tiene gestiones
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>


        <div class="col-md-12 mb-6">
            <div class="card">
                <div class="card-body">
                    <div class="dataTables-wrapper dt-bootstrap4 no-footer">
                        <div class="table-responsive">

                            <canvas id="statistics" class="table chart mh-450px"></canvas>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 mb-6">
            <div class="card">
                <div class="card-body">
                    <div class="dataTables-wrapper dt-bootstrap4 no-footer">
                        <div class="table-responsive">

                            <canvas id="statisticsYear" class="table chart mh-450px"></canvas>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ asset('chartjs-plugin-datalabels.js') }}"></script>
    <script src="{{ asset('chartjs-plugin-zoom.min.js') }}"></script>
    <script>
        var statistics = @json($statistics);
        var statisticsYear = @json($statisticsYear);
        var lineChar = null;
        var lineChar2 = null;
        $(document).ready(function() {
            $("#menu-management").addClass('active open');
            getShowBarra();
            getShowBarraYear();
        });

        function getShowBarra() {
            var pedidos = document.getElementById('statistics');
            var datos = {
                fechas: statistics.map(statis => statis.new_date),
                saldos: statistics.map(statis => statis.total_saldo),
            }
            if (lineChar) {
                lineChar.destroy();
            }
            var fontFamily = KTUtil.getCssVariableValue('--bs-font-sans-serif');
            const labels = datos.fechas;

            // Chart data
            const data = {
                labels: labels,
                datasets: [{
                    label: 'Monto por mes',
                    data: datos.saldos,
                    backgroundColor: '#04B95F',
                    stack: 'Stack 1',
                    datalabels: {
                        color: '#04B95F',
                    }
                }]
            };

            const config = {
                type: 'bar',
                data: data,
                plugins: [ChartDataLabels],
                options: {
                    plugins: {
                        datalabels: {
                            anchor: 'end',
                            align: 'top',
                            // formatter: Math.round,
                            font: {
                                weight: 'bold'
                            }
                        },
                        zoom: {
                            pan: {
                                enabled: true,
                                mode: 'x',
                            },
                            zoom: {
                                mode: 'x',
                                wheel: {
                                    enabled: true,
                                },
                                pinch: {
                                    enabled: true,
                                },

                            }
                        }
                    },
                    responsive: true,
                    drawActiveElementsOnTop: true,
                    IsValueShownAsLabel: true,
                    interaction: {
                        intersect: false,
                    },
                    scales: {
                        x: {
                            stacked: true,
                            ticks: {
                                font: {
                                    size: 13,
                                    weight: 'bold',
                                }
                            }
                        },
                        y: {
                            stacked: true,
                            ticks: {
                                font: {
                                    size: 13,
                                    weight: 'bold',
                                }
                            },
                            beginAtZero: true,
                            grace: '5%',
                        },
                    }
                },
                defaults: {
                    global: {
                        defaultFont: fontFamily
                    }
                }

            };

            lineChar = new Chart(pedidos, config);
        }

        function getShowBarraYear() {
            var pedidos = document.getElementById('statisticsYear');
            var datos = {
                fechas: statisticsYear.map(statis => statis.new_date),
                saldos: statisticsYear.map(statis => statis.total_saldo),
            }
            console.log(datos);
            if (lineChar2) {
                lineChar2.destroy();
            }
            var fontFamily = KTUtil.getCssVariableValue('--bs-font-sans-serif');
            const labels = datos.fechas;

            // Chart data
            const data = {
                labels: labels,
                datasets: [{
                    label: 'Monto por año',
                    data: datos.saldos,
                    backgroundColor: '#04B95F',
                    stack: 'Stack 1',
                    datalabels: {
                        color: '#04B95F',
                    }
                }]
            };

            const config = {
                type: 'bar',
                data: data,
                plugins: [ChartDataLabels],
                options: {
                    plugins: {
                        datalabels: {
                            anchor: 'end',
                            align: 'top',
                            font: {
                                weight: 'bold'
                            }
                        },
                        zoom: {
                            pan: {
                                enabled: true,
                                mode: 'x',
                            },
                            zoom: {
                                mode: 'x',
                                wheel: {
                                    enabled: true,
                                },
                                pinch: {
                                    enabled: true,
                                },

                            }
                        }
                    },
                    responsive: true,
                    drawActiveElementsOnTop: true,
                    IsValueShownAsLabel: true,
                    interaction: {
                        intersect: false,
                    },
                    scales: {
                        x: {
                            stacked: true,
                            beginAtZero: true,
                            ticks: {
                                font: {
                                    size: 13,
                                    weight: 'bold',
                                }
                            }
                        },
                        y: {
                            stacked: true,
                            ticks: {
                                font: {
                                    size: 13,
                                    weight: 'bold',
                                }
                            },
                            beginAtZero: true,
                            grace: '5%',
                        },
                    }
                },
                defaults: {
                    global: {
                        defaultFont: fontFamily
                    }
                }

            };

            lineChar2 = new Chart(pedidos, config);
        }
    </script>
@endpush
