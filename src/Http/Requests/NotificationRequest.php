<?php

namespace Webkul\GraphQLAPI\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NotificationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'               => 'required',
            'content'             => 'required',
            'image'               => 'array',
            'image.*'             => 'mimes:jpeg,jpg,bmp,png',
            'type'                => 'required',
            'channel'             => 'nullable',
            'channels'            => 'required|array',
            'channels.*'          => 'required',
            'product_category_id' => 'nullable|integer',
            'locale'              => 'string',
            'status'              => 'boolean',
        ];
    }
}
