@extends('client.app')

@section('content')
    @include('client.blocks.searchSlider')
    <div class="content-bg">
        <div class="container">
            <div class="row">
                <header class="text-left  girl__title">
                    @if(!Auth::user())
                        @if($_POST && $search_attrs['looking'] == 4)
                            <h2 class="gla-container-title">{{ trans('search.mans') }}</h2>
                        @else
                            <h2 class="gla-container-title">{{ trans('search.girls') }}</h2>
                        @endif
                    @elseif(Auth::user()->hasRole('female'))
                        <h2 class="gla-container-title">{{ trans('search.mans') }}</h2>
                    @elseif(Auth::user()->hasRole('male'))
                        <h2 class="gla-container-title">{{ trans('search.girls') }}</h2>
                    @else
                        @if($_POST && $search_attrs['looking'] == 4)
                            <h2 class="gla-container-title">{{ trans('search.mans') }}</h2>
                        @else
                            <h2 class="gla-container-title">{{ trans('search.girls') }}</h2>
                        @endif
                    @endif
                </header>
            </div>
            <div class="row lightpink">
                <div class="main_items"><!--container for item-->
                    <div class="container gla-container-maxWidth map-bg">
                        <div class="owl online">
                            @if($_POST && $search_attrs['is_online']==1)
                                @foreach($users as $u)
                                    @if($u->isOnline())
                                        @include('client.blocks.user-item')
                                    @endif
                                @endforeach
                            @else
                                @foreach($users as $u)
                                    @include('client.blocks.user-item')
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="text-center">
                        {!! $users->render() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')
<script type="text/javascript" src="{{ url('/assets/js/bootstrap-fileinput-master/js/fileinput.js') }}"></script>
<script type="text/javascript" src="{{ url('/assets/js/file-input-init.js') }}"></script>
<script>
    function get_cities( $id, abc )
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
                        $('select[name="city"]').append("<option value='" + response[i].id + "'  selected='selected'>" + response[i].name + "</option>");
                    else
                        $('select[name="city"]').append("<option value='" + response[i].id + "'>" + response[i].name + "</option>");
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
                $('select[name="user_state_id"]').empty();

                for( var i = 0; i < response.length; i++ )
                {
                    if( response[i].id == $('input[name="user_state_id"]').val() )
                        $('select[name="user_state_id"]').append("<option value='" + response[i].id + "' selected='selected'>" + response[i].name + "</option>");
                    else
                        $('select[name="user_state_id"]').append("<option value='" + response[i].id + "'>" + response[i].name + "</option>");
                }
            },
            error: function( response ){
                console.log( response )
            }
        });

        get_cities($id);
    }

    jQuery(window).on('load', function(){

        get_states( $('select[name="country"]').val() );

    });
    $('select[name="country"]').on('change', function(){

        $('select[name="city"]').empty();

        $.ajax({
            type: 'POST',
            url: '{{ url('/get/states/')  }}',
            data: {id: $(this).val(), _token: $('input[name="_token"]').val()  },
            success: function( response ){
                $('select[name="user_state_id"]').empty();
                for( var i = 0; i < response.length; i++ )
                {
                    $('select[name="user_state_id"]').append("<option value='" + response[i].id + "'>" + response[i].name + "</option>");
                }
            },
            error: function( response ){
                console.log( response )
            }
        });

    });

    $('select[name="user_state_id"]').on('change', function(){

        $.ajax({
            type: 'POST',
            url: '{{ url('/get/cities/') }}',
            data: {id: $(this).val(), _token: $('input[name="_token').val() },
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
        })
    });

</script>
@section('scripts')

@stop
