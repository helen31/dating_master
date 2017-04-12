@extends('client.profile.profile')

@section('profileContent')
    <div class="row col-md-12 col-sm-12">
        <div class="col-md-12 col-sm-12 text-center">
            <div class="col-md-12 col-sm-12 gla-video-column">
                <h3 class="col-md-12 text-center gla-video-title">Little bit about myself</h3>
                <div class="col-sm-12 gla-video-item gla-video-item_border">
                    <video class="gla-video-measurements" controls>
                        <source src="/uploads/video/IMG_4369.mp4" type="video/mp4">
                        <source src="path-to-webm.webm" type="video/webm">
                        Your browser does not support the video tag.
                    </video>
                </div>
                <p class="col-md-12 col-sm-12 gla-video-description">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                    Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                    Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                    Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                </p>
            </div>
        </div>
    </div>
@stop