<?php

namespace SMSkin\IdentityService\Modules\Sms\Controllers;

use SMSkin\LaravelSupport\BaseRequest;
use SMSkin\IdentityService\Modules\Sms\Requests\SendMessageRequest;

class CSendMessage extends BaseController
{
    protected SendMessageRequest|BaseRequest|null $request;

    protected ?string $requestClass = SendMessageRequest::class;

    protected string $method = 'sendMessage';
}
