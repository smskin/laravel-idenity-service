<?php

namespace SMSkin\IdentityService\Modules\Jwt\Controllers;

use SMSkin\IdentityService\Modules\Core\BaseController;
use SMSkin\IdentityService\Modules\Core\BaseRequest;
use SMSkin\IdentityService\Modules\Jwt\Enum\TokenType;
use SMSkin\IdentityService\Modules\Jwt\JwtValidationRules\NotBlockedTokenByJti;
use SMSkin\IdentityService\Modules\Jwt\Requests\ValidateTokenRequest;
use MiladRahimi\Jwt\Cryptography\Algorithms\Hmac\HS256;
use MiladRahimi\Jwt\Exceptions\InvalidSignatureException;
use MiladRahimi\Jwt\Exceptions\InvalidTokenException;
use MiladRahimi\Jwt\Exceptions\JsonDecodingException;
use MiladRahimi\Jwt\Exceptions\SigningException;
use MiladRahimi\Jwt\Exceptions\ValidationException;
use MiladRahimi\Jwt\Parser;
use MiladRahimi\Jwt\Validator\DefaultValidator;
use MiladRahimi\Jwt\Validator\Rules\EqualsTo;
use MiladRahimi\Jwt\Validator\Rules\NewerThan;

class CValidateAccessToken extends BaseController
{
    protected ValidateTokenRequest|BaseRequest|null $request;

    protected ?string $requestClass = ValidateTokenRequest::class;

    /**
     * @return CValidateAccessToken
     * @throws InvalidSignatureException
     * @throws InvalidTokenException
     * @throws JsonDecodingException
     * @throws SigningException
     * @throws ValidationException
     */
    public function execute(): self
    {
        $parser = new Parser($this->getSigner(), $this->getValidator());
        $parser->validate($this->request->token);
        return $this;
    }

    protected function getValidator(): DefaultValidator
    {
        $validator = new DefaultValidator();
        $validator->addRule('exp', new NewerThan(now()->timestamp));
        $validator->addRule('type', new EqualsTo(TokenType::ACCESS_TOKEN->value));
        $validator->addRule('jti', new NotBlockedTokenByJti());
        return $validator;
    }

    /**
     * @return HS256
     */
    private function getSigner(): HS256
    {
        return app(HS256::class);
    }
}
