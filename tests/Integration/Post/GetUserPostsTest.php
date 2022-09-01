<?php

namespace App\tests\Integration\Post;

use App\DataFixtures\UserLoadData;
use App\tests\BaseApiTest;

class GetUserPostsTest extends BaseApiTest
{
    /**
     * @test
     */
    public function it_get_user_posts(): void
    {
        $client = self::createAuthenticatedClient();

        $client->request('GET', '/api/post/user/' . UserLoadData::USER_ID);
        $this->assertResponseIsSuccessful();
        $response = $client->getResponse();
        $data = json_decode($response->getContent(), true);

        $this->assertEquals(true, count($data) !== 0);
    }
}
