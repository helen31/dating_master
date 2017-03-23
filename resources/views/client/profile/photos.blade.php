@extends('client.profile.profile')

@section('styles')
    <link href="{{ url('/assets/css/bootstrap-reset.css') }}" rel="stylesheet">
    <link href="{{ url('/assets/css/fileinput.css') }}" rel="stylesheet">
    <style>
        .grg-img-photo{
            height: 160px;
            width: auto;
        }
        .grg-photo-frame{
            float: left;
            padding: 4px;
        }

        /* The Modal (background) */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 3; /* Sit on top */
            padding-top: 100px; /* Location of the box */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0,0,0); /* Fallback color */
            background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
        }

        /* Modal Content (Image) */
        .modal-content {
            margin: auto;
            display: block;
            width: 60%;
            max-width: 80%;
        }

        @-webkit-keyframes zoom {
            from {-webkit-transform:scale(0)}
            to {-webkit-transform:scale(1)}
        }

        @keyframes zoom {
            from {transform:scale(0)}
            to {transform:scale(1)}
        }

        /* The Close Button */
        .close {
            position: absolute;
            top: 15px;
            right: 35px;
            color: #f1f1f1;
            font-size: 40px;
            font-weight: bold;
            transition: 0.3s;
        }

        .close:hover,
        .close:focus {
            color: #bbb;
            text-decoration: none;
            cursor: pointer;
        }

        /* 100% Image Width on Smaller Screens */
        @media only screen and (max-width: 700px){
            .modal-content {
                width: 100%;
            }
        }
    </style>
@stop

@section('profileContent')

<div role="tabpanel" class="tab-pane" id="profile_foto">
    <div class="col-md-12">
        <h3 class="text-center">{{ trans('profile.photo') }}</h3>
            @foreach($profile_images as $p_image)
                <div class="grg-photo-frame" id="photo-{{$p_image->id}}">
                    <img class="grg-img-photo" src="{{ url('/uploads/users/profile_photos/'.$p_image->url) }}">
                    <a class="delete_gallery" href="#" onclick="deleteProfileFoto(event,'{{$p_image->id}}');"><i class="fa fa-trash-o"></i></a>
                </div>
            @endforeach
    </div>
    <div class="col-md-12"><br></div>
    <div class="form-group text-center col-md-12">
        {!! Form::open(['url' => 'profile/'.$id.'/photo', 'class' => 'form', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        <input id="profile_photo" type="file" name="profile_photo[]" multiple="multiple" class="file grg-fileinput" accept="image/*"
               data-show-upload="false" data-show-caption="true">
        <br>
        {!! Form::submit(trans('buttons.save'), ['class' => 'btn btn-success']) !!}
        {!! Form::close() !!}
    </div>
</div>

<!-- The Modal -->
<div id="myModal" class="modal" onclick="document.getElementById('myModal').style.display='none'">

    <!-- The Close Button -->
    <span class="close" onclick="document.getElementById('myModal').style.display='none'">&times;</span>

    <!-- Modal Content (The Image) -->
    <img class="modal-content" id="img01">
</div>

@stop

@section('scripts')

    <script src="{{ url('/assets/js/bootstrap-datepicker.js') }}"></script>
    <script type="text/javascript" src="{{ url('/assets/js/bootstrap-fileinput-master/js/fileinput.js') }}"></script>
    <script type="text/javascript" src="{{ url('/assets/js/file-input-init.js') }}"></script>
    <script>
        $(function(){
            // Get the modal
            var modal = document.getElementById('myModal');

            // Get the image and insert it inside the modal - use its "alt" text as a caption
            var modalImg = document.getElementById("img01");

            $('img').click(function(){
                modal.style.display = "block";
                modalImg.src = $(this).attr('src');
                $('.navbar-static-top').css('z-index', '0');
            });

            // Get the <span> element that closes the modal
            var span = document.getElementsByClassName("close")[0];

            // When the user clicks on <span> (x), close the modal
            span.onclick = function() {
                modal.style.display = "none";
            }

        });
        function deleteProfileFoto(event,foID){
            event.preventDefault();
            $.post( "/profile/dropProfilePhoto/"+foID, {_token : $('input[name="_token').val()} ).done( function( data ) {
                $("#photo-"+foID).remove();
            });
        }

    </script>
@stop
