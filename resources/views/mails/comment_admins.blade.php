<strong>Имя: </strong>{{ $item->name }}<br/>
<strong>Email: </strong>{{ $item->email }}<br/>
<strong>Сообщение: </strong>{{ $item->message }}
<br/>
<a href="{{ route('back.comments.edit', [$item->id]) }}">Перейти</a>
