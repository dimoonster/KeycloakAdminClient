<?php
declare(strict_types=1);
namespace hstng\KeycloakAdminClient\Providers;

use DateInterval;
use DateTimeImmutable;
use Exception;
use hstng\KeycloakAdminClient\KeycloakProvider;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class KeycloakHTTPProvider implements KeycloakProvider
{
    private string $realm;
    private string $server;
    private string $clientId;
    private string $clientSecret;

    private Client $httpClient;

    private bool $authenticated;
    private string $token;
    private DateTimeImmutable $tokenExpire;

    public function __construct(string $server, string $clientRealm, string $clientId, string $clientSecret, Client $httpClient) {
        $this->server = $server;
        $this->realm = $clientRealm;
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->httpClient = $httpClient;

        $this->authenticated = false;
        $this->token = '';
        $this->tokenExpire = new DateTimeImmutable();
    }

    /**
     * @throws KeycloakHTTPProviderException
     */
    public function authenticate() : void {
        $queryData = [
            "grant_type" => "client_credentials",
            "client_id" => $this->clientId,
            "client_secret" => $this->clientSecret,
        ];

        $url = "$this->server/auth/realms/$this->realm/protocol/openid-connect/token";

        try {
            $response = $this->httpClient->post($url, [
                'form_params' => $queryData,
                'http_errors' => true,
            ]);

            $data = json_decode($response->getBody()->getContents(), true);
            $this->authenticated = true;
            $this->token = $data['access_token'];
            $this->tokenExpire = (new DateTimeImmutable())->add(new DateInterval("PT" . (int)($data['expires_in'] - 1) . "S"));
        } catch (GuzzleException|Exception $e) {
            throw KeycloakHTTPProviderException::AuthError($e);
        }
    }

    public function isAuthenticated() : bool {
        $now = new DateTimeImmutable();
        if($now > $this->tokenExpire) $this->authenticated = false;
        return $this->authenticated;
    }

    /**
     * @throws KeycloakHTTPProviderException
     */
    public function get(string $path, array $queryParams, bool $bearerAuth = true): array {
        if(!$this->isAuthenticated()) $this->authenticate();

        try {
            $request = $this->httpClient->get(
                $this->server . $path,
                $this->prepareOptions([ 'query' => $queryParams ], $bearerAuth)
            );
        } catch (GuzzleException $e) {
            throw KeycloakHTTPProviderException::SendGetRequestError($e);
        }

        return json_decode($request->getBody()->getContents(), true);
    }

    /**
     * @param string $path
     * @param array $queryParams
     * @param bool $bearerAuth
     * @return array
     * @throws KeycloakHTTPProviderException
     */
    public function post(string $path, array $queryParams, bool $bearerAuth = true): array {
        if(!$this->isAuthenticated()) $this->authenticate();

        try {
            $request = $this->httpClient->post(
                $this->server . $path,
                $this->prepareOptions([ 'form_params' => $queryParams ], $bearerAuth)
            );

            return json_decode($request->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            throw KeycloakHTTPProviderException::SendGetRequestError($e);
        }
    }

    private function prepareOptions(array $options, bool $bearerAuth) : array {
        $options['debug'] = true;
        $options['http_errors'] = true;
        if(!isset($options['headers'])) $options['headers'] = [];
        if($bearerAuth === true) {
            $options['headers']['Authorization'] = "Bearer $this->token";
        } else {
            if(isset($options['headers']['Authorization'])) unset($options['headers']['Authorization']);
            $options['auth'] = [
                $this->clientId,
                $this->clientSecret,
            ];
        }
        return $options;
    }

    public function getToken() : string {
        return $this->token;
    }
}