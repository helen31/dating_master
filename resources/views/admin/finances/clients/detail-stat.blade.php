@extends('admin.layout')

@section('content')
    <section class="panel">

        <div class="panel-body">
            <div class="row">
                <div class="col-md-2 col-sm-2 col-xs-3">
                    <img src="/uploads/users/avatars/{{ $user->avatar }}" alt="{{ $user->first_name }}" height="80px">
                </div>
                <div class="col-md-10 col-sm-10 col-xs-9">
                    <h4><a href="{{ url('profile/show/'.$user->id) }}">ID#{{ $user->id }}  {{ $user->first_name.' '.$user->last_name }}</a></h4>
                    <h4 class="text-left">Сумма на счету: <strong>{{ number_format($amount, 2) }}</strong> Love Coins</h4>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-12">
                    <ul class="list-group">
                        <li class="list-group-item list-group-item-info">
                            *Данные за последние 24 часа могут быть неполными из-за разности во времени.
                            Чтобы получить полные данные от какой-то даты в прошлом до текущего момента,
                            поставьте "Конец периода" на 2 дня вперед от сегодня. По умолчанию так и сделано.
                        </li>
                    </ul>
                    <form class="form-inline" method="POST" action="{{ action('Admin\ClientFinanceController@getDetailStat',['user_id' => $user->id]) }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label>Начало периода</label>
                            <input id="datepicker-finances-startDate6" name="start_date" type="datetime" class="form-control" value="{{ $start_date }}">
                        </div>
                        <div class="form-group">
                            <label>Конец периода</label>
                            <input id="datepicker-finances-endDate6" name="end_date" type="datetime" class="form-control" value="{{ $end_date }}">
                        </div>
                        <button  type="submit" class="btn btn-success">Применить</button>
                    </form>
                    <hr>
                    <!-- Общая статистика за период -->
                    <h4>Суммарные данные за выбранный период</h4>
                    <div class="panel panel-success col-md-4">
                        <div class="panel-heading">Пополнения: <strong>{{ number_format($deposits_amount, 2) }}</strong> LC</div>
                    </div>
                    <div class="panel panel-warning col-md-4">
                        <div class="panel-heading">Траты: <strong>{{ number_format($expenses_amount, 2) }}</strong> LC</div>
                    </div>
                    <div class="panel panel-danger col-md-4">
                        <div class="panel-heading">Возвраты: <strong>{{ number_format($refunds_amount, 2) }}</strong> LC</div>
                    </div>


                    <!-- Список транзакций за период -->
                    <table class="table">
                        <thead>
                        <th>Дата / время</th>
                        <th>Название транзакции</th>
                        <th>Сумма, LC</th>
                        </thead>
                        @foreach($transactions as $trans)
                            <tbody>
                            <td>{{ date('d-m-Y - H:i', strtotime($trans->created_at)) }}</td>
                            <td>
                                {{ trans('finance.'.$trans->type) }}
                                @if($trans->description !== null)
                                    : {{ $trans->description }}
                                @endif
                            </td>
                            <td>
                                @if($trans->type == 'deposit' || $trans->type == 'refund')
                                    + {{ $trans->amount }}
                                @else
                                    - {{ $trans->amount }}
                                @endif
                            </td>
                            </tbody>
                        @endforeach
                    </table>
                </div><!-- .col-md-12 -->
            </div><!-- .row -->
        </div><!-- .panel-body -->
    </section>
@stop