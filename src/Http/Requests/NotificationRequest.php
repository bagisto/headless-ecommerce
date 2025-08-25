<?php

namespace Webkul\GraphQLAPI\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NotificationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $channels = core()->getAllChannels()->pluck('code')->toArray();

        $rules = [
            'title'               => ['required'],
            'content'             => ['required'],
            'image'               => ['array'],
            'image.*'             => ['mimes:jpeg,jpg,bmp,png'],
            'type'                => ['required'],
            'channels'            => ['required', 'array', 'min:1', 'in:'.implode(',', $channels)],
            'product_category_id' => ['required_if:type,product,category', 'integer'],
            'status'              => ['boolean'],
        ];

        if ($this->method() == 'PUT') {
            $rules['channel'] = ['required', 'in:'.implode(',', $channels)];
            $rules['locale'] = ['required'];
        }

        return $rules;
    }
}
