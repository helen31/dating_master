@extends('client.profile.profile')

@section('profileContent')

 <h2>{{ trans('profile.smile') }}</h2>

 <table class="table table-hover">
  <tr>
    <th>{{ trans('profile.name') }}</th>
    <th>{{ trans('profile.avatar') }}</th>
    <th>{{ trans('profile.wink_date') }}</th>
  </tr>
     @foreach($smiles as $smile)
         <tr>
             <td><a href="{{ url('profile/show/'.$smile->from) }}">{{ $smile->first_name }}</a></td>
             <td><img src="{{ url('/uploads/users/avatars/'.$smile->avatar) }}" height="80px"></td>
             <td>{{ date('d-m-Y  H:i', strtotime($smile->updated_at)) }}</td>
         </tr>
     @endforeach
</table>
 {!! $smiles->render() !!}

@stop