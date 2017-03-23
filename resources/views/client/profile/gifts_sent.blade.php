@extends('client.profile.profile')

@section('profileContent')

    <h2>{{ trans('profile.gifts') }}</h2>

    <table class="table table-hover">
        <tr>
            <th>#ID</th>
            <th>{{ trans('profile.name') }}</th>
            <th>{{ trans('profile.avatar') }}</th>
            <th>{{ trans('profile.gift_name') }}</th>
            <th>{{ trans('profile.gift_price') }}</th>
            <th>{{ trans('profile.gift_date') }}</th>
            <th>{{ trans('profile.delivery_status') }}</th>
            <th>{{ trans('profile.confirm_photo') }}</th>

        </tr>
        @foreach($gifts as $gift)
            <tr>
                <td>{{ $gift->id }}</td>
                <td><a href="{{ url('profile/show/'.$gift->to) }}">{{ $gift->girl->first_name }}</a></td>
                <td><img src="{{ url('/uploads/users/avatars/'.$gift->girl->avatar) }}" height="80px"></td>
                <td>{{ $gift->title }}</td>
                <td>{{ $gift->prezent->price }} LC</td>
                <td>{{ date('d-m-Y', strtotime($gift->created_at)) }}</td>
                <td>{{ trans('profile.gift_profile_status_'.$gift->status_id) }}</td>
                <td>
                    @if(!empty($gift->confirm_photo))
                        <a href="{{ url('/uploads/confirm_photos/'.$gift->confirm_photo ) }}"><img src="{{ url('/uploads/confirm_photos/'.$gift->confirm_photo ) }}" alt="Confirm Photo" height="100px"></a>
                    @else
                        <p>{{ trans('profile.gift_confirmation_absent') }}</p>
                    @endif
                </td>
            </tr>
        @endforeach
    </table>
    <br>
    @if($gifts->count() < 1)
        <h4>{{ trans('profile.gift_absent_man') }}</h4>
    @endif

@stop