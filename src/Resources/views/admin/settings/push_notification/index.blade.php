<x-admin::layouts>
    <!-- Title of the page -->
    <x-slot:title>
        @lang('bagisto_graphql::app.admin.settings.notification.index.title')
    </x-slot>

    <div class="flex items-center justify-between gap-4 max-sm:flex-wrap">
        <!-- Page title -->
        <p class="text-xl font-bold text-gray-800 dark:text-white">
            @lang('bagisto_graphql::app.admin.settings.notification.index.title')
        </p>

        <!-- Add button -->
        @if (bouncer()->hasPermission('settings.push_notification.create'))
            <a
                href="{{ route('admin.settings.push_notification.create') }}"
                class="primary-button"
            >
                @lang('bagisto_graphql::app.admin.settings.notification.index.add-title')
            </a>
        @endif
    </div>

    <!-- Notification Datagrid -->
    <x-admin::datagrid src="{{ route('admin.settings.push_notification.index') }}" />
</x-admin::layouts>
