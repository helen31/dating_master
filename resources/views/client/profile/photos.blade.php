@extends('client.profile.profile')

@section('styles')
    <link href="{{ url('/assets/css/bootstrap-reset.css') }}" rel="stylesheet">
    <link href="{{ url('/assets/css/fileinput.css') }}" rel="stylesheet">
    <style>

    </style>
@stop

@section('profileContent')

<div role="tabpanel" class="tab-pane" id="profile_foto">
    <div class="col-md-12">
        <h3 class="text-center">{{ trans('profile.photo') }}</h3>
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
    <div class="col-md-12"><br></div>
    <div class="form-group text-center col-md-12">
        {!! Form::open(['url' => '#', 'class' => 'form', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        <input id="profile_photo" type="file" name="profile_photo[]" multiple="multiple" class="file grg-fileinput" accept="image/*"
               data-show-upload="false" data-show-caption="true">
        <br>
        {!! Form::submit(trans('buttons.save'), ['class' => 'btn btn-success']) !!}

        {!! Form::close() !!}
    </div>
</div>
@stop

@section('scripts')

    <script src="{{ url('/assets/js/bootstrap-datepicker.js') }}"></script>
    <script type="text/javascript" src="{{ url('/assets/js/bootstrap-fileinput-master/js/fileinput.js') }}"></script>
    <script type="text/javascript" src="{{ url('/assets/js/file-input-init.js') }}"></script>
    <!--modalWindow for photos-->
    <script type="text/javascript" src="{{ url('/assets/js/modalShow.js') }}"></script>
    <script>
        var modal = new ModalShow($('.js-gla-profile-photo-modal'));
    </script>
    <script>
        /**$(function(){
            // Get the modal
            var modal = document.getElementById('myModal');

            // Get the image and insert it inside the modal - use its "alt" text as a caption
            var modalImg = document.getElementById("img01");
            var span = document.getElementsByClassName("close")[0];

            $('img').click(function(){
                modal.style.display = "block";
                span.style.display= 'block';
                debugger;
                modalImg.src = $(this).attr('src');
                $('.navbar-static-top').css('z-index', '0');
            });

            // Get the <span> element that closes the modal


            // When the user clicks on <span> (x), close the modal
            span.onclick = function() {
                modal.style.display = "none";
            }

        });**/
        function deleteProfileFoto(event,foID){
            event.preventDefault();
            $.post( "/profile/dropProfilePhoto/"+foID, {_token : $('input[name="_token').val()} ).done( function( data ) {
                $("#photo-"+foID).remove();
            });
        }

    </script>
@stop
