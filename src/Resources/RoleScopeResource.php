<?php

namespace hstng\KeycloakAdminClient\Resources;

use hstng\KeycloakAdminClient\KeycloakProvider;
use hstng\KeycloakAdminClient\Representation\RolesList;

class RoleScopeResource
{
    private RoleMappingsResource $roleMappingsResource;
    private ?string $clientId;

    /**
     * @param RoleMappingsResource $roleMappingsResource
     * @param string|null $clientId
     */
    public function __construct(RoleMappingsResource $roleMappingsResource, ?string $clientId = null)
    {
        $this->roleMappingsResource = $roleMappingsResource;
        $this->clientId = $clientId;
    }

    public function getProvider() : KeycloakProvider {
        return $this->roleMappingsResource->getProvider();
    }

    public function getPath() : string {
        if($this->clientId !== null)
            return $this->roleMappingsResource->getPath().'/clients/'.$this->clientId;

        return $this->roleMappingsResource->getPath().'/realm';
    }

    public function listAll() : RolesList {
        $data = $this->getProvider()->get($this->getPath(), ['briefRepresentation' => false]);
        return RolesList::fromArray($data);
    }

    public function listEffective() : RolesList {
        $data = $this->getProvider()->get($this->getPath().'/composite', ['briefRepresentation' => false]);
        return RolesList::fromArray($data);
    }

    public function listAvailable() : RolesList {
        $data = $this->getProvider()->get($this->getPath().'/available', ['briefRepresentation' => false]);
        return RolesList::fromArray($data);
    }

}