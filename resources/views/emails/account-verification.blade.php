@component('mail::message')
# Welcome to SAAS {{ $account->name }}

### The body of your message.

@component('mail::button', ['url' => "https://127.0.0.1/account/verification/" ])
Verify your account
@endcomponent

Token # {{ $account->token }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
