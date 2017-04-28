@extends('client.profile.profile')

@section('profileContent')

<h2>{{ trans('horoscope.check_compatibility') }}</h2>

<table class="table table-hover">
    <tr>
        <th>{{ trans('profile.avatar') }}</th>
        <th>{{ trans('profile.name') }}</th>
        <th>{{ trans('profile.birthday') }}</th>
        <th>{{ trans('profile.zodiac') }}</th>

    </tr>
    <tr>
        <td><img src="{{ url('/uploads/users/avatars/'.$man->avatar) }}" height="80px"></td>
        <td>{{ $man->first_name }}</td>
        <td>{{ date('d-m-Y', strtotime($man->birthday)) }}</td>
        <td>{{ trans('horoscope.'.$man->sign) }}</td>
    </tr>
    <tr>
        <td><img src="{{ url('/uploads/users/avatars/'.$girl->avatar) }}" height="80px"></td>
        <td>{{ $girl->first_name }}</td>
        <td>{{ date('d-m-Y', strtotime($girl->birthday)) }}</td>
        <td>{{ trans('horoscope.'.$girl->sign) }}</td>
    </tr>
</table>
@if(isset($compare) && $compare != null)
    <div class="panel panel-default">
        <div class="panel-body">
           {!! $compare->text !!}
        </div>
    </div>
@else
    <a class="btn btn-success" href="{{ url('profile/'.$id.'/horoscope/'.$cor_id.'/check') }}" role="button">{{ trans('horoscope.check_comp') }} - 1 Love Coin</a>
@endif

@stop