@extends('admin::layouts.app')

@php
    $title = ($item->id) ? 'Просмотр сообщения' : '';
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

        {!! Form::open(['url' => route('back.comments.update', [$item->id]), 'id' => 'mainForm', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal']) !!}

            {{ method_field('PUT') }}

            {!! Form::hidden('comment_id', $item->id) !!}

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
                                            'disabled' => true,
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
                                            ],
                                            [
                                                'label' => 'Нет',
                                                'value' => 0,
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
