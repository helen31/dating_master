@extends('client.profile.profile')

@section('profileContent')
    <h2 class="text-center gla-title-color">{{ trans('finance.finances') }}</h2>

    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
        @if(Session::has('alert-' . $msg))
            <div class="alert alert-{{ $msg }} alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <p>{{ Session::get('alert-' . $msg) }}</p>
            </div>
        @endif
    @endforeach

    <div class="col-md-12">
        <h4>Ваш текущий баланс: 150.00 Love Coins</h4>
            <a href="#">Пополнить счет</a>
        <h5>Транзакции</h5>
        <ul>
            <li>Пополнение счета   + 150 LC   25-04-2017</li>
            <li>Отправка сообщения - 1 LC     23-04-2017</li>
            <li>Открытие контактов - 20 LC    21-04-2017</li>
        </ul>
    </div>

@stop
