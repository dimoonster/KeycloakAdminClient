<?php

namespace hstng\KeycloakAdminClient\Resources;

use hstng\KeycloakAdminClient\KeycloakProvider;
use hstng\KeycloakAdminClient\Representation\GroupsList;
use hstng\KeycloakAdminClient\Representation\UserRepresentation;

class UserResource {
    private UsersResource $usersResource;
    private string $id;

    /**
     * @param UsersResource $usersResource
     * @param string $id
     */
    public function __construct(UsersResource $usersResource, string $id) {
        $this->usersResource = $usersResource;
        $this->id = $id;
    }

    public function getPath() : string {
        return $this->usersResource->getPath()."/$this->id";
    }

    public function getProvider() : KeycloakProvider {
        return $this->usersResource->getProvider();
    }

    public function toRepresentation() : UserRepresentation {
        $data = $this->getProvider()->get($this->getPath(), []);
        return UserRepresentation::fromArray($data);
    }

    public function groups() : GroupsList {
        $data = $this->getProvider()->get($this->getPath().'/groups', [ 'briefRepresentation' => false ]);
        return GroupsList::fromArray($data);
    }

//    public function searchGroups(string $search) : GroupsList {
//
//    }
//
//    public function searchGroupsCount(string $search) : array {
//
//    }

    public function logout() : void {
        $this->getProvider()->get($this->getPath().'/logout', []);
    }

//    public function sessions() : UserSessionRepresentationList {
//
//    }

    public function roles(): RoleMappingsResource {
        return new RoleMappingsResource($this);
    }
}