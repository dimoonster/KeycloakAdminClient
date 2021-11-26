<?php
declare(strict_types=1);
namespace hstng\KeycloakAdminClient\Representation;

class RoleRepresentation {
    private string $id;
    private string $name;
    private string $description;
    private bool $composite;
    private bool $clientRole;
    private string $containerId;
    private AttributesList $attributesList;

    /**
     * @param string $id
     * @param string $name
     * @param string $description
     * @param bool $isComposite
     * @param bool $isClientRole
     * @param string $containerId
     * @param AttributesList $attributesList
     */
    public function __construct(string $id, string $name, string $description, bool $isComposite, bool $isClientRole, string $containerId, AttributesList $attributesList) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->composite = $isComposite;
        $this->clientRole = $isClientRole;
        $this->containerId = $containerId;
        $this->attributesList = $attributesList;
    }

    public static function fromArray(array $data) : RoleRepresentation {
        return new RoleRepresentation(
            $data['id'],
            $data['name'] ?? '',
            $data['description'] ?? '',
            (bool)$data['composite'],
            (bool)$data['clientRole'],
            $data['containerId'],
            AttributesList::fromArray($data['attributes'] ?? [])
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
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return bool
     */
    public function isComposite(): bool
    {
        return $this->composite;
    }

    /**
     * @return bool
     */
    public function isClientRole(): bool
    {
        return $this->clientRole;
    }

    /**
     * @return string
     */
    public function getContainerId(): string
    {
        return $this->containerId;
    }

    /**
     * @return AttributesList
     */
    public function getAttributesList(): AttributesList
    {
        return $this->attributesList;
    }
}