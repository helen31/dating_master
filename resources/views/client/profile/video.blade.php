@extends('client.profile.profile')

@section('styles')
    <link href="{{ url('/assets/css/bootstrap-reset.css') }}" rel="stylesheet">
    <link href="{{ url('/assets/css/fileinput.css') }}" rel="stylesheet">
@stop

@section('profileContent')
    <div class="row">
        <div role="tabpanel" class="tab-pane" id="profile_foto">
            <h2 class="col-md-12 text-center gla-title-color">Видео профиля</h2>
            <div class="col-md-12 gla-video">
                <div class="col-md-12 gla-video-column">
                    <h3 class="col-md-12 col-sm-12 text-center gla-video-title">Пикник на природе</h3>
                    <div class="col-md-6 col-sm-12">
                        <div class="gla-cover-img video-width">
                            <img src="/uploads/video/Girls-Pic-In-High-Quality.jpg" alt="poster" object->
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="gla-video-item">
                            <video width="320" height="240" controls class="video-width">
                                <source src="/uploads/video/IMG_0825.mp4" type="video/mp4">
                                <source src="path-to-webm.webm" type="video/webm">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 gla-video">
                <div class="col-md-12 gla-video-column">
                    <h3 class=" col-md-12 col-sm-12 text-center gla-video-title">Пикник на природе</h3>
                    <div class="col-md-6 col-sm-12">
                        <div class="gla-cover-img video-width">
                            <img src="/uploads/video/Amazing-Girls-Image-.jpg" alt="poster" object->
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="gla-video-item">
                            <video width="320" height="240" controls class="video-width">
                                <source src="/uploads/video/IMG_4369.mp4" type="video/mp4">
                                <source src="path-to-webm.webm" type="video/webm">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12"><br></div>
            <div class="form-group text-center col-md-12">
                {!! Form::open(['url' => '#', 'class' => 'form', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                <input id="profile_photo" type="file" name="" class="file grg-fileinput"
                       data-show-upload="false" data-show-caption="true">
                <br>
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

@stop