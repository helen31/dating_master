@if(Auth::user()->status_id == 2 || Auth::user()->status_id == 3)
    <br>
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="alert alert-info">
                @if(Auth::user()->status_id == 2)
                    <p>{{ trans('flash.profile_deactive') }}</p>
                @else
                    <p>{{ trans('flash.profile_dismiss') }}</p>
                @endif
                <p>{{ trans('flash.profile_is_not_visible') }}</p>
                <p><b><i>{{ trans('flash.reason') }}:</i></b> {{ Auth::user()->status_message }}</p>
                <p>{{ trans('flash.eliminate') }}</p>
            </div>
        </div>
    </div>
@endif
