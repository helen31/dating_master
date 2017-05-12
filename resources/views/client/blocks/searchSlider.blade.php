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
                                <label for="age_start">{{ trans('searchTitle.age') }}</label>
                                <select name="age_start" class="form-control">

                                    @for($i = 18; $i < 99; $i++)
                                        <option value="{{ $i }}"
                                                {{ (isset($search_attrs['age_start']) && $search_attrs['age_start'] == $i) ? 'selected' : ''}}
                                        >{{ $i }}</option>
                                    @endfor
                                </select> -
                                <select name="age_stop" class="form-control">
                                    @for($i = 99; $i >= 18; $i--)
                                        <option value="{{ $i }}"
                                                {{ (isset($search_attrs['age_stop']) && $search_attrs['age_stop'] == $i) ? 'selected' : ''}}
                                        >{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="form-group grg-search-input">
                                <label for="user_weight">{{ trans('profile.weight') }}</label>
                                <select name="weight_start" class="form-control">

                                    @for($i = 35; $i < 250; $i++)
                                        <option value="{{ $i }}"
                                                {{ (isset($search_attrs['weight_start']) && $search_attrs['weight_start'] == $i) ? 'selected' : ''}}
                                        >{{ $i }}</option>
                                    @endfor
                                </select> -
                                <select name="weight_stop" class="form-control">
                                    @for($i = 250; $i >= 35; $i--)
                                        <option value="{{ $i }}"
                                                {{ (isset($search_attrs['weight_stop']) && $search_attrs['weight_stop'] == $i) ? 'selected' : ''}}
                                        >{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="form-group grg-search-input">
                                <label for="user_height">{{ trans('profile.height') }}</label>
                                <select name="height_start" class="form-control">
                                    @for($i = 80; $i < 250; $i++)
                                        <option value="{{ $i }}"
                                                {{ (isset($search_attrs['height_start']) && $search_attrs['height_start'] == $i) ? 'selected' : ''}}
                                        >{{ $i }}</option>
                                    @endfor
                                </select> -
                                <select name="height_stop" class="form-control">
                                    @for($i = 250; $i >= 90; $i--)
                                        <option value="{{ $i }}"
                                                {{ (isset($search_attrs['height_stop']) && $search_attrs['height_stop'] == $i) ? 'selected' : ''}}
                                        >{{ $i }}</option>
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
                                        <option value="0"
                                            {{ (isset($search_attrs['is_online']) && $search_attrs['is_online'] == 0) ? 'selected' : ''}}
                                        >---</option>
                                        <option value="1"
                                            {{ (isset($search_attrs['is_online']) && $search_attrs['is_online'] == 1) ? 'selected' : ''}}
                                        >{{ trans('answer.yes') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-3">
                                <div class="form-group grg-search-input">
                                    <label for="is_avatar">{{ trans('users.photo') }} </label>
                                    <select name="is_avatar" class="form-control">
                                        <option value="0"
                                            {{ (isset($search_attrs['is_avatar']) && $search_attrs['is_avatar'] == 0) ? 'selected' : ''}}
                                        >---</option>
                                        <option value="1"
                                            {{ (isset($search_attrs['is_avatar']) && $search_attrs['is_avatar'] == 1) ? 'selected' : ''}}
                                        >{{ trans('answer.yes') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group grg-search-input">
                                    {!! Form::label('country_id', trans('profile.country')) !!}
                                    <select name="country_id" class="form-control grg-long-select">
                                        <option value="---">---</option>
                                        <option value="3159">{{ trans('users.Russia') }}</option>
                                        <option value="9908">{{ trans('users.Ukraine') }}</option>
                                        <option value="---">---</option>
                                        @foreach($countries as $country)
                                            <option value="{{ $country->id }}"
                                                {{ (isset($search_attrs['country_id']) && $search_attrs['country_id'] == $country->id) ? 'selected' : ''}}>
                                                @if($locale == 'ru')
                                                    {{ $country->name }}
                                                @else
                                                    {{ $country->name_en }}
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group grg-search-input">
                                    {!! Form::label('city_id', trans('profile.city')) !!}
                                    <select name="city_id" class="form-control grg-long-select">
                                        <option value="---">---</option>
                                        <option value="10252">{{ trans('search.Simferopol') }}</option>
                                        <option value="10251">{{ trans('search.Sevastopol') }}</option>
                                        <option value="10398">{{ trans('search.Odessa') }}</option>
                                        <option value="10184">{{ trans('search.Kiev') }}</option>
                                        <option value="10532">{{ trans('search.Kharkiv') }}</option>
                                        <option value="10367">{{ trans('search.Mykolaiv') }}</option>
                                        <option value="4962">{{ trans('search.Saint_Petersburg') }}</option>
                                        <option value="4400">{{ trans('search.Moscow') }}</option>
                                        <option value="4079">{{ trans('search.Krasnodar') }}</option>
                                        <option value="10119">{{ trans('search.Zaporizhzhya') }}</option>
                                        <option value="10337">{{ trans('search.Lviv') }}</option>
                                    </select>
                                </div>
                            </div>
                        </div><!-- .row -->
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group grg-search-input">
                                    {!! Form::label('education', trans('profile.education')) !!}
                                    <select name="education[]" class="form-control" multiple>
                                        @foreach($selects['education'] as $education)
                                            <option value="{{ $education }}"
                                                {{ (isset($search_attrs['education']) && in_array($education, $search_attrs['education'])) ? 'selected' : ''}}
                                            >{{ trans('profile.'.$education) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group grg-search-input">
                                    <label for="religion">{{ trans('profile.religion') }}</label>
                                    <select name="religion[]" class="form-control" multiple>
                                        @foreach($selects['religion'] as $religion)
                                            <option value="{{ $religion }}"
                                                    {{ (isset($search_attrs['religion']) && in_array($religion, $search_attrs['religion'])) ? 'selected' : ''}}
                                            >{{ trans('profile.'.$religion) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group grg-search-input">
                                    <label for="hair">{{ trans('profile.hair') }}</label>
                                    <select name="hair[]" class="form-control" multiple>
                                        @foreach($selects['hair'] as $hair)
                                            <option value="{{ $hair }}"
                                                    {{ (isset($search_attrs['hair']) && in_array($hair, $search_attrs['hair'])) ? 'selected' : ''}}
                                            >{{ trans('profile.'.$hair) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group grg-search-input">
                                    <label for="eyes">{{ trans('profile.eyes') }}</label>
                                    <select name="eyes[]" class="form-control" multiple>
                                        @foreach($selects['eyes'] as $eyes)
                                            <option value="{{ $eyes }}"
                                                    {{ (isset($search_attrs['eyes']) && in_array($eyes, $search_attrs['eyes'])) ? 'selected' : ''}}
                                            >{{ trans('profile.'.$eyes) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group grg-search-input">
                                    <label for="family">{{ trans('profile.family') }}</label>
                                    <select name="family[]" class="form-control" multiple>
                                        @foreach($selects['family'] as $family)
                                            <option value="{{ $family }}"
                                                    {{ (isset($search_attrs['family']) && in_array($family, $search_attrs['family'])) ? 'selected' : ''}}
                                            >{{ ($family == '---') ? '---' : trans('profile.'.$family.'_'.$required_gender) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group grg-search-input">
                                    <label for="zodiac">{{ trans('profile.zodiac') }}</label>
                                    <select name="zodiac[]" class="form-control" multiple>
                                        @foreach($selects['zodiac'] as $zodiac)
                                            <option value="{{ $zodiac }}"
                                                    {{ (isset($search_attrs['zodiac']) && in_array($zodiac, $search_attrs['zodiac'])) ? 'selected' : ''}}
                                            >{{ ($zodiac == '---') ? '---' : trans('horoscope.'.$zodiac) }}</option>
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
