@extends('admin.layout')

@section('content')
    <section class="panel">
        {{ dump($deposits) }}
        {{ dump($amount) }}
        {{ dump($start_date_time) }}
        {{ dump($end_date_time) }}
        {{ $start_date_time }}
        <div class="panel-body">
            <h4 class="text-left">Сумма за период: <strong>{{ round($amount, 2) }}</strong> Love Coins</h4>

            <form class="form-inline">
                <div class="form-group">
                    <label>Начало периода</label>
                    <input type="date" class="form-control" value="1980-04-21">
                </div>
                <div class="form-group">
                    <label>Конец периода</label>
                    <input type="date" class="form-control" value="1980-04-21">
                </div>
                <button type="submit" class="btn btn-success">Применить</button>
            </form>

            <table class="table">
                <thead>
                    <th>Дата / время</th>
                    <th>Клиент</th>
                    <th>Сумма, LC</th>
                </thead>
                @foreach($deposits as $deposit)
                    <tbody>
                        <td>{{ date('d-m-Y - H:i', strtotime($deposit->created_at)) }}</td>
                        <td><a href="#">ID#{{ $deposit->user_id }}  Adam Smith</a></td>
                        <td>{{ $deposit->amount }}</td>
                    </tbody>
                @endforeach
            </table>
        </div>
    </section>
@stop