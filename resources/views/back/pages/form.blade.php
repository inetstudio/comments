@extends('admin::back.layouts.app')

@php
    $title = ($item->id) ? 'Просмотр комментария' : 'Создание комментария';
@endphp

@section('title', $title)

@section('content')

    @push('breadcrumbs')
        @include('admin.module.comments::back.partials.breadcrumbs.form')
    @endpush

    <div class="row m-sm">
        <a class="btn btn-white" href="{{ route('back.comments.index') }}">
            <i class="fa fa-arrow-left"></i> Вернуться назад
        </a>
    </div>

    <div class="wrapper wrapper-content">
        {!! Form::info() !!}

        {!! Form::open(['url' => (! $item->id) ? route('back.comments.store') : route('back.comments.update', [$item->id]), 'id' => 'mainForm', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal']) !!}

            @if ($item->id)
                {{ method_field('PUT') }}
            @endif

            {!! Form::hidden('comment_id', (! $item->id) ? '' : $item->id, ['id' => 'object-id']) !!}

            {!! Form::hidden('comment_type', get_class($item), ['id' => 'object-type']) !!}

            {!! Form::buttons('', '', ['back' => 'back.comments.index']) !!}

            @if (isset($parentItem))
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel-group float-e-margins" id=parentAccordion">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h5 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#parentAccordion" href="#collapseParent" aria-expanded="true">Родительский комментарий</a>
                                    </h5>
                                </div>
                                <div id="collapseParent" class="panel-collapse collapse in" aria-expanded="true">
                                    <div class="panel-body">

                                        {!! Form::hidden('parent_comment_id', $parentItem->id) !!}

                                        {!! Form::string('name', $parentItem->name, [
                                            'label' => [
                                                'title' => 'Имя',
                                            ],
                                            'field' => [
                                                'class' => 'form-control',
                                                'disabled' => true,
                                            ],
                                        ]) !!}

                                        {!! Form::string('email', $parentItem->email, [
                                            'label' => [
                                                'title' => 'Email',
                                            ],
                                            'field' => [
                                                'class' => 'form-control',
                                                'disabled' => true,
                                            ],
                                        ]) !!}

                                        {!! Form::wysiwyg('message', $parentItem->message, [
                                            'label' => [
                                                'title' => 'Сообщение',
                                            ],
                                            'field' => [
                                                'class' => 'form-control',
                                                'id' => 'message',
                                                'disabled' => true,
                                            ],
                                        ]) !!}

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="row">
                <div class="col-lg-12">
                    <div class="panel-group float-e-margins" id="mainAccordion">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h5 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#mainAccordion" href="#collapseMain" aria-expanded="true">{{ (isset($parentItem)) ? 'Ответ' : 'Основная информация' }}</a>
                                </h5>
                            </div>
                            <div id="collapseMain" class="panel-collapse collapse in" aria-expanded="true">
                                <div class="panel-body">

                                    {!! Form::hidden('is_read', 1) !!}

                                    {!! Form::string('name', $item->name, [
                                        'label' => [
                                            'title' => 'Имя',
                                        ],
                                        'field' => [
                                            'class' => 'form-control',
                                            'disabled' => true,
                                        ],
                                    ]) !!}

                                    {!! Form::string('email', $item->email, [
                                        'label' => [
                                            'title' => 'Email',
                                        ],
                                        'field' => [
                                            'class' => 'form-control',
                                            'disabled' => true,
                                        ],
                                    ]) !!}

                                    {!! Form::wysiwyg('message', $item->message, [
                                        'label' => [
                                            'title' => 'Сообщение',
                                        ],
                                        'field' => [
                                            'class' => 'form-control',
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

            {!! Form::buttons('', '', ['back' => 'back.comments.index']) !!}

        {!! Form::close()!!}
    </div>
@endsection
