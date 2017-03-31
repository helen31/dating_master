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
        <td><img src="{{ url('/uploads/users/avatars/1490266220-adam-smith.png') }}" height="80px"></td>
        <td>Adam</td>
        <td>{{ date('d-m-Y', strtotime('1978-02-15')) }}</td>
        <td>Водолей</td>
    </tr>
    <tr>
        <td><img src="{{ url('/uploads/users/avatars/1490265611-svetlana-ivanova.jpg') }}" height="80px"></td>
        <td>Svetlana</td>
        <td>{{ date('d-m-Y', strtotime('1980-03-15')) }}</td>
        <td>Рыбы</td>
    </tr>
</table>
<a class="btn btn-success" href="#" role="button">{{ trans('horoscope.check_comp') }} - 1 LC</a>


@stop