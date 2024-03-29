<div class="modal fade" id="cerrarMes" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Informe</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form action="{{ route('monthly.closure.box') }}" method="get">
                    <div class="row">
                        <div class="col-md-12 fs-2">
                            <label class="form-label"> Fechas del ultimo de registro: </label> <br>

                            <strong>
                                {{ is_null($lastMonthlyClosure)?"No existe fecha registro": \Carbon\Carbon::parse($lastMonthlyClosure->min)->format('d-m-Y')."  |  ". \Carbon\Carbon::parse($lastMonthlyClosure->max)->format('d-m-Y') }}
                            </strong>
                        </div>
                        <div class="separator my-8">

                        </div>
                        <div class="col-md-5 col-sm-12 mb-5">
                            <label for="" class="form-label"> Fecha inicial de informe</label>
                            <input type="date" class="form-control" readonly value="{{$lastRecordedDate->min}}" name="date_start" id="date_start">
                        </div>
                        <div class="col-md-5 col-sm-12 mb-5">
                            <label for="" class="form-label"> Fecha final del informe</label>
                            <input type="date" class="form-control" value="{{$lastRecordedDate->max}}" name="date_end" id="date_end">
                        </div>
                        <div class="col-auto  mb-5 align-self-end">
                            <button class="btn btn-sm btn-success" type="submit"> Generar Informe</button>
                            {{-- <a > Calcular</a> --}}
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
