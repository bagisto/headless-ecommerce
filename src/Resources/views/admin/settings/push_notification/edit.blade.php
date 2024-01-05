@php
    $channels = core()->getAllChannels();

    $currentChannel = core()->getRequestedChannel();

    $currentLocale = core()->getRequestedLocale();

    $notificationTranslation = $notification->translations->where('channel', $currentChannel->code)->where('locale', $currentLocale->code)->first();
@endphp

<x-admin::layouts>
    {{-- Title of the page --}}
    <x-slot:title>
        @lang('bagisto_graphql::app.admin.settings.notification.edit.edit-notification')
    </x-slot:title>

    {{-- Edit Notification Vue Components --}}
    <v-edit-notification></v-edit-notification>

    @pushOnce('scripts')
        <script
            type="text/x-template"
            id="v-edit-notification-template"
        >
            <!-- Input Form -->
            <x-admin::form
                :action="route('admin.settings.push_notification.update', $notification->id)"
                enctype="multipart/form-data"
                method="PUT"
            >
                <div class="flex justify-between items-center">
                    <p class="text-[20px] text-gray-800 dark:text-white font-bold">
                        @lang('bagisto_graphql::app.admin.settings.notification.edit.edit-notification')
                    </p>

                    <div class="flex gap-x-[10px] items-center">
                        <!-- Cancel Button -->
                        <a
                            href="{{ route('admin.settings.push_notification.index') }}"
                            class="transparent-button hover:bg-gray-200 dark:hover:bg-gray-800 dark:text-white "
                        >
                            @lang('bagisto_graphql::app.admin.settings.notification.edit.back-btn')
                        </a>

                        <!-- Send Notification -->
                        <a href="{{ route('admin.settings.push_notification.send-notification', $notification['id']) }}"  class="primary-button">
                            {{ __('bagisto_graphql::app.admin.settings.notification.edit.send-title') }}
                        </a>

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
                <div class="flex  gap-[16px] justify-between items-center mt-[28px] max-md:flex-wrap">
                    <div class="flex gap-x-[4px] items-center">
                        <!-- Channel Switcher -->
                        <x-admin::dropdown :class="$channels->count() <= 1 ? 'hidden' : ''">
                            <!-- Dropdown Toggler -->
                            <x-slot:toggle>
                                <button
                                    type="button"
                                    class="transparent-button px-[4px] py-[6px] hover:bg-gray-200 dark:hover:bg-gray-800  focus:bg-gray-200 dark:focus:bg-gray-800 dark:text-white"
                                >
                                    <span class="icon-store text-[24px] "></span>

                                    {{ $currentChannel->name }}

                                    <input type="hidden" name="channel" value="{{ $currentChannel->code }}"/>

                                    <span class="icon-sort-down text-[24px]"></span>
                                </button>
                            </x-slot:toggle>

                            <!-- Dropdown Content -->
                            <x-slot:content class="!p-[0px]">
                                @foreach ($channels as $channel)
                                    <a
                                        href="?{{ Arr::query(['channel' => $channel->code, 'locale' => $currentLocale->code]) }}"
                                        class="flex gap-[10px] px-5 py-2 text-[16px] cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-950 dark:text-white  "
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
                                    class="transparent-button px-[4px] py-[6px] hover:bg-gray-200 dark:hover:bg-gray-800  focus:bg-gray-200 dark:focus:bg-gray-800 dark:text-white"
                                >
                                    <span class="icon-language text-[24px] "></span>

                                    {{ $currentLocale->name }}

                                    <input type="hidden" name="locale" value="{{ $currentLocale->code }}"/>

                                    <span class="icon-sort-down text-[24px]"></span>
                                </button>
                            </x-slot:toggle>

                            <!-- Dropdown Content -->
                            <x-slot:content class="!p-[0px]">
                                @foreach ($currentChannel->locales as $locale)
                                    <a
                                        href="?{{ Arr::query(['channel' => $currentChannel->code, 'locale' => $locale->code]) }}"
                                        class="flex gap-[10px] px-5 py-2 text-[16px] cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-950 dark:text-white   {{ $locale->code == $currentLocale->code ? 'bg-gray-100 dark:bg-gray-950' : ''}}"
                                    >
                                        {{ $locale->name }}
                                    </a>
                                @endforeach
                            </x-slot:content>
                        </x-admin::dropdown>
                    </div>
                </div>

                <!-- body content -->
                <div class="flex gap-[10px] mt-[14px]">
                    <!-- Left sub Component -->
                    <div class="flex flex-col gap-[8px] flex-1">

                        {!! view_render_event('graphql::app.admin.settings.notification.edit_form_accordian.notification.before', ['notification' => $notification]) !!}

                        <!-- General -->
                        <div class="p-[16px] bg-white dark:bg-gray-900  rounded-[4px] box-shadow">
                            <p class="mb-[16px] text-[16px] text-gray-800 dark:text-white font-semibold">
                                @lang('bagisto_graphql::app.admin.settings.notification.edit.general')
                            </p>

                            <!-- Locales -->
                            <x-admin::form.control-group.control
                                type="hidden"
                                name="locale"
                                value="{{ $notificationTranslation->locale }}"
                            >
                            </x-admin::form.control-group.control>

                            <!-- Title -->
                            <x-admin::form.control-group class="mb-[10px]">
                                <x-admin::form.control-group.label class="required">
                                    @lang('bagisto_graphql::app.admin.settings.notification.edit.title')
                                </x-admin::form.control-group.label>

                                <x-admin::form.control-group.control
                                    type="text"
                                    name="title"
                                    :value="old('title') ?: $notificationTranslation->title"
                                    rules="required"
                                    :label="trans('bagisto_graphql::app.admin.settings.notification.edit.title')"
                                    :placeholder="trans('bagisto_graphql::app.admin.settings.notification.edit.title')"
                                >
                                </x-admin::form.control-group.control>

                                <x-admin::form.control-group.error
                                    control-name="title"
                                >
                                </x-admin::form.control-group.error>
                            </x-admin::form.control-group>
                        </div>

                        <!-- Description and images -->
                        <div class="p-[16px] bg-white dark:bg-gray-900  rounded-[4px] box-shadow">
                            <p class="mb-[16px] text-[16px] text-gray-800 dark:text-white font-semibold">
                                @lang('bagisto_graphql::app.admin.settings.notification.edit.content-and-image')
                            </p>

                            <!-- Content -->
                            <v-description>
                                <x-admin::form.control-group class="mb-[10px]">
                                    <x-admin::form.control-group.label class="required">
                                        @lang('bagisto_graphql::app.admin.settings.notification.edit.notification-content')
                                    </x-admin::form.control-group.label>

                                    <x-admin::form.control-group.control
                                        type="textarea"
                                        name="content"
                                        id="content"
                                        class="content"
                                        :value="old('content') ?: $notificationTranslation->content"
                                        :label="trans('bagisto_graphql::app.admin.settings.notification.edit.notification-content')"
                                        rules="required"
                                        :tinymce="true"
                                    >
                                    </x-admin::form.control-group.control>

                                    <x-admin::form.control-group.error
                                        control-name="content"
                                    >
                                    </x-admin::form.control-group.error>
                                </x-admin::form.control-group>
                            </v-description>

                            <!-- Add Image -->
                            <div class="flex gap-[50px]">
                                <div class="flex flex-col gap-[8px] w-[40%] mt-5">
                                    <p class="text-gray-800 dark:text-white font-medium">
                                        @lang('bagisto_graphql::app.admin.settings.notification.edit.image')
                                    </p>

                                    <x-admin::media.images
                                        name="image"
                                        :uploaded-images="$notification->image ? [['id' => 'logo_path', 'url' => $notification->image_url]] : ''"
                                    ></x-admin::media.images>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Section -->
                    <div class="flex flex-col gap-[8px] w-[360px] max-w-full">
                        <!-- Settings -->
                        <x-admin::accordion>
                            <x-slot:header>
                                <p class="p-[10px] text-gray-600 dark:text-gray-300 text-[16px] font-semibold">
                                    @lang('bagisto_graphql::app.admin.settings.notification.edit.settings')
                                </p>
                            </x-slot:header>

                            <x-slot:content>

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
                                    >
                                    </x-admin::form.control-group.control>
                                </x-admin::form.control-group>

                                <!-- Select Channels -->
                                <p class="required block leading-[24px] text-gray-800 dark:text-white font-medium">
                                    @lang('bagisto_graphql::app.admin.settings.notification.edit.store-view')
                                </p>

                                @foreach($channels as $channel)
                                    <x-admin::form.control-group class="flex gap-[10px] !mb-0 p-[6px]">
                                        @php
                                            $selectedOption = $notificationTranslation->channel ? $notificationTranslation->channel == $channel->code : old('channels')
                                        @endphp

                                        <x-admin::form.control-group.control
                                            type="checkbox"
                                            name="channels[]"
                                            :value="$channel->code"
                                            :id="'channels_' . $channel->id"
                                            :for="'channels_' . $channel->id"
                                            rules="required"
                                            :label="trans('bagisto_graphql::app.admin.settings.notification.edit.store-view')"
                                            :checked="(boolean) $selectedOption"
                                        >
                                        </x-admin::form.control-group.control>

                                        <x-admin::form.control-group.label
                                            :for="'channels_' . $channel->id"
                                            class="!text-[14px] !text-gray-600 dark:!text-gray-300 font-semibold cursor-pointer"
                                        >
                                            {{ core()->getChannelName($channel) }}
                                        </x-admin::form.control-group.label>
                                    </x-admin::form.control-group>
                                @endforeach

                                <x-admin::form.control-group.error
                                    control-name="channels[]"
                                >
                                </x-admin::form.control-group.error>

                                <x-admin::form.control-group class="mb-[10px]">
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

                                    <x-admin::form.control-group.error
                                        control-name="type"
                                    >
                                    </x-admin::form.control-group.error>
                                </x-admin::form.control-group>

                                <x-admin::form.control-group class="mb-[10px]" v-if="showProductCategory" id="product_category">
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

                                    <x-admin::form.control-group.error
                                        control-name="product_category_id"
                                    >
                                    </x-admin::form.control-group.error>

                                    <span class="control-error" v-show="! isValid">@{{ message }}</span>
                                </x-admin::form.control-group>

                            </x-slot:content>
                        </x-admin::accordion>
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
                    showHideOptions: function (event) {
                        this.notificationType = event.target.value;

                        if (this.notificationType == "{{ $notification->type }}") {
                            this.productCategoryInputBox = "{{ $notification->product_category_id }}";
                        } else {
                            this.productCategoryInputBox = '';
                        }

                        this.showProductCategory = false;

                        if (event.target.value == 'product' || event.target.value == 'category' ) {
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

                        this.$axios.post("{{ route('admin.settings.push_notification.cat-product-id') }}",{givenValue:givenValue, selectedType:selectedType})
                            .then(response => {
                                var productCategory = document.getElementById('product_category');

                                if(response.data.value) {
                                    productCategory.classList.remove('has-error');
                                    this.isValid = response.data.value;
                                    this.message = response.data.message;
                                } else {
                                    productCategory.classList.add('has-error');
                                    this.message = response.data.message;
                                    this.isValid = response.data.value;
                                }
                            }).catch(function (error) {
                                // currentObj.output = error;
                                console.log(error);
                            });
                    },
                },
            });
        </script>
    @endPushOnce
</x-admin::layouts>
