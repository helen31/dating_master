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
                <th>{{trans('/admin/index.online')}}</th>
                <th>VIP</th>
                <th>{{trans('/admin/index.lastEntrance')}}</th>
                <th><i class="fa fa-cogs"></i>{{trans('/admin/index.control')}}</th>
                </thead>
                <tbody>
                @foreach($men as $man)
                    <tr>
                        <td>{{ $man->id }}</td>
                        <td>{{ $man->first_name }} {{ $man->last_name }}</td>
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
                            @if($man->status->id == 4)<!-- Если анкета удалена, отображается только кнопка "Восстановить" -->
                                <a href="{{ url('/admin/man/restore/'.$man->id) }}" class="btn btn-danger btn-xs"><i class="fa fa-chevron-circle-up"></i>  Восстановить</a>
                            @else <!-- Если анкета не удалена - следующий набор кнопок -->
                                <a href="{{ url('/profile/show/'. $man->id ) }}" class="btn btn-success btn-xs"><i class="fa fa-check"></i></a>
                                <a href="{{ url('/admin/man/edit/'.$man->id) }}" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a>
                                <a href="{{ url('/admin/man/drop/'.$man->id) }}" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></a>
                            @endif
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