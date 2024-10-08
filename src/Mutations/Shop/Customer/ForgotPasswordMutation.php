<?php

namespace Webkul\GraphQLAPI\Mutations\Shop\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Symfony\Component\Mailer\Exception\TransportException;
use Webkul\GraphQLAPI\Validators\CustomException;

class ForgotPasswordMutation extends Controller
{
    use SendsPasswordResetEmails;

    /**
     * Method to reset the customer password
     *
     * @return array
     *
     * @throws CustomException
     */
    public function forgot(mixed $rootValue, array $args, GraphQLContext $context)
    {
        bagisto_graphql()->validate($args, [
            'email' => 'required|email|exists:customers,email',
        ]);

        try {
            $response = $this->broker()->sendResetLink($args);

            if ($response == Password::RESET_LINK_SENT) {
                return [
                    'success' => true,
                    'message' => trans('bagisto_graphql::app.shop.customers.forgot-password.reset-link-sent'),
                ];
            }

            if ($response == Password::RESET_THROTTLED) {
                return [
                    'success' => true,
                    'message' => trans('bagisto_graphql::app.shop.customers.forgot-password.already-sent'),
                ];
            }

            throw new CustomException(trans('bagisto_graphql::app.shop.customers.forgot-password.email-not-exist'));
        } catch (TransportException $e) {
            DB::table('customer_password_resets')->where('email', $args['email'])->delete();

            throw new CustomException(trans('bagisto_graphql::app.email.configuration-error'));
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
