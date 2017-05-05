@extends('client.profile.profile')

@section('profileContent')
    <h2 class="gla-title-color">{{ trans('finance.finances') }}</h2>

    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
        @if(Session::has('alert-' . $msg))
            <div class="alert alert-{{ $msg }} alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <p>{{ Session::get('alert-' . $msg) }}</p>
            </div>
        @endif
    @endforeach
    <h4 class="gla-table-balance">{{ trans('finance.current_balance') }}: {{ $finances }} {{ trans('finance.love_coins') }}</h4>
    <div class="row gla-finance-form">
        <div class="col-md-12 gla-finance-form-title">
            <h4>{{ trans('finance.deposit_funds') }}</h4>
        </div>
        <form action="" class="col-md-6 form-horizontal gla-form">
            <div class="form-group">
                <label for="buyLC" class="col-sm-6 col-md-6 col-lg-6 control-label gla-form-label">{{ trans('finance.buy_love_coins') }}</label>
                <div class="col-sm-6 col-md-6 col-lg-6">
                    <input type="text" class="form-control" id="buyLC" placeholder="{{ trans('finance.enter_amount') }}">
                </div>
            </div>
            <div class="form-group gla-form-group-margin">
                <div class="col-sm-offset-6 col-sm-6">
                    <button type="submit" class="btn btn-default gla-form-button">{{ trans('finance.buy_love_coins') }}</button>
                </div>
            </div>
        </form>
        <div class="col-md-6 gla-form-radio">
            <div class="radio">
                <label class="gla-label">
                    <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked>
                    eur <span>75.00</span>
                </label>
            </div>
            <div class="radio">
                <label class="gla-label">
                    <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">
                    usd <span></span>
                </label>
            </div>
        </div>
        <div class="col-md-12 gla-finance-form-info">
            <h5><strong>{{ trans('finance.information') }}</strong></h5>
            {{ trans('finance.short_info') }}
        </div>
    </div>
    @if(isset($transactions) && $transactions->count() > 0)
        <div class="row gla-finance-table">
            <h2 class="gla-title-color">{{ trans('finance.your_transactions') }}</h2>
            <h4 class="gla-table-balance">{{ trans('finance.current_balance') }}: {{ $finances }} {{ trans('finance.love_coins') }}</h4>
            <div class="table-responsive">
                <table class="table table-bordered table-responsive danger gla-table">
                    <thead>
                    <tr>
                        <th scope="col">{{ trans('finance.date') }}</th>
                        <th scope="col">{{ trans('finance.description') }}</th>
                        <th scope="col">{{ trans('finance.amount_lc') }}</th>
                    </tr>
                    </thead>
                    @foreach($transactions as $trans)
                        @if($trans->type == 'deposit')
                            <tr class="active">
                                <td>{{ date('d-m-Y H:i', strtotime($trans->created_at)) }}</td>
                                <td>{{ trans('finance.deposit') }}</td>
                                <td>{{ $trans->amount }}</td>
                            </tr>
                        @else
                            <tr>
                                <td>{{ date('d-m-Y H:i', strtotime($trans->created_at)) }}</td>
                                <td>
                                    <img src="/uploads/users/avatars/{{ $trans->whomPay->avatar }}"  class="gla-table-photo" alt="{{ $trans->whomPay->first_name }}">
                                    <div class="gla-table-info">
                                        <a href="{{ url('profile/show/'.$trans->girl_id) }}" class="gla-table-link"><p>{{ $trans->whomPay->first_name }}</p></a>
                                        <p class="gla-table-service">
                                            {{ trans('finance.'.$trans->type) }}
                                            @if($trans->description !== null)
                                                : {{ $trans->description }}
                                            @endif
                                        </p>
                                        @if(\App\Services\ClientFinanceService::isServiceActive($trans->user_id, $trans->girl_id, $trans->type) === true)
                                            @if($trans->expire === null)
                                                <p class="gla-table-terms text-success">{{ trans('finance.service_is_active') }}</p>
                                            @else
                                                <p class="gla-table-terms text-success">{{ trans('finance.service_is_active_until') }} {{ date('d-m-Y H:i', strtotime($trans->expire)) }}</p>
                                            @endif
                                        @endif
                                    </div>
                                </td>
                                <td>- {{ $trans->amount }}</td>
                            </tr>
                        @endif
                    @endforeach
                </table>
                {{ $transactions->render() }}
            </div>
        </div>
    @endif
@stop
