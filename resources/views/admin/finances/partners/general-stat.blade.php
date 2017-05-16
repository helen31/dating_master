@extends('admin.layout')

@section('content')
    <section class="panel">

        <div class="panel-body">
            <h4 class="text-left">Общая задолженность перед партнерами: <strong>{{ number_format($amount, 2) }}</strong> USD</h4>
            <hr>
            <table class="table">
                <thead>
                <th>Партнер</th>
                <th>Задолженность, USD</th>
                <th>Управление</th>
                </thead>
                @foreach($partner_finances as $pfin)
                    <tbody>
                    <td><a href="{{ url(\App::getLocale().'/admin/partner/show/'.$pfin->partner_id) }}">ID#{{ $pfin->partner_id }} {{ $pfin->first_name }} {{ $pfin->last_name }}</a></td>
                    <td>{{ $pfin->amount }}</td>
                    <td>
                        <a href="{{ url(\App::getLocale().'/admin/finance/partners/detail-stat/'.$pfin->partner_id) }}" class="btn btn-info btn-xs"><i class="fa fa-bar-chart-o"></i>&nbsp;&nbsp;Отчет</a>
                        <a href="{{ url(\App::getLocale().'/admin/finance/partners/payment/'.$pfin->partner_id) }}" class="btn btn-success btn-xs"><i class="fa fa-money"></i>&nbsp;&nbsp;Сделать выплату</a>
                        <a href="{{ url(\App::getLocale().'/admin/finance/partners/fine/'.$pfin->partner_id) }}" class="btn btn-danger btn-xs"><i class="fa fa-usd"></i>&nbsp;&nbsp;Начислить штраф</a>
                    </td>
                    </tbody>
                @endforeach
            </table>
        </div>
    </section>
@stop