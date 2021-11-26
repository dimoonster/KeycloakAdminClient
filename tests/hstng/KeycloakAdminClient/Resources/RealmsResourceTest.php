<?php

namespace Dimoonster\KeycloakAdminClient\Resources;

use Dimoonster\KeycloakAdminClient\KeycloakProvider;
use PHPUnit\Framework\TestCase;

class RealmsResourceTest extends TestCase
{
    private function getMockedProvider() : KeycloakProvider {
        $mock = $this->getMockBuilder(KeycloakProvider::class)->getMock();
        return $mock;
    }

    public function testGetProvider()
    {
        $provider = $this->getMockedProvider();
        $realms = new RealmsResource($provider);
        $this->assertInstanceOf(KeycloakProvider::class, $realms->getProvider());
        $this->assertEquals($provider, $realms->getProvider());
    }

    public function testRealm() {
        $realms = new RealmsResource($this->getMockedProvider());
        $this->assertInstanceOf(RealmResource::class, $realms->realm("test"));
    }

    public function testGetAuthPath()
    {
        $realms = new RealmsResource($this->getMockedProvider());
        $this->assertEquals("/auth/realms", $realms->getAuthPath());
    }

    public function testGetAdminPath()
    {
        $realms = new RealmsResource($this->getMockedProvider());
        $this->assertEquals("/auth/admin/realms", $realms->getAdminPath());
    }
}
