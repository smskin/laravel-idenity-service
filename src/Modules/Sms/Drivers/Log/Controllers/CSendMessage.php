<?php

namespace SMSkin\IdentityService\Modules\Sms\Drivers\Log\Controllers;

use Illuminate\Support\Facades\Log;
use SMSkin\IdentityService\Modules\Core\BaseController;
use SMSkin\IdentityService\Modules\Core\BaseRequest;
use SMSkin\IdentityService\Modules\Sms\Requests\SendMessageRequest;
use function config;

class CSendMessage extends BaseController
{
    protected SendMessageRequest|BaseRequest|null $request;

    protected ?string $requestClass = SendMessageRequest::class;

    public function execute(): self
    {
        Log::channel($this->getChannel())->debug('SMS Message. Phone: ' . $this->request->phone . ', Message: ' . $this->request->message);
        return $this;
    }

    private function getChannel(): string
    {
        return config('identity-service.modules.sms.drivers.log.channel');
    }
}
