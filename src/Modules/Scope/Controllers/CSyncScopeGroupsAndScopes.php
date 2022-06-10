<?php

namespace SMSkin\IdentityService\Modules\Scope\Controllers;

use Illuminate\Validation\ValidationException;
use SMSkin\IdentityService\Models\Scope;
use SMSkin\IdentityService\Models\ScopeGroup;
use SMSkin\IdentityService\Traits\ClassFromConfig;
use SMSkin\LaravelSupport\BaseController;
use SMSkin\LaravelSupport\Models\EnumItem;
use SMSkin\IdentityService\Modules\Scope\Actions\CreateScope;
use SMSkin\IdentityService\Modules\Scope\Actions\CreateScopeGroup;
use SMSkin\IdentityService\Modules\Scope\Actions\DeleteScopeGroupsExcludeRequested;
use SMSkin\IdentityService\Modules\Scope\Actions\DeleteScopesExcludeRequested;
use SMSkin\IdentityService\Modules\Scope\Actions\UpdateScopeGroupName;
use SMSkin\IdentityService\Modules\Scope\Actions\UpdateScopeName;
use SMSkin\IdentityServiceClient\Enums\Models\ScopeGroup as ScopeGroupEnumItem;
use SMSkin\IdentityService\Modules\Scope\Requests\CreateScopeGroupRequest;
use SMSkin\IdentityService\Modules\Scope\Requests\CreateScopeRequest;
use SMSkin\IdentityService\Modules\Scope\Requests\DeleteScopesExcludeRequestedRequest;
use SMSkin\IdentityService\Modules\Scope\Requests\DeleteScopesGroupsExcludeRequestedRequest;
use SMSkin\IdentityService\Modules\Scope\Requests\UpdateScopeGroupNameRequest;
use SMSkin\IdentityService\Modules\Scope\Requests\UpdateScopeNameRequest;

class CSyncScopeGroupsAndScopes extends BaseController
{
    use ClassFromConfig;

    /**
     * @return $this
     * @throws ValidationException
     */
    public function execute(): static
    {
        $groupIds = [];
        $scopeIds = [];

        $groups = self::getScopeGroupsEnum();
        foreach ($groups::items() as $groupEnum) {
            $group = $this->getGroup($groupEnum);
            foreach ($groupEnum->scopes as $scopeEnum) {
                $scope = $this->updateScope($group, $scopeEnum);
                $scopeIds[] = $scope->id;
            }
            $groupIds[] = $group->id;
        }

        $this->dropUnusedGroups($groupIds);
        $this->dropUnusedScopes($scopeIds);

        return $this;
    }

    /**
     * @param ScopeGroupEnumItem $item
     * @return ScopeGroup
     * @throws ValidationException
     */
    private function getGroup(ScopeGroupEnumItem $item): ScopeGroup
    {
        $group = ScopeGroup::where('slug', $item->id)->first();
        if ($group) {
            (new UpdateScopeGroupName(
                (new UpdateScopeGroupNameRequest())
                    ->setGroup($group)
                    ->setName($item->title)
            ))->execute();
            return $group;
        }

        return (new CreateScopeGroup(
            (new CreateScopeGroupRequest())
                ->setName($item->title)
                ->setSlug($item->id)
        ))->execute()->getResult();
    }

    /**
     * @param ScopeGroup $group
     * @param EnumItem $item
     * @return Scope
     * @throws ValidationException
     */
    private function updateScope(ScopeGroup $group, EnumItem $item): Scope
    {
        $scope = Scope::where('group_id', $group->id)->where('slug', $item->id)->first();
        if ($scope) {
            (new UpdateScopeName(
                (new UpdateScopeNameRequest())
                    ->setScope($scope)
                    ->setName($item->title)
            ))->execute();
            return $scope;
        }

        return (new CreateScope(
            (new CreateScopeRequest())
                ->setGroup($group)
                ->setName($item->title)
                ->setSlug($item->id)
        ))->execute()->getResult();
    }

    /**
     * @param array $groupIds
     * @return void
     * @throws ValidationException
     */
    private function dropUnusedGroups(array $groupIds)
    {
        if (!count($groupIds)) {
            return;
        }

        (new DeleteScopeGroupsExcludeRequested(
            (new DeleteScopesGroupsExcludeRequestedRequest())
                ->setIds($groupIds)
        ))->execute();
    }

    /**
     * @param array $scopeIds
     * @return void
     * @throws ValidationException
     */
    private function dropUnusedScopes(array $scopeIds)
    {
        if (!count($scopeIds)) {
            return;
        }

        (new DeleteScopesExcludeRequested(
            (new DeleteScopesExcludeRequestedRequest())
                ->setIds($scopeIds)
        ))->execute();
    }
}
