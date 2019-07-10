@inject('commentsService', 'InetStudio\CommentsPackage\Comments\Contracts\Services\Back\ItemsServiceContract')

@php
    $comments = $commentsService->getItemsStatisticByActivity();

    $colors = [
        0 => 'warning',
        1 => 'primary',
    ];

    $titles = [
        0 => 'На модерации',
        1 => 'Активные',
    ];
@endphp

<div class="ibox float-e-margins">
    <div class="ibox-content">
        <h2>Комментарии</h2>
        <ul class="todo-list m-t">
            @foreach ($comments as $comment)
                <li>
                    <small class="label label-{{ (isset($colors[$comment->is_active])) ? $colors[$comment->is_active] : 'info' }}">{{ $comment->total }}</small>
                    <span class="m-l-xs">{{ (isset($titles[$comment->is_active])) ? $titles[$comment->is_active] : 'Не удалось определить статус' }}</span>
                </li>
            @endforeach
            <hr>
            <li>
                <small class="label label-default">{{ $comments->sum('total') }}</small>
                <span class="m-l-xs">Всего</span>
            </li>
        </ul>
    </div>
</div>
