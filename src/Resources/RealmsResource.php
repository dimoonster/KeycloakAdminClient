<?php

namespace hstng\KeycloakAdminClient\Resources;

use hstng\KeycloakAdminClient\KeycloakProvider;

class RealmsResource {
    private KeycloakProvider $provider;
    /** @var RealmResource[] array  */
    private array $realms;

    /**
     * @param KeycloakProvider $provider
     */
    public function __construct(KeycloakProvider $provider)
    {
        $this->provider = $provider;
        $this->realms = [];
    }

    public function getAuthPath() : string {
        return '/auth/realms';
    }

    public function getAdminPath() : string {
        return '/auth/admin/realms';
    }

    /**
     * @return KeycloakProvider
     */
    public function getProvider(): KeycloakProvider {
        return $this->provider;
    }

    public function realm(string $realm) : RealmResource {
        if(!isset($this->realms[$realm])) $this->realms[$realm] = new RealmResource($this, $realm);

        return $this->realms[$realm];
    }
}