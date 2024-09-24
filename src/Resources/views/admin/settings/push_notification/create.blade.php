<x-admin::layouts>
    <!-- Title of the page -->
    <x-slot:title>
        @lang('bagisto_graphql::app.admin.settings.notification.create.new-notification')
    </x-slot>

    <!-- Create Notification Components -->
    <v-create-notification></v-create-notification>

    @pushOnce('scripts')
        <script
            type="text/x-template"
            id="v-create-notification-template"
        >
            <!-- Notification Create Form -->
            <x-admin::form
                :action="route('admin.settings.push_notification.store')"
                enctype="multipart/form-data"
            >
                <div class="flex items-center justify-between gap-4 max-sm:flex-wrap">
                    <p class="text-xl font-bold leading-6 text-gray-800 dark:text-white">
                        @lang('bagisto_graphql::app.admin.settings.notification.create.new-notification')
                    </p>

                    <div class="flex items-center gap-x-2.5">
                        <!-- Back Button -->
                        <a
                            href="{{ route('admin.settings.push_notification.index') }}"
                            class="transparent-button hover:bg-gray-200 dark:hover:bg-gray-800 dark:text-white "
                        >
                            @lang('bagisto_graphql::app.admin.settings.notification.create.back-btn')
                        </a>

                        <!-- Save Button -->
                        <button
                            type="submit"
                            class="primary-button"
                        >
                            @lang('bagisto_graphql::app.admin.settings.notification.create.create-btn-title')
                        </button>
                    </div>
                </div>

                <!-- Full Pannel -->
                <div class="mt-3.5 flex gap-2.5 max-xl:flex-wrap">
                    <!-- Left Section -->
                    <div class="flex flex-1 flex-col gap-2 max-xl:flex-auto">
                        <!-- General -->
                        <div class="box-shadow rounded bg-white p-4 dark:bg-gray-900">
                            <p class="mb-4 text-base font-semibold text-gray-800 dark:text-white">
                                @lang('bagisto_graphql::app.admin.settings.notification.create.general')
                            </p>

                            <!-- Locales -->
                            <x-admin::form.control-group.control
                                type="hidden"
                                name="locale"
                                value="all"
                            />

                            <!-- Title -->
                            <x-admin::form.control-group class="mb-2.5">
                                <x-admin::form.control-group.label class="required">
                                    @lang('bagisto_graphql::app.admin.settings.notification.create.title')
                                </x-admin::form.control-group.label>

                                <x-admin::form.control-group.control
                                    type="text"
                                    name="title"
                                    :value="old('title')"
                                    rules="required"
                                    :label="trans('bagisto_graphql::app.admin.settings.notification.create.title')"
                                    :placeholder="trans('bagisto_graphql::app.admin.settings.notification.create.title')"
                                />

                                <x-admin::form.control-group.error control-name="title" />
                            </x-admin::form.control-group>
                        </div>

                        <!-- Description and images -->
                        <div class="box-shadow rounded bg-white p-4 dark:bg-gray-900">
                            <p class="mb-4 text-base font-semibold text-gray-800 dark:text-white">
                                @lang('bagisto_graphql::app.admin.settings.notification.create.content-and-image')
                            </p>

                            <!-- Content -->
                            <v-description>
                                <x-admin::form.control-group class="mb-2.5">
                                    <x-admin::form.control-group.label class="required">
                                        @lang('bagisto_graphql::app.admin.settings.notification.create.notification-content')
                                    </x-admin::form.control-group.label>

                                    <x-admin::form.control-group.control
                                        type="textarea"
                                        name="content"
                                        id="content"
                                        class="content"
                                        :value="old('content')"
                                        :label="trans('bagisto_graphql::app.admin.settings.notification.create.notification-content')"
                                        rules="required"
                                        :tinymce="true"
                                    />

                                    <x-admin::form.control-group.error control-name="content" />
                                </x-admin::form.control-group>
                            </v-description>

                            <!-- Add Image -->
                            <div class="flex flex-col gap-2">
                                <p class="text-gray-800 dark:text-white font-medium">
                                    @lang('bagisto_graphql::app.admin.settings.notification.create.image')
                                </p>

                                <x-admin::media.images name="image" />
                            </div>
                        </div>
                    </div>

                    <!-- Right Section -->
                    <div class="flex w-[360px] max-w-full flex-col gap-2">
                        <!-- Settings -->
                        <div class="box-shadow rounded bg-white p-4 dark:bg-gray-900">
                            <p class="mb-4 text-base font-semibold text-gray-800 dark:text-white">
                                @lang('bagisto_graphql::app.admin.settings.notification.create.settings')
                            </p>

                            <!-- Visible in menu -->
                            <x-admin::form.control-group>
                                <x-admin::form.control-group.label class="required">
                                    @lang('bagisto_graphql::app.admin.settings.notification.create.status')
                                </x-admin::form.control-group.label>

                                <x-admin::form.control-group.control
                                    type="switch"
                                    name="status"
                                    value="1"
                                    :label="trans('graphql::app.admin.settings.notification.create.status')"
                                />
                            </x-admin::form.control-group>

                            <x-admin::form.control-group class="mb-2.5">
                                <x-admin::form.control-group.label class="required">
                                    @lang('bagisto_graphql::app.admin.settings.notification.create.notification-type')
                                </x-admin::form.control-group.label>

                                <x-admin::form.control-group.control
                                    type="select"
                                    name="type"
                                    rules="required"
                                    :value="old('type')"
                                    id="type"
                                    class="cursor-pointer"
                                    :label="trans('bagisto_graphql::app.admin.settings.notification.create.notification-type')"
                                    v-model="notificationType"
                                    @change="showHideOptions($event)"
                                >
                                    <!-- Here! All Needed types are defined -->
                                    @foreach(['others', 'product', 'category'] as $type)
                                        <option value="{{ $type }}" >
                                            @lang('bagisto_graphql::app.admin.settings.notification.create.option-type.'. $type)
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
                                    @lang('bagisto_graphql::app.admin.settings.notification.create.product-cat-id')
                                </x-admin::form.control-group.label>

                                <v-field
                                    type="text"
                                    name="product_category_id"
                                    value="{{ old('product_category_id') }}"
                                    label="{{ trans('bagisto_graphql::app.admin.settings.notification.create.create.product-cat-id') }}"
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
                                        placeholder="{{ trans('bagisto_graphql::app.admin.settings.notification.create.product-cat-id') }}"
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
                                @lang('bagisto_graphql::app.admin.settings.notification.create.store-view')
                            </p>

                            @foreach (core()->getAllChannels() as $channel)
                                <x-admin::form.control-group class="!mb-2 flex select-none items-center gap-2.5 last:!mb-0">
                                    <x-admin::form.control-group.control
                                        type="checkbox"
                                        name="channels[]"
                                        :value="$channel->code"
                                        :id="'channels_'.$channel->id"
                                        :for="'channels_'.$channel->id"
                                        rules="required"
                                        :label="trans('bagisto_graphql::app.admin.settings.notification.create.store-view')"
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
            app.component('v-create-notification', {
                template: '#v-create-notification-template',

                inject: ['$validator'],

                data() {
                    return {
                        showProductCategory: false,

                        valid: '',

                        notificationType : '',

                        productCategoryInputBox : '{{ old('product_category_id') }}',

                        message: '',

                        isValid: false,
                    }
                },

                methods: {
                    showHideOptions(event) {
                        this.notificationType = event.target.value;

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
