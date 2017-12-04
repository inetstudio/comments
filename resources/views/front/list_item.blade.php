<li>
    @if (isset($commentItem['user']['object']) && $commentItem['user']['object']->hasRole('admin'))
        <span class="article-comments_list-name editor">Редакция <i class="icon-logo"></i></span>
    @else
        <span class="article-comments_list-name">{{ $commentItem['user']['name'] }}</span>
    @endif

    <span class="article-comments_list-time">{{ \Illuminate\Support\Carbon::formatTime($commentItem['datetime']) }}</span>
    <span class="article-comments_list-text">{{ $commentItem['message'] }}</span>

    @if (count($commentItem['items']) > 0)
        <ul>
            @foreach($commentItem['items'] as $commentItemSub)
                @include('admin.module.comments::front.list_item', [
                    'commentItem' => $commentItemSub,
                ])
            @endforeach
        </ul>
    @endif
</li>
