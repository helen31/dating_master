@extends('client.profile.profile')

@section('profileContent')
    <h2>{{ trans('profile.gifts_choose') }}</h2>
    <img src="{{ url('/uploads/users/avatars/'. $girl->avatar) }}" alt="Girl Photo" height="100px">&nbsp;{{ $girl->first_name }}
    <br>
    <h2>{{ trans('profile.gifts_catalogue') }}</h2>

    <table class="table table-hover">
        <tr>
            <th>#ID</th>
            <th> {{trans('/admin/gifts.photo')}} </th>
            <th> {{trans('/admin/gifts.name')}}</th>
            <th> {{trans('/admin/gifts.description')}}</th>
            <th> {{trans('/admin/gifts.price')}}</th>
            <th> {{trans('/admin/gifts.action')}}</th>

        </tr>
        @foreach($presents as $present)
            <tr>
                <td> {{ $present->id }} </td>
                <td> <img src="{{ url('/uploads/presents/'. $present->image) }}" alt="{{ $present->image }}" width="150px"> </td>
                <td> {{ $present->title }} </td>
                <td> {{ $present->description }} </td>
                <td> {{ $present->price }} LC</td>
                <td> <a href="{{ url(\App::getLocale().'/profile/'.$id.'/presents/'.$girl->id.'/gift/'.$present->id) }}" class="btn btn-success btn-xs">
                        <i class="fa fa-shopping-cart"></i>&nbsp;
                        {{ trans('profile.gifts_make_order') }}
                    </a>
                </td>
            </tr>
        @endforeach
    </table>
    {!! $presents->render() !!}

@stop