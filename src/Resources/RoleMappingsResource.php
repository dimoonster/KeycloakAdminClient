<?php

namespace hstng\KeycloakAdminClient\Resources;

use hstng\KeycloakAdminClient\KeycloakProvider;

class RoleMappingsResource
{
    private UserResource $userResource;

    /**
     * @param UserResource $userResource
     */
    public function __construct(UserResource $userResource)
    {
        $this->userResource = $userResource;
    }

    public function getPath() : string {
        return $this->userResource->getPath().'/role-mappings';
    }

    public function getProvider() : KeycloakProvider {
        return $this->userResource->getProvider();
    }

    public function realmLevel() : RoleScopeResource {
        return new RoleScopeResource($this);
    }

    public function clientLevel(string $clientId) : RoleScopeResource {
        return new RoleScopeResource($this, $clientId);
    }
}