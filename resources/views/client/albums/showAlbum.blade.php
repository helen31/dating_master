@extends('client.profile.profile')

@section('styles')

    <style>
        .photo{
            float: left;
            display: inline-block;
            width: 30%;
            position: relative;
        }
        img {
            padding: 10px;
            cursor: pointer;
        }


        /* The Modal (background) */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 2; /* Sit on top */
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
        .delete_gallery{
            position: absolute;
            top: 10px;
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
        .file-drop-zone-title{
            opacity: 0!important;
        }
    </style>
@stop

@section('profileContent')

    <section class="panel">
        <header class="panel-heading">{{ trans('albums.name') }}: {{ $album->name }}</header>
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
            <div class="col-md-12">
                @foreach($photos as $p)
                    <div class="photo" id="photo-{{$p->id}}">
                        <img src="{{ url('/uploads/albums/'.$p->image) }}" width="100%">
                    </div>
                @endforeach
            </div>
            <!-- The Modal -->
            <div id="myModal" class="modal" onclick="document.getElementById('myModal').style.display='none'">

                <!-- The Close Button -->
                <span class="close" onclick="document.getElementById('myModal').style.display='none'">&times;</span>

                <!-- Modal Content (The Image) -->
                <img class="modal-content" id="img01">
            </div>
        </div>
    </section>
@stop
@section('scripts')

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
    </script>
@stop