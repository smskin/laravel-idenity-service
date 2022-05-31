<?php

namespace SMSkin\IdentityService\Modules\Sms\Drivers\Log;

use Illuminate\Validation\ValidationException;
use SMSkin\IdentityService\Modules\Core\BaseModule;
use SMSkin\IdentityService\Modules\Sms\Contracts\Driver;
use SMSkin\IdentityService\Modules\Sms\Drivers\Log\Controllers\CSendMessage;
use SMSkin\IdentityService\Modules\Sms\Requests\SendMessageRequest;
use function app;

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

        app(CSendMessage::class, [
            'request' => $request
        ])->execute();
    }
}