<?php

namespace SMSkin\IdentityService\Modules\Auth\Drivers\Email\Actions;

use SMSkin\IdentityService\Models\UserEmailCredential;
use SMSkin\IdentityService\Modules\Auth\Drivers\Email\Requests\CreateCredentialRequest;
use SMSkin\LaravelSupport\BaseAction;
use SMSkin\LaravelSupport\BaseRequest;

class CreateCredentialContext extends BaseAction
{
    protected CreateCredentialRequest|BaseRequest|null $request;

    protected ?string $requestClass = CreateCredentialRequest::class;

    public function execute(): self
    {
        $credential = new UserEmailCredential();
        $credential->user_id = $this->request->user->id;
        $credential->email = $this->request->email;
        $credential->password = $this->request->password;
        $credential->verified_at = $this->request->verifiedAt;
        $credential->save();

        $this->result = $credential;
        return $this;
    }

    /**
     * @return UserEmailCredential
     */
    public function getResult(): UserEmailCredential
    {
        return parent::getResult();
    }
}
