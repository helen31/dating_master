@extends('admin.layout')

@section('styles')

@stop

@section('content')

        <!-- Вывод ошибок, например, если отправлено пустое сообщение -->
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Вывод переписки пользователя и корреспондента -->
        @foreach($messages as $m)
            <div class="grg-mail-message">
                    <img style="float:left;margin:5px;" src="{{ url('/uploads/users/avatars/'.$m->avatar) }}" height="56px">
                <p>
                    {{ $m->first_name }}&nbsp;&nbsp;<i>{{ date('d-m-Y H:i', strtotime($m->created_at)) }}</i>
                    &nbsp;&nbsp;
                    @if($m->status == 0)
                        <span style="color:#B02642;"><strong>{{ trans('mail.unread') }}</strong></span>
                    @else
                        <span style="color:#A0A0A0;">{{ trans('mail.read') }}</span>
                    @endif
                </p>
                <p>{{ $m->message }}</p>
                <hr>
            </div>
        @endforeach
        {!! $messages->render() !!}

        <!-- Форма отправки сообщения -->
        {!! Form::open(['action' => 'Admin\MessagesFromManController@sendMessage', 'class' => 'form', 'method' => 'POST']) !!}
        <div class="form-group">
            {!! Form::label('sent_message', trans('mail.write_message_from') ) !!}:&nbsp;
            <a href="{{ url('profile/show/'.$girl->id) }}">{{ $girl->first_name.' '.$girl->last_name }}</a>.&nbsp;&nbsp;
            @if($girl->partner_id != 1 && (Auth::user()->hasRole('Owner') || Auth::user()->hasRole('Moder')))
                {{ trans('mail.partner') }}:&nbsp;<a href="{{ url('/admin/partner/show/'.$girl->partner_id) }}">{{ \App\Http\Controllers\Admin\GirlsController::getPartnerNameByID($girl->partner_id) }}</a>
            @endif
            {!! Form::textarea('sent_message', '', ['class' => 'form-control', 'required' => 'required']) !!}
        </div>
        <input name="to_user" type="hidden" value="{{ $man_id }}">
        <input name="from_user" type="hidden" value="{{ $girl_id }}">
        <div class="form-group">
            {!! Form::submit(trans('mail.send_message'), ['class' => 'btn btn-success']) !!}
        </div>
        {!! Form::close() !!}

@stop