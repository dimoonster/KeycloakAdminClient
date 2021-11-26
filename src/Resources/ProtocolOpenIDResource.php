<?php

namespace hstng\KeycloakAdminClient\Resources;

use hstng\KeycloakAdminClient\KeycloakProvider;

class ProtocolOpenIDResource {
    private RealmResource $realmResource;

    /**
     * @param RealmResource $realmResource
     */
    public function __construct(RealmResource $realmResource)
    {
        $this->realmResource = $realmResource;
    }

    public function getPath() : string {
        return $this->realmResource->getAuthPath().'/protocol/openid-connect';
    }

    public function getProvider() : KeycloakProvider {
        return $this->realmResource->getProvider();
    }

    public function tokenIntrospect(string $token) : array {
        $query = [
            'token' => $token
        ];

        return $this->getProvider()->post($this->getPath().'/token/introspect', $query, false);
    }

}