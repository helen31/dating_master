@extends('client.profile.profile')

@section('styles')
    <style>
        .grg-btn-girl-contacts{
            margin: 10px 2px;
        }
    </style>
@stop

@section('profileContent')

    <h2>{{ trans('profile.request_contacts') }}</h2>

    <table class="table table-hover">
        <tr>
            <th>{{ trans('profile.avatar') }}</th>
            <th>{{ trans('profile.name') }}</th>
            <th>{{ trans('profile.birthday') }}</th>
        </tr>
        <tr>
            <td><img src="{{ url('/uploads/users/avatars/'.$girl->avatar) }}" height="80px"></td>
            <td>{{ $girl->first_name }}</td>
            <td>{{ date('d-m-Y', strtotime($girl->birthday)) }}</td>
        </tr>
    </table>

        @if($know_email == true)
            <div class="panel panel-default">
                <div class="panel-body">
                    <p>{{ $girl->first_name.' '.$girl->last_name }}</p>
                    <p>{{ trans('profile.email').': '.$girl->email }}</p>
                </div>
            </div>
        @else
            <div class="grg-btn-girl-contacts">
                <a class="btn btn-success" href="{{ url('profile/'.$id.'/contacts/'.$girl_id.'/request_email') }}" role="button">{{ trans('profile.request_surname_email') }} - 20 LC</a>
            </div>
        @endif

        @if($know_phone == true)
            <div class="panel panel-default">
                <div class="panel-body">
                    <p>{{ $girl->first_name.' '.$girl->last_name }}</p>
                    <p>{{ trans('profile.phone').': '.$girl->phone }}</p>
                </div>
            </div>
        @else
            <div class="grg-btn-girl-contacts">
                <a class="btn btn-success" href="{{ url('profile/'.$id.'/contacts/'.$girl_id.'/request_phone') }}" role="button">{{ trans('profile.request_surname_phone') }} - 40 LC</a>
            </div>
        @endif

@stop