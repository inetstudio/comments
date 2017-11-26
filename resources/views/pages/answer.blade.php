@extends('admin::back.layouts.app')

@php
    $title = 'Добавление комментария';
@endphp

@section('title', $title)

@section('content')

    @push('breadcrumbs')
        @include('admin.module.comments::partials.breadcrumbs')
        <li>
            <a href="{{ route('back.comments.index') }}">Комментарии</a>
        </li>
    @endpush

    <div class="row m-sm">
        <a class="btn btn-white" href="{{ route('back.comments.index') }}">
            <i class="fa fa-arrow-left"></i> Вернуться назад
        </a>
    </div>

    <div class="wrapper wrapper-content">
        {!! Form::info() !!}

        {!! Form::open(['url' => route('back.comments.store'), 'id' => 'mainForm', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal']) !!}

            {!! Form::hidden('parent_comment_id', $item->id) !!}

            {!! Form::buttons('', '', ['back' => 'back.comments.index']) !!}

            <div class="row">
                <div class="col-lg-12">
                    <div class="panel-group float-e-margins" id="mainAccordion">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h5 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#mainAccordion" href="#collapseMain" aria-expanded="true">Основная информация</a>
                                </h5>
                            </div>
                            <div id="collapseMain" class="panel-collapse collapse in" aria-expanded="true">
                                <div class="panel-body">

                                    {!! Form::string('comment_name', $item->name, [
                                        'label' => [
                                            'title' => 'Имя',
                                        ],
                                        'field' => [
                                            'class' => 'form-control',
                                            'disabled' => true,
                                        ],
                                    ]) !!}

                                    {!! Form::string('comment_email', $item->email, [
                                        'label' => [
                                            'title' => 'Email',
                                        ],
                                        'field' => [
                                            'class' => 'form-control',
                                            'disabled' => true,
                                        ],
                                    ]) !!}

                                    {!! Form::wysiwyg('comment_message', $item->message, [
                                        'label' => [
                                            'title' => 'Комментарий',
                                        ],
                                        'field' => [
                                            'class' => 'form-control',
                                            'id' => 'comment_message',
                                            'disabled' => true,
                                        ],
                                    ]) !!}

                                    {!! Form::wysiwyg('message', '', [
                                        'label' => [
                                            'title' => 'Ответ на комментарий',
                                        ],
                                        'field' => [
                                            'class' => 'form-control',
                                            'id' => 'message',
                                        ],
                                    ]) !!}

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {!! Form::buttons('', '', ['back' => 'back.comments.index']) !!}

        {!! Form::close()!!}
    </div>
@endsection
