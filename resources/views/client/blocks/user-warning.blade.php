@if(Auth::user()->status_id == 2 || Auth::user()->status_id == 3 || Auth::user()->status_id == 5)
    <br>
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="alert alert-info">

                @if(Auth::user()->status_id == 2)
                    <p>{{ trans('flash.profile_deactive') }}</p>
                    <p>{{ trans('flash.profile_is_not_visible') }}</p>
                @endif

                @if(Auth::user()->status_id == 3)
                    <p>{{ trans('flash.profile_dismiss') }}</p>
                    <p>{{ trans('flash.profile_is_not_visible') }}</p>
                    <p><b><i>{{ trans('flash.reason') }}:</i></b> {{ Auth::user()->status_message }}</p>
                    <p>{{ trans('flash.eliminate') }}</p>
                @endif

                @if(Auth::user()->status_id == 5)
                    <p>{{ trans('flash.profile_onmoderation') }}</p>
                    <p>{{ trans('flash.profile_is_not_visible_moder') }}</p>
                @endif

            </div>
        </div>
    </div>
@endif
