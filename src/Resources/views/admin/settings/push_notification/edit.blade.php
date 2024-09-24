@php
    $channels = core()->getAllChannels();

    $currentChannel = core()->getRequestedChannel();

    $currentLocale = core()->getRequestedLocale();

    $notificationTranslation = $notification->translations()
        ->where('channel', $currentChannel->code)
        ->where('locale', $currentLocale->code)
        ->first();
@endphp

<x-admin::layouts>
    <!-- Title of the page -->
    <x-slot:title>
        @lang('bagisto_graphql::app.admin.settings.notification.edit.edit-notification')
    </x-slot:title>

    <!-- Edit Notification Components -->
    <v-edit-notification></v-edit-notification>

    @pushOnce('scripts')
        <script
            type="text/x-template"
            id="v-edit-notification-template"
        >
            <!-- Notification Edit Form -->
            <x-admin::form
                :action="route('admin.settings.push_notification.update', $notification->id)"
                enctype="multipart/form-data"
                method="PUT"
            >
                <div class="flex items-center justify-between gap-4 max-sm:flex-wrap">
                    <p class="text-xl font-bold leading-6 text-gray-800 dark:text-white">
                        @lang('bagisto_graphql::app.admin.settings.notification.edit.edit-notification')
                    </p>

                    <div class="flex items-center gap-x-2.5">
                        <!-- Cancel Button -->
                        <a
                            href="{{ route('admin.settings.push_notification.index') }}"
                            class="transparent-button hover:bg-gray-200 dark:hover:bg-gray-800 dark:text-white "
                        >
                            @lang('bagisto_graphql::app.admin.settings.notification.edit.back-btn')
                        </a>

                        <!-- Send Notification -->
                        @if (
                            core()->getConfigData('general.api.pushnotification.private_key')
                            && $notification->status
                        )
                            <a
                                href="{{ route('admin.settings.push_notification.send_notification', $notification['id']) }}"
                                class="primary-button"
                            >
                                @lang('bagisto_graphql::app.admin.settings.notification.edit.send-title')
                            </a>
                        @endif

                        <!-- Save Button -->
                        <button
                            type="submit"
                            class="primary-button"
                        >
                            @lang('bagisto_graphql::app.admin.settings.notification.edit.update-btn-title')
                        </button>
                    </div>
                </div>

                <!-- Channel and Locale Switcher -->
                <div class="mt-7 flex items-center justify-between gap-4 max-md:flex-wrap">
                    <div class="flex items-center gap-x-1">
                        <!-- Channel Switcher -->
                        <x-admin::dropdown :class="$channels->count() <= 1 ? 'hidden' : ''">
                            <!-- Dropdown Toggler -->
                            <x-slot:toggle>
                                <button
                                    type="button"
                                    class="transparent-button px-1 py-1.5 hover:bg-gray-200 focus:bg-gray-200 dark:text-white dark:hover:bg-gray-800 dark:focus:bg-gray-800"
                                >
                                    <span class="icon-store text-2xl"></span>

                                    {{ $currentChannel->name }}

                                    <input
                                        type="hidden"
                                        name="channel"
                                        value="{{ $currentChannel->code }}"
                                    />

                                    <span class="icon-sort-down text-2xl"></span>
                                </button>
                            </x-slot:toggle>

                            <!-- Dropdown Content -->
                            <x-slot:content class="!p-0">
                                @foreach ($channels as $channel)
                                    <a
                                        href="?{{ Arr::query(['channel' => $channel->code, 'locale' => $currentLocale->code]) }}"
                                        class="flex cursor-pointer gap-2.5 px-5 py-2 text-base hover:bg-gray-100 dark:text-white dark:hover:bg-gray-950"
                                    >
                                        {{ $channel->name }}
                                    </a>
                                @endforeach
                            </x-slot:content>
                        </x-admin::dropdown>

                        <!-- Locale Switcher -->
                        <x-admin::dropdown>
                            <!-- Dropdown Toggler -->
                            <x-slot:toggle>
                                <button
                                    type="button"
                                    class="transparent-button px-1 py-1.5 hover:bg-gray-200 focus:bg-gray-200 dark:text-white dark:hover:bg-gray-800 dark:focus:bg-gray-800"
                                >
                                    <span class="icon-language text-2xl"></span>

                                    {{ $currentLocale->name }}
                                    
                                    <input
                                        type="hidden"
                                        name="locale"
                                        value="{{ $currentLocale->code }}"
                                    />
        
                                    <span class="icon-sort-down text-2xl"></span>
                                </button>
                            </x-slot:toggle>

                            <!-- Dropdown Content -->
                            <x-slot:content class="!p-0">
                                @foreach ($currentChannel->locales as $locale)
                                    <a
                                        href="?{{ Arr::query(['channel' => $currentChannel->code, 'locale' => $locale->code]) }}"
                                        class="flex gap-2.5 px-5 py-2 text-base cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-950 dark:text-white {{ $locale->code == $currentLocale->code ? 'bg-gray-100 dark:bg-gray-950' : ''}}"
                                    >
                                        {{ $locale->name }}
                                    </a>
                                @endforeach
                            </x-slot:content>
                        </x-admin::dropdown>
                    </div>
                </div>

                <!-- body content -->
                <div class="mt-3.5 flex gap-2.5 max-xl:flex-wrap">
                    <!-- Left sub Component -->
                    <div class="flex flex-1 flex-col gap-2 max-xl:flex-auto">

                        {!! view_render_event('graphql::app.admin.settings.notification.edit_form_accordian.notification.before', ['notification' => $notification]) !!}

                        <!-- General -->
                        <div class="box-shadow rounded bg-white p-4 dark:bg-gray-900">
                            <p class="mb-4 text-base font-semibold text-gray-800 dark:text-white">
                                @lang('bagisto_graphql::app.admin.settings.notification.edit.general')
                            </p>

                            <!-- Locales -->
                            <x-admin::form.control-group.control
                                type="hidden"
                                name="locale"
                                value="{{ $notificationTranslation?->locale ?? $currentLocale->code }}"
                            />

                            <!-- Title -->
                            <x-admin::form.control-group class="mb-2.5">
                                <x-admin::form.control-group.label class="required">
                                    @lang('bagisto_graphql::app.admin.settings.notification.edit.title')
                                </x-admin::form.control-group.label>

                                <x-admin::form.control-group.control
                                    type="text"
                                    name="title"
                                    :value="old('title') ?: $notificationTranslation?->title"
                                    rules="required"
                                    :label="trans('bagisto_graphql::app.admin.settings.notification.edit.title')"
                                    :placeholder="trans('bagisto_graphql::app.admin.settings.notification.edit.title')"
                                />

                                <x-admin::form.control-group.error control-name="title" />
                            </x-admin::form.control-group>
                        </div>

                        <!-- Description and images -->
                        <div class="box-shadow rounded bg-white p-4 dark:bg-gray-900">
                            <p class="mb-4 text-base font-semibold text-gray-800 dark:text-white">
                                @lang('bagisto_graphql::app.admin.settings.notification.edit.content-and-image')
                            </p>

                            <!-- Content -->
                            <v-description>
                                <x-admin::form.control-group class="mb-2.5">
                                    <x-admin::form.control-group.label class="required">
                                        @lang('bagisto_graphql::app.admin.settings.notification.edit.notification-content')
                                    </x-admin::form.control-group.label>

                                    <x-admin::form.control-group.control
                                        type="textarea"
                                        name="content"
                                        id="content"
                                        class="content"
                                        :value="old('content') ?: $notificationTranslation?->content"
                                        :label="trans('bagisto_graphql::app.admin.settings.notification.edit.notification-content')"
                                        rules="required"
                                        :tinymce="true"
                                    />

                                    <x-admin::form.control-group.error control-name="content" />
                                </x-admin::form.control-group>
                            </v-description>

                            <!-- Add Image -->
                            <div class="flex flex-col gap-2">
                                <p class="text-gray-800 dark:text-white font-medium">
                                    @lang('bagisto_graphql::app.admin.settings.notification.edit.image')
                                </p>

                                <x-admin::media.images
                                    name="image"
                                    :uploaded-images="$notification->image ? [
                                        [
                                            'id'  => 'image',
                                            'url' => Storage::url($notification->image)
                                        ]
                                    ] : []"
                                />
                            </div>
                        </div>
                    </div>

                    <!-- Right Section -->
                    <div class="flex w-[360px] max-w-full flex-col gap-2">
                        <!-- Settings -->
                        <div class="box-shadow rounded bg-white p-4 dark:bg-gray-900">
                            <p class="mb-4 text-base font-semibold text-gray-800 dark:text-white">
                                @lang('bagisto_graphql::app.admin.settings.notification.edit.settings')
                            </p>

                            <!-- Visible in menu -->
                            <x-admin::form.control-group>
                                <x-admin::form.control-group.label class="text-gray-800 dark:text-white font-medium">
                                    @lang('bagisto_graphql::app.admin.settings.notification.edit.status')
                                </x-admin::form.control-group.label>

                                <input
                                    type="hidden"
                                    name="status"
                                    value="0"
                                />

                                @php $selectedOption = old('status') ?: $notification->status @endphp

                                <x-admin::form.control-group.control
                                    type="switch"
                                    name="status"
                                    value="1"
                                    :label="trans('graphql::app.admin.settings.notification.edit.status')"
                                    :checked="(bool) $selectedOption"
                                />
                            </x-admin::form.control-group>

                            <x-admin::form.control-group class="mb-2.5">
                                <x-admin::form.control-group.label class="required">
                                    @lang('bagisto_graphql::app.admin.settings.notification.edit.notification-type')
                                </x-admin::form.control-group.label>

                                <x-admin::form.control-group.control
                                    type="select"
                                    name="type"
                                    rules="required"
                                    :value="old('type')"
                                    id="type"
                                    class="cursor-pointer"
                                    :label="trans('bagisto_graphql::app.admin.settings.notification.edit.notification-type')"
                                    v-model="notificationType"
                                    @change="showHideOptions($event)"
                                >
                                    <!-- Here! All Needed types are defined -->
                                    @foreach(['others', 'product', 'category'] as $type)
                                        <option
                                            value="{{ $type }}"
                                            {{ $selectedOption == $type ? 'selected' : '' }}
                                        >
                                            @lang('bagisto_graphql::app.admin.settings.notification.edit.option-type.'. $type)
                                        </option>
                                    @endforeach
                                </x-admin::form.control-group.control>

                                <x-admin::form.control-group.error control-name="type" />
                            </x-admin::form.control-group>

                            <x-admin::form.control-group
                                class="mb-2.5"
                                v-if="showProductCategory"
                                id="product_category"
                            >
                                <x-admin::form.control-group.label class="required">
                                    @lang('bagisto_graphql::app.admin.settings.notification.edit.product-cat-id')
                                </x-admin::form.control-group.label>

                                <v-field
                                    type="text"
                                    name="product_category_id"
                                    value="{{ old('product_category_id') }}"
                                    label="{{ trans('bagisto_graphql::app.admin.settings.notification.edit.product-cat-id') }}"
                                    v-validate="showProductCategory ? 'required' : ''"
                                    v-slot="{ field }"
                                >
                                    <input
                                        type="text"
                                        name="product_category_id"
                                        id="product_category_id"
                                        v-model="productCategoryInputBox"
                                        @keyup="checkIdExistOrNot"
                                        :class="[errors['{{ 'product_category_id' }}'] ? 'border border-red-600 hover:border-red-600' : '']"
                                        class="flex w-full min-h-[39px] py-2 px-3 border rounded-[6px] text-[14px] text-gray-600 dark:text-gray-300 transition-all hover:border-gray-400 dark:hover:border-gray-400 dark:focus:border-gray-400 focus:border-gray-400 dark:bg-gray-900 dark:border-gray-800"
                                        placeholder="{{ trans('bagisto_graphql::app.admin.settings.notification.edit.product-cat-id') }}"
                                        v-code
                                    >
                                </v-field>

                                <x-admin::form.control-group.error control-name="product_category_id" />

                                <span
                                    class="mt-1 text-xs italic text-red-600"
                                    v-show="! isValid"
                                >
                                    @{{ message }}
                                </span>
                            </x-admin::form.control-group>
                        </div>

                        <div class="box-shadow rounded bg-white p-4 dark:bg-gray-900">
                            <p class="required pb-2.5 text-base font-semibold text-gray-800 dark:text-white">
                                @lang('bagisto_graphql::app.admin.settings.notification.edit.store-view')
                            </p>

                            @php
                                $selectedChannels = old('channels') ?: $notification->translations->pluck('channel')->toArray();
                            @endphp

                            @foreach (core()->getAllChannels() as $channel)
                                <x-admin::form.control-group class="!mb-2 flex select-none items-center gap-2.5 last:!mb-0">
                                    <x-admin::form.control-group.control
                                        type="checkbox"
                                        name="channels[]"
                                        :value="$channel->code"
                                        :id="'channels_'.$channel->id"
                                        :for="'channels_'.$channel->id"
                                        rules="required"
                                        :label="trans('bagisto_graphql::app.admin.settings.notification.edit.store-view')"
                                        :checked="in_array($channel->code, $selectedChannels)"
                                    />

                                    <label
                                        class="cursor-pointer text-xs font-medium text-gray-600 dark:text-gray-300"
                                        for="'channels_'.$channel->id"
                                    >
                                        {{ core()->getChannelName($channel) }}
                                    </label>
                                </x-admin::form.control-group>
                            @endforeach

                            <x-admin::form.control-group.error control-name="channels[]" />
                        </div>
                    </div>
                </div>
            </x-admin::form>
        </script>

        <script type="module">
            app.component('v-edit-notification', {
                template: '#v-edit-notification-template',

                inject: ['$validator'],

                data() {
                    return {
                        showProductCategory:  "{{ $notification->type }}" != 'others' ,

                        valid: '',

                        notificationType : '{{ old('type') ?: $notification->type }}',

                        productCategoryInputBox : '{{ old('product_category_id') ?: $notification->product_category_id }}',

                        message: '',

                        isValid: false,
                    }
                },

                methods: {
                    showHideOptions(event) {
                        this.notificationType = event.target.value;

                        if (this.notificationType == "{{ $notification->type }}") {
                            this.productCategoryInputBox = "{{ $notification->product_category_id }}";
                        } else {
                            this.productCategoryInputBox = '';
                        }

                        this.showProductCategory = false;

                        if (
                            event.target.value == 'product'
                            || event.target.value == 'category'
                        ) {
                            this.showProductCategory = true;
                        }
                    },

                    //id exist or not
                    checkIdExistOrNot(event) {
                        var selectedType = this.notificationType;
                        var givenValue = this.productCategoryInputBox;
                        var spaceCount = (givenValue.split(" ").length - 1);

                        if (spaceCount > 0) {
                            this.isValid = true;

                            return false;
                        }

                        this.$axios.post("{{ route('admin.settings.push_notification.cat-product-id') }}", {
                            givenValue: givenValue,
                            selectedType: selectedType
                        })
                            .then(response => {
                                var productCategory = document.getElementById('product_category');

                                if (response.data.value) {
                                    productCategory.classList.remove('has-error');
                                    this.isValid = response.data.value;
                                    this.message = response.data.message;
                                } else {
                                    productCategory.classList.add('has-error');
                                    this.message = response.data.message;
                                    this.isValid = response.data.value;
                                }
                            }).catch((error) => {
                                console.log(error);
                            });
                    },
                },
            });
        </script>
    @endPushOnce
</x-admin::layouts>
