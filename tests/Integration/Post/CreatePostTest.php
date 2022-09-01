<?php

namespace App\tests\Integration\Post;

use App\tests\BaseApiTest;
use Symfony\Component\HttpFoundation\Response;

class CreatePostTest extends BaseApiTest
{
    /**
     * @test
     */
    public function it_create_post(): void
    {
        $client = self::createAuthenticatedClient();

        $postData = self::createPost($client);
        $this->assertResponseIsSuccessful();

        $client->request('GET', '/api/post/' . $postData['id']);
        $response = $client->getResponse();
        $data = json_decode($response->getContent(), true);

        $this->assertEquals($postData['id'], $data['id']);
        $this->assertEquals(self::POST_TITLE, $data['title']);
        $this->assertEquals(self::POST_CONTENT, $data['content']);
    }

    /**
     * @test
     */
    public function it_create_post_title_not_blank(): void
    {
        $client = self::createAuthenticatedClient();

        $client->request('POST', '/api/post', [
            'title' => '',
            'content' => 'content',
        ]);
        $response = $client->getResponse();
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function it_create_post_content_not_blank(): void
    {
        $client = self::createAuthenticatedClient();

        $client->request('POST', '/api/post', [
            'title' => 'title',
            'content' => '',
        ]);
        $response = $client->getResponse();
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }
}
