@inject('commentsService', 'InetStudio\CommentsPackage\Comments\Contracts\Services\Back\ItemsServiceContract')

@php
    $unreadBadge = $commentsService->getUnreadItemsCount();
@endphp

<li class="{{ isActiveRoute('back.comments.*', 'mm-active') }}">
    <a href="{{ route('back.comments.index') }}"><i class="fa fa-comments"></i> <span
                class="nav-label">Комментарии</span><span
                class="label label-primary float-right">{{ $unreadBadge }}</span></a>
</li>
