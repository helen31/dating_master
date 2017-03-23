@section('style')

@stop
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
                <th>{{trans('/admin/index.name')}}/{{trans('/admin/index.surname')}}</th>
                <th>{{trans('/admin/index.avatar')}}</th>
                <th>{{trans('/admin/index.online')}}</th>
                <th>VIP</th>
                <th>{{trans('/admin/index.lastEntrance')}}</th>
                <th><i class="fa fa-cogs"></i> {{trans('/admin/index.control')}}</th>
                </thead>
                <tbody>
                @foreach($men as $man)
                    <tr>
                        <td>{{ $man->id }}</td>
                        <td>
                            <p><strong>{{ $man->first_name }} {{ $man->last_name }}</strong></p>
                            <p class="{{ 'grg-'.$man->stat_name }}">{{ trans('admin/index.'.$man->stat_name) }}</p>
                        </td>
                        <td><img width="150px" src="{{ url('uploads/users/avatars/'.$man->avatar)}}"></td>

                        <td style="text-align:center;">
                            @if($man->isOnline())
                                <i class="fa fa-eye"></i>
                                <p>Online</p>
                            @else
                                -
                            @endif
                        </td>
                        <td style="text-align:center;">
                            @if($man->vip == 1)
                                <i class="fa fa-star"></i>
                                <p>VIP</p>
                            @else
                                -
                            @endif
                        </td>

                        <td>
                            <p>{{ date('d-m-Y', strtotime($man->last_login)) }}</p>
                            <p><i class="fa fa-clock-o"></i>  {{ date('H:i', strtotime($man->last_login)) }}</p>
                        </td>
                        <td>
                            <a target="_blank" href="{{ url(App::getLocale().'/profile/show/'.$man->id) }}" class="btn btn-success btn-xs"><i class="fa fa-check"></i></a>
                            <a href="{{ url(App::getLocale().'/admin/man/edit/'.$man->id) }}" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a>
                            <a href="{{ url(App::getLocale().'/admin/man/drop/'.$man->id) }}" class="btn btn-danger btn-xs" ><i class="fa fa-trash-o "></i></a>
                            <!--
                            <a data-toggle="tooltip" data-placement="bottom" data-original-title="{{trans('/admin/index.sender')}}" href="{{ url(App::getLocale().'/admin/sender/new/'.$man->id) }}" class="btn btn-primary btn-xs"><i class="fa fa-comment-o"></i></a>
                            -->
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {!! $men->render() !!}
        </div>
    </section>
@stop
@section('scripts')

@stop