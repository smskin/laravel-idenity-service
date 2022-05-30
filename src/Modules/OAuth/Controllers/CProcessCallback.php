<?php

namespace SMSkin\IdentityService\Modules\OAuth\Controllers;

use SMSkin\IdentityService\Http\Api\Resources\Auth\RJwt;
use SMSkin\IdentityService\Modules\Auth\Exceptions\DisabledDriver;
use SMSkin\IdentityService\Modules\Auth\Exceptions\RegistrationDisabled;
use SMSkin\IdentityService\Modules\Core\BaseRequest;
use SMSkin\IdentityService\Modules\Jwt\JwtModule;
use SMSkin\IdentityService\Modules\Jwt\Models\Jwt;
use SMSkin\IdentityService\Modules\Jwt\Requests\GenerateAccessTokenByUserRequest;
use SMSkin\IdentityService\Modules\OAuth\Exceptions\RemoteIdAlreadyAssignedToAnotherUser;
use SMSkin\IdentityService\Modules\OAuth\Models\Callback;
use SMSkin\IdentityService\Modules\OAuth\Requests\ProcessCallbackRequest;
use SMSkin\IdentityService\Modules\Signature\Requests\GenerateSignatureRequest;
use SMSkin\IdentityService\Modules\Signature\SignatureModule;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use MiladRahimi\Jwt\Exceptions\JsonEncodingException;
use MiladRahimi\Jwt\Exceptions\SigningException;
use Illuminate\Support\Facades\Session;
use SMSkin\IdentityService\Traits\ClassFromConfig;

class CProcessCallback extends BaseController
{
    use ClassFromConfig;

    protected ProcessCallbackRequest|BaseRequest|null $request;

    protected ?string $requestClass = ProcessCallbackRequest::class;

    /**
     * @return $this
     * @throws DisabledDriver
     * @throws JsonEncodingException
     * @throws RegistrationDisabled
     * @throws RemoteIdAlreadyAssignedToAnotherUser
     * @throws SigningException
     * @throws ValidationException
     */
    public function execute(): self
    {
        $user = $this->getDriver()->processCallback($this->request);
        $callback = $this->getCallbackObject();
        if (!$callback) {
            abort(403);
        }
        $jwt = app(JwtModule::class)->generateAccessTokenByUser(
            (new GenerateAccessTokenByUserRequest)
                ->setUser($user)
                ->setScopes([
                    $this->getSystemChangeScope()
                ])
        );
        $this->result = redirect()->to($this->prepareCallbackUrl($callback, $jwt));

        return $this;
    }

    /**
     * @return RedirectResponse
     */
    public function getResult(): RedirectResponse
    {
        return parent::getResult();
    }

    private function getCallbackObject(): ?Callback
    {
        $data = Session::get(CGetRedirector::SESSION_KEY);
        if (!$data) {
            return null;
        }
        return (new Callback())->fromArray($data);
    }

    /**
     * @param Callback $callback
     * @param Jwt $jwt
     * @return string
     * @throws ValidationException
     */
    private function prepareCallbackUrl(Callback $callback, Jwt $jwt): string
    {
        $encodedJwt = base64_encode(json_encode(new RJwt($jwt)));

        return $callback->url . '?' . http_build_query(
                [
                    'value' => $encodedJwt,
                    'signature' => app(SignatureModule::class)->generate(
                        (new GenerateSignatureRequest)
                            ->setValue(sha1($encodedJwt))
                            ->setSalt($callback->key)
                    )
                ]
            );
    }
}
