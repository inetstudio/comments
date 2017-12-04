@foreach ($comments['items'] as $commentItem)
    @include('admin.module.comments::front.list_item', [
        'commentItem' => $commentItem,
    ])
@endforeach

@if ($comments['stop'])
    [end]
@endif
