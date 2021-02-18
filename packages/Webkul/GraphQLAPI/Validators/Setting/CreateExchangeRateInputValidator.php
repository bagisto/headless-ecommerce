<?php

namespace Webkul\GraphQLAPI\Validators\Setting;

use Illuminate\Validation\Rule;
use Nuwave\Lighthouse\Validation\Validator;

class CreateExchangeRateInputValidator extends Validator
{
    public function rules(): array
    {
        dd(request()->all());
        return [
            'target_currency'   => [
                Rule::unique('currency_exchange_rates', 'target_currency')->ignore($this->arg('id'), 'id'),
            ],
        ];
    }
}