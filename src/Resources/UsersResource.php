<?php

namespace hstng\KeycloakAdminClient\Resources;

use hstng\KeycloakAdminClient\KeycloakProvider;
use hstng\KeycloakAdminClient\Representation\UsersList;
use hstng\KeycloakAdminClient\Requests\UserSearchRequest;
use hstng\KeycloakAdminClient\Requests\UserSearchRequestException;

class UsersResource {
    private RealmResource $realm;

    /**
     * @param RealmResource $realm
     */
    public function __construct(RealmResource $realm) {
        $this->realm = $realm;
    }

    public function getProvider() : KeycloakProvider {
        return $this->realm->getProvider();
    }

    public function getPath() : string {
        return $this->realm->getAdminPath().'/users';
    }

    public function user(string $id) : UserResource {
        return new UserResource($this, $id);
    }

    /**
     * @throws UserSearchRequestException
     */
    public function search(UserSearchRequest $searchRequest) : UsersList {
        $queryParams = $searchRequest->toRequestArray();
        $data =  $this->getProvider()->get($this->getPath(), $queryParams);
        return UsersList::fromArray($data);
    }
}