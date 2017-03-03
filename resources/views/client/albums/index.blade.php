@extends('client.profile.profile')

@section('styles')
    <link href="{{ url('/assets/css/bootstrap-reset.css') }}" rel="stylesheet">
    <link href="{{ url('/assets/css/fileinput.css') }}" rel="stylesheet">
    <link href="{{ url('assets/css/datepicker.css') }}" rel="stylesheet">
@stop

@section('profileContent')

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
                                <a href="{{ url(App::getLocale().'/profile/'.Auth::user()->id.'/edit_album/'.$a->id) }}">
                                    <img src="{{ url('/uploads/albums/'.$a->cover_image) }}" width="90%">
                                    <div class="text-center">{{ $a->name }}</div>
                                </a>
                                <a class="delete_gallery" href="#" onclick="deleteGallery({{$a->id}});"  ><i class="fa fa-trash-o"></i></a>
                            </div>
                        </div>
                    @endforeach
                    <div class="item last_create col-md-4">
                        <a href="{{ url('/profile/'.Auth::user()->id.'/add_album') }}">
                            <img style="    width: 100%;" class="create" src="/public/uploads/add_image.png">
                            <div class="text-center">{{ trans('albums.add') }}</div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@stop

@section('scripts')
    <script src="{{ url('/assets/js/bootstrap-datepicker.js') }}"></script>
    <script type="text/javascript" src="{{ url('/assets/js/bootstrap-fileinput-master/js/fileinput.js') }}"></script>
    <script type="text/javascript" src="{{ url('/assets/js/file-input-init.js') }}"></script>

    <script>
        function deleteGallery($gaId){
            $.post( "/profile/deleteAlbum/"+$gaId, {_token : $('input[name="_token').val()} ).done( function( data ) {
            $("#gallerey-"+$gaId).remove();
            });
        }
    </script>
@stop