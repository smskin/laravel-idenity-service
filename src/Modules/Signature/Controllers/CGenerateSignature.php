<?php

namespace SMSkin\IdentityService\Modules\Signature\Controllers;

use SMSkin\LaravelSupport\BaseController;
use SMSkin\LaravelSupport\BaseRequest;
use SMSkin\IdentityService\Modules\Signature\Requests\GenerateSignatureRequest;

class CGenerateSignature extends BaseController
{
    protected GenerateSignatureRequest|BaseRequest|null $request;

    protected ?string $requestClass = GenerateSignatureRequest::class;

    public function execute(): self
    {
        $signature = $this->request->value . '|' . $this->getKey() . '|' . $this->request->salt;
        $this->result = sha1(strtolower($signature));
        return $this;
    }

    /**
     * @return string
     */
    public function getResult(): string
    {
        return parent::getResult();
    }

    private function getKey(): string
    {
        return config('identity-service.modules.signature.token');
    }
}
