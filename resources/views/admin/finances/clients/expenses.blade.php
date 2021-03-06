@extends('admin.layout')

@section('content')
    <section class="panel">

        <div class="panel-body">
            <h4 class="text-left">Сумма за период: <strong>{{ number_format($amount, 2) }}</strong> Love Coins</h4>
            <ul class="list-group">
                <li class="list-group-item list-group-item-info">
                    *Данные за последние 24 часа могут быть неполными из-за разности во времени.
                    Чтобы получить полные данные от какой-то даты в прошлом до текущего момента,
                    поставьте "Конец периода" на 2 дня вперед от сегодня. По умолчанию так и сделано.
                </li>
            </ul>
            <form class="form-inline" method="POST" action="{{ action('Admin\ClientFinanceController@getDeposits') }}">
                {{ csrf_field() }}
                <div class="form-group">
                    <label>Начало периода</label>
                    <input id="datepicker-finances-startDate2" name="start_date" type="datetime" class="form-control" value="{{ $start_date }}">
                </div>
                <div class="form-group">
                    <label>Конец периода</label>
                    <input id="datepicker-finances-endDate2" type="datetime" class="form-control" value="{{ $end_date }}">
                </div>
                <button name="end_date" type="submit" class="btn btn-success">Применить</button>
            </form>
            <hr>

            <table class="table">
                <thead>
                    <th>Дата / время</th>
                    <th>Клиент</th>
                    <th>Транзакция</th>
                    <th>Сумма, LC</th>
                </thead>
                @foreach ($transactions as $trans)
                    <tbody>
                        <td>{{ date('d-m-Y - H:i', strtotime($trans->created_at)) }}</td>
                        <td><a href="{{ url('profile/show/'.$trans->user_id) }}">ID#{{ $trans->user_id }}  {{ $trans->first_name.' '.$trans->last_name }}</a></td>
                        <td>
                            {{ trans('finance.'.$trans->type) }}
                            @if ($trans->description !== null)
                                : {{ $trans->description }}
                            @endif
                        </td>
                        <td>{{ $trans->amount }}</td>
                    </tbody>
                @endforeach
            </table>
        </div>
    </section>
@stop