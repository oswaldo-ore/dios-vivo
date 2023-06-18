<div class="modal fade" id="cerrarMes" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cierre Mensual</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form action="{{ route('monthly.closure.box') }}" method="get">
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form-label"> Fechas del ultimo de registro: </label> <br>

                            <strong>
                                {{ is_null($lastMonthlyClosure)?"No existe fecha registro": $lastMonthlyClosure->min."  -  ". $lastMonthlyClosure->max }}
                            </strong>
                        </div>
                        <div class="separator my-5">

                        </div>
                        <div class="col-md-5 col-sm-12 mb-5">
                            <label for="" class="form-label"> Fecha inicial de cierre</label>
                            <input type="date" class="form-control form-control-sm" readonly value="{{$lastRecordedDate->min}}" name="date_start" id="date_start">
                        </div>
                        <div class="col-md-5 col-sm-12 mb-5">
                            <label for="" class="form-label"> Fecha final de cierre</label>
                            <input type="date" class="form-control form-control-sm" value="{{$lastRecordedDate->max}}" name="date_end" id="date_end">
                        </div>
                        <div class="col-auto  mb-5 align-self-end">
                            <button class="btn btn-sm btn-success" type="submit"> Cerrar Caja</button>
                            {{-- <a > Calcular</a> --}}
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
