<?php

namespace App\tests\Integration\User;

use App\tests\BaseApiTest;
use App\DataFixtures\UserLoadData;

class GetUserTest extends BaseApiTest
{
    /**
     * @test
     */
    public function it_get_user()
    {
        $client = self::createAuthenticatedClient();
        $client->request('GET', '/api/user/' . UserLoadData::USER_ID);
        $this->assertResponseIsSuccessful();

        $response =  $client->getResponse();
        $data = json_decode($response->getContent(), true);

        $this->assertEquals(UserLoadData::USER_ID, $data['id']);
        $this->assertEquals(UserLoadData::USER_USERNAME, $data['username']);
    }
}
