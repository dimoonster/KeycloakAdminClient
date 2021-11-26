<?php

namespace Dimoonster\KeycloakAdminClient\Resources;

use PHPUnit\Framework\TestCase;

class RealmResourceTest extends TestCase
{

    public function testOpenId()
    {
        $mockRealms = $this->getMockBuilder(RealmsResource::class)->disableOriginalConstructor()->getMock();
        $realm = new RealmResource($mockRealms, "test");

        $this->assertInstanceOf(ProtocolOpenIDResource::class, $realm->openId());
    }

    public function testGetAdminPath()
    {
        $mockRealms = $this
            ->getMockBuilder(RealmsResource::class)
            ->disableOriginalConstructor()
            ->getMock();
        $mockRealms->method('getAdminPath')->willReturn('/admin/root/path');
        $realm = new RealmResource($mockRealms, "test");

        $this->assertEquals("/admin/root/path/test", $realm->getAdminPath());
    }

    public function testGetAuthPath()
    {
        $mockRealms = $this
            ->getMockBuilder(RealmsResource::class)
            ->disableOriginalConstructor()
            ->getMock();
        $mockRealms->method('getAuthPath')->willReturn('/root/path');
        $realm = new RealmResource($mockRealms, "test");

        $this->assertEquals("/root/path/test", $realm->getAuthPath());
    }

    public function testUsers()
    {
        $mockRealms = $this->getMockBuilder(RealmsResource::class)->disableOriginalConstructor()->getMock();
        $realm = new RealmResource($mockRealms, "test");

        $this->assertInstanceOf(UsersResource::class, $realm->users());
    }
}
