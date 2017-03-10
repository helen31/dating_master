@extends('admin.layout')

@section('styles')

@stop
@section('content')
    <section class="panel">
        <heading>

        </heading>
        <div class="panel-body">
            <table class="table table-hovered">
                <thead>
                <th>ID</th>
                <th>{{trans('/admin/index.name')}}/{{trans('/admin/index.surname')}}</th>
                <th>{{trans('/admin/index.avatar')}}</th>
                @if( Auth::user()->hasRole('Owner') )
                    <th>{{trans('/admin/index.partner')}}</th>
                @endif
                <th>Online</th>
                <th>Camera</th>
                <th>Hot</th>
                <th>{{trans('/admin/index.lastEntrance')}}</th>
                <th><i class="fa fa-cogs"></i>{{trans('/admin/index.control')}}</th>
                </thead>
                <tbody>
                @foreach($girls as $girl)
                    <tr>
                        <td>{{ $girl->id }}</td>
                        <td>{{ $girl->first_name }} {{ $girl->last_name }}</td>
                        <td><img width="150px" src="{{ url('uploads/'.$girl->avatar)}}"></td>
                        @if( Auth::user()->hasRole('Owner') )
                            <td>
                                @if($girl->partner_id != 1)
                                    <a href="{{ url('admin/partner/show/'.$girl->partner_id) }}">
                                        {{ \App\Http\Controllers\Admin\GirlsController::getPartnerNameByID($girl->partner_id) }}
                                    </a>
                                @else
                                   Admin
                                @endif
                            </td>
                        @endif

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
                            @if($girl->status->id == 4)<!-- Если анкета удалена, отображается только кнопка "Восстановить" -->
                                <a href="{{ url('/admin/girl/restore/'.$girl->id) }}" class="btn btn-danger btn-xs"><i class="fa fa-chevron-circle-up"></i>  Восстановить</a>
                            @else <!-- Если анкета не удалена - следующий набор кнопок -->
                                <a href="{{ url('/profile/show/'. $girl->id ) }}" class="btn btn-success btn-xs"><i class="fa fa-check"></i></a>
                                <a href="{{ url('/admin/girl/edit/'.$girl->id) }}" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a>
                                <a href="{{ url('/admin/girl/drop/'.$girl->id) }}" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></a>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {!! $girls->render() !!}
        </div>
    </section>
@stop
@section('scripts')

@stop