@extends('client.profile.profile')

@section('styles')
    <style>
        .grg-badge{
            background-color:#B02642;
        }
        .grg-mail-padding{
            padding-left: 8px;
            padding-top: 16px;
        }
        .grg-btn-favourites,
        .grg-btn-blacklist,
        .grg-btn-favourites-remove,
        .grg-btn-blacklist-remove{
            color: #fff;
        }
        .grg-btn-favourites:hover,
        .grg-btn-blacklist:hover,
        .grg-btn-favourites-remove:hover,
        .grg-btn-blacklist-remove:hover{
            color: #CDC5E7;
        }
        .grg-btn-favourites{
            background-color: #B02642;
        }
        .grg-btn-favourites-remove{
            background-color: #F4C15F;
        }
        .grg-btn-blacklist{
            background-color: #18171B;
        }
        .grg-btn-blacklist-remove{
            background-color: #9A9996;
        }
        .grg-red-text{
            color: #B02642;
        }
    </style>
@stop

@section('profileContent')

    <div class="row grg-mail-padding">

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
        <h2 class="text-center">{{ trans('mail.write_message') }}</h2>

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

        <!-- Кнопки "Добавить в фавориты" и "Добавить в черный список"
        или "Удалить из черного списка", "Удалить из фаворитов"
        в зависимости от содержания переменных $is_favourites и $is_blacklist -->
        <div class="text-right">
            @if($is_favourites > 0)
                <a href="{{ url('profile/'.$user_id.'/remove/'.$cor_id.'/from_list/1') }}" class="btn grg-btn-favourites-remove btn-xs"><i class="fa fa-minus-circle"></i>&nbsp;&nbsp;{{ trans('mail.remove_from_favourites') }}</a>
            @else
                <a href="{{ url('profile/'.$user_id.'/add/'.$cor_id.'/to_list/1') }}" class="btn grg-btn-favourites btn-xs"><i class="fa fa-heart"></i>&nbsp;&nbsp;{{ trans('mail.add_to_favourites') }}</a>
            @endif
            @if($is_blacklist > 0)
                <a href="{{ url('profile/'.$user_id.'/remove/'.$cor_id.'/from_list/2') }}" class="btn grg-btn-blacklist-remove btn-xs" ><i class="fa fa-thumbs-up "></i>&nbsp;&nbsp;{{ trans('mail.remove_from_blacklist') }}</a>
            @else
                <a href="{{ url('profile/'.$user_id.'/add/'.$cor_id.'/to_list/2') }}" class="btn grg-btn-blacklist btn-xs" ><i class="fa fa-thumbs-down "></i>&nbsp;&nbsp;{{ trans('mail.add_to_blacklist') }}</a>
            @endif
        </div>
        <br>


        <!-- Форма отправки сообщения -->
        {!! Form::open(['action' => 'MessagesController@sendMessage', 'class' => 'form', 'method' => 'POST']) !!}
            <div class="form-group">
                {!! Form::label('sent_message', trans('mail.write_message_for') ) !!}<strong>:</strong>
                <img style="float:left;margin:5px;" src="{{ url('/uploads/users/avatars/'.$cor->avatar) }}" height="40px">
                <p class="grg-red-text"><strong>{{ $cor->first_name }}</strong></p>
                {!! Form::textarea('sent_message', '', ['class' => 'form-control', 'required' => 'required']) !!}
            </div>
            <input name="to_user" type="hidden" value="{{ $cor_id }}">
            <input name="from_user" type="hidden" value="{{ $user_id }}">
            <div class="form-group">
                {!! Form::submit(trans('mail.send_message'), ['class' => 'btn btn-success']) !!}
            </div>
        {!! Form::close() !!}

    </div>

@stop