<?php

namespace SMSkin\IdentityService\Modules\Scope\Requests;

use SMSkin\LaravelSupport\BaseRequest;

class DeleteScopesGroupsExcludeRequestedRequest extends BaseRequest
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
                'exists:scope_groups,id'
            ]
        ];
    }

    /**
     * @param array $ids
     * @return DeleteScopesGroupsExcludeRequestedRequest
     */
    public function setIds(array $ids): DeleteScopesGroupsExcludeRequestedRequest
    {
        $this->ids = $ids;
        return $this;
    }
}