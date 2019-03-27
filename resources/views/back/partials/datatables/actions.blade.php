<div class="btn-nowrap">
    <a href="{{ route('back.comments.create') }}?parent_comment_id={{ $id }}" class="btn btn-xs btn-default m-r-xs"><i class="fa fa-comments"></i></a>
    <a href="{{ route('back.comments.edit', [$id]) }}" class="btn btn-xs btn-default m-r-xs"><i class="fa fa-pencil-alt"></i></a>
    <a href="#" class="btn btn-xs btn-danger delete" data-url="{{ route('back.comments.destroy', [$id]) }}"><i class="fa fa-times"></i></a>
</div>
