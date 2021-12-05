<?php
declare(strict_types=1);
namespace hstng\KeycloakAdminClient\Representation;

class RealmRepresentation {
    private string $realmName;
    private string $publicKey;
    private string $tokenService;
    private string $accountService;
    private int $tokensNotBefore;

    /**
     * @param string $realmName
     * @param string $publicKey
     * @param string $tokenService
     * @param string $accountService
     * @param int $tokensNotBefore
     */
    public function __construct(string $realmName, string $publicKey, string $tokenService, string $accountService, int $tokensNotBefore)
    {
        $this->realmName = $realmName;
        $this->publicKey = $publicKey;
        $this->tokenService = $tokenService;
        $this->accountService = $accountService;
        $this->tokensNotBefore = $tokensNotBefore;
    }

    public static function fromArray(array $data) : RealmRepresentation {
        return new self(
            (string)$data['realm'],
            (string)$data['public_key'],
            (string)$data['token-service'],
            (string)$data['account-service'],
            (int)$data['tokens-not-before']
        );
    }

    /**
     * @return string
     */
    public function getRealmName(): string
    {
        return $this->realmName;
    }

    /**
     * @return string
     */
    public function getPublicKey(): string
    {
        return $this->publicKey;
    }

    public function getPublicKeyAsCert() : string {
        return"-----BEGIN PUBLIC KEY-----\n{$this->getPublicKey()}\n-----END PUBLIC KEY-----";
    }

    /**
     * @return string
     */
    public function getTokenService(): string
    {
        return $this->tokenService;
    }

    /**
     * @return string
     */
    public function getAccountService(): string
    {
        return $this->accountService;
    }

    /**
     * @return int
     */
    public function getTokensNotBefore(): int
    {
        return $this->tokensNotBefore;
    }


}