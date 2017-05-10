@extends('client.profile.profile')

@section('styles')
    <link href="{{ url('/assets/css/bootstrap-reset.css') }}" rel="stylesheet">
    <link href="{{ url('/assets/css/fileinput.css') }}" rel="stylesheet">
    <link href="{{ url('assets/css/datepicker.css') }}" rel="stylesheet">

@stop

@section('profileContent')
    <section class="panel panel-default">
        <header class="panel-heading">
            {{ trans('profile.edit') }}
            @if(Auth::user()->status_id != 6)
                @if(Auth::user()->status_id == 2)
                    <a href="{{ url(App::getLocale().'/profile/activate/'.Auth::user()->id) }}" class="btn btn-success btn-xs" >
                        <i class="fa fa-arrow-up"></i>  {{ trans('profile.activate') }}
                    </a>
                @else
                    <a href="{{ url(App::getLocale().'/profile/deactivate/'.Auth::user()->id) }}" class="btn btn-warning btn-xs" >
                        <i class="fa fa-pause"></i>  {{ trans('profile.deactivate') }}
                    </a>
                @endif
                <a href="{{ url(App::getLocale().'/profile/drop/'.Auth::user()->id) }}" class="btn btn-danger btn-xs" >
                    <i class="fa fa-trash-o"></i>  {{ trans('profile.drop') }}
                </a>
            @endif
        </header>

        <div class="panel-body">
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {!! Form::open(['url' => '/profile/update/'.$id, 'class' => 'form', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}

                        <div class="col-md-6">
                            <h3> {{ trans('profile.primary') }}</h3>
                            <div class="form-group">
                                {!! Form::label('avatar', trans('profile.avatar')) !!}<br/>
                                <img class="img-responsive" src="{{ url('/uploads/users/avatars/'. $user->avatar) }}" id="preview-avatar">
                                <input type="file" class="form-control file" name="avatar" accept="image/*" value="{{ $user->avatar }}" data-show-upload="false" data-show-caption="true">
                            </div>
                            <p class="text-danger">* {{ trans('profile.required_fields') }}</p>
                            <div class="form-group">
                                {!! Form::label('first_name', trans('profile.first_name')) !!}<span class="text-danger">*</span>
                                {!! Form::text('first_name', !empty($user->first_name) ? $user->first_name : '', ['class'=>'form-control', 'required'=>'required', 'placeholder' => trans('profile.placeholder_name')]) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('second_name', trans('profile.last_name')) !!}<span class="text-danger">*</span>
                                {!! Form::text('second_name', !empty($user->last_name) ? $user->last_name : '', ['class'=>'form-control', 'required'=>'required', 'placeholder' => trans("profile.placeholder_surname")]) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('birthday', trans('profile.birthday')) !!}<span class="text-danger">*</span>
                                {!! Form::date('birthday', $user->profile->birthday, ['class'=>'form-control', 'required'=>'required']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('email',trans('profile.email')) !!}<span class="text-danger">*</span>
                                {!! Form::email('email', !empty($user->email) ? $user->email : '', ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'email@email.com']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('phone', trans('profile.phone')) !!}<span class="text-danger">*</span>
                                {!! Form::text('phone', !empty($user->phone) ? $user->phone : '', ['class' => 'form-control', 'required' => 'required']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('password', trans('profile.password')) !!}
                                {!! Form::password('password', ['class' => 'form-control', ]) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('coutry', trans('profile.country')) !!}<span class="text-danger">*</span>
                                <select name="country" class="form-control">
                                    @foreach($countries as $country)
                                        <option value="{{ $country->id }}"
                                                @if( $country->id == $user->country_id )
                                                selected="selected"
                                                @endif
                                        >
                                            @if(\App::getLocale()=="ru")
                                                {{ $country->name }}
                                            @else
                                                {{ $country->name_en }}
                                            @endif
                                            </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                {!! Form::label('state', trans('profile.state') ) !!}<span class="text-danger">*</span>
                                {!! Form::hidden('user_state_id', $user->state_id ) !!}
                                <select name="state" class="form-control"></select>
                            </div>
                            <div class="form-group">
                                {!! Form::label('city', trans('profile.city') ) !!}<span class="text-danger">*</span>
                                {!! Form::hidden('user_city_id', $user->city_id ) !!}
                                <select name="city" class="form-control"></select>
                            </div>
                            <div class="form-group">
                                {!! Form::label('about', trans('profile.about') ) !!}
                                {!! Form::textarea('about', !empty($user->profile->about) ? $user->profile->about : '', ['class' => 'form-control']) !!}
                            </div>
                            @if(\Auth::user()->hasRole('female'))
                                <h3>{{ trans('profile.passport_data') }}</h3>
                                <div class="form-group">
                                    <label for="passno">{{ trans('profile.passno') }}</label><span class="text-danger">*</span>
                                    {!! Form::text('passno', !empty($passport->passno) ? $passport->passno : '', ['class' => 'form-control', 'required' => 'required']) !!}
                                </div>
                                <div class="form-group">
                                    <label for="pass_date">{{ trans('profile.pass_date') }}</label><span class="text-danger">*</span>
                                    {!! Form::date('pass_date', !empty($passport->date) ? $passport->date : '', ['class'=>'form-control', 'required' => 'required']) !!}
                                </div>
                                <div class="form-group">
                                    <label for="pass_photo">{{ trans('profile.pass_photo') }}</label><span class="text-danger">*</span>
                                    <img class="img-responsive" src="{{ url('/uploads/users/passports/'.  ((isset($passport->cover))?$passport->cover:"")) }}">
                                    <input type="file" class="form-control file" name="pass_photo" value=""  accept="image/*" data-show-upload="false" data-show-caption="true">
                                </div>
                            @endif
                        </div>


                        <div class="col-md-6">
                            <h3>{{trans('profile.lookingFor')}}</h3>
                            <div class="form-group">
                                {!! Form::label('l_age_start', trans('profile.l_age_start') ) !!}
                                {!! Form::number('l_age_start', !empty($user->profile->l_age_start) ? $user->profile->l_age_start : 18, ['class' => 'form-control'] )!!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('l_age_stop', trans('profile.l_age_stop') ) !!}
                                {!! Form::number('l_age_stop', !empty($user->profile->l_age_stop) ? $user->profile->l_age_stop : 99, ['class' => 'form-control'] )!!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('l_height_start', 'Рост (см) от:') !!}
                                {!! Form::number('l_height_start', !empty($user->profile->l_height_start) ? $user->profile->l_height_start : 0, ['class' => 'form-control']) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('l_height_stop', 'До:') !!}
                                {!! Form::number('l_height_stop', !empty($user->profile->l_height_stop) ? $user->profile->l_height_stop : 220, ['class' => 'form-control']) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('l_weight_start', 'Вес (кг) от:') !!}
                                {!! Form::number('l_weight_start', !empty($user->profile->l_weight_start) ? $user->profile->l_weight_start : 0, ['class' => 'form-control']) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('l_weight_stop', 'До:') !!}
                                {!! Form::number('l_weight_stop', !empty($user->profile->l_weight_stop) ? $user->profile->l_weight_stop : 500, ['class' => 'form-control']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('looking', trans('profile.looking') ) !!}
                                {!! Form::textarea('looking', !empty($user->profile->looking) ? $user->profile->looking : '', ['class' => 'form-control'] )!!}
                            </div>
                            <h3> {{trans('profile.additionalInformation')}} </h3>
                            <div class="form-group">
                                {!! Form::label('height', trans('profile.height') ) !!}
                                {!! Form::text('height', !empty($user->profile->height) ? $user->profile->height : '' , ['class' => 'form-control']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('weight', trans('profile.weight') ) !!}
                                {!! Form::text('weight', !empty($user->profile->weight) ? $user->profile->weight : '', ['class' => 'form-control']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('eyes', trans('profile.eyes') ) !!}
                                <select name="eyes" class="form-control">
                                    @foreach($selects['eyes'] as $eyes)
                                        <option value="{{ $eyes }}" {{ (!empty($user->profile->eyes) && $eyes == $user->profile->eyes)?'selected':'' }}>{{ trans('profile.'.$eyes) }}</option>
                                    @endforeach
                                </select>
			                </div>
                            <div class="form-group">
                                {!! Form::label('hair', trans('profile.hair') ) !!}
                                <select name="hair" class="form-control">
                                    @foreach($selects['hair'] as $hair)
                                        <option value="{{ $hair }}" {{ (!empty($user->profile->hair) && $hair == $user->profile->hair)?'selected':'' }}>{{ trans('profile.'.$hair) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                {!! Form::label('education', trans('profile.education') ) !!}
                                <select name="education" class="form-control">
                                    @foreach($selects['education'] as $education)
                                        <option value="{{ $education }}" {{ (!empty($user->profile->education) && $education == $user->profile->education)?'selected':'' }}>{{ trans('profile.'.$education) }}</option>
                                    @endforeach
                                </select>
			                </div>
                            <div class="form-group">
                                {!! Form::label('occupation', trans('profile.occupation') ) !!}
                                {!! Form::text('occupation', !empty($user->profile->occupation) ? $user->profile->occupation : '', ['class' => 'form-control']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('finance_income', trans('profile.finance_income') ) !!}
                                <select name="finance_income" class="form-control">
                                    @foreach($selects['finance_income'] as $finance_income)
                                        <option value="{{ $finance_income }}" {{ (!empty($user->profile->finance_income) && $finance_income == $user->profile->finance_income)?'selected':'' }}>{{ trans('profile.'.$finance_income) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- Селект family (семейное положение) учитывает пол пользователя - пример: женат/замужем -->
                            <div class="form-group">
                                {!! Form::label('family', trans('profile.family') ) !!}
                                <select name="family" class="form-control">
                                    @foreach($selects['family'] as $family)
                                        @if($family == '---')
                                            <option value="{{ $family }}" {{ (!empty($user->profile->family) && $family == $user->profile->family)?'selected':'' }}>{{ trans('profile.'.$family) }}</option>
                                        @else
                                            <option value="{{ $family }}" {{ (!empty($user->profile->family) && $family == $user->profile->family)?'selected':'' }}>
                                            {{ (!empty($user->profile->gender) && ($user->profile->gender == 'male' || $user->profile->gender == 'female')) ? trans('profile.'.$family.'_'.$user->profile->gender) : $family }}</option>
                                        @endif
                                    @endforeach
                                </select>
			                </div>
                            <div class="form-group">
                                {!! Form::label('kids', trans('profile.kids') ) !!}
                                <select name="kids" class="form-control">
                                    @foreach($selects['kids'] as $kids)
                                        <option value="{{ $kids }}" {{ (!empty($user->profile->kids) && $kids == $user->profile->kids)?'selected':'' }}>{{ trans('profile.'.$kids) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                {!! Form::label('kids_live', trans('profile.kids_live') ) !!}
                                <select name="kids_live" class="form-control">
                                    @foreach($selects['kids_live'] as $kids_live)
                                        <option value="{{ $kids_live }}" {{ (!empty($user->profile->kids_live) && $kids_live == $user->profile->kids_live)?'selected':'' }}>{{ trans('profile.'.$kids_live) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                {!! Form::label('want_kids', trans('profile.want_kids') ) !!}
                                <select name="want_kids" class="form-control">
                                    @foreach($selects['want_kids'] as $want_kids)
                                        <option value="{{ $want_kids }}" {{ (!empty($user->profile->want_kids) && $want_kids == $user->profile->want_kids)?'selected':'' }}>{{ trans('profile.'.$want_kids) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                {!! Form::label('english_level', trans('profile.english_level') ) !!}
                                <select name="english_level" class="form-control">
                                    @foreach($selects['english_level'] as $english_level)
                                        <option value="{{ $english_level }}" {{ (!empty($user->profile->english_level) && $english_level == $user->profile->english_level)?'selected':'' }}>{{ trans('profile.'.$english_level) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                {!! Form::label('know_lang', trans('profile.know_lang') ) !!}
                                {!! Form::text('know_lang', !empty($user->profile->know_lang) ? $user->profile->know_lang : '', ['class' => 'form-control']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('religion', trans('profile.religion') ) !!}
                                <select name="religion" class="form-control">
                                    @foreach($selects['religion'] as $religion)
                                        <option value="{{ $religion }}" {{ (!empty($user->profile->religion) && $religion == $user->profile->religion)?'selected':'' }}>{{ trans('profile.'.$religion) }}</option>
                                    @endforeach
                                </select>
			                </div>
                            <div class="form-group">
                                {!! Form::label('smoke', trans('profile.smoke') ) !!}
                                <select name="smoke" class="form-control">
                                    @foreach($selects['smoke'] as $smoke)
                                        <option value="{{ $smoke }}" {{ (!empty($user->profile->smoke) && $smoke == $user->profile->smoke)?'selected':'' }}>{{ trans('profile.'.$smoke) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                {!! Form::label('drink', trans('profile.drink') ) !!}
                                <select name="drink" class="form-control">
                                    @foreach($selects['drink'] as $drink)
                                        <option value="{{ $drink }}" {{ (!empty($user->profile->drink) && $drink == $user->profile->drink)?'selected':'' }}>{{ trans('profile.'.$drink) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                {!! Form::submit(trans('buttons.save'), ['class' => 'btn btn-success']) !!}
                            </div>
                        </div><!-- .col-md-6 -->
                {!! Form::close() !!}
        </div><!-- .panel-default -->
    </section>
@stop

@section('scripts')

    <script src="{{ url('/assets/js/bootstrap-datepicker.js') }}"></script>
    <script type="text/javascript" src="{{ url('/assets/js/bootstrap-fileinput-master/js/fileinput.js') }}"></script>
    <script type="text/javascript" src="{{ url('/assets/js/file-input-init.js') }}"></script>
    <script>

        function get_cities( $id )
        {
            $.ajax({
                type: 'POST',
                url: '{{ url('/get/cities/') }}',
                data: {id: $id, _token: $('input[name="_token').val() },
                success: function( response ){
                    $('select[name="city"]').empty();
                    for ( var i = 0; i < response.length; i++)
                    {
                        if( response[i].id == $('input[name="user_city_id"]').val() )
                            $('select[name="city"]').append("<option value='" + response[i].id + "'  selected='selected'>" +
                                    @if (\App::getLocale() == 'ru') response[i].name @else response[i].name_en @endif + "</option>");
                        else
                            $('select[name="city"]').append("<option value='" + response[i].id + "'>" +
                                    @if (\App::getLocale() == 'ru') response[i].name @else response[i].name_en @endif + "</option>");
                    }

                },
                error: function( response ){
                    console.log( response );
                }
            });
        }

        function get_states( $id )
        {
            $.ajax({
                type: 'POST',
                url: '{{ url('/get/states/') }}',
                data: {id: $id, _token: $('input[name="_token"]').val()  },
                success: function( response ){
                    $('select[name="state"]').empty();

                    for( var i = 0; i < response.length; i++ )
                    {
                        if( response[i].id == $('input[name="user_state_id"]').val() )
                            $('select[name="state"]').append("<option value='" + response[i].id + "' selected='selected'>" +
                                    @if (\App::getLocale() == 'ru') response[i].name @else response[i].name_en @endif + "</option>");
                        else
                            $('select[name="state"]').append("<option value='" + response[i].id + "'>" +
                                    @if (\App::getLocale() == 'ru') response[i].name @else response[i].name_en @endif + "</option>");
                    }
                },
                error: function( response ){
                    console.log( response )
                }
            });

            get_cities($('input[name="user_state_id"]').val());
        }

        $(window).on('load', function(){
            get_states( $('select[name="country"]').val() );
        });


        $(function() {

            $('.datepicker').datepicker({
                format: 'dd/mm/yyyy'
            });

            $('button.status').click(function(){

                $.ajax({
                    type: 'POST',
                    url: '{{ url('/admin/girl/changeStatus') }}',
                    data: { id: $('select[name="status"]').val(),
                        user_id: $('input[name="user_id"]').val(),
                        why: $('textarea[name="why"]').val(),
                        _token: $('input[name="_token"]').val() },
                    success: function( response ){
                        console.log(response);
                    },
                    error: function( response ){
                        console.log(response);
                    }
                });

            });

            $('input[name="avatar"]').change(function(){
                $('#preview-avatar').css('display', 'none');
            });
            $('input[name="pass_photo"]').change(function(){
                $('#preview-pass-photo').css('display', 'none');
            });

            $('select[name="country"]').on('change', function(){

                $('select[name="city"]').empty();

                $.ajax({
                    type: 'POST',
                    url: '{{ url('/get/states/')  }}',
                    data: {id: $(this).val(), _token: $('input[name="_token"]').val()  },
                    success: function( response ){
                        $('select[name="state"]').empty();
                        for( var i = 0; i < response.length; i++ )
                        {
                            $('select[name="state"]').append("<option value='" + response[i].id + "'>" +
                                    @if (\App::getLocale() == 'ru') response[i].name @else response[i].name_en @endif + "</option>");
                        }
                    },
                    error: function( response ){
                        console.log( response )
                    }
                });

            });

            $('select[name="state"]').on('change', function(){

                $.ajax({
                    type: 'POST',
                    url: '{{ url('/get/cities/') }}',
                    data: {id: $(this).val(), _token: $('input[name="_token').val() },
                    success: function( response ){
                        $('select[name="city"]').empty();
                        for ( var i = 0; i < response.length; i++)
                        {
                            $('select[name="city"]').append("<option value='" + response[i].id + "'>" +
                                    @if (\App::getLocale() == 'ru') response[i].name @else response[i].name_en @endif + "</option>");
                        }

                    },
                    error: function( response ){
                        console.log( response );
                    }
                })

            });

        });

        jQuery(window).on('load', function(){

            var city_id = $('input[name="city_id"]').val();

        });
    </script>
@stop