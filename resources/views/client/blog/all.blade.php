@extends('client.app')

@section('content')
    <div class="container">
        <div class="row" style="margin-bottom: 50px; margin-top: 50px">
            <div id="blog" class="col-sm-12">
                @foreach($posts as $p)
                    <div class="row gla-row-margin-bottom">
                        <div class=" col-sm-5">
                            <img class="image img-responsive img-thumbnail" src="{{ url('/uploads/blog/'.$p->cover_image) }}">
                        </div>
                        <div class="col-sm-7">
                            <h2 class="gla-blog-title-margin">{{ $p->title }}</h2>
                            <div class="body text-justify"><p>{{ strip_tags(mb_substr($p->body, 0, 500, 'UTF-8') . '...') }}</p></div>
                            <div class="button"><a href="{{ url('/'.App::getLocale().'/blog/'.$p->id) }}" class="btn btn-pink">{{ trans('blog.readMore') }}</a> </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="col-sm-12 paginate text-center">
                {{ $posts->render() }}
            </div>
        </div>
    </div>

@endsection

@section('styles')
<style>

</style>


@stop