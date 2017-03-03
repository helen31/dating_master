@extends('client.profile.profile')

@section('styles')
    <link href="{{ url('/assets/css/bootstrap-reset.css') }}" rel="stylesheet">
    <link href="{{ url('/assets/css/fileinput.css') }}" rel="stylesheet">
    <link href="{{ url('assets/css/datepicker.css') }}" rel="stylesheet">
@stop

@section('profileContent')

    <section class="panel">
        <header class="panel-heading">{{ trans('albums.create') }}</header>
        <div class="panel-body">
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            {!! Form::open(['url' =>url('/'.App::getLocale().'/profile/'.Auth::user()->id.'/add_album'), 'class' => 'form', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                <div class="form-group">
                    {!! Form::label(trans('albums.name')) !!}
                    <input name="name" type="text" class="form-control">
                </div>
                <div class="form-group">
                    {!! Form::label(trans('albums.cover')) !!}
                    {!! Form::file('cover_image', ['class' => 'file', 'accept' => 'image/*',
                        'data-show-upload' => 'false', 'data-show-caption' => 'true']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label(trans('albums.choose')) !!}

                    <input type="file" name="files[]" multiple="multiple" class="file" accept="image/*"
                           data-show-upload="false" data-show-caption="true">
                </div>
                    {!! Form::input('hidden','user_id', Auth::user()->id) !!}
                <div class="form-group text-center">
                    <input type="submit" class="btn btn-lg btn-success" value="{{ trans('albums.send') }}">
                </div>
            {!! Form::close() !!}
        </div>
    </section>
@stop
@section('scripts')
    <script type="text/javascript" src="{{ url('/assets/js/bootstrap-fileinput-master/js/fileinput.js') }}"></script>
    <script type="text/javascript" src="{{ url('/assets/js/file-input-init.js') }}"></script>
    <script>
        $("#cover_image").fileinput({
            minFileCount: 1,
            maxFileCount: 1,
            validateInitialCount: true,
            overwriteInitial: true,
            allowedFileExtensions: ["jpg", "png", "gif", "jpeg"]
        });
    </script>
@stop