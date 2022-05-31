<?php

namespace SMSkin\IdentityService\Modules\Auth\Drivers\Phone\Controllers;

use SMSkin\IdentityService\Modules\Auth\Drivers\Phone\Actions\MarkVerificationAsCanceled;
use SMSkin\IdentityService\Modules\Auth\Drivers\Phone\Requests\ExistVerificationRequest;
use SMSkin\IdentityService\Modules\Auth\Exceptions\VerificationAlreadyCanceled;
use SMSkin\IdentityService\Modules\Core\BaseController;
use SMSkin\IdentityService\Modules\Core\BaseRequest;

class CMarkVerificationAsCanceled extends BaseController
{
    protected ExistVerificationRequest|BaseRequest|null $request;

    protected ?string $requestClass = ExistVerificationRequest::class;

    /**
     * @return $this
     * @throws VerificationAlreadyCanceled
     */
    public function execute(): self
    {
        $this->validateState();
        $this->updateContext();
        return $this;
    }

    /**
     * @return void
     * @throws VerificationAlreadyCanceled
     */
    private function validateState()
    {
        if ($this->request->verification->is_canceled) {
            throw new VerificationAlreadyCanceled();
        }
    }

    private function updateContext()
    {
        app(MarkVerificationAsCanceled::class, [
            'request' => $this->request
        ])->execute();
    }
}