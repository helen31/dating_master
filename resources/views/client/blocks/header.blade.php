<style>
    .grg-header-button{
        text-transform: uppercase;
    }

    .gl-container{
        padding: 0 8px;
    }

    .gl-language_icon{
        vertical-align: inherit;
    }
    .gla-header-md-padding{
        padding-left: 0;
    }
    .gla-header-ms-padding{
        padding: 0;
    }
    .fa-sign-in{
        margin-right: 4px;
    }
</style>
<div id="header">
    <div class="container gl-container">
        <div class="row">

            <!-- Logo -->
            <div class="col-lg-7 col-md-6 col-sm-5 logo">
                <a href="{{ url(App::getLocale().'/') }}">
                    <img id="logo_img" class="header__logo" src="/public/uploads/logo.png" alt="Logo"><span class='logo_text'>&nbsp;&nbsp;GET MARRIED CLUB</span>
                </a>
            </div>
            <!--end logo-->

            <div class="col-lg-5 col-md-6 col-sm-7 login-buttons">
            @if(!Auth::user())
                <!--Login buttons-->
                    <div class="col-md-4 col-sm-4">
                        <li class="dropdown btn btn-default pull-right">
                            <a href="javascript:;" data-toggle="dropdown" class="dropdown-toggle" aria-expanded="false">
                                <img src="{{ url('/assets/img/flags/'.App::getLocale().'.png') }}" class="gl-language_icon" alt="{{App::getLocale()}}">
                                <span>{{ trans( 'langs.'.App::getLocale() ) }}</span>
                                <b class=" fa fa-angle-down"></b>
                            </a>
                            <ul role="menu" class="dropdown-menu language-switch">
                                @foreach( Config::get('app.locales') as $locale )
                                    @if( $locale != App::getLocale() )
                                        <li>
                                            <a tabindex="-1" href="{{ LaravelLocalization::getLocalizedURL($locale) }}">
                                                <img src="{{ url('/assets/img/flags/'.$locale.'.png') }}" class="gl-language_icon" alt="{{$locale}}">
                                                <span> {{ trans('langs.'.$locale) }} </span>
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </li>
                    </div>
                    <div class="col-md-8 col-sm-8 gla-header-ms-padding">
                        <div class="col-md-6 gla-header-md-padding">
                            <button type="button" class="btn btn-default" id="button-login" data-toggle="modal" data-target="#loginModal"><i class="fa fa-sign-in" aria-hidden="true"></i> {{ trans('buttons.login') }} </button>
                        </div>
                        <div class="col-md-6 gla-header-md-padding">
                            <button class="btn btn-default" id="button-register" data-toggle="modal" data-target="#registerModal"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> {{ trans('buttons.signup') }} </button>
                        </div>
                    </div>
                    <!--end login buttons-->
                @else
                    <div class="col-md-12 gla-header-md-padding">
                        <li class="dropdown btn btn-default pull-right">
                            <a href="javascript:;" data-toggle="dropdown" class="dropdown-toggle" aria-expanded="false">
                                <img src="{{ url('/assets/img/flags/'.App::getLocale().'.png') }}" class="gl-language_icon" alt="{{App::getLocale()}}">
                                <span>{{ trans( 'langs.'.App::getLocale() ) }}</span>
                                <b class=" fa fa-angle-down"></b>
                            </a>
                            <ul role="menu" class="dropdown-menu language-switch">
                                @foreach( Config::get('app.locales') as $locale )
                                    @if( $locale != App::getLocale() )
                                        <li>
                                            <a tabindex="-1" href="{{ LaravelLocalization::getLocalizedURL($locale) }}">
                                                <img src="{{ url('/assets/img/flags/'.$locale.'.png') }}" class="gl-language_icon" alt="{{$locale}}">
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