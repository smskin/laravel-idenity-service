<?php

namespace SMSkin\IdentityService\Modules\Jwt\Controllers;

use SMSkin\LaravelSupport\BaseController;
use SMSkin\LaravelSupport\BaseRequest;
use SMSkin\IdentityService\Modules\Jwt\Enum\TokenType;
use SMSkin\IdentityService\Modules\Jwt\JwtValidationRules\NotBlockedTokenByJti;
use SMSkin\IdentityService\Modules\Jwt\Models\JwtContext;
use SMSkin\IdentityService\Modules\Jwt\Requests\DecodeTokenRequest;
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

class CDecodeAccessToken extends BaseController
{
    protected DecodeTokenRequest|BaseRequest|null $request;

    protected ?string $requestClass = DecodeTokenRequest::class;

    /**
     * @var string[]
     */
    protected static array $decodedTokens = [];

    /**
     * @return self
     * @throws InvalidSignatureException
     * @throws InvalidTokenException
     * @throws JsonDecodingException
     * @throws SigningException
     * @throws ValidationException
     */
    public function execute(): self
    {
        $key = md5($this->request->token);
        if (in_array($key, self::$decodedTokens)) {
            $this->result = self::$decodedTokens[$key];
            return $this;
        }

        $token = $this->decodeToken();
        self::$decodedTokens[$key] = $token;
        $this->result = $token;
        return $this;
    }

    /**
     * @return JwtContext
     * @throws InvalidSignatureException
     * @throws InvalidTokenException
     * @throws JsonDecodingException
     * @throws SigningException
     * @throws ValidationException
     */
    private function decodeToken(): JwtContext
    {
        $parser = new Parser($this->getSigner(), $this->getValidator());
        $result = $parser->parse($this->request->token);
        return (new JwtContext())->fromArray($result);
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
     * @return JwtContext
     */
    public function getResult(): JwtContext
    {
        return parent::getResult();
    }

    /**
     * @return HS256
     */
    private function getSigner(): HS256
    {
        return app(HS256::class);
    }
}
