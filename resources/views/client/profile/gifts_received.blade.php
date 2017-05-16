@extends('client.profile.profile')

@section('profileContent')

    <h2 class="gla-title-color">{{ trans('profile.gifts') }}</h2>

    <table class="table table-hover">
        <tr>
            <th>#ID</th>
            <th>{{ trans('profile.name') }}</th>
            <th>{{ trans('profile.gift_name') }}</th>
            <th>{{ trans('profile.gift_date') }}</th>
            <th>{{ trans('profile.delivery_status') }}</th>
        </tr>
        @foreach($gifts as $gift)
            <tr>
                <td>{{ $gift->id }}</td>
                <td><a href="{{ url('profile/show/'.$gift->from) }}">{{ $gift->man->first_name }}</a></td>
                <td>{{ $gift->title }}</td>
                <td>{{ date('d-m-Y', strtotime($gift->created_at)) }}</td>
                <td>{{ trans('profile.gift_profile_status_'.$gift->status_id) }}</td>
            </tr>
        @endforeach
    </table>
    <br>
    @if($gifts->count() < 1)
        <h4>{{ trans('profile.gift_absent_girl') }}</h4>
    @endif


@stop