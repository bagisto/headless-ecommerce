@extends('admin::layouts.content')

@section('page_title')
    {{ __('bagisto_graphql::app.admin.notification.edit-notification') }}
@stop

@section('content')
    <div class="content">
        @php
            $locale = request()->get('locale') ?: app()->getLocale();
            $channel = request()->get('channel') ?: core()->getDefaultChannelCode();

            $channelLocales = app('Webkul\Core\Repositories\ChannelRepository')->findOneByField('code', $channel)->locales;

            if (! $channelLocales->contains('code', $locale)) {
                $locale = config('app.fallback_locale');
            }
            
            $notificationTranslation = $notification->translations->where('channel', $channel)->where('locale', $locale)->first();
        @endphp
        <form method="POST" action="" @submit.prevent="onSubmit" enctype="multipart/form-data">

            <div class="page-header">
                <div class="page-title">
                    <h1>
                        <i class="icon angle-left-icon back-link" onclick="window.location = '{{ route('admin.push_notification.index') }}'"></i>

                        {{ __('bagisto_graphql::app.admin.notification.edit-notification') }}
                    </h1>

                    <div class="control-group">
                        <select class="control" id="channel-switcher" name="channel">
                            @foreach (core()->getAllChannels() as $channelModel)

                                <option
                                    value="{{ $channelModel->code }}" {{ ($channelModel->code) == $channel ? 'selected' : '' }}>
                                    {{ core()->getChannelName($channelModel) }}
                                </option>

                            @endforeach
                        </select>
                    </div>

                    <div class="control-group">
                        <select class="control" id="locale-switcher" name="locale">
                            @foreach ($channelLocales as $localeModel)

                                <option
                                    value="{{ $localeModel->code }}" {{ ($localeModel->code) == $locale ? 'selected' : '' }}>
                                    {{ $localeModel->name }}
                                </option>

                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="page-action" style="margin-top:10px;">
                     <a href="{{ route('admin.push_notification.send-notification', $notification['id']) }}"  class="btn btn-lg btn-primary">
                        {{ __('bagisto_graphql::app.admin.notification.title') }}
                    </a> 

                    <button type="submit" class="btn btn-lg btn-primary">
                        {{ __('bagisto_graphql::app.admin.notification.create-btn-title') }}
                    </button>
                </div>
            </div>

            <div class="page-content">

                <div class="form-container">
                    @csrf()
                    <input name="_method" type="hidden" value="PUT">
                    <input type="hidden" value="{{ $notification['id'] }}" name="notification_id" />
                    
                    <div class="control-group" :class="[errors.has('title') ? 'has-error' : '']">
                        <label for="title" class="required">{{ __('bagisto_graphql::app.admin.notification.notification-title') }}</label>

                        <input type="text" v-validate="'required'" class="control" id="title" name="title" value="{{ old('title') ?? (isset($notificationTranslation['title']) ? $notificationTranslation['title']: '') }}" data-vv-as="&quot;{{ __('bagisto_graphql::app.admin.notification.notification-title') }}&quot;" v-slugify-target="'slug'"/>

                        <span class="control-error" v-if="errors.has('title')">@{{ errors.first('title') }}</span>
                    </div>
                    
                    <div class="control-group" :class="[errors.has('content') ? 'has-error' : '']">
                        <label for="content" class="required">{{ __('bagisto_graphql::app.admin.notification.notification-content') }}</label>
                        
                        <textarea class="control" name="content" v-validate="'required'" data-vv-as="&quot;{{ __('bagisto_graphql::app.admin.notification.notification-content') }}&quot;" cols="30" rows="10">{{ old('content') ?? (isset($notificationTranslation['content']) ? $notificationTranslation['content'] : '') }}
                        </textarea>
                        
                        <span class="control-error" v-if="errors.has('content')">@{{ errors.first('content') }}</span>
                    </div>

                    <div class="control-group" :class="[errors.has('image') ? 'has-error' : '']">
                        <label for="image" class="required">
                            {{ __('bagisto_graphql::app.admin.notification.notification-image') }}
                        </label>

                        <image-wrapper :button-label="'{{ __('bagisto_graphql::app.admin.notification.notification-image') }}'" input-name="image" :multiple="false" :images='"{{ url('storage/'.$notification->image) }}"'></image-wrapper>

                        <span class="control-error" v-if="errors.has('image')">@{{ errors.first('image') }}</span>
                    </div>

                    <option-wrapper></option-wrapper>

                    <div class="control-group" :class="[errors.has('channels[]') ? 'has-error' : '']" >
                        <label for="reseller" class="required">
                            {{ __('bagisto_graphql::app.admin.notification.store-view') }}
                        </label>

                        <select  v-validate="'required'" id="channels" class="control" name="channels[]" multiple="multiple" data-vv-as="&quot;{{ __('bagisto_graphql::app.admin.notification.store-view') }}&quot;">
                            @foreach ($channels as $channelDetail)
                                <option value="{{ $channelDetail->code }}"
                                    @if ( in_array($channelDetail->code, $notification->notificationChannelsArray())) selected @endif >
                                    {{ $channelDetail->name }}
                                </option>
                            @endforeach
                        </select>
                        <span class="control-error" v-if="errors.has('channels[]')">@{{ errors.first('channels[]') }}
                        </span>
                    </div>

                    <div class="control-group" :class="[errors.has('status') ? 'has-error' : '']">
                        <label for="status">
                            {{ __('bagisto_graphql::app.admin.notification.notification-status') }}
                        </label>

                        <select class="control" name="status" data-vv-as="&quot;{{ __('bagisto_graphql::app.admin.notification.notification-status') }}&quot;">
                            <option value="1" {{ $notification->status == '1' ? 'selected' : '' }}>{{ __('bagisto_graphql::app.admin.notification.status.enabled') }}</option>
                            <option value="0" {{ $notification->status == '0' ? 'selected' : '' }}>{{ __('bagisto_graphql::app.admin.notification.status.disabled') }}</option>
                        </select>
                        <span class="control-error" v-if="errors.has('status')">@{{ errors.first('status') }}</span>
                    </div>
                </div>
            </div>
        </form>
    </div>
