<style>
    .grg-header-button{
        text-transform: uppercase;
    }
</style>
<div id="header">
    <div class="container">
        <div class="row">

            <!-- Logo -->
            <div class="col-lg-7 col-md-6 col-sm-5 logo">
                <a href="{{ url(App::getLocale().'/') }}">
                    <img id="logo_img" src="/public/uploads/logo.png" alt="Logo"><span class='logo_text'>&nbsp;&nbsp;GET MARRIED CLUB</span>
                </a>
            </div>
            <!--end logo-->

            <div class="col-lg-5 col-md-6 col-sm-7 login-buttons">
                @if(!Auth::user())
                    <!--Login buttons-->
                    <div class="col-md-4">
                        <li class="dropdown btn btn-default pull-right">
                                <a href="javascript:;" data-toggle="dropdown" class="dropdown-toggle" aria-expanded="false">
                                    <img src="{{ url('/assets/img/flags/'.App::getLocale().'.png') }}" alt="{{App::getLocale()}}">
                                    <span>{{ trans( 'langs.'.App::getLocale() ) }}</span>
                                    <b class=" fa fa-angle-down"></b>
                                </a>
                                <ul role="menu" class="dropdown-menu language-switch">
                                    @foreach( Config::get('app.locales') as $locale )
                                        @if( $locale != App::getLocale() )
                                            <li>
                                                <a tabindex="-1" href="{{ LaravelLocalization::getLocalizedURL($locale) }}">
                                                    <img src="{{ url('/assets/img/flags/'.$locale.'.png') }}" alt="{{$locale}}">
                                                    <span> {{ trans('langs.'.$locale) }} </span>
                                                </a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                        </div>
                        <div class="col-md-4 col-sm-4">
                            <button type="button" class="btn btn-default" id="button-login" data-toggle="modal" data-target="#loginModal"> {{ trans('buttons.login') }} </button>
                        </div>
                        <div class="col-md-4 col-sm-4">
                            <button class="btn btn-default" id="button-register" data-toggle="modal" data-target="#registerModal"> {{ trans('buttons.signup') }} </button>
                        </div>
                    <!--end login buttons-->
                @else
                    <div class="col-md-12">
                        <li class="dropdown btn btn-default pull-right">
                            <a href="javascript:;" data-toggle="dropdown" class="dropdown-toggle" aria-expanded="false">
                                <img src="{{ url('/assets/img/flags/'.App::getLocale().'.png') }}" alt="{{App::getLocale()}}">
                                <span>{{ trans( 'langs.'.App::getLocale() ) }}</span>
                                <b class=" fa fa-angle-down"></b>
                            </a>
                            <ul role="menu" class="dropdown-menu language-switch">
                                @foreach( Config::get('app.locales') as $locale )
                                    @if( $locale != App::getLocale() )
                                        <li>
                                            <a tabindex="-1" href="{{ LaravelLocalization::getLocalizedURL($locale) }}">
                                                <img src="{{ url('/assets/img/flags/'.$locale.'.png') }}" alt="{{$locale}}">
                                                <span> {{ trans('langs.'.$locale) }} </span>
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </li>
                            <a href="{{ url(App::getLocale().'/profile/'. Auth::user()->id) }}" class="btn btn-default pull-right grg-header-button"><i class="fa fa-user"></i>&nbsp;{{ trans('buttons.profile') }}</a>
                            <a href="{{ url('/logout') }}" class="btn btn-default pull-right grg-header-button"><i class="fa fa-sign-out"></i>&nbsp;{{ trans('buttons.logout') }}</a>
                        </div>
                @endif
            </div>
        </div><!--end row-->
    </div>
</div>

@include('client.blocks.nav')