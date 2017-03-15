@extends('client.profile.profile')

@section('profileContent')
    <style>
        .grg-img-photo{
            height: 160px;
            width: auto;
        }
        .grg-photo-frame{
            float: left;
            padding: 4px;
        }
        .item.last_create a{
            opacity: 0.9;
            transition: 0.2s;
        }
        .item.last_create a:hover{
            opacity: 1;
            transition: 0.2s;
        }
        /* Animation */
        .grg-tada {
            -webkit-animation-duration: 0.4s;
            -moz-animation-duration: 0.4s;
            -o-animation-duration: 0.4s;
            animation-duration: 0.4s;
            -webkit-animation-timing-function: ease;
            -moz-animation-timing-function: ease;
            -o-animation-timing-function: ease;
            animation-timing-function: ease;
        }

        .grg-tada:active {
            -webkit-animation-name: Tada;
            -moz-animation-name: Tada;
            -o-animation-name: Tada;
            animation-name: Tada;
        }

        @-webkit-keyframes Tada {
            0% {
                -webkit-transform:scale(1)
            }
            10%, 20% {
                -webkit-transform:scale(0.9) rotate(-3deg)
            }
            30%, 50%, 70%, 90% {
                -webkit-transform:scale(1.1) rotate(3deg)
            }
            40%, 60%, 80% {
                -webkit-transform:scale(1.1) rotate(-3deg)
            }
            100% {
                -webkit-transform:scale(1) rotate(0)
            }
        }
        @-moz-keyframes Tada {
            0% {
                -moz-transform:scale(1)
            }
            10%,20% {
                -moz-transform:scale(0.9) rotate(-3deg)
            }
            30%, 50%, 70%, 90% {
                -moz-transform:scale(1.1) rotate(3deg)
            }
            40%, 60%, 80% {
                -moz-transform:scale(1.1) rotate(-3deg)
            }
            100% {
                -moz-transform:scale(1) rotate(0)
            }
        }
        @-o-keyframes Tada {
            0% {
                -o-transform:scale(1)
            }
            10%,20% {
                -o-transform:scale(0.9) rotate(-3deg)
            }
            30%, 50%, 70%, 90% {
                -o-transform:scale(1.1) rotate(3deg)
            }
            40%, 60%, 80% {
                -o-transform:scale(1.1) rotate(-3deg)
            }
            100% {
                -o-transform:scale(1) rotate(0)
            }
        }
        @keyframes Tada {
            0% {
                transform:scale(1)
            }
            10%, 20% {
                transform:scale(0.9) rotate(-3deg)
            }
            30%, 50%, 70%, 90% {
                transform:scale(1.1) rotate(3deg)
            }
            40%, 60%, 80% {
                transform:scale(1.1) rotate(-3deg)
            }
            100% {
                transform:scale(1) rotate(0)
            }
        }



    </style>
    <div class="row">
        <div class="hidden">
            {{ csrf_field() }}
        </div>

            <div class="avatar col-md-4 col-xs-6"><img src="{{ url('/uploads/'.$u->avatar) }}" width="100%"/></div>
            <div id="mobile_ver">
                <div class="col-md-6 col-xs-6"> 
                    <div class="row info mobile_ver">
                        <div class="name text-right">
                            <header>{{ $u->first_name }} <span class="profile_id">| ID: <span id="id">{{ $u->uid }}</span> </span>
                            @if( (Auth::user()) && (Auth::user()->hasRole('Female')) )
                                 <i class="fa fa-check" aria-hidden="true"></i> 
                            @endif
                            </header>
                        </div>
                        <div class="text-right">ID: {{ $u->uid }}</div>
                        <div class="text-right">{{ trans('profile.age') }}: {{ date('Y-m-d') - $u->birthday }}</div>
                        <div class="text-right">From: {{ (\App::getLocale() == 'ru') ? $u->country : $u->country_en }}</div>
                        <div class="icons">
                            <i class="fa fa-smile-o" aria-hidden="true"></i>
                            <i class="fa fa-envelope-o" aria-hidden="true"></i>
                            <i class="fa fa-comments" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-xs-12">
                    <div class="four_icons">
                            <div class="col-xs-3">{{ trans('profile.photo') }}</div>
                            <div class="col-xs-3">{{ trans('profile.video') }}</div>
                            <div class="col-xs-3">{{ trans('profile.smiles') }}</div>
                            <div class="col-xs-3">{{ trans('profile.gifts') }}</div>
                    </div>
                </div>
                <div class="col-md-12 col-xs-12">
                    <div class="col-md-6 col-xs-6">
                        <ul class="mob_info">
                            <li>{{ trans('profile.country') }}: {{ (\App::getLocale() == 'ru') ? $u->country : $u->country_en }}</li>
                            <li>{{ trans('profile.height') }}: {{ $u->height }}</li>
                            <li>{{ trans('profile.eyes') }}: {{ trans('profile.'.$u->eyes) }}</li>

                        </ul>
                    </div>
                    <div class="col-md-6 col-xs-6">
                        <ul class="mob_info">
                            <li>{{ trans('profile.horoscope') }}: {{ trans('horoscope.'.$sign) }}</li>
                            <li>{{ trans('profile.height') }}: {{ $u->weight }}</li>
                            <li>{{ trans('profile.hair') }}: {{ trans('profile.'.$u->hair) }}</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-12 col-xs-12">
                    <header>About</header>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quasi ex corporis ad ratione nemo reprehenderit laudantium soluta, facere excepturi, possimus fugit modi quod quisquam vitae similique necessitatibus blanditiis, repellat fuga?</p>
                </div>
            </div>
            <div id="max_info">
                <div class="user_data col-md-6 col-xs-6">
                    <div class="row info">
                        <div class="name">
                            <header>{{ $u->first_name }} <span class="profile_id">| ID: {{ $u->uid }} </span>
                            @if( (Auth::user()) && (Auth::user()->hasRole('Female')) )
                                 <i class="fa fa-check" aria-hidden="true"></i> 
                            @endif
                            </header>
                        </div>
                    </div>

                    <div class="row info">
                        <div class="col-md-6"><strong>{{ trans('profile.age') }}:</strong> {{ date('Y-m-d') - $u->birthday }}</div>
                        <div class="col-md-6"><strong>{{ trans('profile.country') }}:</strong> {{ (\App::getLocale() == 'ru') ? $u->country : $u->country_en }}</div>
                    </div>
                    <div class="row info">
                        <div class="col-md-6"><strong>{{ trans('profile.birthday') }}:</strong> {{ $u->birthday }}</div>
                        <div class="col-md-6"><strong>{{ trans('profile.city') }}:</strong> {{ (\App::getLocale() == 'ru') ? $u->city : $u->city_en }}</div>
                    </div>
                    <div class="row info">
                        <div class="col-md-6"><strong>{{ trans('profile.zodiac') }}:</strong> {{ trans('horoscope.'.$sign) }}</div>
                        <div class="col-md-6"><strong>{{ trans('profile.height') }}:</strong> {{ $u->height }}</div>
                    </div>
                    <div class="row info">
                        <div class="col-md-6"><strong>{{ trans('profile.weight') }}:</strong> {{ $u->weight }}</div>
                        <div class="col-md-6"><strong>{{ trans('profile.hair') }}:</strong> {{ trans('profile.'.$u->hair) }}</div>
                    </div>
                    <div class="row info">
                        <div class="col-md-6"><strong>{{ trans('profile.eyes') }}:</strong> {{ trans('profile.'.$u->eyes) }}</div>
                        <div class="col-md-6"><strong>{{ trans('profile.education') }}:</strong> {{ trans('profile.'.$u->education) }}</div>
                    </div>
                    <div class="row info">
                        <div class="col-md-6"><strong>{{ trans('profile.religion') }}:</strong> {{ trans('profile.'.$u->religion) }}</div>
                        <div class="col-md-6"><strong>{{ trans('profile.kids') }}:</strong> {{ trans('profile.'.$u->kids) }}</div>
                    </div>
                    <div class="row info">
                        <div class="col-md-6"><strong>{{ trans('profile.want_kids') }}:</strong> {{ trans('profile.'.$u->want_kids) }}</div>
                        <div class="col-md-6"><strong>{{ trans('profile.family') }}:</strong>
                            {{ ($u->family != '---') ? trans('profile.'.$u->family.'_'.$u->gender) : '---' }}</div>
                    </div>
                    <div class="row info">
                        <div class="col-md-6"><strong>{{ trans('profile.smoke') }}:</strong> {{ trans('profile.'.$u->smoke) }}</div>
                        <div class="col-md-6"><strong>{{ trans('profile.drink') }}:</strong> {{ trans('profile.'.$u->drink) }}</div>
                    </div>
                    <div class="row info">
                        <div class="col-md-6"><strong>{{ trans('profile.occupation') }}:</strong> {{ $u->occupation }}</div>
                        <div class="col-md-6"></div>
                    </div>
                </div>
                @if(Auth::user()->id != $id)
                    <div class="row" id="buttons">
                        <div class="col-md-4">
                            <div class="row girl-action">
                                <div class="col-md-4 col-sm-4 col-xs-4 col-lg-3">
                                    <img src="/assets/img/video.png" alt="Webcam online" title="Webcam online">
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-4 col-lg-3">
                                    <a href="#chat"><img src="/assets/img/interface.png" alt="Chat now" title="Chat now!"></a>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-4 col-lg-3">
                                    <a href="{{ url('/'. App::getLocale() . '/profile/'. $u->uid . '/message') }}"><img src="/assets/img/note.png" alt="Leave a message" title="{{ trans('profile.leave_message') }}"></a>
                                </div>
                                 <div class="col-md-4 col-sm-4 col-xs-4 col-lg-3">
                                     <a href="javascript:;"><img class="grg-tada" src="/assets/img/smile.png" alt="Smile" title="{{ trans('profile.wink') }}" id="smile"></a>
                                </div>
                            </div>
                        </div>
                        <!--
                            <div class="col-md-2">
                                <button name="horoscope" class="btn btn-success">Show horoscope compability</button>
                                <button name="flp" class="btn btn-success">○	имя + фамилия + телефон </button>
                                <button name="fle" class="btn btn-success">○	имя + фамилия + email </button>
                            </div>
                        -->
                    </div>
                @endif
                <div class="row col-md-12">
                    <div>

                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#about" aria-controls="about" role="tab" data-toggle="tab">{{ trans('profile.about') }}</a></li>
                            <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">{{ trans('profile.looking') }}</a></li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="about">
                                {{ $u->about }}
                            </div>
                            <div role="tabpanel" class="tab-pane" id="profile">
                                {{ $u->looking }}
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-md-12">
                    <br>
                    <hr>
                    <header>{{ trans('profile.photo') }}</header>
                    <br>
                    @foreach($profile_images as $p_image)
                        <div class="grg-photo-frame" id="photo-{{$p_image->id}}">
                            <img class="grg-img-photo" src="{{ url('/uploads/'.$p_image->url) }}">
                        </div>
                    @endforeach
                </div>
                <div class="col-md-12">
                    @if($u->gender = 'female' && count($albums) > 0)
                        <br>
                        <hr>
                        <header>{{ trans('albums.albums') }}</header>
                        <br>
                        <div class="owl row online">
                            @foreach($albums as $a)
                                <div class="item col-md-4">
                                    <div class="row text-center">
                                        <a href="{{ url(App::getLocale().'/profile/'.$id.'/show_album/'.$a->id) }}">
                                            <img src="{{ url('/uploads/albums/'.$a->cover_image) }}" width="250px">
                                            <div class="text-center">{{ $a->name }}</div>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

    </div>

