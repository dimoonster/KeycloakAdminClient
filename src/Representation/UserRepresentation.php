<?php
declare(strict_types=1);
namespace hstng\KeycloakAdminClient\Representation;

use DateTimeImmutable;

class UserRepresentation  {
    private string $id;
    private DateTimeImmutable $createdDate;
    private string $userName;
    private bool $enabled;
    private bool $emailVerified;
    private string $email;
    private string $firstName;
    private string $lastName;
    private array $requiredActions;
    private AttributesList $attributes;

    /**
     * @param string $id
     * @param DateTimeImmutable $createdDate
     * @param string $userName
     * @param bool $enabled
     * @param bool $emailVerified
     * @param string $email
     * @param string $firstName
     * @param string $lastName
     * @param array $requiredActions
     * @param AttributesList $attributes
     */
    public function __construct(string $id, DateTimeImmutable $createdDate, string $userName, bool $enabled, bool $emailVerified, string $email, string $firstName, string $lastName, array $requiredActions, AttributesList $attributes)
    {
        $this->id = $id;
        $this->createdDate = $createdDate;
        $this->userName = $userName;
        $this->enabled = $enabled;
        $this->emailVerified = $emailVerified;
        $this->email = $email;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->requiredActions = $requiredActions;
        $this->attributes = $attributes;
    }

    public static function fromArray(array $data) : UserRepresentation {
        return new self(
            $data['id'],
            (new DateTimeImmutable())->setTimestamp((int)$data['createdTimestamp']),
            $data['username'],
            (bool)$data['enabled'],
            (bool)$data['emailVerified'],
            $data['email'],
            $data['firstName'],
            $data['lastName'],
            $data['requiredActions'] ?? [],
            AttributesList::fromArray($data['attributes'] ?? []),
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
     * @return DateTimeImmutable
     */
    public function getCreatedDate(): DateTimeImmutable
    {
        return $this->createdDate;
    }

    /**
     * @return string
     */
    public function getUserName(): string
    {
        return $this->userName;
    }

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    /**
     * @return bool
     */
    public function isEmailVerified(): bool
    {
        return $this->emailVerified;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @return array
     */
    public function getRequiredActions(): array
    {
        return $this->requiredActions;
    }

    /**
     * @return AttributesList
     */
    public function getAttributes(): AttributesList
    {
        return $this->attributes;
    }

}