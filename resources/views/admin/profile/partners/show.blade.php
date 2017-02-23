@extends('admin.layout')

@section('styles')

@stop

@section('content')
    <div class="container panel">
        <header class="panel-heading">
            {{ $user->first_name }} {{ $user->last_name }}
        </header>
        <div class="panel-body">
            <div class="col-md-6">
                <img class="img-responsive" src="{{ url( '/uploads/admins/'. $user->avatar ) }}">
            </div>
            <div class="col-md-6">
                <div class="row">
                    <b>Имя / фамилия:</b> {{ $user->first_name }} {{ $user->last_name }}
                </div>

                <div class="row">
                    <b>Адрес:</b>  {{ $user->address }}
                </div>

                <div class="row">
                    <b>Контакты:</b>  {{ $user->contacts }}
                </div>

                <div class="row">
                    <b>Информация:</b>  {{ $user->info }}
                </div>

                <div class="row">
                    <b>Компания:</b> {{ $user->company_name }}
                </div>
                <div class="row">
                    <b>Телефон:</b> {{ $user->phone }}
                </div>
                <div class="row">
                    <b>Email:</b> {{ $user->email }}
                </div>
            </div>
        </div>
    </div>

@stop

@section('scripts')

@stop