@component('shop::emails.layouts.master')

    <div>
        <div style="text-align: center;">
            <a href="{{ config('app.url') }}">
                @include ('shop::emails.layouts.logo')
            </a>
        </div>

        <div  style="font-size:16px; color:#242424; font-weight:600; margin-top: 60px; margin-bottom: 15px">
                {!! __('bagisto_graphql::app.mail.customer.password.heading') !!}
        </div>

        <div>
            {!! __('bagisto_graphql::app.mail.customer.password.summary') !!}
        </div>

        @if (! empty($data['password']))
            <p style="font-size: 16px;color: #000000;line-height: 24px;">
                <center><strong>{{ __('bagisto_graphql::app.shop.customer.text-password', ['password' => $data['password']]) }}</strong></center>
            </p>
        @endif
    </div>

@endcomponent