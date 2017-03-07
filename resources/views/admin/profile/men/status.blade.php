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
                <th>{{trans('/admin/index.lastEntrance')}}</th>
                <th><i class="fa fa-cogs"></i>{{trans('/admin/index.control')}}</th>
                </thead>
                <tbody>
                @foreach($men as $man)
                    <tr>
                        <td>{{ $man->id }}</td>
                        <td>{{ $man->first_name }} {{ $man->last_name }}</td>
                        <td><img width="150px" src="{{ url('uploads/'.$man->avatar)}}"></td>

                        <td>
                            @if($man->isOnline())
                                <button class="btn btn-small online_btn"> Online </button>
                            @else
                                <span class="red">{{ trans('admin.No') }}</span>
                            @endif
                        </td>

                        <td> {{ $man->last_login }} </td>
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