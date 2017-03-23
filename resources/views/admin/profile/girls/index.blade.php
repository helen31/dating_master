@extends('admin.layout')

@section('content')
    <!-- Набор стилей для обозначения статуса анкеты в админке -->
    <style>
        .grg-active,
        .grg-onmoderation,
        .grg-dismiss,
        .grg-deactive,
        .grg-deleted,
        .grg-noprofile
        {
            padding:4px;
            text-align:center;
            color: #FFF;
        }
        .grg-active{
            background-color: #00D035;
        }
        .grg-onmoderation{
            background-color: #69C2FE;
        }
        .grg-dismiss{
            background-color: #E58226;
        }
        .grg-deactive{
            background-color: #E4BA00;
        }
        .grg-deleted{
            background-color: #E55957;
        }
        .grg-noprofile{
            background-color: #777777;
        }
    </style>

    <section class="panel">
        <heading>

        </heading>
        <div class="panel-body">
            <table class="table table-hovered">
                <thead>
                    <th>ID</th>
                    <th>Имя/Фамилия</th>
                    <th>{{ trans('/admin/index.avatar') }}</th>
                    <th>{{ trans('/admin/index.online') }}</th>
                    <th>Camera</th>
                    <th>Hot</th>
                    <th>Посл. вход</th>
                    <th><i class="fa fa-cogs"></i> {{ trans('/admin/index.control') }}</th>
                </thead>
                <tbody>
                @foreach($girls as $girl)
                    <tr>
                        <td>{{ $girl->id }}</td>
                        <td>
                            <p><strong>{{ $girl->first_name }} {{ $girl->last_name }}</strong></p>
                            <p class="{{ 'grg-'.$girl->stat_name }}">{{ trans('admin/index.'.$girl->stat_name) }}</p>
                            @if(Auth::user()->hasRole('Owner') || Auth::user()->hasRole('Moder'))
                                @if($girl->partner_id != 1)
                                    <p><i>Партнер: <a href="{{ url('admin/partner/show/'.$girl->partner_id) }}">{{ \App\Http\Controllers\Admin\GirlsController::getPartnerNameByID($girl->partner_id) }}</a></i></p>
                                @endif
                            @endif
                        </td>
                        <td><img width="150px" src="{{ url('uploads/users/avatars/'.$girl->avatar)}}"></td>

                        <td style="text-align:center;">
                            @if($girl->isOnline())
                                <i class="fa fa-eye"></i>
                                <p>Online</p>
                            @else
                                -
                            @endif
                        </td>
                        <td style="text-align:center;">
                            @if($girl->webcam !== 0)
                                <i class="fa fa-desktop"></i>
                                <p>WebCam</p>
                            @else
                                -
                            @endif
                        </td>
                        <td style="text-align:center;">
                            @if($girl->hot !== 0)
                                <i class="fa fa-heart"></i>
                                <p>Hot</p>
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            <p>{{ date('d-m-Y', strtotime($girl->last_login)) }}</p>
                            <p><i class="fa fa-clock-o"></i>  {{ date('H:i', strtotime($girl->last_login)) }}</p>
                        </td>

                        <td>
                            <a target="_blank" href="{{ url(App::getLocale().'/profile/show/'.$girl->id) }}" class="btn btn-success btn-xs"><i class="fa fa-check"></i></a>
                            @if( Auth::user()->hasRole('Owner') )
                                <a id="button-migrate-user" onclick="ChangeOpen('{{$girl->id}}','{{$girl->partner_id}}');" data-toggle="modal" data-target="#migrate-user" href="#" class="btn btn-warning btn-xs"><i class="fa fa-arrows-h"></i></a>
                            @endif
                            <a href="{{ url(App::getLocale().'/admin/girl/edit/'.$girl->id) }}" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a>
                            <a href="{{ url(App::getLocale().'/admin/girl/drop/'.$girl->id) }}" class="btn btn-danger btn-xs" ><i class="fa fa-trash-o "></i></a>
                            <a data-toggle="tooltip" data-placement="bottom" data-original-title="{{trans('/admin/index.sender')}}" href="{{ url(App::getLocale().'/admin/sender/new/'.$girl->id) }}" class="btn btn-primary btn-xs"><i class="fa fa-comment-o"></i></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {!! $girls->render() !!}
        </div>
    </section>
    @if( Auth::user()->hasRole('Owner') )
        <div class="modal fade in" id="migrate-user" tabindex="-1" role="dialog" aria-labelledby="migrate-user" style="display: none;">
            <style>
                .modal-body {
                    width: 100%;
                    display: inline-block;
                    padding: 0!important;
                }
                .modalContent {
                    background: url(/assets/img/patterns/gray_pattern.gif);
                    border: 10px solid #fafafa;
                    padding: 15px;
                }
            </style>
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="modalContent col-md-12">
                            <div class="col-md-12" style="margin-bottom: 15px">
                                <div class="pull-right">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                </div>
                                <h4 class="pull-left"><i class="fa fa-magic"></i>Change partner</h4>
                            </div>
                            {!! Form::open(['url' => '/admin/girl/changepartner', 'class' => 'form', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                                <input type="hidden" name="girl_id" value="">

                                <div class="form-group col-md-12">
                                    <label for="first_name">Current partner</label>
                                    <select type="text" name="partner_list" class="form-control" placeholder="First Name" required="">
                                            <option value="1">Administrator</option>
                                        @foreach($partners as $parnter)
                                            <option value="{{$parnter->id}}">{{'('.$parnter->id.') '.$parnter->first_name.' '.$parnter->last_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-12" style="    text-align: center;">
                                    <button class="btn btn-pink btn-sm" type="submit" id="createAccount">Change partner</button>
                                </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <script>
        function ChangeOpen(girl_id,partner_id) {
            if(partner_id==0){
                $("select[name='partner_list']").val(1).change();
            }
            $("input[name='girl_id']").val(girl_id);
            $("select[name='partner_list']").val(partner_id).change();
        }
    </script>
@stop
@section('scripts')

@stop