<?php

namespace SMSkin\IdentityService\Modules\Scope\Controllers;

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

    public function execute(): self
    {
        $groupIds = [];
        $scopeIds = [];

        $groups = $this->getScopeGroupsEnum();
        foreach ($groups as $groupEnum) {
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

    private function getGroup(ScopeGroupEnumItem $item): ScopeGroup
    {
        $group = ScopeGroup::where('slug', $item->id)->first();
        if ($group) {
            app(UpdateScopeGroupName::class, [
                'request' => (new UpdateScopeGroupNameRequest())
                    ->setGroup($group)
                    ->setName($item->title)
            ])->execute();
            return $group;
        }

        return app(CreateScopeGroup::class, [
            'request' => (new CreateScopeGroupRequest())
                ->setName($item->title)
                ->setSlug($item->id)
        ])->execute()->getResult();
    }

    private function updateScope(ScopeGroup $group, EnumItem $item): Scope
    {
        $scope = Scope::where('group_id', $group->id)->where('slug', $item->id)->first();
        if ($scope) {
            app(UpdateScopeName::class, [
                'request' => (new UpdateScopeNameRequest())
                    ->setScope($scope)
                    ->setName($item->title)
            ])->execute();
            return $scope;
        }

        return app(CreateScope::class, [
            'request' => (new CreateScopeRequest())
                ->setGroup($group)
                ->setName($item->title)
                ->setSlug($item->id)
        ])->execute()->getResult();
    }

    private function dropUnusedGroups(array $groupIds)
    {
        app(DeleteScopeGroupsExcludeRequested::class, [
            'request' => (new DeleteScopesGroupsExcludeRequestedRequest())
                ->setIds($groupIds)
        ])->execute();
    }

    private function dropUnusedScopes(array $scopeIds)
    {
        app(DeleteScopesExcludeRequested::class, [
            'request' => (new DeleteScopesExcludeRequestedRequest())
                ->setIds($scopeIds)
        ])->execute();
    }
}