@stop

@push('scripts')
    <script type="text/x-template" id="options-template">
        <div>
            <div class="control-group" :class="[errors.has('type') ? 'has-error' : '']">
                <label for="type" class="required">
                    {{ __('bagisto_graphql::app.admin.notification.notification-type') }}
                </label>

                <select class="control" id="type" name="type" v-validate="'required'" data-vv-as="&quot;{{ __('bagisto_graphql::app.admin.notification.notification-type') }}&quot;" @change="showHideOptions($event)" v-model="notificationType">

                    <option value="">{{ __('bagisto_graphql::app.admin.notification.notification-type-option.select') }}</option>
                    <option value="others" {{ $notification->type == 'other' ? 'selected' : '' }}>{{ __('bagisto_graphql::app.admin.notification.notification-type-option.simple') }}</option>
                    <option value="product" {{ $notification->type == 'product' ? 'selected' : '' }}>{{ __('bagisto_graphql::app.admin.notification.notification-type-option.product') }}</option>
                    <option value="category" {{ $notification->type == 'category' ? 'selected' : '' }}>{{ __('bagisto_graphql::app.admin.notification.notification-type-option.category') }}</option>
                </select>
                <span class="control-error" v-if="errors.has('type')">@{{ errors.first('type') }}</span>
            </div>

            <div class="control-group" id="productCat" :class="[errors.has('product_category_id') ? 'has-error' : '']" v-if="showProductCategory">
                <label for="product_category_id" class="required">
                    {{ __('bagisto_graphql::app.admin.notification.product-cat-id') }}
                </label>

                <input type="text" id="product_category_id" class="control" name="product_category_id" v-validate="showProductCategory ? 'required' : ''" data-vv-as="&quot;{{ __('bagisto_graphql::app.admin.notification.product-cat-id') }}&quot;" @keyup="checkIdExistOrNot" v-model="productCategoryInputBox" placeholder="{{ __('bagisto_graphql::app.admin.notification.product-cat-id') }}" >

                <span class="control-error" v-if="errors.has('product_category_id')">@{{ errors.first('product_category_id') }}</span>
            </div>

        </div>
    </script>

    <script>

        Vue.component('option-wrapper', {

            template: '#options-template',

            inject: ['$validator'],

            data: function(data) {
                return {
                    showProductCategory: '{{ ($notification['type'] == 'product' || $notification['type'] == 'category') ?? false }}',
                    notificationType : '{{ $notification['type'] }}',
                    productCategoryInputBox : '{{ old('product_category_id') ?? $notification->product_category_id }}',
                    message: '',
                    isValid: false,
                    
                }
            },

            methods: {
                showHideOptions: function (event) {
                    this_this = this;
                    this_this.notificationType = event.target.value;

                    this_this.showProductCategory = false;
                    if (event.target.value == 'product' || event.target.value == 'category' ) {
                        this_this.showProductCategory = true;
                    }
                },

                //id exist or not
                checkIdExistOrNot(event) {
                    this_this = this;
                    var selectedType = this_this.notificationType;
                    var givenValue = this_this.productCategoryInputBox;
                    var spaceCount = (givenValue.split(" ").length - 1);

                    if (spaceCount > 0) {
                        this_this.isValid = true;
                        return false;
                    }

                    this_this.$http.post("{{ route('admin.push_notification.cat-product-id') }}",{givenValue:givenValue, selectedType:selectedType})

                    .then(response => {
                        if(response.data.value) {
                            $('#product_category').removeClass('has-error');
                            this_this.isValid = response.data.value;
                            this_this.message = response.data.message;
                        } else {
                            $('#product_category').addClass('has-error');
                            this_this.message = response.data.message;
                            this_this.isValid = response.data.value;
                        }
                    }).catch(function (error) {
                        currentObj.output = error;
                    });
                },
            },
        });

    </script>

    <script>
        $(document).ready(function () {
            $('#channel-switcher, #locale-switcher').on('change', function (e) {
                $('#channel-switcher').val()
                var query = '?channel=' + $('#channel-switcher').val() + '&locale=' + $('#locale-switcher').val();

                window.location.href = "{{ route('admin.push_notification.edit', $notification->id)  }}" + query;
            })
        });
    </script>
@endpush
