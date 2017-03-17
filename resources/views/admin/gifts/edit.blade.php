@extends('admin.layout')

@section('styles')
    <link href="{{ url('/assets/css/fileinput.css') }}" rel="stylesheet">
    <link href="{{ url('assets/css/datepicker.css') }}" rel="stylesheet">

    <style>

    </style>
@stop

@section('content')
    <section class="panel">
        <div class="panel-body">
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
                {!! Form::open(['url' => 'admin/gifts/update/'.$gift->id, 'class' => 'form', 'enctype' => 'multipart/form-data']) !!}

                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('confirm_photo', 'Загрузите фото девушки с подарком') !!} <br/>
                        <img class="img-responsive" src="/uploads/confirm_photos/{{ $gift->confirm_photo }}" id="preview-image" alt="{{ $gift->confirm_photo }}"/>
                        <input type="file" class="form-control file" name="confirm_photo" value="" accept="image/*">
                    </div>
                </div>
                <div class="col-md-6">
                    <h3>Информация о подарке</h3>
                    <p><img src="/uploads/presents/{{ $gift->prezent->image }}" alt="{{ $gift->prezent->image }}" height="100px"/></p>
                    <p>Кто подарил: <a href="{{ url('/profile/show/'.$gift->from) }}">ID#{{ $gift->from }}</a></p>
                    <p>Кому подарен: <a href="{{ url('/profile/show/'.$gift->to) }}">ID#{{ $gift->to }}</a></p>
                    <p>Стоимость: {{ $gift->prezent->price }} LC</p>
                    @if($gift->girl->partner_id == 1)
                        <p>Admin</p>
                    @else
                        <p>Партнер девушки: <a href="{{ url('/admin/partner/show/'.$gift->girl->partner_id) }}">ID#{{ $gift->girl->partner_id }}</a></p>
                    @endif
                    <p>Статус доставки: <span class="bg-danger">&nbsp;{{ trans('admin/sidebar-left.gift_status_'.$gift->status_id) }}&nbsp;</span></p>
                </div>
                <div class="col-md-12">

                    @if( Auth::user()->hasRole('Owner') || Auth::user()->hasRole('Moder'))
                        <div class="form-group">
                            {!! Form::label('status_id', 'Статус доставки') !!}

                            <select name="status_id" class="form-control">
                                @foreach($statuses as $status)
                                    <option value="{{ $status->id }}" {{ $status->id == $gift->status_id ? "selected" : ''}}>{{ trans('admin/sidebar-left.gift_'.$status->name) }}</option>
                                @endforeach
                            </select>

                        </div>
                        <div class="form-group">
                            <label for="status_message">Причина отклонения (если есть):</label>
                            <textarea name="status_message" class="form-control">{{ $gift->status_message }}</textarea>
                        </div>
                    @else
                        <h3 class="text-center">Информация о доставке</h3>
                        <p class="text-center"><strong>Статус доставки:</strong> <span class="bg-danger">&nbsp;{{ trans('admin/sidebar-left.gift_status_'.$gift->status_id) }}&nbsp;</span></p>
                        @if($gift->status_id == 3)
                            <p class="text-center"><strong>Причина отклонения:</strong> {{ ($gift->status_message) ? $gift->status_message : 'не указана' }}</p>
                        @endif
                    @endif

                    <div class="form-group text-center">
                        @if( Auth::user()->hasRole('Owner') || Auth::user()->hasRole('Moder'))
                            {!! Form::submit('Сохранить', ['class' => 'btn btn-success']) !!}
                        @else
                            <br>
                            {!! Form::submit('Отправить на рассмотрение', ['class' => 'btn btn-success']) !!}
                        @endif
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
    </section>

@stop

@section('scripts')
    <script type="text/javascript" src="{{ url('/assets/js/bootstrap-fileinput-master/js/fileinput.js') }}"></script>
    <script type="text/javascript" src="{{ url('/assets/js/file-input-init.js') }}"></script>
@stop