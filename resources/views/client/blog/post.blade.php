@extends('client.app')

@section('content')
    <div class="container">
        <div class="row gla-post-margin">
            <div class="col-md-8 col-md-offset-2">
                @foreach($post as $p)
                    @if( $p->cover_image )
                    <img src="{{ url('/uploads/blog/'.$p->cover_image) }}" class="img-responsive">
                    @endif
                    <h2>{{ $p->title }}</h2>
                    {!! $p->body !!}
                @endforeach
            </div>
        </div>
    </div>
@stop
