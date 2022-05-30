<?php

namespace SMSkin\IdentityService\Modules\Signature\Controllers;

use SMSkin\IdentityService\Modules\Core\BaseController;
use SMSkin\IdentityService\Modules\Core\BaseRequest;
use SMSkin\IdentityService\Modules\Signature\Requests\ValidateSignatureRequest;

class CValidateSignature extends BaseController
{
    protected ValidateSignatureRequest|BaseRequest|null $request;

    protected ?string $requestClass = ValidateSignatureRequest::class;

    public function execute(): self
    {
        $signature = $this->request->value . '|' . $this->getKey() . '|' . $this->request->salt;
        $this->result = sha1(strtolower($signature)) === strtolower($this->request->signature);
        return $this;
    }

    /**
     * @return bool
     */
    public function getResult(): bool
    {
        return parent::getResult();
    }

    private function getKey(): string
    {
        return config('identity-service.modules.signature.token');
    }
}
