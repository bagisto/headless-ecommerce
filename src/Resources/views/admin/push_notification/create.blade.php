@extends('admin::layouts.content')

@section('page_title')
    {{ __('bagisto_graphql::app.admin.notification.new-notification') }}
@stop

@section('content')
    <div class="content">
        <form method="POST" action="{{ route('admin.push_notification.store') }}" @submit.prevent="onSubmit" enctype="multipart/form-data">

            <div class="page-header">
                <div class="page-title">
                    <h1>
                        <i class="icon angle-left-icon back-link" onclick="window.location = '{{ route('admin.push_notification.index') }}'"></i>

                        {{ __('bagisto_graphql::app.admin.notification.new-notification') }}
                    </h1>
                </div>
                <div class="page-action">
                    <button type="submit" class="btn btn-lg btn-primary">
                        {{ __('bagisto_graphql::app.admin.notification.create-btn-title') }}
                    </button>
                </div>
            </div>

            <div class="page-content">

                <div class="form-container">
                    @csrf()
                    
                    <accordian title="{{ __('bagisto_graphql::app.admin.notification.general') }}" :active="true">
                        <div slot="body">

                            <div class="control-group" :class="[errors.has('title') ? 'has-error' : '']">
                                <label for="title" class="required">
                                    {{ __('bagisto_graphql::app.admin.notification.notification-title') }}
                                </label>

                                <input type="text" class="control" name="title" v-validate="'required'" value="{{ old('title') }}" data-vv-as="&quot;{{ __('bagisto_graphql::app.admin.notification.notification-title') }}&quot;">

                                <span class="control-error" v-if="errors.has('title')">@{{ errors.first('title') }}</span>
                            </div>

                            <div class="control-group" :class="[errors.has('content') ? 'has-error' : '']">
                                <label for="content" class="required">
                                    {{ __('bagisto_graphql::app.admin.notification.notification-content') }}
                                </label>
                                <textarea  class="control" name="content" v-validate="'required'" data-vv-as="&quot;{{ __('bagisto_graphql::app.admin.notification.notification-content') }}&quot;" cols="30" rows="10">{{ old('content') }}</textarea>
                                <span class="control-error" v-if="errors.has('content')">@{{ errors.first('content') }}</span>
                            </div>

                            <div class="control-group" :class="[errors.has('image') ? 'has-error' : '']">
                                <label for="image" class="required">
                                    {{ __('bagisto_graphql::app.admin.notification.notification-image') }}
                                </label>
                                <image-wrapper :button-label="'{{ __('bagisto_graphql::app.admin.notification.notification-image') }}'" input-name="image" :multiple="false" ></image-wrapper>

                                <span class="control-error" v-if="errors.has('image')">@{{ errors.first('image') }}</span>
                            </div>

                            <option-wrapper></option-wrapper>

                            <div class="control-group" :class="[errors.has('channels[]') ? 'has-error' : '']" >
                                <label for="reseller" class="required">
                                    {{ __('bagisto_graphql::app.admin.notification.store-view') }}
                                </label>

                                <select  v-validate="'required'" id="channels" class="control" name="channels[]" multiple="multiple" data-vv-as="&quot;{{ __('bagisto_graphql::app.admin.notification.store-view') }}&quot;">
                                    @foreach ($channels as $channel)
                                        <option value="{{ $channel->code }}">
                                            {{ $channel->name }}
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
                                    <option value="1">{{ __('bagisto_graphql::app.admin.notification.status.enabled') }}</option>
                                    <option value="0">{{ __('bagisto_graphql::app.admin.notification.status.disabled') }}</option>
                                </select>
                                <span class="control-error" v-if="errors.has('status')">@{{ errors.first('status') }}</span>
                            </div>
                        </div>
                    </accordian>
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
                    <option value="others">{{ __('bagisto_graphql::app.admin.notification.notification-type-option.simple') }}</option>
                    <option value="product">{{ __('bagisto_graphql::app.admin.notification.notification-type-option.product') }}</option>
                    <option value="category">{{ __('bagisto_graphql::app.admin.notification.notification-type-option.category') }}</option>
                </select>
                <span class="control-error" v-if="errors.has('type')">@{{ errors.first('type') }}</span>
            </div>

            <div class="control-group" :class="[errors.has('product_category_id') ? 'has-error' : '']" v-if="showProductCategory" id="product_category">
                <label for="product_category_id" class="required">
                    {{ __('bagisto_graphql::app.admin.notification.product-cat-id') }}
                </label>

                <input type="text" valid="" id="product_category_id" class="control" name="product_category_id" v-validate="showProductCategory ? 'required' : ''"  data-vv-as="&quot;{{ __('bagisto_graphql::app.admin.notification.product-cat-id') }}&quot;" @keyup="checkIdExistOrNot" v-model="productCategoryInputBox" placeholder="{{ __('bagisto_graphql::app.admin.notification.product-cat-id') }}" />

                <span class="control-error" v-if="errors.has('product_category_id')">@{{ errors.first('product_category_id') }}</span>

                <span class="control-error" v-show="! isValid">@{{ message }}</span>

            </div>
        </div>
    </script>

    <script>

        Vue.component('option-wrapper', {

            template: '#options-template',

            inject: ['$validator'],

            data: function(data) {
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
@endpush
