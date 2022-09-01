<?php

namespace App\tests\Integration\Post;

use App\tests\BaseApiTest;

class GetUserAuthPostsTest extends BaseApiTest
{
    /**
     * @test
     */
    public function it_get_user_auth_posts(): void
    {
        $client = self::createAuthenticatedClient();

        self::createPost($client);

        $client->request('GET', '/api/user/posts');
        $this->assertResponseIsSuccessful();

        $response = $client->getResponse();
        $data = json_decode($response->getContent(), true);

        $this->assertEquals(true, count($data) !== 0);
    }
}
