@inject('commentsService', 'InetStudio\CommentsPackage\Comments\Contracts\Services\Back\CommentsServiceContract')

@php
    $unreadBadge = $commentsService->getUnreadCommentsCount();
@endphp

<li class="{{ isActiveRoute('back.comments.*') }}">
    <a href="{{ route('back.comments.index') }}"><i class="fa fa-comments"></i> <span
                class="nav-label">Комментарии</span><span
                class="label label-primary float-right">{{ $unreadBadge }}</span></a>
</li>
