<strong>Имя: </strong>{{ $comment->name }}<br/>
<strong>Email: </strong>{{ $comment->email }}<br/>
<strong>Сообщение: </strong>{{ $comment->message }}
<br/>
<a href="{{ route('back.comments.edit', [$id]) }}">Перейти</a>
