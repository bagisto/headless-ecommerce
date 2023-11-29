<x-admin::layouts>
    <x-slot:title>
        @lang('bagisto_graphql::app.admin.notification.title')
    </x-slot:title>

    <div class="flex gap-[16px] justify-between items-center max-sm:flex-wrap">
        <p class="text-[20px] text-gray-800 dark:text-white font-bold">
            @lang('bagisto_graphql::app.admin.notification.title')
        </p>
                
        <div class="flex gap-x-[10px] items-center">
            @if (bouncer()->hasPermission('settings.push_notification.create'))
                <a href="{{ route('admin.push_notification.create') }}">
                    <div class="primary-button">
                        @lang('bagisto_graphql::app.admin.notification.add-title')
                    </div>
                </a>
            @endif
        </div>      
    </div> 

    <x-admin::datagrid src="{{ route('admin.push_notification.index') }}"></x-admin::datagrid>
</x-admin::layouts>

@push('scripts')
    <script>
        function reloadPage(getVar, getVal) {
            let url = new URL(window.location.href);
            url.searchParams.set(getVar, getVal);

            window.location.href = url.href;
        }
        
    </script>
@endpush
