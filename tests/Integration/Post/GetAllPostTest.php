<?php

namespace App\tests\Integration\Post;

use App\tests\BaseApiTest;

class GetAllPostTest extends BaseApiTest
{
    /**
     * @test
     */
    public function it_post_get_all(): void
    {
        $client = self::createAuthenticatedClient();

        self::createPost($client);

        $client->request('GET', '/api/posts');
        $this->assertResponseIsSuccessful();

        $response = $client->getResponse();
        $data = json_decode($response->getContent(), true);

        $this->assertEquals(true, count($data) !== 0);
    }
}
