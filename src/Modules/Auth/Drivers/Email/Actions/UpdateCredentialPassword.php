<?php

namespace SMSkin\IdentityService\Modules\Auth\Drivers\Email\Actions;

use SMSkin\IdentityService\Modules\Auth\Drivers\Email\Requests\UpdateCredentialPasswordRequest;
use SMSkin\IdentityService\Modules\Core\BaseAction;
use SMSkin\IdentityService\Modules\Core\BaseRequest;

class UpdateCredentialPassword extends BaseAction
{
    protected UpdateCredentialPasswordRequest|BaseRequest|null $request;

    protected ?string $requestClass = UpdateCredentialPasswordRequest::class;

    public function execute(): self
    {
        $credential = $this->request->credential;
        $credential->password = $this->request->password;
        $credential->save();
        return $this;
    }
}