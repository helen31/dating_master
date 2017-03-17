@extends('admin.layout')

@section('styles')
    <style>
        .grg-noprofile{
            color: #777777;
        }
    </style>
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
                <p ><a href="{{ url(App::getLocale().'/admin/girls/noprofile') }}" class="text-danger grg-noprofile"><strong>{{ trans('admin/control.noprofile') }}:</strong><span class="label label-default pull-right">{{ isset($noprofile) ? sizeof($noprofile): 0 }}</span></a></p>
            </div>
        </section>
    </div>
    <div class="col-md-3">
        @if(Auth::user()->hasRole('Owner') || Auth::user()->hasRole('Moder'))
            <section class="panel">
                <header class="panel-heading">
                    {{ trans('admin/control.profilesOfMen') }}
                    <span class="tools pull-right">
                        <a class="t-collapse fa fa-chevron-down" href="javascript:;"></a>
                    </span>
                </header>
                <div class="panel-body" style="display: block;">
                    <p ><a href="{{ url(App::getLocale().'/admin/men') }}" class="text-primary"><strong>{{ trans('admin/control.allProfiles') }}:</strong><span class="label label-primary pull-right">{{ isset($men) ? sizeof($men): 0 }}</span></a></p>
                    <p ><a href="{{ url(App::getLocale().'/admin/man/active') }}" class="text-success"><strong>{{ trans('admin/control.active') }}:</strong></strong><span class="label label-success pull-right">{{ isset($m_active) ? sizeof($m_active): 0 }}</span></a></p>
                    <p ><a href="{{ url(App::getLocale().'/admin/man/moderation') }}" class="text-info"><strong>{{ trans('admin/control.moderation') }}:</strong><span class="label label-info pull-right">{{ isset($m_moderation) ? sizeof($m_moderation): 0 }}</span></a></p>
                    <p ><a href="{{ url(App::getLocale().'/admin/man/dismiss') }}" class="text-warning"><strong>{{ trans('admin/control.dismiss') }}:</strong><span class="label label-warning pull-right">{{ isset($m_dismiss) ? sizeof($m_dismiss): 0 }}</span></a></p>
                    <p ><a href="{{ url(App::getLocale().'/admin/man/deactive') }}" class="text-warning"><strong>{{ trans('admin/control.deactive') }}:</strong><span class="label label-warning pull-right">{{ isset($m_deactive) ? sizeof($m_deactive): 0 }}</span></a></p>
                    <p ><a href="{{ url(App::getLocale().'/admin/man/deleted') }}" class="text-danger"><strong>{{ trans('admin/control.deleted') }}:</strong><span class="label label-danger pull-right">{{ isset($m_deleted) ? sizeof($m_deleted): 0 }}</span></a></p>
                    <p ><a href="{{ url(App::getLocale().'/admin/man/noprofile') }}" class="text-danger grg-noprofile"><strong>{{ trans('admin/control.noprofile') }}:</strong><span class="label label-default pull-right">{{ isset($m_noprofile) ? sizeof($m_noprofile): 0 }}</span></a></p>
                </div>
            </section>
        @endif
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