@extends('admin::back.layouts.app')

@php
    $title = ($item->id) ? 'Просмотр комментария' : 'Создание комментария';
@endphp

@section('title', $title)

@section('content')

    @push('breadcrumbs')
        @include('admin.module.comments::back.partials.breadcrumbs.form')
    @endpush

    <div class="wrapper wrapper-content">
        <div class="ibox">
            <div class="ibox-title">
                <a class="btn btn-sm btn-white" href="{{ route('back.comments.index') }}">
                    <i class="fa fa-arrow-left"></i> Вернуться назад
                </a>
            </div>
        </div>

        {!! Form::info() !!}

        {!! Form::open(['url' => (! $item->id) ? route('back.comments.store') : route('back.comments.update', [$item->id]), 'id' => 'mainForm', 'enctype' => 'multipart/form-data']) !!}

        @if ($item->id)
            {{ method_field('PUT') }}
        @endif

        {!! Form::hidden('comment_id', (! $item->id) ? '' : $item->id, ['id' => 'object-id']) !!}

        {!! Form::hidden('comment_type', get_class($item), ['id' => 'object-type']) !!}

        <div class="ibox">
            <div class="ibox-title">
                {!! Form::buttons('', '', ['back' => 'back.comments.index']) !!}
            </div>
            <div class="ibox-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel-group float-e-margins" id="mainAccordion">

                            @if (isset($parentItem))
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h5 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#mainAccordion"
                                               href="#collapseParent" aria-expanded="true">Родительский комментарий</a>
                                        </h5>
                                    </div>
                                    <div id="collapseParent" class="collapse show" aria-expanded="true">
                                        <div class="panel-body">

                                            {!! Form::hidden('parent_comment_id', $parentItem->id) !!}

                                            {!! Form::string('name', $parentItem->name, [
                                                'label' => [
                                                    'title' => 'Имя',
                                                ],
                                                'field' => [
                                                    'disabled' => true,
                                                ],
                                            ]) !!}

                                            {!! Form::string('email', $parentItem->email, [
                                                'label' => [
                                                    'title' => 'Email',
                                                ],
                                                'field' => [
                                                    'disabled' => true,
                                                ],
                                            ]) !!}

                                            {!! Form::wysiwyg('message', $parentItem->message, [
                                                'label' => [
                                                    'title' => 'Сообщение',
                                                ],
                                                'field' => [
                                                    'id' => 'message',
                                                    'disabled' => true,
                                                ],
                                            ]) !!}

                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h5 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#mainAccordion" href="#collapseMain"
                                           aria-expanded="true">{{ (isset($parentItem)) ? 'Ответ' : 'Основная информация' }}</a>
                                    </h5>
                                </div>
                                <div id="collapseMain" class="collapse show" aria-expanded="true">
                                    <div class="panel-body">

                                        {!! Form::hidden('is_read', 1) !!}

                                        {!! Form::hidden('name', $item->name) !!}
                                        {!! Form::string('name', $item->name, [
                                            'label' => [
                                                'title' => 'Имя',
                                            ],
                                            'field' => [
                                                'disabled' => true,
                                            ],
                                        ]) !!}

                                        {!! Form::hidden('email', $item->email) !!}
                                        {!! Form::string('email', $item->email, [
                                            'label' => [
                                                'title' => 'Email',
                                            ],
                                            'field' => [
                                                'disabled' => true,
                                            ],
                                        ]) !!}

                                        {!! Form::hidden('message', $item->message) !!}
                                        {!! Form::wysiwyg('message', $item->message, [
                                            'label' => [
                                                'title' => 'Сообщение',
                                            ],
                                            'field' => [
                                                'id' => 'message',
                                            ],
                                        ]) !!}

                                        {!! Form::radios('is_active', $item->is_active, [
                                            'label' => [
                                                'title' => 'Отображать на сайте',
                                            ],
                                            'radios' => [
                                                [
                                                    'label' => 'Да',
                                                    'value' => 1,
                                                    'options' => [
                                                        'class' => 'i-checks',
                                                    ],
                                                ],
                                                [
                                                    'label' => 'Нет',
                                                    'value' => 0,
                                                    'options' => [
                                                        'class' => 'i-checks',
                                                    ],
                                                ]
                                            ],
                                        ]) !!}

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ibox-footer">
                {!! Form::buttons('', '', ['back' => 'back.comments.index']) !!}
            </div>
        </div>

        {!! Form::close()!!}
    </div>
@endsection
