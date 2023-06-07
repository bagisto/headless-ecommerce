<?php

namespace Webkul\GraphQLAPI\Mutations\Shop\Customer;

use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Webkul\Customer\Http\Controllers\Controller;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\GraphQLAPI\Validators\Customer\CustomException;

class ForgotPasswordMutation extends Controller
{
    use SendsPasswordResetEmails;

    /**
     * Contains current guard
     *
     * @var array
     */
    protected $guard;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->guard = 'api';

        auth()->setDefaultDriver($this->guard);
        
        $this->middleware('auth:' . $this->guard, ['except' => ['forgot']]);
    }

    /**
     * Method to reset the customer password
     *
     * @return \Illuminate\Http\Response
     */
    public function forgot($rootValue, array $args , GraphQLContext $context)
    {
        if (! isset($args['input']) || (isset($args['input']) && !$args['input'])) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.error-invalid-parameter'));
        }
    
        $data = $args['input'];
        
        $validator = Validator::make($data, [
            'email' => 'required|email',
        ]);
                
        if ($validator->fails()) {
            $errorMessage = [];
            foreach ($validator->messages()->toArray() as $message) {
                $errorMessage[] = is_array($message) ? $message[0] : $message;
            }
            
            throw new CustomException(
                implode(" ,", $errorMessage),
                'Invalid ForgotPassword Details.'
            );
        }
        
        try {
            $response = $this->broker()->sendResetLink($data);
            
            if ($response == Password::RESET_LINK_SENT) {
                return [
                    'status'    => true,
                    'success'   => trans('customer::app.forget_password.reset_link_sent')
                ];
            } else {
                throw new CustomException(
                    trans('bagisto_graphql::app.shop.response.password-reset-failed'),
                    'Invalid ForgotPassword Email Details.'
                );
            }
        } catch (\Swift_RfcComplianceException $e) {
            throw new CustomException(
                trans('customer::app.forget_password.reset_link_sent'),
                'Swift_RfcComplianceException: Invalid ForgotPassword Details.'
            );
        } catch (Exception $e) {
            throw new CustomException(
                $e->getMessage(),
                'Exception: invalid forgot password email.'
            );
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