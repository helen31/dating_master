@extends('admin.layout')

@section('content')

    <section class="panel">
        <header class="panel-heading">Редактировать прайсы</header>
        <p class="text-center bg-info">*Целая и дробная часть числа должны разделятся точкой (пример: 3.50), иначе данные не сохранятся</p>
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
            @foreach($prices as $price)
                <div class="col-md-12">
                    {!! Form::open(['action' => 'Admin\PriceController@setPrice', 'class' => 'form-horizontal']) !!}
                        <div class="form-group">
                            <input type="hidden" name="service_id" value="{{ $price->id }}">
                            <label class="col-md-6 control-label">{{ trans('finance.'.$price->name).' ('.trans('finance.'.$price->term).') ' }}</label>
                            <div class="col-md-3">
                                <input class="form-control" name="price" type="text"  value="{{ (double)$price->price }}">
                            </div>
                            {!! Form::submit('Сохранить', ['class' => 'btn btn-success col-md-3']) !!}
                        </div>
                    {!! Form::close() !!}
                </div>
            @endforeach
        </div>
    </section>


@stop