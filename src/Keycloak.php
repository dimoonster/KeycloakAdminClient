<?php
declare(strict_types=1);
namespace hstng\KeycloakAdminClient;

use hstng\KeycloakAdminClient\Resources\RealmResource;
use hstng\KeycloakAdminClient\Resources\RealmsResource;

class Keycloak {
    private KeycloakProvider $provider;

    /**
     * @param KeycloakProvider $provider
     */
    public function __construct(KeycloakProvider $provider)
    {
        $this->provider = $provider;
    }

    public function realms() : RealmsResource {
        return new RealmsResource($this->provider);
    }

    public function realm(string $realmName) : RealmResource {
        return $this->realms()->realm($realmName);
    }
}