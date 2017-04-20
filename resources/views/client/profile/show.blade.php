@extends('client.profile.profile')

@section('profileContent')
    <style>


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

        /**Pohup Window Smile**/
        .grg-tada_link{
            text-decoration: none;
            position: relative;
        }

        .grg-tada{

        }

        .smilePopupWindow{
            display: none;
            position: absolute;
            top: -41px;
            left: -34px;
            width: 222%;
            text-align: center;
            border-radius: 11px;
            color: #ffffff;
            text-shadow: 2px 2px 4px #000000;
            font-weight: 900;
            font-size: 15px;
        }
    </style>

    <div class="hidden">
        {{ csrf_field() }}
    </div>
    <div class="row">
        <div class="avatar col-lg-5 col-md-4 col-xs-12">
            <img src="{{ url('/uploads/users/avatars/'.$u->avatar) }}" class="gla-avatar-img"/>
        </div>
        <div class="col-lg-7 col-md-8 col-xs-12  gla-user-data-margin">
            <div class="user_data col-md-12 gla-user-data-style">
                <div class="name">
                    <h3>{{ $u->first_name }} <span class="profile_id">| ID: {{ $u->uid }} </span>
                        @if( (Auth::user()) && (Auth::user()->hasRole('Female')) )
                            <i class="fa fa-check" aria-hidden="true"></i>
                        @endif
                    </h3>
                </div>
                <div class="row info">
                    <div class="col-md-6 col-xs-6"><strong>{{ trans('profile.age') }}:</strong> {{ date('Y-m-d') - $u->birthday }}</div>
                    <div class="col-md-6 col-xs-6"><strong>{{ trans('profile.country') }}:</strong> {{ (\App::getLocale() == 'ru') ? $u->country : $u->country_en }}</div>
                </div>
                <div class="row info">
                    <div class="col-md-6 col-xs-6"><strong>{{ trans('profile.birthday') }}:</strong> {{ $u->birthday }}</div>
                    <div class="col-md-6 col-xs-6"><strong>{{ trans('profile.city') }}:</strong> {{ (\App::getLocale() == 'ru') ? $u->city : $u->city_en }}</div>
                </div>
                <div class="row info">
                    <div class="col-md-6 col-xs-6"><strong>{{ trans('profile.zodiac') }}:</strong> {{ trans('horoscope.'.$sign) }}</div>
                    <div class="col-md-6 col-xs-6"><strong>{{ trans('profile.height') }}:</strong> {{ $u->height }}</div>
                </div>
                <div class="row info">
                    <div class="col-md-6 col-xs-6"><strong>{{ trans('profile.weight') }}:</strong> {{ $u->weight }}</div>
                    <div class="col-md-6 col-xs-6"><strong>{{ trans('profile.hair') }}:</strong> {{ trans('profile.'.$u->hair) }}</div>
                </div>
                <div class="row info">
                    <div class="col-md-6 col-xs-6"><strong>{{ trans('profile.eyes') }}:</strong> {{ trans('profile.'.$u->eyes) }}</div>
                    <div class="col-md-6 col-xs-6"><strong>{{ trans('profile.education') }}:</strong> {{ trans('profile.'.$u->education) }}</div>
                </div>
                <div class="row info">
                    <div class="col-md-6 col-xs-6"><strong>{{ trans('profile.religion') }}:</strong> {{ trans('profile.'.$u->religion) }}</div>
                    <div class="col-md-6 col-xs-6"><strong>{{ trans('profile.kids') }}:</strong> {{ trans('profile.'.$u->kids) }}</div>
                </div>
                <div class="row info">
                    <div class="col-md-6 col-xs-6"><strong>{{ trans('profile.want_kids') }}:</strong> {{ trans('profile.'.$u->want_kids) }}</div>
                    <div class="col-md-6 col-xs-6"><strong>{{ trans('profile.family') }}:</strong>
                        {{ ($u->family != '---') ? trans('profile.'.$u->family.'_'.$u->gender) : '---' }}</div>
                </div>
                <div class="row info">
                    <div class="col-md-6 col-xs-6"><strong>{{ trans('profile.smoke') }}:</strong> {{ trans('profile.'.$u->smoke) }}</div>
                    <div class="col-md-6 col-xs-6"><strong>{{ trans('profile.drink') }}:</strong> {{ trans('profile.'.$u->drink) }}</div>
                </div>
                <div class="row info">
                    <div class="col-md-6 col-xs-6"><strong>{{ trans('profile.occupation') }}:</strong> {{ $u->occupation }}</div>
                    <div class="col-md-6 col-xs-6"></div>
                </div>
            </div>
            <div class="user_data col-md-12 gla-user-data-styleMobile">
                <div class="name">
                    <h3>{{ $u->first_name }} <span class="profile_id">| ID: {{ $u->uid }} </span>
                        @if( (Auth::user()) && (Auth::user()->hasRole('Female')) )
                            <i class="fa fa-check" aria-hidden="true"></i>
                        @endif
                    </h3>
                </div>
                <div class="gla-user-data-item"><strong>{{ trans('profile.age') }}:</strong> {{ date('Y-m-d') - $u->birthday }}</div>
                <div class="gla-user-data-item"><strong>{{ trans('profile.country') }}:</strong> {{ (\App::getLocale() == 'ru') ? $u->country : $u->country_en }}</div>
                <div class="gla-user-data-item"><strong>{{ trans('profile.birthday') }}:</strong> {{ $u->birthday }}</div>
                <div class="gla-user-data-item"><strong>{{ trans('profile.city') }}:</strong> {{ (\App::getLocale() == 'ru') ? $u->city : $u->city_en }}</div>
                <div class="gla-user-data-item"><strong>{{ trans('profile.zodiac') }}:</strong> {{ trans('horoscope.'.$sign) }}</div>
                <div class="gla-user-data-item"><strong>{{ trans('profile.height') }}:</strong> {{ $u->height }}</div>
                <div class="gla-user-data-item"><strong>{{ trans('profile.weight') }}:</strong> {{ $u->weight }}</div>
                <div class="gla-user-data-item"><strong>{{ trans('profile.hair') }}:</strong> {{ trans('profile.'.$u->hair) }}</div>
                <div class="gla-user-data-item"><strong>{{ trans('profile.eyes') }}:</strong> {{ trans('profile.'.$u->eyes) }}</div>
                <div class="gla-user-data-item"><strong>{{ trans('profile.education') }}:</strong> {{ trans('profile.'.$u->education) }}</div>
                <div class="gla-user-data-item"><strong>{{ trans('profile.religion') }}:</strong> {{ trans('profile.'.$u->religion) }}</div>
                <div class="gla-user-data-item"><strong>{{ trans('profile.kids') }}:</strong> {{ trans('profile.'.$u->kids) }}</div>
                <div class="gla-user-data-item"><strong>{{ trans('profile.want_kids') }}:</strong> {{ trans('profile.'.$u->want_kids) }}</div>
                <div class="gla-user-data-item"><strong>{{ trans('profile.family') }}:</strong>
                    {{ ($u->family != '---') ? trans('profile.'.$u->family.'_'.$u->gender) : '---' }}</div>
                <div class="gla-user-data-item"><strong>{{ trans('profile.smoke') }}:</strong> {{ trans('profile.'.$u->smoke) }}</div>
                <div class="gla-user-data-item"><strong>{{ trans('profile.drink') }}:</strong> {{ trans('profile.'.$u->drink) }}</div>
                <div class="gla-user-data-item"><strong>{{ trans('profile.occupation') }}:</strong> {{ $u->occupation }}</div>
                <div class="gla-user-data-item"></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div id="max_info" class="col-md-12">
            @if(Auth::user()->id != $id)
                <div class="row" id="buttons">
                    <div class="col-sm-12 col-md-12 col-lg-6 girl-action">
                        <a href="#" class="gla-profile-link">
                            <img src="/assets/img/video.png" class="gla-profile-icon" alt="webcam online" title="Webcam online">
                        </a>
                        <a href="#chat" class="gla-profile-link">
                            <img src="/assets/img/chat.png" class="gla-profile-icon" alt="Chat now" title="chat now!">
                        </a>
                        <a href="javascript:;" class="grg-tada_link gla-profile-link">
                            <img class="grg-tada gla-profile-icon" src="/assets/img/heart.png" alt="smile" title="{{ trans('profile.wink') }}" id="smile">
                            <span class="smilePopupWindow">{{ trans('profile.you_wink') }}</span>
                        </a>
                        <a href="{{ url('/'. App::getLocale() . '/profile/'. Auth::user()->id . '/correspond/'.$u->uid) }}" class="gla-profile-link">
                            <img src="/assets/img/message.png" class="gla-profile-icon" alt="leave a message" title="{{ trans('profile.leave_message') }}">
                        </a>
                        @if(Auth::user()->hasRole('Male'))
                            <a href="{{ url('/'. App::getLocale() . '/profile/'. Auth::user()->id . '/presents/'.$u->uid) }}" class="gla-profile-link">
                                <img src="/assets/img/gift.png" class="gla-profile-icon" alt="gifts" title="{{ trans('profile.make_gift') }}">
                            </a>
                            <a href="{{ url('/'. App::getLocale() . '/profile/'. Auth::user()->id . '/horoscope/'.$u->uid) }}" class="gla-profile-link">
                                <img src="/assets/img/astrology.png" class="gla-profile-icon" alt="horoscope" title="{{ trans('horoscope.check_compatibility') }}">
                            </a>
                            <a href="{{ url('/'. App::getLocale() . '/profile/'. Auth::user()->id . '/contacts/'.$u->uid) }}" class="gla-profile-link">
                                <img src="/assets/img/phone-book.png" class="gla-profile-icon" alt="get contacts" title="{{ trans('profile.request_contacts') }}">
                            </a>
                        @endif
                    </div>
                </div>
            @endif
            <div class="row">
                <!-- Nav tabs -->
                <div class="col-md-12 col-lg-12">
                    <ul class="nav nav-tabs gla-nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#about" aria-controls="about" role="tab" data-toggle="tab">{{ trans('profile.about') }}</a></li>
                        <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">{{ trans('profile.looking') }}</a></li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content gla-tab-content">
                        <div role="tabpanel" class="tab-pane active" id="about">
                            {{ $u->about }}
                        </div>
                        <div role="tabpanel" class="tab-pane" id="profile">
                            {{ $u->looking }}
                        </div>
                    </div>
                </div>
            </div>
            <!--Profile photos-->
            @if(count($profile_images) > 0)
                <div class="row gla-profile-block">
                    <div class="col-md-12">
                        <h2>{{ trans('profile.photo') }}</h2>
                        <div class="js-gla-profile-photo-modal">
                            @foreach($profile_images as $p_image)
                                <div class="grg-photo-frame" id="photo-{{$p_image->id}}">
                                    <img class="grg-img-photo js-img-photo" src="{{ url('/uploads/users/profile_photos/'.$p_image->url) }}">
                                <!--<a class="delete_gallery" href="#" onclick="deleteProfileFoto(event,'{{$p_image->id}}');">
                                    <i class="fa fa-trash-o"></i>
                                </a>-->
                                </div>
                        @endforeach
                        <!-- The Modal -->
                            <div id="myModal" class="gla-modal js-gla-modal">
                                <!-- Modal Content (The Image) -->
                                <div class="gla-modal-content-wrap">
                                    <img class="gla-modal-content js-modal-img" id="img01">
                                    <!-- The Close Button -->
                                    <span class="gla-close js-gla-close">&times;</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <!--Albums-->
            @if($u->gender = 'female' && count($albums) > 0)
                <div class="row gla-profile-block">
                    <div class="col-md-12">
                        <h2>{{ trans('albums.albums') }}</h2>
                        <div class="row">
                            @foreach($albums as $a)
                                <div class="item col-md-6 col-sm-12">
                                    <a href="{{ url(App::getLocale().'/profile/'.$id.'/show_album/'.$a->id) }}">
                                        <img src="{{ url('/uploads/albums/'.$a->cover_image) }}" width="250px">
                                        <div class="text-center">{{ $a->name }}</div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
            <!--Videos-->
            @if(count($videos) > 0)
                <div class="row gla-profile-block">
                    <div class="col-md-12">
                        <h2>{{ trans('profile.video') }}</h2>
                        <div class="row">
                            @foreach($videos as $video)
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <a href="{{ url('profile/'.$video->uid.'/video/show/'.$video->id) }}">
                                        <div class="gla-cover-img gla-cover-img_width">
                                            <img src="/uploads/videos/covers/{{ $video->cover }}" alt="Poster">
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@stop

@section('scripts')
    <script type="text/javascript" src="{{ url('/assets/js/modalShow.js') }}"></script>
    <script>
        var modal1 = new ModalShow($('.js-gla-profile-photo-modal'));
    </script>
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

    <!--You have winked-->
    <script>
        $('#smile').on('click', function (event) {
            event.preventDefault();

            $(event.target).parent('.grg-tada_link').find('.smilePopupWindow').show(600, function (event) {
                var currentElem = $(this);

                setTimeout( function(){ currentElem.hide(); }, 800);
            });
        })
    </script>
@stop