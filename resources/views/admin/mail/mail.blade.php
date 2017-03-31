@extends('admin.layout')

@section('styles')
    <style>
        .grg-badge{
            background-color:#B02642;
        }
    </style>
@stop

@section('content')

        <h5>{{ trans('mail.unread_count') }}:&nbsp;&nbsp;<span class="badge grg-badge">{{ $unread_income_count }}</span></h5>

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
                        <tr style="{{ ($m->status == 0)?'font-weight: bold;':'' }} cursor:pointer;" onclick='location.href="{{ url(''.App::getLocale().'/admin/messages-from-man/'.$m->from_user.'/correspond/'.$m->to_user) }}"'>
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
    </div>
@stop