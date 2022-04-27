@foreach ($messages as $message)
    <tr>      
        <td>
            @for ($i = 0; $i <= $count; $i++)
                <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
            @endfor
            {{ $message['body'] }}
        </td>
        <td>
             @if ($user_id == $message['user_id'])
            <a class="btn btn-secondary" href="/edit-message/{{ $message['id'] }}">edit</a>
            @endif
            @if(empty($message['messages']))
            <a class="btn btn-danger" href="/delete-message/{{ $message['id'] }}">delete</a>
            @endif
            @if ($level == 0)
            <a class="btn btn-success" href="/reply-to-message/{{ $message['id'] }}">reply</a>
            @endif
        </td>
    </tr>

    @if( !empty ($message['messages']) )
        @include('layouts.message-row', ['messages' => $message['messages'], 'count' => $count + 1]);
    @endif    

@endforeach