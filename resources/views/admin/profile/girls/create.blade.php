@extends('admin.layout')

@section('styles')
    <!-- ink href="{{ url('/assets/css/bootstrap-reset.css') }}" rel="stylesheet" -->
    <link href="{{ url('/assets/css/fileinput.css') }}" rel="stylesheet">

    <style>
        .file-input.file-input-new,#status .file-input{
            position: relative !important;
        }
        .file-input{
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            top: 0;
            overflow: visible;
            background-color: white;

        }
        .red{
            color:red!important;
        }
        #profile_foto .file-input{
            position: relative!important;
        }
        .file-drop-zone-title{
            opacity: 0!important;
        }
        .kv-file-upload.btn.btn-xs.btn-default{
            display:none;
        }
    </style>

@stop

@section('content')

    <section class="panel">
        <header class="panel-heading">
            Добавить новую анкету
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

            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#osn" aria-controls="osn" role="tab" data-toggle="tab" id="open_main">Основная информация профиля</a></li>
                <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab" id="open_additional">Данные профиля</a></li>
                <li role="presentation"><a href="#profile_foto" aria-controls="profile_fot" role="tab" data-toggle="tab" id="profile_fo">Фото профиля</a></li>
                <li role="presentation"><a href="#status" aria-controls="status" role="tab" data-toggle="tab" id="open_partner">Партнерская информация</a></li>
            </ul>
                {!! Form::open(['url' => 'admin/girl/store', 'class' => 'form', 'method' => 'POST', 'files' => true]) !!}
            <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="osn">
                        <div class="col-md-12 text-center">
                            <h3> Основная информация профиля </h3>
                            <div class="avatar_block col-md-12">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        {!! Form::label('avatar', 'Аватар') !!}<br/>
                                        <div class="img_avatar" style="max-height: 445px;display: inline-block;width: 100%;"><img width="373rem" style="max-width: 100%;width: auto;height: auto;    max-height: 445px;" src="/uploads/empty_girl.png" id="preview-avatar"></div>
                                        <input type="file" class="form-control file" name="avatar" accept="image/*" value="/uploads/empty_girl.png">
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group col-md-6">
                                        {!! Form::label('webcam', 'Вебкамера') !!}
                                        <input type="checkbox" name="webcam">
                                    </div>
                                    <div class="form-group col-md-6">
                                        {!! Form::label('hot', 'Hot Block') !!}
                                        <input type="checkbox" name="hot">
                                    </div>
                                    <div class="form-group  col-md-4">
                                        <label for="first_name">Имя<span class="red">*</span></label>
                                        {!! Form::text('first_name', '', ['class'=>'form-control', 'placeholder' => 'Name']) !!}
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="second_name">Фамилия<span class="red">*</span></label>
                                        {!! Form::text('second_name', '', ['class'=>'form-control', 'placeholder' => 'Surname']) !!}
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="birthday">Дата рождения<span class="red">*</span></label>
                                        {!! Form::text('birthday', '', ['class'=>'form-control', 'id'=>'datepicker-birthday2', 'placeholder'=>'yyyy-mm-dd']) !!}
                                    </div>

                                    <div class="info col-md-4">
                                        <div class="form-group">
                                            <label for="email">Email<span class="red">*</span></label>
                                            {!! Form::email('email', '', ['class' => 'form-control', 'placeholder' => 'email@email.com']) !!}
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="phone">Phone<span class="red">*</span></label>
                                        {!! Form::text('phone', '', ['class' => 'form-control' ]) !!}
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="password">Password<span class="red">*</span></label>
                                        {!! Form::password('password', ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="coutry">Cтрана<span class="red">*</span></label>
                                        <select name="country" class="form-control">
                                            @foreach($countries as $country)
                                                <option value="{{ $country->id }}"> {{ $country->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="state">Штат<span class="red">*</span></label>
                                        {!! Form::hidden('user_state_id', '' ) !!}
                                        <select name="state" class="form-control"></select>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="city">Город<span class="red">*</span></label>
                                        {!! Form::hidden('user_city_id', '' ) !!}
                                        <select name="city" class="form-control"></select>
                                    </div>
                                </div>
                                <div class="form-group text-center col-md-12">
                                    <a style="color: white;background-color: gray;" class="btn btn-next next" onClick="next_click();">Далее</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="profile_foto">
                        <div class="col-md-12">
                            <h3 class="text-center"> Фотографии профиля (максимально 10 фото) </h3>
                            <div class="form-group col-md-12">
                                <div class="form-group">
                                    <input type="file" name="profile_photo[]" class="file" accept="image/*" multiple>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="profile">
                        <div class="col-md-12">
                            <h3 class="text-center"> Дополнительная информация профиля </h3>
                            <div class="form-group col-md-4">
                                {!! Form::label('height', 'Рост (см)') !!}
                                {!! Form::text('height', '', ['class' => 'form-control']) !!}
                            </div>
                            <div class="form-group col-md-4">
                                {!! Form::label('weight', 'Вес (кг)') !!}
                                {!! Form::text('weight', '', ['class' => 'form-control']) !!}
                            </div>
                            <div class="form-group col-md-4">
                                {!! Form::label('occupation', 'Род деятельности') !!}
                                {!! Form::text('occupation', '', ['class' => 'form-control']) !!}
                            </div>
                            <div class="form-group col-md-4">
                                {!! Form::label('eyes', 'Цвет глаз') !!}
                                <select name="eyes" class="form-control">
                                    @foreach($selects['eyes'] as $eyes)
                                        <option value="{{ $eyes }}" >{{ trans('profile.'.$eyes) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                {!! Form::label('hair', 'Цвет волос') !!}
                                <select name="hair" class="form-control">
                                    @foreach($selects['hair'] as $hair)
                                        <option value="{{ $hair }}" >{{ trans('profile.'.$hair) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                {!! Form::label('education', 'Образование') !!}
                                <select name="education" class="form-control">
                                    @foreach($selects['education'] as $education)
                                        <option value="{{ $education }}" >{{ trans('profile.'.$education) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                {!! Form::label('kids', 'Дети') !!}
                                <select name="kids" class="form-control">
                                    @foreach($selects['kids'] as $kids)
                                        <option value="{{ $kids }}" >{{ trans('profile.'.$kids) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                {!! Form::label('kids_live', 'Проживание детей')!!}
                                <select name="kids_live" class="form-control">
                                    @foreach($selects['kids_live'] as $kids_live)
                                        <option value="{{ $kids_live }}" >{{ trans('profile.'.$kids_live) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                {!! Form::label('want_kids', 'Желание завести детей') !!}
                                <select name="want_kids" class="form-control">
                                    @foreach($selects['want_kids'] as $want_kids)
                                        <option value="{{ $want_kids }}" >{{ trans('profile.'.$want_kids) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                {!! Form::label('family', 'Семейное положение') !!}
                                <select name="family" class="form-control">
                                    @foreach($selects['family'] as $family)
                                        @if($family == '---')
                                            <option value="---">---</option>
                                        @else
                                            <option value="{{ $family }}">{{ trans('profile.'.$family.'_female') }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                {!! Form::label('religion', 'Вероисповедание') !!}
                                <select name="religion" class="form-control">
                                    @foreach($selects['religion'] as $religion)
                                        <option value="{{ $religion }}" >{{ trans('profile.'.$religion) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                {!! Form::label('finance_income', 'Доход') !!}
                                <select name="finance_income" class="form-control">
                                    @foreach($selects['finance_income'] as $finance_income)
                                        <option value="{{ $finance_income }}" >{{ trans('profile.'.$finance_income) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                {!! Form::label('know_lang', 'Знание языков') !!}
                                {!! Form::text('know_lang','', ['class' => 'form-control']) !!}
                            </div>
                            <div class="form-group col-md-4">
                                {!! Form::label('english_level', 'Знание Английского') !!}
                                <select name="english_level" class="form-control">
                                    @foreach($selects['english_level'] as $english_level)
                                        <option value="{{ $english_level }}" >{{ trans('profile.'.$english_level) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                {!! Form::label('smoke', 'Отношение к курению') !!}
                                <select name="smoke" class="form-control">
                                    @foreach($selects['smoke'] as $smoke)
                                        <option value="{{ $smoke }}" >{{ trans('profile.'.$smoke) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                {!! Form::label('drink', 'Отношение к алкоголю') !!}
                                <select name="drink" class="form-control">
                                    @foreach($selects['drink'] as $drink)
                                        <option value="{{ $drink }}" >{{ trans('profile.'.$drink) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-12">
                                {!! Form::label('about', 'О девушке ') !!}
                                <textarea class="form-control" name="about" style="height: 152px;"></textarea>
                            </div>

                            <div class="form-group col-md-12" style="padding: 0;">
                                <div class="form-group col-md-8">
                                    {!! Form::label('looking', 'О партнере ') !!}
                                    <textarea class="form-control" name="looking" style="height: 152px;"></textarea>
                                </div>
                                <div class="form-group col-md-4">
                                    <div class="col-md-6">
                                        {!! Form::label('l_age_start', 'Возраст от:') !!}
                                        {!! Form::number('l_age_start', 18, ['class' => 'form-control']) !!}
                                    </div>

                                    <div class="col-md-6">
                                        {!! Form::label('l_age_stop', 'До:') !!}
                                        {!! Form::number('l_age_stop', 99, ['class' => 'form-control']) !!}
                                    </div>

                                    <div class="col-md-6">
                                        {!! Form::label('l_height_start', 'Рост (см) от:') !!}
                                        {!! Form::number('l_height_start', 0, ['class' => 'form-control']) !!}
                                    </div>

                                    <div class="col-md-6">
                                        {!! Form::label('l_height_stop', 'До:') !!}
                                        {!! Form::number('l_height_stop', 250, ['class' => 'form-control']) !!}
                                    </div>

                                    <div class="col-md-6">
                                        {!! Form::label('l_weight_start', 'Вес (кг) от:') !!}
                                        {!! Form::number('l_weight_start', 0, ['class' => 'form-control']) !!}
                                    </div>

                                    <div class="col-md-6">
                                        {!! Form::label('l_weight_stop', 'До:') !!}
                                        {!! Form::number('l_weight_stop', 500, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    {!! Form::label('l_horoscope_id', 'Знак зодиака партнера:') !!}
                                    <select name="l_horoscope_id" id="l_horoscope_id" class="form-control">
                                        <option value="---">---</option>
                                        @foreach($zodiac_list as $key=>$zodiac)
                                                <option value="{!! $key !!}">{{ trans('horoscope.'.$zodiac) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group text-center col-md-12">
                                <a style="color: white;background-color: gray;" class="btn btn-next next" onclick="next_click1();">Далее</a>
                            </div>
 
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="status">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="passno">№ паспорта<span class="red">*</span></label>
                                    {!! Form::text('passno', '', ['class' => 'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    <label for="pass_date">Дата выдачи паспорта<span class="red">*</span></label>
                                    {!! Form::text('pass_date', '', ['class'=>'form-control', 'id'=>'datepicker-pass_date2', 'placeholder'=>'yyyy-mm-dd']) !!}
                                </div>
                                <div class="form-group">
                                    <label for="pass_photo">Фото/Скан паспорта<span class="red">*</span></label>
                                    <input type="file" class="form-control file" name="pass_photo" value=""  accept="image/*"><!--disabled="disabled"-->
                                </div>

                                <div class="form-group col-md-12 text-center">
                                    {!! Form::submit(trans('buttons.save'), ['class' => 'btn btn-success']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
        </div>
    </section>

@stop

@section('scripts')
    <!--<script type="text/javascript" src="{{ url('/assets/js/jquery-ui_jquery-ui-1.10.1.custom.min.js') }}"></script>-->

    <!--bootstrap picker-->

    <script type="text/javascript" src="{{ url('/assets/js/bootstrap-fileinput-master/js/fileinput.js') }}"></script>
    <script type="text/javascript" src="{{ url('/assets/js/file-input-init.js') }}"></script>

    <script>
        function next_click() {

                $('#open_additional').trigger('click');
                return false;

        }
        function next_click1() {

                $('#open_partner').trigger('click');
                return false;

        }
        function refreshCities(){
            $.ajax({
                type: 'POST',
                url: '{{ url('/get/cities/') }}',
                data: {id: $('select[name="state"]').val(), _token: $('input[name="_token').val() },
                success: function( response ){
                    $('select[name="city"]').empty();
                    for ( var i = 0; i < response.length; i++)
                    {
                        $('select[name="city"]').append("<option value='" + response[i].id + "'>" + response[i].name + "</option>");
                    }
                },
                error: function( response ){
                    console.log( response );
                }
            });
        }
        function refreshRegions() {
            $('select[name="city"]').empty();
            $.ajax({
                type: 'POST',
                url: '{{ url('/get/states/')  }}',
                data: {id: $('select[name="country"]').val(), _token: $('input[name="_token"]').val()  },
                success: function( response ){
                    $('select[name="state"]').empty();
                    for( var i = 0; i < response.length; i++ )
                    {
                        $('select[name="state"]').append("<option value='" + response[i].id + "'>" + response[i].name + "</option>");
                    }
                    refreshCities();
                },
                error: function( response ){
                    console.log( response )
                }
            });
        }
        $(window).on('load', function(){
            refreshRegions();
        });
        $(function() {
            $('select[name="country"]').on('change', function(){
                $('select[name="state"]').empty();
                $('select[name="city"]').empty();
                refreshRegions();
            });
            $('select[name="state"]').on('change', function(){
                refreshCities();
            });
        });
    </script>
@stop