<ul class="article-comments_list">
    @foreach ($comments['items'] as $commentItem)
        @include('admin.module.comments::front.list_item', [
            'commentItem' => $commentItem,
        ])
    @endforeach
</ul>

@if (! $comments['stop'])
    <div class="skin-btn-wrap">
        <a class="skin-btn skin-btn-reg ajax-loader" data-target=".article-comments_list" href="{{ route('front.comments.get', ['type' => $type, 'id' => $id]) }}">Больше комментариев</a>
    </div>
@endif
