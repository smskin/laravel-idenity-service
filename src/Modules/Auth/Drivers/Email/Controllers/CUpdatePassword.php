<?php

namespace SMSkin\IdentityService\Modules\Auth\Drivers\Email\Controllers;

use Illuminate\Validation\ValidationException;
use SMSkin\IdentityService\Models\UserEmailCredential;
use SMSkin\IdentityService\Modules\Auth\Drivers\Email\Actions\UpdateCredentialPassword;
use SMSkin\IdentityService\Modules\Auth\Drivers\Email\Requests\UpdateCredentialPasswordRequest;
use SMSkin\IdentityService\Modules\Auth\Drivers\Email\Requests\UpdatePasswordRequest;
use SMSkin\IdentityService\Modules\Auth\Exceptions\CredentialWithThisIdentifyNotExists;
use SMSkin\LaravelSupport\BaseController;
use SMSkin\LaravelSupport\BaseRequest;

class CUpdatePassword extends BaseController
{
    protected UpdatePasswordRequest|BaseRequest|null $request;

    protected ?string $requestClass = UpdatePasswordRequest::class;

    /**
     * @return static
     * @throws CredentialWithThisIdentifyNotExists
     * @throws ValidationException
     */
    public function execute(): static
    {
        $credential = $this->getCredential();
        if (!$credential) {
            throw new CredentialWithThisIdentifyNotExists();
        }

        $this->updateContext($credential);
        return $this;
    }

    private function getCredential(): ?UserEmailCredential
    {
        return UserEmailCredential::where('user_id', $this->request->user->id)
            ->whereEmail($this->request->email)->first();
    }

    /**
     * @param UserEmailCredential $credential
     * @return void
     * @throws ValidationException
     */
    private function updateContext(UserEmailCredential $credential)
    {
        (new UpdateCredentialPassword(
            (new UpdateCredentialPasswordRequest())
                ->setCredential($credential)
                ->setPassword($this->request->password)
        ))->execute();
    }
}
