@extends('admin.layout')

@section('scripts')

@stop
@section('content')
<div class="row">
    <div class="col-md-3">
        <section class="panel">
            <header class="panel-heading">
                {{ trans('admin/control.profilesOfGirls') }}
                    <span class="tools pull-right">
                    <a class="t-collapse fa fa-chevron-down" href="javascript:;"></a>
                </span>
            </header>
            <div class="panel-body" style="display: block;">
                <p ><a href="{{ url(App::getLocale().'/admin/girls') }}" class="text-primary"><strong>{{ trans('admin/control.allProfiles') }}:</strong><span class="label label-primary pull-right">{{ isset($girls) ? sizeof($girls): 0 }}</span></a></p>
                <p ><a href="{{ url(App::getLocale().'/admin/girls/active') }}" class="text-success"><strong>{{ trans('admin/control.active') }}:</strong></strong><span class="label label-success pull-right">{{ isset($active) ? sizeof($active): 0 }}</span></a></p>
                <p ><a href="{{ url(App::getLocale().'/admin/girls/moderation') }}" class="text-info"><strong>{{ trans('admin/control.moderation') }}:</strong><span class="label label-info pull-right">{{ isset($moderation) ? sizeof($moderation): 0 }}</span></a></p>
                <p ><a href="{{ url(App::getLocale().'/admin/girls/dismiss') }}" class="text-warning"><strong>{{ trans('admin/control.dismiss') }}:</strong><span class="label label-warning pull-right">{{ isset($dismiss) ? sizeof($dismiss): 0 }}</span></a></p>
                <p ><a href="{{ url(App::getLocale().'/admin/girls/deactive') }}" class="text-warning"><strong>{{ trans('admin/control.deactive') }}:</strong><span class="label label-warning pull-right">{{ isset($deactive) ? sizeof($deactive): 0 }}</span></a></p>
                <p ><a href="{{ url(App::getLocale().'/admin/girls/deleted') }}" class="text-danger"><strong>{{ trans('admin/control.deleted') }}:</strong><span class="label label-danger pull-right">{{ isset($deleted) ? sizeof($deleted): 0 }}</span></a></p>

            </div>
        </section>
    </div>
    <div class="col-md-3">
        @if(Auth::user()->hasRole('Owner') || Auth::user()->hasRole('Moder'))
            <section class="panel">
                <header class="panel-heading">
                    {{ trans('admin/control.users') }}
                        <span class="tools pull-right">
                        <a class="t-collapse fa fa-chevron-down" href="javascript:;"></a>
                    </span>
                </header>
                <div class="panel-body" style="display: block;">
                    <p class="text-success"><strong>{{ trans('admin/control.mans') }}:</strong></strong><span class="label label-success pull-right">{{ isset($man) ? sizeof($man): 0 }}</span> </p>
                    <hr/>
                    <p><a href="{{ url(App::getLocale().'/admin/partners') }}" class="text-primary"><strong>{{ trans('admin/control.partners') }}:</strong><span class="label label-primary pull-right">{{ isset($partner) ? sizeof($partner): 0 }}</span></a> </p>
                    @if(Auth::user()->hasRole('Owner'))
                        <p><a href="{{ url(App::getLocale().'/admin/moderators') }}" class="text-info"><strong>{{ trans('admin/control.moderators') }}:</strong></strong><span class="label label-info pull-right">{{ isset($moderator) ? sizeof($moderator): 0 }}</span></a></p>
                    @endif
                </div>
            </section>
        @endif
    </div>
    <div class="col-md-6">

    </div>
</div>
@stop
@section('scripts')

@stop