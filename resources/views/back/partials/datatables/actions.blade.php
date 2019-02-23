<div class="btn-group btn-nowrap">
    <a href="{{ route('back.comments.create') }}?parent_comment_id={{ $id }}" class="btn-xs btn-default"><i class="fa fa-comments"></i></a>
    <a href="{{ route('back.comments.edit', [$id]) }}" class="btn-xs btn-default"><i class="fa fa-pencil-alt"></i></a>
    <a href="#" class="btn-xs btn-danger delete" data-url="{{ route('back.comments.destroy', [$id]) }}"><i class="fa fa-times"></i></a>
</div>
