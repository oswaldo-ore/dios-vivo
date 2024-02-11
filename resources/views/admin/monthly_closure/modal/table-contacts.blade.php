<div class="table-responsive h-450px" >
    <table class="table table-hover table-rounded table-striped border" >
        <thead>
            <tr class="fw-bold fs-6 text-gray-800">
                <th>#</th>
                <th>Numero</th>
                <th>Es Grupo</th>
            </tr>
        </thead>
        <tbody >
            @foreach ($chats as $chat)
                <tr onclick="toggleCheckbox(this,{{$loop->iteration}},'{{$chat->name}}',{{$chat->isGroup}})">
                    <td>
                        <div  class="form-check form-check-custom form-check-solid  d-block">
                            <input type="checkbox" name="contactsSelected[]" class="form-check-input" type="checkbox"
                                value="{{ $chat->id->_serialized }}" id="{{$loop->iteration}}">
                        </div>
                    </td>
                    <td class="fs-2 name">{{ $chat->name }}</td>
                    <td class="fs-2">{{ $chat->isGroup ? 'Si' : 'No' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
