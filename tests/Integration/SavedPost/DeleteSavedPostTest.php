<?php

namespace App\tests\Integration\SavedPost;

use App\tests\BaseApiTest;
use Symfony\Component\HttpFoundation\Response;

class DeleteSavedPostTest extends BaseApiTest
{
    /**
     * @test
     */
    public function it_delete_savedPost(): void
    {
        $client = self::createAuthenticatedClient();

        $postData = self::createPost($client);
        $savedPostData = self::createSavedPost($client, $postData['id']);

        $client->request('GET', '/api/user/savedPosts');
        $response = $client->getResponse();
        $data = json_decode($response->getContent(), true);

        foreach ($data as $savedPost) {
            if ($savedPost['id'] === $savedPostData['id'])
                $this->assertEquals(true, $savedPost['id'] === $savedPostData['id']);
        }

        $client->request('DELETE', '/api/savedPost/post/' . $postData['id']);
        $response = $client->getResponse();
        $this->assertEquals(Response::HTTP_NO_CONTENT, $response->getStatusCode());

        $client->request('GET', '/api/user/savedPosts');
        $response = $client->getResponse();
        $data = json_decode($response->getContent(), true);

        foreach ($data as $savedPost) {
            if ($savedPost['id'] === $savedPostData['id'])
                $this->assertEquals(false, $savedPost['id'] === $savedPostData['id']);
        }
    }

    /**
     * @test
     */
    public function it_delete_savedPost_id_not_blank(): void
    {
        $client = self::createAuthenticatedClient();

        $client->request('DELETE', '/api/savedPost/');
        $response = $client->getResponse();
        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }
}
