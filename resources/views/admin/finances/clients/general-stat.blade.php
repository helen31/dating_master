@extends('admin.layout')

@section('content')
    <section class="panel">

        <div class="panel-body">
            <h4 class="text-left">Общая сумма на счетах клиентов: <strong>{{ number_format($amount, 2) }}</strong> Love Coins</h4>
            <hr>
            <table class="table">
                <thead>
                    <th>Клиент</th>
                    <th>Баланс на счету, LC</th>
                    <th>Управление</th>
                </thead>
                @foreach($finances as $fin)
                    <tbody>
                        <td><a href="{{ url('profile/show/'.$fin->user_id) }}">ID#{{ $fin->user_id }}  {{ $fin->first_name.' '.$fin->last_name }}</a></td>
                        <td>{{ $fin->amount }}</td>
                        <td>
                            <a href="{{ url(App::getLocale().'/admin/finance/clients/detail-stat/'.$fin->user_id) }}" class="btn btn-info btn-xs"><i class="fa fa-bar-chart-o"></i>&nbsp;&nbsp;Отчет</a>
                            <a href="{{ url(\App::getLocale().'/admin/finance/clients/refund/'.$fin->user_id) }}" class="btn btn-success btn-xs"><i class="fa fa-money"></i>&nbsp;&nbsp;Начислить LC</a>
                            <a href="{{ url(\App::getLocale().'/admin/finance/clients/debit/'.$fin->user_id) }}" class="btn btn-danger btn-xs"><i class="fa fa-usd"></i>&nbsp;&nbsp;Списать LC</a>
                        </td>
                    </tbody>
                @endforeach
            </table>
        </div>
    </section>
@stop