@stop

@section('additional_scripts')
    <script>
        var $ = jQuery.noConflict();

        $(document).ready(function(){
            $('button[name="horoscope"]').click(function(){
               //todo window with information about "money"

                $.ajax({
                    type: "POST",
                    url: '{{ url('/horoscope') }}',
                    data: {girl_id: parseInt($('#id').html()), _token: $('input[name="_token"]').val()},
                    success: function( response ) {
                        $('#serviceModal').modal();
                        $('#serviceModal').find('.modal-body').append(
                                "<div>" + response.text + "</div>"
                        );
                    },
                    error: function( response ) {
                        $('#serviceModal').modal();
                    }
                })
            });

            $('button[name="flp"]').click(function(){
                //todo window with information about "money"

                $.ajax({
                    type: "POST",
                    url: '{{ url('/flp') }}',
                    data: {girl_id: parseInt($('#id').html()), _token: $('input[name="_token"]').val()},
                    success: function( response ) {
                        $('#serviceModal').modal();
                        $('#serviceModal').find('.modal-body').append(
                                "<div>" + response.first_name + "</div>" +
                                "<div>" + response.last_name + "</div>" +
                                "<div>" + response.phone + "</div>"
                        );
                    },
                    error: function( response ) {
                        $('#serviceModal').modal();
                        $('#serviceModal').find('.modal-body').append(response);
                    }
                })
            });

            $('button[name="fle"]').click(function(){
                //todo window with information about "money"

                $.ajax({
                    type: "POST",
                    url: '{{ url('/fle') }}',
                    data: {girl_id: parseInt($('#id').html()), _token: $('input[name="_token"]').val()},
                    success: function( response ) {
                        $('#serviceModal').modal();
                        $('#serviceModal').find('.modal-body').append(
                            "<div>" + response.first_name + "</div>" +
                            "<div>" + response.last_name + "</div>" +
                            "<div>" + response.email + "</div>"
                        );
                    },
                    error: function( response ) {
                        $('#serviceModal').modal();
                        $('#serviceModal').find('.modal-body').append( response );
                    }
                })
            });
        
        //Smile 
             $('#smile').click(function(e){
                 e.preventDefault();
                //todo window with information about "money"

                $.ajax({
                    type: "POST",
                    url: '{{ url('/wink') }}',
                    data: 'id='+{{$u->uid}}+'&_token={{ csrf_token() }}',
                    success: function( response ) {
                        console.log(response);
                    },
                    error: function( response ) {
                        console.log('error');
                    }
                })
            });
        });
        /**
         * todo: funciton for appending data to modal
         */
    </script>
@stop