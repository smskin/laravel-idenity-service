<?php

namespace SMSkin\IdentityService\Modules\Auth\Drivers\Email\Controllers;

use Illuminate\Validation\ValidationException;
use SMSkin\IdentityService\Modules\Auth\Drivers\Email\Actions\MarkVerificationAsCanceled;
use SMSkin\IdentityService\Modules\Auth\Drivers\Email\Requests\ExistVerificationRequest;
use SMSkin\IdentityService\Modules\Auth\Exceptions\VerificationAlreadyCanceled;
use SMSkin\LaravelSupport\BaseController;
use SMSkin\LaravelSupport\BaseRequest;

class CMarkVerificationAsCanceled extends BaseController
{
    protected ExistVerificationRequest|BaseRequest|null $request;

    protected ?string $requestClass = ExistVerificationRequest::class;

    /**
     * @return static
     * @throws ValidationException
     * @throws VerificationAlreadyCanceled
     */
    public function execute(): static
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

    /**
     * @return void
     * @throws ValidationException
     */
    private function updateContext()
    {
        (new MarkVerificationAsCanceled($this->request))->execute();
    }
}
