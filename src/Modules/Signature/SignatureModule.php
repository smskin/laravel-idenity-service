<?php

namespace SMSkin\IdentityService\Modules\Signature;

use SMSkin\IdentityService\Modules\Core\BaseModule;
use SMSkin\IdentityService\Modules\Signature\Controllers\CGenerateSignature;
use SMSkin\IdentityService\Modules\Signature\Controllers\CValidateSignature;
use SMSkin\IdentityService\Modules\Signature\Requests\GenerateSignatureRequest;
use SMSkin\IdentityService\Modules\Signature\Requests\ValidateSignatureRequest;
use Illuminate\Validation\ValidationException;

class SignatureModule extends BaseModule
{
    /**
     * @param GenerateSignatureRequest $request
     * @return string
     * @throws ValidationException
     */
    public function generate(GenerateSignatureRequest $request): string
    {
        $request->validate();

        return app(CGenerateSignature::class, [
            'request' => $request
        ])->execute()->getResult();
    }

    /**
     * @param ValidateSignatureRequest $request
     * @return bool
     * @throws ValidationException
     */
    public function validate(ValidateSignatureRequest $request): bool
    {
        $request->validate();

        return app(CValidateSignature::class, [
            'request' => $request
        ])->execute()->getResult();
    }
}
