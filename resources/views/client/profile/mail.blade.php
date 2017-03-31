@extends('client.profile.profile')

@section('styles')
    <style>
        .grg-badge{
            background-color:#B02642;
        }
        .grg-mail-padding{
            padding-left: 8px;
            padding-top: 16px;
        }
    </style>
@stop

@section('profileContent')

    <div class="row grg-mail-padding">
        <h2 class="text-center">{{ trans('mail.mail') }}</h2>

        <!-- Nav tabs -->

        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active">
                <a href="#income" aria-controls="income" role="tab" data-toggle="tab">
                    {{ trans('mail.income') }}
                    @if($unread_income_count > 0)
                        <span class="badge grg-badge">{{ $unread_income_count }}</span>
                    @endif
                </a>
            </li>
            <li role="presentation">
                <a href="#outcome" aria-controls="outcome" role="tab" data-toggle="tab">
                    {{ trans('mail.outcome') }}
                </a>
            </li>
            <li role="presentation">
                <a href="#favourites" aria-controls="favourites" role="tab" data-toggle="tab">
                    {{ trans('mail.favourites') }}
                    @if($unread_favourites_count > 0)
                        <span class="badge grg-badge">{{ $unread_favourites_count }}</span>
                    @endif
                </a>
            </li>
            <li role="presentation">
                <a href="#blacklist" aria-controls="blacklist" role="tab" data-toggle="tab">
                    {{ trans('mail.blacklist') }}
                </a>
            </li>

        </ul>

        <!-- Tab panes -->

        <div class="tab-content" style="background-color: white">

            <!-- Входящие -->

            <div role="tabpanel" class="tab-pane active" id="income">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>{{ trans('mail.sender') }}</th>
                                <th>{{ trans('mail.message') }}</th>
                                <th>{{ trans('mail.status') }}</th>
                                <th>{{ trans('mail.date') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($income as $m)
                                <tr style="{{ ($m->status == 0)?'font-weight: bold;':'' }} cursor:pointer;" onclick='location.href="{{ url('profile/'.$m->to_user.'/correspond/'.$m->from_user) }}"'>
                                    <td>
                                        <img src="{{ url('/uploads/users/avatars/'.$m->avatar) }}" height="40px">
                                        {{ $m->first_name }}
                                    </td>
                                    <td>
                                        {{ mb_substr($m->message, 0, 50) }}...
                                    </td>
                                    <td>
                                        @if($m->status == 0)
                                            <span style="color:#B02642;">{{ trans('mail.unread') }}</span>
                                        @else
                                            <span style="color:#A0A0A0;">{{ trans('mail.read') }}</span>
                                        @endif
                                    </td>
                                    <td>{{ date('d-m-Y H:i', strtotime($m->created_at)) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {!!  $income->render() !!}
            </div>

            <!-- Исходящие -->

            <div role="tabpanel" class="tab-pane" id="outcome">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>{{ trans('mail.recipient') }}</th>
                        <th>{{ trans('mail.message') }}</th>
                        <th>{{ trans('mail.status') }}</th>
                        <th>{{ trans('mail.date') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($outcome as $m)
                            <tr style="{{ ($m->status == 0)?'font-weight: bold;':'' }} cursor:pointer;" onclick='location.href="{{ url('profile/'.$m->from_user.'/correspond/'.$m->to_user) }}"'>
                                <td>
                                    <img src="{{ url('/uploads/users/avatars/'.$m->avatar) }}" height="40px">
                                    {{ $m->first_name }}
                                </td>
                                <td>
                                    {{ mb_substr($m->message, 0, 50) }}...
                                </td>
                                <td>
                                    @if($m->status == 0)
                                        <span style="color:#B02642;">{{ trans('mail.unread') }}</span>
                                    @else
                                        <span style="color:#A0A0A0;">{{ trans('mail.read') }}</span>
                                    @endif
                                </td>
                                <td>{{ date('d-m-Y H:i', strtotime($m->created_at)) }}</td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
                {!!  $outcome->render() !!}
            </div>

            <!-- Сообщения от фаворитов -->

            <div role="tabpanel" class="tab-pane" id="favourites">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>{{ trans('mail.sender') }}</th>
                        <th>{{ trans('mail.message') }}</th>
                        <th>{{ trans('mail.status') }}</th>
                        <th>{{ trans('mail.date') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($favourites as $m)
                        <tr style="{{ ($m->status == 0)?'font-weight: bold;':'' }} cursor:pointer;" onclick='location.href="{{ url('profile/'.$m->to_user.'/correspond/'.$m->from_user) }}"'>
                            <td>
                                <img src="{{ url('/uploads/users/avatars/'.$m->avatar) }}" height="40px">
                                {{ $m->first_name }}
                            </td>
                            <td>
                                {{ mb_substr($m->message, 0, 50) }}...
                            </td>
                            <td>
                                @if($m->status == 0)
                                    <span style="color:#B02642;">{{ trans('mail.unread') }}</span>
                                @else
                                    <span style="color:#A0A0A0;">{{ trans('mail.read') }}</span>
                                @endif
                            </td>
                            <td>{{ date('d-m-Y H:i', strtotime($m->created_at)) }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {!!  $favourites->render() !!}
            </div>

            <!-- Сообщения от черного списка -->

            <div role="tabpanel" class="tab-pane" id="blacklist">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>{{ trans('mail.sender') }}</th>
                        <th>{{ trans('mail.message') }}</th>
                        <th>{{ trans('mail.status') }}</th>
                        <th>{{ trans('mail.date') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($blacklist as $m)
                        <tr style="{{ ($m->status == 0)?'font-weight: bold;':'' }} cursor:pointer;" onclick='location.href="{{ url('profile/'.$m->to_user.'/correspond/'.$m->from_user) }}"'>
                            <td>
                                <img src="{{ url('/uploads/users/avatars/'.$m->avatar) }}" height="40px">
                                {{ $m->first_name }}
                            </td>
                            <td>
                                {{ mb_substr($m->message, 0, 50) }}...
                            </td>
                            <td>
                                @if($m->status == 0)
                                    <span style="color:#B02642;">{{ trans('mail.unread') }}</span>
                                @else
                                    <span style="color:#A0A0A0;">{{ trans('mail.read') }}</span>
                                @endif
                            </td>
                            <td>{{ date('d-m-Y H:i', strtotime($m->created_at)) }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {!!  $blacklist->render() !!}
            </div>
        </div>
    </div>
@stop