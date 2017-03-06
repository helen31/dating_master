@extends('admin.layout')

@section('styles')
    <link href="{{ url('/assets/css/bootstrap-reset.css') }}" rel="stylesheet">
    <link href="{{ url('/assets/css/fileinput.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ url('assets/css/datepicker.css') }}">
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
        .item.last_create a{
            opacity: 0.9;
            transition: 0.2s;
        }
        .item.last_create a:hover{
            opacity: 1;
            transition: 0.2s;
        }
        .delete_gallery{
            position: absolute;
            top: 0;
            background: red;
            color: white;
            /* right: 25px; */
            width: 25px;
            text-align: center;
            height: 25px;
            font-size: 20px;
            line-height: 25px;
            opacity: 0.7;
            transition: 0.3s;
            left: 0;
            right: 0;
            margin: auto;
        }
        .delete_gallery:hover{
            opacity: 1;
            transition: 0.3s;
            color: white;
        }
        .file-input.file-input-new,#profile_foto .file-input{
            position: relative !important;
        }
    </style>
@stop

@section('content')
    <section class="panel">
        <header class="panel-heading">
            Редактировать анкету
            @if(Auth::user()->hasRole('Partner'))
                @if($user->status_id == 2)
                    <a href="{{ url(App::getLocale().'/admin/partner/activate/'.$user->id) }}" class="btn btn-success btn-xs" >
                        <i class="fa fa-arrow-up"></i>  Активировать
                    </a>
                @else
                    <a href="{{ url(App::getLocale().'/admin/partner/deactivate/'.$user->id) }}" class="btn btn-warning btn-xs" >
                        <i class="fa fa-pause"></i>  Приостановить
                    </a>
                @endif
            @endif
            <a href="{{ url(App::getLocale().'/admin/girl/drop/'.$user->id) }}" class="btn btn-danger btn-xs" >
                <i class="fa fa-trash-o"></i>  Удалить анкету
            </a>
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

            <!-- Сообщение в админке, если профильт деактивирован или отклонен -->

            @if(($user->status_id == 2 || $user->status_id == 3) && $user->status_message != NULL )
                <div class="alert alert-info">
                    <p>Анкета приостановлена или отклонена</p>
                    <p><b><i>Причина:</i></b> {{ $user->status_message }}</p>
                </div>
            @endif

            <!-- Nav tabs -->

            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#osn" aria-controls="osn" role="tab" data-toggle="tab" id="open-main">Основная информация профиля</a></li>
                <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab" id="open-additional">Данные профиля</a></li>
                <li role="presentation"><a href="#profile_foto" aria-controls="profile_fot" role="tab" data-toggle="tab" id="profile_fo">Фото профиля</a></li>
                <li role="presentation"><a href="#status" aria-controls="status" role="tab" data-toggle="tab" id="open_partner">Партнерская информация</a></li>
                <li role="presentation"><a href="#photoalbums" aria-controls="photoalbums" role="tab" data-toggle="tab">Фотоальбомы</a></li>
            </ul>
            {!! Form::open(['url' => '#', 'class' => 'form', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}

                <!-- Основная информация профиля -->

                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="osn">
                        <div class="col-md-12 text-center">
                            <h3> Основная информация профиля </h3>
                            <div class="avatar_block col-md-12">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        {!! Form::label('avatar', 'Аватар') !!}<br/>
                                        <img class = "img-responsive" src="{{ url('/uploads/'. $user->avatar) }}" id="preview-avatar">
                                        <input type="file" class="form-control file" name="avatar" accept="image/*" >
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group col-md-6">
                                        {!! Form::label('webcam', 'Вебкамера') !!}
                                        <input type="checkbox" name="webcam"
                                               @if($user->webcam !== 0)
                                               checked
                                                @endif
                                        >
                                    </div>
                                    <div class="form-group col-md-6">
                                        {!! Form::label('hot', 'Hot Block') !!}
                                        <input type="checkbox" name="hot" {{ ($user->hot == 0) ?: 'checked' }}>
                                    </div>
                                    <div class="form-group  col-md-4">
                                        {!! Form::label('first_name', 'Имя') !!}
                                        {!! Form::text('first_name', $user->first_name, ['class'=>'form-control', 'placeholder' => 'Name']) !!}
                                    </div>

                                    <div class="form-group col-md-4">
                                        {!! Form::label('second_name', 'Фамилия') !!}
                                        {!! Form::text('second_name', $user->last_name, ['class'=>'form-control', 'placeholder' => 'Surname']) !!}
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="birthday">Дата рождения<span class="red">*</span></label>
                                        {!! Form::date('birthday', $user->profile->birthday, ['class'=>'form-control']) !!}
                                    </div>

                            <div class="info col-md-4">
                                <div class="form-group">
                                    {!! Form::label('email','Email') !!}
                                    {!! Form::email('email', $user->email, ['class' => 'form-control', 'placeholder' => 'email@email.com','disabled' => 'disabled', 'required' => 'required']) !!}
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                {!! Form::label('phone', 'Phone') !!}
                                {!! Form::text('phone', $user->phone, ['class' => 'form-control', 'disabled' => 'disabled']) !!}
                            </div>
                            <div class="form-group col-md-4">
                                {!! Form::label('password', 'Password') !!}
                                {!! Form::password('password', ['class' => 'form-control']) !!}
                            </div>
                            <div class="form-group col-md-4">
                                {!! Form::label('coutry', 'Cтрана') !!}
                                <select name="country" class="form-control">
                                    @foreach($countries as $country)
                                        <option value="{{ $country->id }}"
                                                @if( $country->id == $user->country_id )
                                                selected="selected"
                                                @endif
                                        > {{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                {!! Form::label('state', 'Регион / Штат') !!}
                                {!! Form::hidden('user_state_id', $user->state_id ) !!}
                                <select name="state" class="form-control"></select>
                            </div>

                            <div class="form-group col-md-4">
                                {!! Form::label('city', 'Город') !!}
                                {!! Form::hidden('user_city_id', $user->city_id ) !!}
                                <select name="city" class="form-control"></select>
                            </div>
                            <div class="form-group text-center col-md-12">
                                <a style="color: white;background-color: gray;" class="btn btn-next next" onClick="next_click('#open-additional');">Далее</a>
                            </div>
                            </div>
                            </div>
                        </div>
                    </div>

                    <!-- Фото профиля -->

                    <div role="tabpanel" class="tab-pane" id="profile_foto">
                        <div class="col-md-12">
                            <h3 class="text-center"> Фотографии профиля (макс. 10) </h3>
                            <div class="form-group col-md-12">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        @foreach($profile_images as $p_image)
                                            <div class="photo col-md-3" style="height: 200px;" id="photo-{{$p_image->id}}">
                                                <img src="{{ url('/uploads/'.$p_image->url) }}" width="100%">
                                                <a class="delete_gallery" href="#" onclick="deleteProfileFoto(event,'{{$p_image->id}}');"><i class="fa fa-trash-o"></i></a>
                                            </div>
                                        @endforeach
                                    </div>
                                    {!! Form::label(trans('profile_photo')) !!}
                                    <input id="profile_photo" type="file" name="profile_photo[]" multiple="multiple" class="file" accept="image/*">
                                </div>
                            </div>
                        </div>
                        <div class="form-group text-center col-md-12">
                            <a style="color: white;background-color: gray;" class="btn btn-next next" onClick="next_click('#open_partner');">Далее</a>
                        </div>
                    </div>

                    <!-- Дополнительная информация профиля -->

                    <div role="tabpanel" class="tab-pane" id="profile">
                        <div class="col-md-12">
                            <h3 class="text-center"> Дополнительная информация профиля </h3>
                            <div class="form-group col-md-4">
                                {!! Form::label('height', 'Рост (см)') !!}
                                {!! Form::text('height', $user->profile->height, ['class' => 'form-control']) !!}
                            </div>
                            <div class="form-group col-md-4">
                                {!! Form::label('weight', 'Вес (кг)') !!}
                                {!! Form::text('weight', $user->profile->weight, ['class' => 'form-control']) !!}
                            </div>
                            <div class="form-group col-md-4">
                                {!! Form::label('occupation', 'Род деятельности') !!}
                                {!! Form::text('occupation', $user->profile->occupation, ['class' => 'form-control']) !!}
                            </div>

                            <div class="form-group col-md-4">
                                {!! Form::label('eyes', 'Цвет глаз') !!}
                                <select name="eyes" class="form-control">
                                    @foreach($selects['eyes'] as $eyes)
                                        <option value="{{ $eyes }}" {{ (!empty($user->profile->eyes) && $eyes == $user->profile->eyes)?'selected':'' }}>{{ trans('profile.'.$eyes) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                {!! Form::label('hair', 'Цвет волос') !!}
                                <select name="hair" class="form-control">
                                    @foreach($selects['hair'] as $hair)
                                        <option value="{{ $hair }}" {{ (!empty($user->profile->hair) && $hair == $user->profile->hair)?'selected':'' }}>{{ trans('profile.'.$hair) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                {!! Form::label('education', 'Образование') !!}
                                <select name="education" class="form-control">
                                    @foreach($selects['education'] as $education)
                                        <option value="{{ $education }}" {{ (!empty($user->profile->education) && $education == $user->profile->education)?'selected':'' }}>{{ trans('profile.'.$education) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                {!! Form::label('kids', 'Дети') !!}
                                <select name="kids" class="form-control">
                                    @foreach($selects['kids'] as $kids)
                                        <option value="{{ $kids }}" {{ (!empty($user->profile->kids) && $kids == $user->profile->kids)?'selected':'' }}>{{ trans('profile.'.$kids) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                {!! Form::label('kids_live', 'Проживание детей')!!}
                                <select name="kids_live" class="form-control">
                                    @foreach($selects['kids_live'] as $kids_live)
                                        <option value="{{ $kids_live }}" {{ (!empty($user->profile->kids_live) && $kids_live == $user->profile->kids_live)?'selected':'' }}>{{ trans('profile.'.$kids_live) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                {!! Form::label('want_kids', 'Желание завести детей') !!}
                                <select name="want_kids" class="form-control">
                                    @foreach($selects['want_kids'] as $want_kids)
                                        <option value="{{ $want_kids }}" {{ (!empty($user->profile->want_kids) && $want_kids == $user->profile->want_kids)?'selected':'' }}>{{ trans('profile.'.$want_kids) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                {!! Form::label('family', 'Семейное положение') !!}
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
                            <div class="form-group col-md-4">
                                {!! Form::label('religion', 'Вероисповедание') !!}
                                <select name="religion" class="form-control">
                                    @foreach($selects['religion'] as $religion)
                                        <option value="{{ $religion }}" {{ (!empty($user->profile->religion) && $religion == $user->profile->religion)?'selected':'' }}>{{ trans('profile.'.$religion) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                {!! Form::label('finance_income', 'Доход') !!}
                                <select name="finance_income" class="form-control">
                                    @foreach($selects['finance_income'] as $finance_income)
                                        <option value="{{ $finance_income }}" {{ (!empty($user->profile->finance_income) && $finance_income == $user->profile->finance_income)?'selected':'' }}>{{ trans('profile.'.$finance_income) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                {!! Form::label('know_lang', 'Знание языков') !!}
                                {!! Form::text('know_lang', !empty($user->profile->know_lang) ? $user->profile->know_lang : '', ['class' => 'form-control']) !!}
                            </div>
                            <div class="form-group col-md-4">
                                {!! Form::label('english_level', 'Уровень английского') !!}
                                <select name="english_level" class="form-control">
                                    @foreach($selects['english_level'] as $english_level)
                                        <option value="{{ $english_level }}" {{ (!empty($user->profile->english_level) && $english_level == $user->profile->english_level)?'selected':'' }}>{{ trans('profile.'.$english_level) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                {!! Form::label('smoke', 'Курение') !!}
                                <select name="smoke" class="form-control">
                                    @foreach($selects['smoke'] as $smoke)
                                        <option value="{{ $smoke }}" {{ (!empty($user->profile->smoke) && $smoke == $user->profile->smoke)?'selected':'' }}>{{ trans('profile.'.$smoke) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                {!! Form::label('drink', 'Алкоголь') !!}
                                <select name="drink" class="form-control">
                                    @foreach($selects['drink'] as $drink)
                                        <option value="{{ $drink }}" {{ (!empty($user->profile->drink) && $drink == $user->profile->drink)?'selected':'' }}>{{ trans('profile.'.$drink) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-12">
                                {!! Form::label('about', 'О девушке ') !!}
                                <textarea class="form-control" name="about" style="height: 152px;">{!! $user->profile->about !!}</textarea>
                            </div>

                            <div class="form-group col-md-12" style="padding: 0;">
                                <div class="form-group col-md-8">
                                    {!! Form::label('looking', 'О партнере ') !!}
                                    <textarea class="form-control" name="looking" style="height: 152px;">{!! $user->profile->looking !!}</textarea>
                                </div>
                                <div class="form-group col-md-4">
                                    <div class="col-md-6">
                                        {!! Form::label('l_age_start', 'Возраст от:') !!}
                                        {!! Form::number('l_age_start', $user->profile->l_age_start, ['class' => 'form-control']) !!}
                                    </div>

                                    <div class="col-md-6">
                                        {!! Form::label('l_age_stop', 'До:') !!}
                                        {!! Form::number('l_age_stop', $user->profile->l_age_stop, ['class' => 'form-control']) !!}
                                    </div>

                                    <div class="col-md-6">
                                        {!! Form::label('l_height_start', 'Рост (см) от:') !!}
                                        {!! Form::number('l_height_start', $user->profile->l_height_start, ['class' => 'form-control']) !!}
                                    </div>

                                    <div class="col-md-6">
                                        {!! Form::label('l_height_stop', 'До:') !!}
                                        {!! Form::number('l_height_stop', $user->profile->l_height_stop, ['class' => 'form-control']) !!}
                                    </div>

                                    <div class="col-md-6">
                                        {!! Form::label('l_weight_start', 'Вес (кг) от:') !!}
                                        {!! Form::number('l_weight_start', $user->profile->l_weight_start, ['class' => 'form-control']) !!}
                                    </div>

                                    <div class="col-md-6">
                                        {!! Form::label('l_weight_stop', 'До:') !!}
                                        {!! Form::number('l_weight_stop', $user->profile->l_weight_stop, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    {!! Form::label('l_horoscope_id', 'Знак зодиака партнера:') !!}
                                    <select name="l_horoscope_id" id="l_horoscope_id" class="form-control">
                                        <option value="---">---</option>
                                        @foreach($zodiac_list as $key=>$zodiac)
                                            @if($key==$user->profile->l_horoscope_id)
                                                <option value="{!! $key !!}" selected="selected">{!! trans('horoscope.'.$zodiac) !!}</option>
                                            @else
                                                <option value="{!! $key !!}">{!! trans('horoscope.'.$zodiac) !!}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group text-center col-md-12">
                                <a style="color: white;background-color: gray;" class="btn btn-next next" onClick="next_click('#profile_fo');">Далее</a>
                            </div>
                        </div>
                    </div>

                    <!-- Фотоальбомы -->

                    <div role="tabpanel" class="tab-pane" id="photoalbums">
                        <div class="row">
                            <div class="col-md-12">
                                <h3 class="text-center">Albums</h3>
                                <div class="row">
                                    <div class="owl row online">
                                        @foreach($albums as $a)
                                            <div class="item col-md-4" id="gallerey-{{$a->id}}">
                                                <div class="row text-center">
                                                    <a href="{{ url(App::getLocale().'/admin/girl/edit/'.$user->id.'/edit_album/'.$a->id) }}">
                                                        <img src="{{ url('/uploads/albums/'.$a->cover_image) }}" width="90%">
                                                        <div class="text-center">{{ $a->name }}</div>
                                                    </a>
                                                    <a class="delete_gallery" href="#" onclick="deleteGallery({{$a->id}});"  ><i class="fa fa-trash-o"></i></a>
                                                </div>
                                            </div>
                                        @endforeach
                                        <div class="item last_create col-md-4">
                                            <a href="{{url(App::getLocale().'/admin/girl/edit/'.$user->id.'/add_album') }}">
                                                <img style="    width: 100%;" class="create" src="/public/uploads/add_image.png">
                                                <div class="text-center">{{ trans('albums.add') }}</div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Партнерская информация -->

                    <div role="tabpanel" class="tab-pane" id="status">
                        <div class="row">
                            <div class="col-md-12">
                                @if( Auth::user()->hasRole('Owner') || Auth::user()->hasRole('Moder'))
                                <div class="form-group" style="margin-top: 20px">
                                    <select name="status" class="form-control">
                                        @foreach($statuses as $status)
                                            @if($status->id == 4)<!-- Статус удаленный не выводим, так как профили удаляются через SoftDelete -->
                                            @else
                                                <option value="{{ $status->id }}" {{ $status->id == $user->status_id ? "selected" : ''}}>{{ trans('status.'.$status->name) }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                                </div>
                                <div class="form-group">
                                    <label for="status_message">Причина отказа (если есть):</label>
                                    <textarea name="status_message" class="form-control"></textarea>
                                </div>
                                @else
                                    <title>Статус анкеты:
                                        @foreach($statuses as $status)
                                            @if($status->id == $user->status_id)
                                                {{ trans('status.'.$status->name) }}
                                            @endif
                                        @endforeach
                                    </title>
                                @endif

                                <div class="form-group">
                                    {!! Form::label('passno','№ паспорта') !!}
                                    {!! Form::text('passno', ((isset($passport->passno))?$passport->passno:""), ['class' => 'form-control', 'disabled' => 'disabled']) !!}
                                </div>

                                <div class="form-group">
                                {!! Form::label('pass_date', 'Дата выдачи паспорта') !!}
                                {!! Form::text('pass_date', ((isset($passport->date))?$passport->date:"") , ['class' => 'form-control default-date-picker', 'id' => 'datepicker', 'disabled' => 'disabled']) !!}
                                </div>

                                <div class="form-group">
                                    {!! Form::label('avatar', 'Фото/Скан паспорта') !!}
                                    <br/>
                                    <img class="img-responsive" src="{{ url('/uploads/'.  ((isset($passport->cover))?$passport->cover:"")) }}">
                                    <input type="file" class="form-control file" name="pass_photo" value="{{ ((isset($passport->cover))?$passport->cover:"") }}" accept="image/*" disabled="disabled"><!--disabled="disabled"-->
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

    <script src="{{ url('/assets/js/bootstrap-datepicker.js') }}"></script>
    <script type="text/javascript" src="{{ url('/assets/js/bootstrap-fileinput-master/js/fileinput.js') }}"></script>
    <script type="text/javascript" src="{{ url('/assets/js/file-input-init.js') }}"></script>


    <script>
        function next_click(id) {

            $(id).trigger('click');
            return false;
        }

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

        $(window).on('load', function(){

            var city_id = $('input[name="city_id"]').val();

        })
        function deleteGallery($gaId){
            $.post( "/admin/girl/deleteAlbum/"+$gaId, {_token : $('input[name="_token').val()} ).done( function( data ) {

                $("#gallerey-"+$gaId).remove();

            });
        }
    </script>
    <script>
        $("#profile_photo").fileinput({
            uploadUrl: "/file-upload-batch/1",
            uploadAsync: false,
            minFileCount: 0,
            maxFileCount: (10 - {{count($profile_images)}}),
            overwriteInitial: false,
            allowedFileExtensions: ["jpg", "png", "gif", "jpeg"],
            showUpload: false,
        });
        function deleteProfileFoto(event,foID){
            event.preventDefault();
            $.post( "/admin/girl/dropProfileFoto/"+foID, {_token : $('input[name="_token').val()} ).done( function( data ) {
                $("#photo-"+foID).remove();
            });
        }
    </script>

@stop