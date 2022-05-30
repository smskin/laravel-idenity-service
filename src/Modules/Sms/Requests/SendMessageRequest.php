<?php

namespace SMSkin\IdentityService\Modules\Sms\Requests;

use SMSkin\IdentityService\Modules\Core\BaseRequest;
use SMSkin\IdentityService\Modules\Core\Rules\PhoneRule;

class SendMessageRequest extends BaseRequest
{
    public string $phone;
    public string $message;

    public function rules(): array
    {
        return [
            'phone' => [
                'required',
                new PhoneRule()
            ],
            'message' => [
                'required'
            ]
        ];
    }

    /**
     * @param string $phone
     * @return SendMessageRequest
     */
    public function setPhone(string $phone): SendMessageRequest
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @param string $message
     * @return SendMessageRequest
     */
    public function setMessage(string $message): SendMessageRequest
    {
        $this->message = $message;
        return $this;
    }
}
