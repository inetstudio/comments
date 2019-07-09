@inject('commentsService', 'InetStudio\CommentsPackage\Comments\Contracts\Services\Back\CommentsServiceContract')

@php
    $unreadBadge = $commentsService->getUnreadCommentsCount();
@endphp

<li class="dropdown">
    <a class="count-info" href="{{ route('back.comments.index') }}">
        <i class="fa fa-lg fa-comments"></i> <span class="label label-primary">{{ $unreadBadge }}</span>
    </a>
</li>
