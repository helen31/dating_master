@extends('admin.layout')

@section('styles')

@stop

@section('content')

    <section class="panel">
        <header class="panel-heading text-right">
        </header>
        <div class="panel-body">

                <table class="table table-hovered">
                    <thead>
                        <tr>
                            <th> #ID </th>
                            <th> Название подарка </th>
                            <th> Фото </th>
                            <th> Кто подарил </th>
                            <th> Кому подарили </th>
                            <th> Стоимость </th>
                            <th> Фото подтверждения </th>
                            <th> Управление </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($gifts as $gift)
                            <tr>
                                <td> {{ $gift->id }} </td>
                                <td> {{ $gift->title }}</td>
                                <td> <img src="{{ url('/uploads/presents/'.$gift->prezent->image ) }}" alt="Gift Photo" height="100px"></td>
                                <td>  <a href="{{ url('/profile/show/'.$gift->from) }}">ID#{{ $gift->from }}</a></td>
                                <td>  <a href="{{ url('profile/show/'.$gift->to) }}">ID#{{ $gift->to }}</a></td>
                                <td> {{ $gift->prezent->price }}</td>
                                <td>
                                    @if(!empty($gift->confirm_photo))
                                        <a href="{{ url('/uploads/confirm_photos/'.$gift->confirm_photo ) }}"><img src="{{ url('/uploads/confirm_photos/'.$gift->confirm_photo ) }}" alt="Confirm Photo" height="100px"></a>
                                    @else
                                        <p>Нет фото</p>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ url('/admin/gifts/edit/'.$gift->id) }}" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a>
                                    @if( Auth::user()->hasRole('Owner') || Auth::user()->hasRole('Moder') )
                                        <a href="{{ url('/admin/gifts/drop/'.$gift->id) }}" class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
        </div>
    </section>

@stop

@section('scripts')

@stop