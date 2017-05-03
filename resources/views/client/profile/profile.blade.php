@extends('client.app')

@section('content')
    <div class="content-bg">
        <div class="row map-bg">
            <div class="col-md-12">
                <div class="container">
                    <div class="col-lg-2 col-md-2 col-sm-3 gla-leftNav" id="profileMenu">
                        <!--desktop Profile left nav-->
                        @if(Auth::user())
                            @include('client.blocks.profile-sidebar')
                        @endif
                    </div>
                    <div class="col-lg-10 col-md-10 col-sm-9" id="profileFields">
                        @yield('profileContent')
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('styles')
    <style>
        header{
            font-weight: bold;
            font-size: 20px;
        }
    </style>
@stop

@section('scripts')
    @yield('additional_scripts')
@stop