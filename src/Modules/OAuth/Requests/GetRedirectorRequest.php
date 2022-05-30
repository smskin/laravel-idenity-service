<?php

namespace SMSkin\IdentityService\Modules\OAuth\Requests;

use SMSkin\IdentityService\Modules\Core\Rules\InstanceOfRule;
use SMSkin\IdentityService\Modules\OAuth\Models\Callback;

class GetRedirectorRequest extends BaseRequest
{
    public array $scopes = [];
    public Callback $callback;
    public string $signature;

    public function rules(): array
    {
        return array_merge(
            parent::rules(),
            [
                'callback' => [
                    'required',
                    new InstanceOfRule(Callback::class)
                ],
                'scopes' => [
                    'nullable',
                    'array'
                ],
                'signature' => [
                    'required'
                ]
            ]
        );
    }

    /**
     * @param array $scopes
     * @return GetRedirectorRequest
     */
    public function setScopes(array $scopes): GetRedirectorRequest
    {
        $this->scopes = $scopes;
        return $this;
    }

    /**
     * @param Callback $callback
     * @return GetRedirectorRequest
     */
    public function setCallback(Callback $callback): GetRedirectorRequest
    {
        $this->callback = $callback;
        return $this;
    }

    /**
     * @param string $signature
     * @return GetRedirectorRequest
     */
    public function setSignature(string $signature): GetRedirectorRequest
    {
        $this->signature = $signature;
        return $this;
    }
}
