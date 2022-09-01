<?php

namespace App\tests\Integration\Post;

use App\tests\BaseApiTest;
use Symfony\Component\HttpFoundation\Response;

class GetPostTest extends BaseApiTest
{
    /**
     * @test
     */
    public function it_get_post(): void
    {
        $client = self::createAuthenticatedClient();

        $postData = self::createPost($client);

        $client->request('GET', '/api/post/' . $postData['id']);
        $this->assertResponseIsSuccessful();

        $response = $client->getResponse();
        $data = json_decode($response->getContent(), true);

        $this->assertEquals($postData['id'], $data['id']);
        $this->assertEquals(self::POST_TITLE, $data['title']);
        $this->assertEquals(self::POST_CONTENT, $data['content']);
    }

    /**
     * @test
     */
    public function it_get_post_postId_not_blank(): void
    {
        $client = self::createAuthenticatedClient();

        $client->request('GET', '/api/post/');
        $response = $client->getResponse();
        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }
}
