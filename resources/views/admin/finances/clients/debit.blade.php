@extends('admin.layout')

@section('content')
    <section class="panel">
        <div class="panel-body">
            <div class="row">
                <div class="col-md-2 col-sm-2 col-xs-3">
                    <img src="/uploads/users/avatars/{{ $user->avatar }}" alt="{{ $user->first_name }}" height="80px">
                </div>
                <div class="col-md-10 col-sm-10 col-xs-9">
                    <h4><a href="{{ url(\App::getLocale().'/profile/show/'.$user->id) }}">ID#{{ $user->id }}  {{ $user->first_name.' '.$user->last_name }}</a></h4>
                    <h4 class="text-left">Средства на счету клиента: <strong>{{ number_format($amount, 2) }}</strong> Love Coins</h4>
                </div>
            </div>
            <hr>
            <li class="list-group-item list-group-item-info text-center">
                *Целая и дробная часть числа (сумма списания) должны разделятся точкой (пример: 3.50), иначе данные не сохранятся
            </li>
            <hr>
            <div class="col-md-12">
                {!! Form::open(['action' => ['Admin\ClientFinanceController@saveDebit', $user->id]]) !!}
                <div class="form-group">
                    {!! Form::label('amount', 'Сумма списания (Love Coins)') !!}
                    {!! Form::text('amount', '', ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('description', 'Причина') !!}
                    {!! Form::textarea('description', '', ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::submit('Списать Love Coins', ['class' => 'btn btn-danger']) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </section>
@stop