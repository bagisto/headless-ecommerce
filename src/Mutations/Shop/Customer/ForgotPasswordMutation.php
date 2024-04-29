<?php

namespace Webkul\GraphQLAPI\Mutations\Shop\Customer;

use Illuminate\Support\Facades\Password;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Validator;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use App\Http\Controllers\Controller;
use Webkul\GraphQLAPI\Validators\CustomException;

class ForgotPasswordMutation extends Controller
{
    use SendsPasswordResetEmails;

    /**
     * Method to reset the customer password
     *
     * @return \Illuminate\Http\Response
     */
    public function forgot($rootValue, array $args , GraphQLContext $context)
    {
        $validator = Validator::make($args, [
            'email' => 'required|email',
        ]);

        bagisto_graphql()->checkValidatorFails($validator);

        try {
            $response = $this->broker()->sendResetLink($args);

            if ($response == Password::RESET_LINK_SENT) {
                return [
                    'status'  => true,
                    'success' => trans('bagisto_graphql::app.shop.customers.forgot-password.reset-link-sent'),
                ];
            }

            if ($response == Password::RESET_THROTTLED) {
                return [
                    'status'  => false,
                    'success' => trans('bagisto_graphql::app.shop.customers.forgot-password.already-sent'),
                ];
            }

            throw new CustomException(trans('bagisto_graphql::app.shop.customers.forgot-password.email-not-exist'));
        } catch (\Swift_RfcComplianceException $e) {
            throw new CustomException(trans('bagisto_graphql::app.shop.customers.forgot-password.reset-link-sent'));
        } catch (\Exception $e) {
            report($e);

            throw new CustomException($e->getMessage());
        }
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function broker()
    {
        return Password::broker('customers');
    }
}
