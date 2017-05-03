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
    <h4 class="gla-table-balance">Текущий баланс: 00.00 Love Coins</h4>
    <div class="row gla-finance-form">
        <div class="col-md-12 gla-finance-form-title">
            <h4>Пополнить счёт</h4>
        </div>
        <form action="" class="col-md-6 form-horizontal gla-form">
            <div class="form-group">
                <label for="buyLC" class="col-sm-6 col-md-6 col-lg-6 control-label gla-form-label">Купить Love Coins</label>
                <div class="col-sm-6 col-md-6 col-lg-6">
                    <input type="text" class="form-control" id="buyLC" placeholder="введите сумму">
                </div>
            </div>
            <div class="form-group gla-form-group-margin">
                <div class="col-sm-offset-6 col-sm-6">
                    <button type="submit" class="btn btn-default gla-form-button">Купить Love Coins</button>
                </div>
            </div>
        </form>
        <div class="col-md-6 gla-form-radio">
            <div class="radio">
                <label class="gla-label">
                    <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked>
                    eur <span>30.00</span>
                </label>
            </div>
            <div class="radio">
                <label class="gla-label">
                    <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">
                    usd <span>30.00</span>
                </label>
            </div>
        </div>
        <div class="col-md-12 gla-finance-form-info">
            <h5>Информация</h5>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit,
            sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
            Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
        </div>
    </div>
    <div class="row gla-finance-table">
        <h2 class="gla-title-color">Ваши транзакции</h2>
        <h4 class="gla-table-balance">Текущий баланс: 150.00 Love Coins</h4>
        <div class="table-responsive">
            <table class="table table-bordered table-responsive danger gla-table">
                <thead>
                <tr>
                    <th scope="col">Дата</th>
                    <th scope="col">Описание</th>
                    <th scope="col">Сумма(LC)</th>
                </tr>
                </thead>
                <tr class="active">
                    <td>27-04-2017 15:00</td>
                    <td>пополнение счёта</td>
                    <td>150.00</td>
                </tr>
                <tr>
                    <td>28-04-2017 12:00</td>
                    <td>
                        <img src="/uploads/users/avatars/1490264152-alina.jpg"  class="gla-table-photo" alt="">
                        <div class="gla-table-info">
                            <a href="#" class="gla-table-link"><p>Надежда</p></a>
                            <p class="gla-table-service">Lorem ipsum dolor sit amet</p>
                            <p class="gla-table-terms">услуга активна</p>
                        </div>
                    </td>
                    <td>150.00</td>
                </tr>
                <tr class="active">
                    <td>29-04-2017 09:00</td>
                    <td>
                        пополнение счёта
                    </td>
                    <td>150.00</td>
                </tr>
                <tr>
                    <td>30-04-2017 02:00</td>
                    <td>
                        <img src="/uploads/users/avatars/1490264152-alina.jpg"  class="gla-table-photo" alt="">
                        <div class="gla-table-info">
                            <a href="#" class="gla-table-link"><p>Надежда</p></a>
                            <p class="gla-table-service">Lorem ipsum dolor sit amet</p>
                            <p class="gla-table-terms">услуга активна до 20-05-2017</p>
                        </div>
                    </td>
                    <td>150.00</td>
                </tr>
            </table>
        </div>
    </div>


@stop
