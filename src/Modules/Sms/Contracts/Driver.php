<?php

namespace SMSkin\IdentityService\Modules\Sms\Contracts;

use SMSkin\IdentityService\Modules\Sms\Requests\SendMessageRequest;
use Illuminate\Validation\ValidationException;

interface Driver
{
    /**
     * @param SendMessageRequest $request
     * @return void
     * @throws ValidationException
     */
    public function sendMessage(SendMessageRequest $request): void;
}
