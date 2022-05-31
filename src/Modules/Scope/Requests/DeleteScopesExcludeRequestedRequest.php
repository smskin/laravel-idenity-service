<?php

namespace SMSkin\IdentityService\Modules\Scope\Requests;

use SMSkin\LaravelSupport\BaseRequest;

class DeleteScopesExcludeRequestedRequest extends BaseRequest
{
    public array $ids;

    public function rules(): array
    {
        return [
            'ids' => [
                'required',
                'array'
            ],
            'ids.*' => [
                'required',
                'exists:scopes,id'
            ]
        ];
    }

    /**
     * @param array $ids
     * @return DeleteScopesExcludeRequestedRequest
     */
    public function setIds(array $ids): DeleteScopesExcludeRequestedRequest
    {
        $this->ids = $ids;
        return $this;
    }
}