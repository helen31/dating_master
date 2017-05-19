@extends('client.app')

@section('content')
    <div class="container map-bg gla-price-bg">
        <div class="row">
            <div class="col-md-12">
                <h2 class="gla-title-color">Pricing</h2>
                @foreach($prices as $price)
                    <div class="col-sm-6 col-md-4">
                        <div class="panel panel-default">
                            <div class="panel-heading"><h4>{{ trans('finance.'.$price->name) }}</h4></div>
                            <div class="panel-body">
                                <p class="lead">{{ $price->price }} LC</p>
                                <p class="">{{ trans('finance.'.$price->term) }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @if(Auth::user() && Auth::user()->hasRole('Male'))
            <div class="col-md-12 text-center">
                <a class="btn btn-success" href="{{ url(App::getLocale().'/profile/'.Auth::user()->id.'/finance') }}">{{ trans('finance.deposit_funds') }}</a>
            </div>
        @endif
    </div>
@stop
