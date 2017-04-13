@extends('client.profile.profile')

@section('styles')
    <link href="{{ url('/assets/css/bootstrap-reset.css') }}" rel="stylesheet">
    <link href="{{ url('/assets/css/fileinput.css') }}" rel="stylesheet">
@stop

@section('profileContent')
    <div class="row">
        <div role="tabpanel" class="tab-pane">
            <h2 class="text-center gla-title-color">{{ trans('profile.video') }}</h2>
            @foreach($videos as $video)
                <div class="col-md-12 gla-video" id="video-{{ $video->id }}">
                    <div class="col-md-12 gla-video-column">
                        <h3 class="col-md-12 col-sm-12 text-center gla-video-title">{{ $video->name }}</h3>
                        <a class="delete_gallery" href="#" onclick="deleteProfileVideo(event,'{{ $video->id }}');"><i class="fa fa-trash-o"></i></a>
                        <div class="col-md-6 col-sm-12">
                            <div class="gla-cover-img video-width">
                                <img src="/uploads/videos/covers/{{ $video->cover }}" alt="poster">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="gla-video-item">
                                <video width="320" height="240" controls class="video-width">
                                    <source src="/uploads/videos/videos-mp4/{{ $video->video }}" type="video/mp4">
                                    {{ trans('profile.video_not_supported') }}
                                </video>
                            </div>
                        </div>
                        <p class="col-md-12 col-sm-12 text-left">
                            <strong>{{ trans('profile.video_description') }}</strong>:&nbsp;{{ $video->description }}
                        </p>
                    </div>
                </div>
            @endforeach
            <hr>

            <div class="col-md-12">
                <h2 class="text-center gla-title-color">{{ trans('profile.add_video') }}</h2>

                {!! Form::open(['url' => 'profile/'.\Auth::user()->id.'/video/add', 'class' => 'form', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}

                <div class="form-group">
                    {!! Form::label('name', trans('profile.video_name')) !!}
                    {!! Form::text('name', old('name'), ['class'=>'form-control', 'placeholder' => trans('profile.video_name')]) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('description', trans('profile.video_description')) !!}
                    {!! Form::textarea('description', old('description'), ['class'=>'form-control', 'placeholder' => trans('profile.video_description')]) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('cover', trans('profile.cover_label')) !!}
                    <input type="file" name="cover" class="file grg-fileinput"
                           data-show-upload="false" data-show-caption="true" accept="image/*">
                </div>
                <div class="form-group">
                    {!! Form::label('video', trans('profile.video_label')) !!}
                    <input type="file" name="video" class="file grg-fileinput"
                           data-show-upload="false" data-show-caption="true" accept="video/mp4">
                </div>
                {!! Form::submit(trans('buttons.save'), ['class' => 'btn btn-success']) !!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>


@stop

@section('scripts')

    <script src="{{ url('/assets/js/bootstrap-datepicker.js') }}"></script>
    <script type="text/javascript" src="{{ url('/assets/js/bootstrap-fileinput-master/js/fileinput.js') }}"></script>
    <script type="text/javascript" src="{{ url('/assets/js/file-input-init.js') }}"></script>
    <script>
        function deleteProfileVideo(event,videoID){
            event.preventDefault();
            $.post( "/profile/deleteVideo/"+videoID, {_token : $('input[name="_token').val()} ).done( function( data ) {
                $("#video-"+videoID).remove();
            });
        }

    </script>

@stop