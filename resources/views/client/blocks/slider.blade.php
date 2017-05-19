<div class="header-bg">
    <div class="container no-gutter">

        <div class="short_search_wrapper bg-default col-sm-12 col-md-4 col-lg-3">
            <div class="search-form">
                <div class="form-header">
                    <h4>{{ trans('searchTitle.findYourTrueLove') }}</h4>
                </div>
                {!! Form::open(['action' => 'SearchController@search', 'method' => 'POST', 'class' => 'form-search form-inline']) !!}
                    <div class="text-left">

                        <div class="form-group grg-search-input gla-search-inputblock">
                            <label class="gla-form-top-label" for="looking">{{ trans('searchTitle.lookingForA') }}</label>
                            <select name="looking" class="form-control">

                                @if(!Auth::user())
                                    <option value="5">{{ trans('searchTitle.woman1') }}</option>
                                @elseif(Auth::user()->hasRole('male'))
                                    <option value="5" selected>{{ trans('searchTitle.woman1') }}</option>
                                @elseif(Auth::user()->hasRole('female'))
                                    <option value="4" selected>{{ trans('searchTitle.man1') }}</option>
                                @else
                                    <option value="5">{{ trans('searchTitle.woman1') }}</option>
                                    <option value="4">{{ trans('searchTitle.man1') }}</option>
                                @endif

                            </select>
                        </div>

                        <div class="form-group grg-search-input gla-search-inputblock">
                            <label class="gla-form-top-label" for="I">{{ trans('searchTitle.age') }}</label>
                            <select name="age_start" class="form-control">
                                @for($i = 18; $i < 60; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select> -
                            <select name="age_stop" class="form-control">
                                @for($i = 60; $i >= 18; $i--)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="form-group buttons_adv">
                            <button type="submit" class="btn btn-white">
                                {{ trans('searchTitle.findAPerson') }}<i class="fa fa-search"></i>
                            </button>
                            <a class="gla-advancedSearch" href="/search">{{ trans('searchTitle.advancedSearch') }}</a>
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>