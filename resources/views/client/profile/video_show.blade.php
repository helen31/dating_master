@extends('client.profile.profile')

@section('profileContent')
    <div class="row col-md-12 col-sm-12">
        <div class="col-md-12 col-sm-12 text-center">
            <div class="col-md-12 col-sm-12 gla-video-column">
                <h3 class="col-md-12 text-center gla-video-title">{{ $video->name }}</h3>
                <div class="col-sm-12 gla-video-item gla-video-item_border">
                    <video class="gla-video-measurements" controls>
                        <source src="/uploads/videos/videos-mp4/{{ $video->video }}" type="video/mp4">
                        {{ trans('profile.video_not_supported') }}
                    </video>
                </div>
                <p class="col-md-12 col-sm-12 text-justify">{{ $video->description }}</p>
                <p class="col-md-12 col-sm-12 text-danger">*{{ trans('profile.video_24_access') }}</p>

            </div>
        </div>
    </div>
@stop