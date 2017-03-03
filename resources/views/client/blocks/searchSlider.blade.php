<div class="header-bg">
    <div class="container">
        {!! Form::open(['url' => '#', 'method' => 'POST', 'class' => 'form-search form-inline']) !!}
        <div class="short_search_wrapper bg-default col-md-3">
                <div class="search-form">
                    <div class="form-header text-center">
                        <h4>{{ trans('searchTitle.seriousDatingWithSweetDate') }}</h4>
                    </div>
                        <div class="text-right">
                            <!-- Поле "Я ищу" -->
                            <!-- Незарегистрированный пользователь может выбрать мужчину и женщину-->
                            <!-- Мужчина может выбрать только женщину, женщина - только мужчину -->
                            <div class="form-group grg-search-input">
                                <label for="looking">{{ trans('searchTitle.lookingForA') }}</label>
                                <select name="looking" class="form-control">
                                    @if(!Auth::user())
                                        <option value="5">{{ trans('searchTitle.woman1') }}</option>
                                        <option value="4">{{ trans('searchTitle.man1') }}</option>
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

                            <div class="form-group grg-search-input">
                                <label for="I">{{ trans('searchTitle.age') }}</label>
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
                        </div>
                </div>
            </div>
			<div class="col-md-1"></div>
            <div class="col-md-8 short_search_wrapper bg-default">
                <div class="search-form">
                    <div class="form-header">
                        <h4> {{ trans('search.filter') }} </h4>
                    </div>
                    <div class="form-search">
	                    <div class="row">
                            <div class="col-md-3 col-sm-3">
                                <div class="form-group grg-search-input">
                                    <label for="is_online">{{ trans('users.online') }} </label>
                                    <select name="is_online" class="form-control">
                                        <option value="0">---</option>
                                        <option value="1">{{ trans('answer.yes') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-3">
                                <div class="form-group grg-search-input">
                                    <label for="is_avatar">{{ trans('users.photo') }} </label>
                                    <select name="is_avatar" class="form-control">
                                        <option value="0">---</option>
                                        <option value="1">{{ trans('answer.yes') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group grg-search-input">
                                    {!! Form::label('coutry', trans('profile.country')) !!}
                                    <select name="country" class="form-control grg-long-select">
                                        <option value="false" selected>---</option>
                                        @foreach($countries as $country)
                                            <option value="{{ $country->id }}"> {{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div><!-- .row -->
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group grg-search-input">
                                    {!! Form::label('education', trans('profile.education')) !!}
                                    <select name="education" class="form-control">
                                        @foreach($selects['education'] as $education)
                                            <option value="{{ $education }}">{{ trans('profile.'.$education) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group grg-search-input">
                                    <label for="religion">{{ trans('profile.religion') }}</label>
                                    <select name="religion" class="form-control">
                                        @foreach($selects['religion'] as $religion)
                                            <option value="{{ $religion }}">{{ trans('profile.'.$religion) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group grg-search-input">
                                    <label for="kids">{{ trans('profile.kids') }}</label>
                                    <select name="kids" class="form-control">
                                        @foreach($selects['kids'] as $kids)
                                            <option value="{{ $kids }}">{{ trans('profile.'.$kids) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group grg-search-input">
                                    <label for="want_kids">{{ trans('profile.want_kids') }}</label>
                                    <select name="want_kids" class="form-control">
                                        @foreach($selects['want_kids'] as $want_kids)
                                            <option value="{{ $want_kids }}">{{ trans('profile.'.$want_kids) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div><!-- .row -->
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group grg-search-input">
                                    <label for="smoke">{{ trans('profile.smoke') }}</label>
                                    <select name="smoke" class="form-control">
                                        @foreach($selects['smoke'] as $smoke)
                                            <option value="{{ $smoke }}">{{ trans('profile.'.$smoke) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group grg-search-input">
                                    <label for="drink">{{ trans('profile.drink') }}</label>
                                    <select name="drink" class="form-control">
                                        @foreach($selects['drink'] as $drink)
                                            <option value="{{ $drink }}">{{ trans('profile.'.$drink) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div><!-- .row -->
                        <div class="row">
	                        <div class="col-md-12 col-xs-12 form-group">
	                            <button type="submit" class="btn btn-white">
	                                <i class="fa fa-search"></i>{{ trans('profile.findAPerson') }}
	                            </button>
	                        </div>
	                    </div>
                    </div><!-- .row -->
                </div>
            </div>
        {!! Form::close() !!}
    </div>
</div>
