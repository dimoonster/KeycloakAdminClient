<?php

namespace hstng\KeycloakAdminClient\Resources;

use hstng\KeycloakAdminClient\KeycloakProvider;
use hstng\KeycloakAdminClient\Representation\RealmRepresentation;

class RealmResource {
    private string $realm;
    private RealmsResource $realmsResource;

    public function __construct(RealmsResource $realms, string $realm)
    {
        $this->realm = $realm;
        $this->realmsResource = $realms;
    }

    public function getProvider() : KeycloakProvider {
        return $this->realmsResource->getProvider();
    }

    public function getAuthPath() : string {
        return $this->realmsResource->getAuthPath().'/'.$this->realm;
    }

    public function getAdminPath() : string {
        return $this->realmsResource->getAdminPath().'/'.$this->realm;
    }

    public function users() : UsersResource {
        return new UsersResource($this);
    }

    public function openId() : ProtocolOpenIDResource {
        return new ProtocolOpenIDResource($this);
    }

    public function toRepresentation() : RealmRepresentation {
        $data = $this->getProvider()->get($this->getAuthPath(), []);
        return RealmRepresentation::fromArray($data);
    }
}