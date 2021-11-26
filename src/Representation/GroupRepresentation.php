<?php
declare(strict_types=1);
namespace hstng\KeycloakAdminClient\Representation;

class GroupRepresentation {
    private string $id;
    private string $name;
    private string $path;

    private bool $attributesLoaded;
    private AttributesList $attributes;

    private bool $realmRolesLoaded;
    private array $realmRoles;

    private bool $clientRolesLoaded;
    private array $clientRoles;

    /**
     * @param string $id
     * @param string $name
     * @param string $path
     * @param bool $attributesLoaded
     * @param AttributesList $attributesList
     * @param bool $realmRolesLoaded
     * @param array $realmRoles
     * @param bool $clientRolesLoaded
     * @param array $clientRoles
     */
    public function __construct(string $id, string $name, string $path, bool $attributesLoaded, AttributesList $attributesList, bool $realmRolesLoaded, array $realmRoles, bool $clientRolesLoaded, array $clientRoles)
    {
        $this->id = $id;
        $this->name = $name;
        $this->path = $path;

        $this->attributesLoaded = $attributesLoaded;
        $this->attributes = $attributesList;

        $this->realmRolesLoaded = $realmRolesLoaded;
        $this->realmRoles = $realmRoles;

        $this->clientRolesLoaded = $clientRolesLoaded;
        $this->clientRoles = $clientRoles;
    }

    public static function fromArray(array $data) : GroupRepresentation {
        return new self(
            $data['id'],
            $data['name'],
            $data['path'],
            array_key_exists('attributes', $data),
            AttributesList::fromArray($data['attributes'] ?? []),
            array_key_exists('realmRoles', $data),
            $data['realmRoles'] ?? [],
            array_key_exists('clientRoles', $data),
            $data['clientRoles'] ?? []
        );
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @return bool
     */
    public function isAttributesLoaded(): bool
    {
        return $this->attributesLoaded;
    }

    /**
     * @return AttributesList
     */
    public function getAttributes(): AttributesList
    {
        return $this->attributes;
    }

    /**
     * @return bool
     */
    public function isRealmRolesLoaded(): bool
    {
        return $this->realmRolesLoaded;
    }

    /**
     * @return array
     */
    public function getRealmRoles(): array
    {
        return $this->realmRoles;
    }

    /**
     * @return bool
     */
    public function isClientRolesLoaded(): bool
    {
        return $this->clientRolesLoaded;
    }

    /**
     * @return array
     */
    public function getClientRoles(): array
    {
        return $this->clientRoles;
    }
}