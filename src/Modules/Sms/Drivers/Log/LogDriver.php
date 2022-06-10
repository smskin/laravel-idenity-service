<?php

namespace SMSkin\IdentityService\Modules\Sms\Drivers\Log;

use Illuminate\Validation\ValidationException;
use SMSkin\LaravelSupport\BaseModule;
use SMSkin\IdentityService\Modules\Sms\Contracts\Driver;
use SMSkin\IdentityService\Modules\Sms\Drivers\Log\Controllers\CSendMessage;
use SMSkin\IdentityService\Modules\Sms\Requests\SendMessageRequest;

class LogDriver extends BaseModule implements Driver
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
