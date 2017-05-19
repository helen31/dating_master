<style>
    .grg-header-button{
        text-transform: uppercase;
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
            <div class="vcenter logo">
                <div class="col-md-12">
                    <a href="{{ url(App::getLocale().'/') }}">
                        <img id="logo_img" class="header__logo" src="/public/uploads/logo.png" alt="Logo"><span class='logo_text'>&nbsp;&nbsp;GET MARRIED CLUB</span>
                    </a>
                </div>
            </div>
            <!--end logo-->
            <div class="vcenter vcenter_right login-buttons">
                <div class="col-md-3 col-sm-4">
                    <div class="dropdown gla-dropdown-style">
                        <a href="javascript:;" data-toggle="dropdown" class="dropdown-toggle" aria-expanded="false">
                            <img src="{{ url('/assets/img/flags/'.App::getLocale().'.png') }}" class="gl-language_icon" alt="{{App::getLocale()}}">
                            <span class="gla-header-icon-description">{{ trans( 'langs.'.App::getLocale() ) }}</span>
                            <b class="fa fa-angle-down"></b>
                        </a>
                        <ul role="menu" class="dropdown-menu gla-dropdown-menu language-switch">
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
                    </div>
                </div>
            @if(!Auth::user())
                <!--Login buttons-->
                    <div class="col-md-9 gla-header-ms-padding">
                        <div class="gla-header-md-padding gla-header-md-margin_left">
                            <button type="button" class="btn btn-default" id="button-login" data-toggle="modal" data-target="#loginModal"><i class="fa fa-sign-in" aria-hidden="true"></i> {{ trans('buttons.login') }} </button>
                        </div>
                        <div class="gla-header-md-padding">
                            <button class="btn btn-default" id="button-register" data-toggle="modal" data-target="#registerModal"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> {{ trans('buttons.signup') }} </button>
                        </div>
                    </div>
                    <!--end login buttons-->
                @else
                    <div class="col-md-8 gla-header-md-padding">
                        <div class="dropdown gla-profile-dropdown">
                            <a href="javascript:void(0);" data-toggle="dropdown" class="dropdown-toggle" aria-expanded="false">
                                <div class="profile-header-container">
                                    <div class="profile-header-img" style="background-image: url({{ url('/uploads/users/avatars/'. $user->avatar) }})"></div>
                                    <span class="gla-header-icon-description">Svetlana</span>
                                    <i class="fa fa-angle-down" aria-hidden="true"></i>
                                </div>
                            </a>
                            <ul class="dropdown-menu gla-dropdown-menu" role="menu" aria-labelledby="dLabel">
                                <li><a tabindex="-1" href="{{ url(App::getLocale().'/profile/'. Auth::user()->id) }}"><i class="fa fa-user" aria-hidden="true"></i>{{ trans('buttons.profile') }}</a></li>
                                <li><a tabindex="-1" href="{{ url('/logout') }}"><i class="fa fa-sign-out" aria-hidden="true"></i>{{ trans('buttons.logout') }}</a></li>
                            </ul>
                        </div>
                    </div>
                @endif
            </div>
        </div><!--end row-->
    </div>
</div>

@include('client.blocks.nav')