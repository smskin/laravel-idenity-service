<?php

namespace SMSkin\IdentityService\Modules\Auth\Drivers\Email\Controllers;

use SMSkin\IdentityService\Models\UserEmailCredential;
use SMSkin\IdentityService\Modules\Auth\Drivers\Email\Requests\ValidateCredentialRequest;
use SMSkin\LaravelSupport\BaseController;
use SMSkin\LaravelSupport\BaseRequest;
use Illuminate\Support\Facades\Hash;

class CValidateCredential extends BaseController
{
    protected ValidateCredentialRequest|BaseRequest|null $request;

    protected ?string $requestClass = ValidateCredentialRequest::class;

    /**
     * @return $this
     */
    public function execute(): self
    {
        $credential = $this->getCredential();
        if (!$credential) {
            $this->result = false;
            return $this;
        }

        if (!Hash::check($this->request->password, $credential->password)) {
            $this->result = false;
            return $this;
        }

        $this->result = true;
        return $this;
    }

    /**
     * @return bool
     */
    public function getResult(): bool
    {
        return parent::getResult();
    }

    private function getCredential(): ?UserEmailCredential
    {
        return UserEmailCredential::where('email', $this->request->email)->first();
    }
}
