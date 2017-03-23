@extends('client.profile.profile')

@section('profileContent')

    <h2>{{ trans('profile.gifts_order_confirmation') }}</h2>

    <table class="table table-hover">
        <tr>
            <th> {{ trans('profile.gifts_girl_photo') }} </th>
            <th> {{ trans('profile.gifts_girl_name') }}</th>
            <th> {{ trans('profile.gifts_gift_photo') }}</th>
            <th> {{ trans('/admin/gifts.name') }}</th>
            <th> {{ trans('/admin/gifts.description') }}</th>
            <th> {{ trans('/admin/gifts.price') }}</th>

        </tr>
            <tr>
                <td><img src="{{ url('/uploads/users/avatars/'. $girl->avatar) }}" alt="Girl Photo" height="100px">&nbsp;</td>
                <td>{{ $girl->first_name }}</td>
                <td> <img src="{{ url('/uploads/presents/'. $present->image) }}" alt="{{ $present->image }}" width="150px"> </td>
                <td> {{ $present->title }} </td>
                <td> {{ $present->description }} </td>
                <td> {{ $present->price }} LC</td>
            </tr>
    </table>

    {!! Form::open(['url' => \App::getLocale().'/profile/'.$id.'/gift/order', 'class' => 'form', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'files' => true]) !!}

    <div class="form-group">
        {!! Form::label('gift_message', trans('profile.gifts_write_message')) !!}
        <textarea name="gift_message" class="form-control" rows="5"></textarea>
    </div>

    <input type="hidden" name="from" value="{{ Auth::user()->id }}">
    <input type="hidden" name="to" value="{{ $girl->id }}">
    <input type="hidden" name="present" value="{{ $present->id }}">

    <br>
    <div class="form-group">
        {!! Form::submit(trans('profile.gifts_confirm_order'), ['class' => 'btn btn-success grg-form-button']) !!}
    </div>

    {!! Form::close() !!}

@stop