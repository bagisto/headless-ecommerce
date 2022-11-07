@extends('admin::layouts.content')

@section('page_title')
    {{ __('bagisto_graphql::app.admin.notification.title') }}
@stop

@section('content')
    <div class="content">
        <?php $locale = request()->get('locale') ?: null; ?>
        <?php $channel = request()->get('channel') ?: null; ?>

        <div class="page-header">
            <div class="page-title">
                <h1>{{ __('bagisto_graphql::app.admin.notification.title') }}</h1>
            </div>
            
            <div class="page-action">
                <a href="{{ route('admin.push_notification.create') }}" class="btn btn-lg btn-primary">
                    {{ __('bagisto_graphql::app.admin.notification.add-title') }}
                </a>
            </div>
        </div>

        <div class="page-content">
            <datagrid-plus src="{{ route('admin.push_notification.index') }}"></datagrid-plus>
        </div>
    </div>
@stop

@push('scripts')
    <script>
        function reloadPage(getVar, getVal) {
            let url = new URL(window.location.href);
            url.searchParams.set(getVar, getVal);

            window.location.href = url.href;
        }
        
    </script>
@endpush
