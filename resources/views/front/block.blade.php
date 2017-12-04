<div class="row">
    <div class="col">
        <div class="article-comments">

            @include('admin.module.comments::front.form', [
                'type' => $type,
                'id' => $id,
            ])

            @include('admin.module.comments::front.list', [
                'comments' => $comments,
                'type' => $type,
                'id' => $id,
            ])

        </div>
    </div>
</div>
