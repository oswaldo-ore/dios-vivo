<div class="mb-3">
    <label for="">Buscar</label>
    <input type="text" name="search_name_phone" onkeyup="searchByTrNameNumber()" class="form-control form-control-solid">
</div>
<div class="table-responsive h-450px">
    <table class="table table-hover  table-rounded table-striped border">
        <thead>
            <tr class="fw-bold fs-6 text-gray-800">
                <th>#</th>
                <th>Numero</th>
                <th>Es Grupo</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($contactos as $contacto)
                <tr onclick="toggleCheckbox(this,{{ $loop->iteration }},'{{ $contacto->name??'' }}',{{ $contacto->isGroup }})"
                    name="{{ $contacto->name??"Sin nombre" }}" number="{{ $contacto->number }}"
                    >
                    <td>
                        <div class="form-check form-check-custom form-check-solid  d-block">
                            <input type="checkbox" name="contactsSelected[]" class="form-check-input" type="checkbox"
                                value="{{ $contacto->id->_serialized }}" id="{{ $loop->iteration }}">
                        </div>
                    </td>
                    <td class="fs-2 name">{{ $contacto->name??"Sin nombre" }} <br>{{ $contacto->number }} </td>
                    <td class="fs-2">{{ $contacto->isGroup ? 'Si' : 'No' }}</td>

                </tr>
            @endforeach
        </tbody>
    </table>
</div>
