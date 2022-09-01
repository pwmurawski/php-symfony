<?php

namespace App\tests\Integration\SavedPost;

use App\tests\BaseApiTest;
use Symfony\Component\HttpFoundation\Response;

class PostSavedPostTest extends BaseApiTest
{
    /**
     * @test
     */
    public function it_post_savedPost(): void
    {
        $client = self::createAuthenticatedClient();

        $postData = self::createPost($client);
        $savedPostData = self::createSavedPost($client, $postData['id']);
        $this->assertResponseIsSuccessful();

        $client->request('GET', '/api/user/savedPosts');
        $response = $client->getResponse();
        $data = json_decode($response->getContent(), true);

        foreach ($data as $savedPost) {
            if ($savedPost['id'] === $savedPostData['id']) {
                $this->assertEquals(true, $savedPost['id'] === $savedPostData['id']);
            }
        }
    }

    /**
     * @test
     */
    public function it_post_savedPost_postId_not_blank(): void
    {
        $client = self::createAuthenticatedClient();

        self::createSavedPost($client, '');
        $response = $client->getResponse();
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function it_post_savedPost_post_exist(): void
    {
        $client = self::createAuthenticatedClient();

        self::createSavedPost($client, '00000000-0000-0000-0000-000000000000');
        $response = $client->getResponse();
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function it_post_savedPost_post_not_savedPost(): void
    {
        $client = self::createAuthenticatedClient();

        $postData = self::createPost($client);
        self::createSavedPost($client, $postData['id']);
        self::createSavedPost($client, $postData['id']);

        $response = $client->getResponse();
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }
}
