<?php
namespace hstng\KeycloakAdminClient;

interface KeycloakProvider {
    public function get(string $path, array $queryParams, bool $bearerAuth = true) : array;
    public function post(string $path, array $queryParams, bool $bearerAuth = true) : array;
}