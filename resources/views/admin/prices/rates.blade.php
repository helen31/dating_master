@extends('admin.layout')

@section('content')

    <section class="panel">
        <header class="panel-heading">Редактировать обменные курсы и комиссию партнерам</header>
        <li class="list-group-item list-group-item-info text-center">
            *Целая и дробная часть числа должны разделятся точкой (пример: 3.50), иначе данные не сохранятся
        </li>
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
            @foreach($rates as $rate)
                <div class="col-md-12">
                    {!! Form::open(['action' => 'Admin\PriceController@setRate', 'class' => 'form-horizontal']) !!}
                    <div class="form-group">
                        <input type="hidden" name="rate_id" value="{{ $rate->id }}">
                        <label class="col-md-6 control-label">{{ $rate->description }}</label>
                        <div class="col-md-3">
                            <input class="form-control" name="rate" type="text"  value="{{ (double)$rate->rate }}">
                        </div>
                        {!! Form::submit('Сохранить', ['class' => 'btn btn-success col-md-3']) !!}
                    </div>
                    {!! Form::close() !!}
                </div>
            @endforeach
        </div>
    </section>


@stop