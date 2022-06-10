<?php

namespace SMSkin\IdentityService\Modules\Sms;

use SMSkin\LaravelSupport\BaseModule;
use SMSkin\IdentityService\Modules\Sms\Controllers\CSendMessage;
use SMSkin\IdentityService\Modules\Sms\Requests\SendMessageRequest;
use Illuminate\Validation\ValidationException;

class SmsModule extends BaseModule
{
    /**
     * @param SendMessageRequest $request
     * @return void
     * @throws ValidationException
     */
    public function sendMessage(SendMessageRequest $request): void
    {
        $request->validate();

        (new CSendMessage($request))->execute();
    }
}
