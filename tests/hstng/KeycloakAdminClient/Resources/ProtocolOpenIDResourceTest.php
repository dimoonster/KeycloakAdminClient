<?php
namespace Dimoonster\KeycloakAdminClient\Resources;

use Dimoonster\KeycloakAdminClient\KeycloakProvider;
use PHPUnit\Framework\TestCase;

class ProtocolOpenIDResourceTest extends TestCase
{
    public function testTokenIntrospect()
    {
        $sampleArray = ['1', '2'];

        $providerMock = $this->getMockBuilder(KeycloakProvider::class)->getMock();
        $providerMock->method('post')->willReturn($sampleArray);

        $mock = $this->getMockBuilder(RealmResource::class)->disableOriginalConstructor()->getMock();
        $mock->method('getAuthPath')->willReturn('/auth');
        $mock->method('getProvider')->willReturn($providerMock);

        $openId = new ProtocolOpenIDResource($mock);

        self::assertIsArray($openId->tokenIntrospect(""));
        self::assertEquals($sampleArray, $openId->tokenIntrospect(""));
    }

    public function testGetPath()
    {
        $mock = $this->getMockBuilder(RealmResource::class)->disableOriginalConstructor()->getMock();
        $mock->method('getAuthPath')->willReturn('/auth');
        $openId = new ProtocolOpenIDResource($mock);

        self::assertIsString($openId->getPath());
        self::assertEquals("/auth/protocol/openid-connect", $openId->getPath());
    }

}
