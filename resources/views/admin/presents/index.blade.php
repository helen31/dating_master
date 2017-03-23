@extends('admin.layout')

@section('styles')

@stop

@section('content')

    <section class="panel">
        <header class="panel-heading text-right">
            <a href="{{ url(App::getLocale().'/admin/presents/new') }}" class="btn btn-success"> {{trans('/admin/gifts.addGift')}}</a>
        </header>
        <div class="panel-body">

            @if(!empty($presents))
                <table class="table table-hovered">
                    <thead>
                        <tr>
                            <th> #ID </th>
                            <th> {{trans('/admin/gifts.photo')}} </th>
                            <th> {{trans('/admin/gifts.name')}}</th>
                            <th> {{trans('/admin/gifts.description')}}</th>
                            <th> {{trans('/admin/gifts.price')}}</th>
                            <th> {{trans('/admin/gifts.action')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($presents as $p)
                            <tr>
                                <td> {{ $p->id }} </td>
                                <td> <img src="{{ url('/uploads/presents/'. $p->image) }}" alt="{{ $p->image }}" width="150px"> </td>
                                <td> {{ $p->title }} </td>
                                <td> {{ $p->description }} </td>
                                <td> {{ $p->price }} </td>
                                <td>
                                    @if(Auth::user()->hasRole("Owner") || Auth::user()->hasRole("Moder"))
                                        <a href="{{ url('/admin/presents/edit/'.$p->id) }}" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a>
                                        <a href="{{ url('/admin/presents/drop/'.$p->id) }}" class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></a>
                                    @else
                                        @if($p->partner_id == Auth::user()->id)
                                            <a href="{{ url('/admin/presents/edit/'.$p->id) }}" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a>
                                            <a href="{{ url('/admin/presents/drop/'.$p->id) }}" class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></a>
                                        @else
                                            <p>Admin</p>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $presents->render() !!}
            @else
                <p> {{trans('/admin/gifts.noGifts')}} </p>
            @endif
        </div>
    </section>

@stop

@section('scripts')

@stop