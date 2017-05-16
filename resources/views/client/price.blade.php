@extends('client.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @foreach($prices as $price)
                    <div class="col-md-4">
                        <h4>{{ trans('finance.'.$price->name) }}</h4>
                        <p>{{ $price->price }} LC</p>
                        <p>{{ trans('finance.'.$price->term) }}</p>
                    </div>
                @endforeach
            </div>
        </div>
        @if(Auth::user() && Auth::user()->hasRole('Male'))
            <div class="row">
                <div class="col-md-12">
                    <a class="btn btn-success" href="{{ url(App::getLocale().'/profile/'.Auth::user()->id.'/finance') }}">{{ trans('finance.deposit_funds') }}</a>
                </div>
            </div>
        @endif
    </div>
@stop
