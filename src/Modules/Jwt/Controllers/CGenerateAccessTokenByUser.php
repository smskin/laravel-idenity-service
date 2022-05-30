<?php

namespace SMSkin\IdentityService\Modules\Jwt\Controllers;

use SMSkin\IdentityService\Modules\Core\BaseController;
use SMSkin\IdentityService\Modules\Core\BaseRequest;
use SMSkin\IdentityService\Modules\Jwt\Models\Jwt;
use SMSkin\IdentityService\Modules\Jwt\Requests\GenerateAccessTokenByUserRequest;
use SMSkin\IdentityService\Modules\Jwt\Requests\GenerateAccessTokenRequest;
use MiladRahimi\Jwt\Exceptions\JsonEncodingException;
use MiladRahimi\Jwt\Exceptions\SigningException;

class CGenerateAccessTokenByUser extends BaseController
{
    protected GenerateAccessTokenByUserRequest|BaseRequest|null $request;

    protected ?string $requestClass = GenerateAccessTokenByUserRequest::class;

    /**
     * @return $this
     * @throws JsonEncodingException
     * @throws SigningException
     */
    public function execute(): self
    {
        $this->result = app(CGenerateAccessToken::class, [
            'request' => (new GenerateAccessTokenRequest)
                ->setSubject($this->request->user->identity_uuid)
                ->setScopes($this->request->scopes)
        ])->execute()->getResult();
        return $this;
    }

    /**
     * @return Jwt
     */
    public function getResult(): Jwt
    {
        return parent::getResult();
    }
}
