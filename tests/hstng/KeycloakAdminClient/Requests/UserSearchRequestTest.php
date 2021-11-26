<?php

namespace hstng\KeycloakAdminClient\Requests;

use PHPUnit\Framework\Constraint\IsType;
use PHPUnit\Framework\TestCase;

class UserSearchRequestTest extends TestCase
{

    public function testGetMaxResults()
    {
        $request = new UserSearchRequest();
        $this->assertIsInt($request->getMaxResults());
        $this->assertEquals(50, $request->getMaxResults());
    }

    public function testGetFirstResult()
    {
        $request = new UserSearchRequest();
        $this->assertIsInt($request->getFirstResult());
        $this->assertEquals(0, $request->getFirstResult());
    }

    public function testWithFirstResult()
    {
        $newValue = 555;
        $fields = array_keys(UserSearchRequest::AVAILABLE_FIELDS_TYPES);
        $request = new UserSearchRequest();
        $initValue = $request->getFirstResult();
        $this->assertNotEquals($newValue, $initValue);

        foreach ($fields as $field) {
            $this->assertFalse($request->has($field));
        }

        $changed = $request->withFirstResult($newValue);
        $this->assertNotEquals($request, $changed);
        $this->assertNotEquals($request->getFirstResult(), $changed->getFirstResult());

        $this->assertEquals($initValue, $request->getFirstResult());
        $this->assertEquals($newValue, $changed->getFirstResult());

        $this->assertEquals($request->getMaxResults(), $changed->getMaxResults());
        $this->assertNotEquals($request->toRequestArray(), $changed->toRequestArray());

        foreach ($fields as $field) {
            $this->assertFalse($request->has($field));
        }

        foreach ($fields as $field) {
            $this->assertFalse($changed->has($field));
        }
    }

    public function testWithMaxResults()
    {
        $newValue = 333;
        $fields = array_keys(UserSearchRequest::AVAILABLE_FIELDS_TYPES);
        $request = new UserSearchRequest();
        $initValue = $request->getMaxResults();
        $this->assertNotEquals($newValue, $initValue);

        foreach ($fields as $field) {
            $this->assertFalse($request->has($field));
        }

        $changed = $request->withMaxResults($newValue);
        $this->assertNotEquals($request, $changed);
        $this->assertNotEquals($request->getMaxResults(), $changed->getMaxResults());

        $this->assertEquals($initValue, $request->getMaxResults());
        $this->assertEquals($newValue, $changed->getMaxResults());

        $this->assertEquals($request->getFirstResult(), $changed->getFirstResult());
        $this->assertNotEquals($request->toRequestArray(), $changed->toRequestArray());

        foreach ($fields as $field) {
            $this->assertFalse($request->has($field));
        }

        foreach ($fields as $field) {
            $this->assertFalse($changed->has($field));
        }

    }

    public function testWith()
    {
        $request = new UserSearchRequest();
        $fields = array_keys(UserSearchRequest::AVAILABLE_FIELDS_TYPES);
        foreach ($fields as $field) {
            switch(UserSearchRequest::AVAILABLE_FIELDS_TYPES[$field]) {
                case 'boolean':
                    $changedTrue = $request->with($field, true);
                    $this->assertNotEquals($request, $changedTrue);
                    $this->assertTrue($changedTrue->has($field));
                    $this->assertTrue($changedTrue->get($field));
                    foreach ($fields as $subField) {
                        if($field === $subField) continue;
                        $this->assertEquals($request->has($subField), $changedTrue->has($subField));
                    }

                    $changedFalse = $request->with($field, false);
                    $this->assertNotEquals($request, $changedTrue);
                    $this->assertTrue($changedTrue->has($field));
                    foreach ($fields as $subField) {
                        if($field === $subField) continue;
                        $this->assertEquals($request->has($subField), $changedFalse->has($subField));
                    }
            }
        }
    }

    public function testHas()
    {
        $request = new UserSearchRequest();
        $fields = array_keys(UserSearchRequest::AVAILABLE_FIELDS_TYPES);
        foreach ($fields as $field) {
            $this->assertIsBool($request->has($field));
            $this->assertEquals(false,$request->has($field));
        }
    }

    private function getFilledUserSearchRequest() : UserSearchRequest {
        $request = new UserSearchRequest();
        $fields = array_keys(UserSearchRequest::AVAILABLE_FIELDS_TYPES);
        foreach ($fields as $field) {
            switch(UserSearchRequest::AVAILABLE_FIELDS_TYPES[$field]) {
                case 'boolean':
                    $request = $request->with($field, true);
                    break;
                case 'string':
                    $request = $request->with($field, "test");
                    break;
                case 'integer':
                    $request = $request->with($field, 1);
                    break;
                default:
                    $this->assertEquals("", "unknown", "Strange type");
            }
        }
        return $request;
    }

    public function testWithout() {
        $request = $this->getFilledUserSearchRequest();
        $fields = array_keys(UserSearchRequest::AVAILABLE_FIELDS_TYPES);

        foreach ($fields as $field) {
            $preRequest = $request;
            $request = $request->without($field);
            $this->assertInstanceOf(get_class($preRequest), $request);
            $this->assertNotEquals($preRequest, $request);
        }
    }

    public function testGet()
    {
        $request = $this->getFilledUserSearchRequest();
        foreach (UserSearchRequest::AVAILABLE_FIELDS_TYPES as $field=>$type) {
            $this->assertThat($request->get($field), new IsType($type));
        }
    }

    public function testToArray()
    {
        $request = $this->getFilledUserSearchRequest();
        $dataArray = $request->toRequestArray();
        $this->assertIsArray($dataArray);
        $this->assertCount(11, $dataArray);
        $this->assertEquals([
            'max' => 50,
            'first' => 0,
            'search' => 'test',
            'username' => 'test',
            'firstName' => 'test',
            'lastName' => 'test',
            'email' => 'test',
            'emailVerified' => 'true',
            'idpAlias' => 'test',
            'idpUserId' => 'test',
            'enabled' => 'true',
        ], $dataArray);
    }

}
