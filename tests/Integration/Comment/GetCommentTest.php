<?php

namespace App\tests\Integration\Comment;

use App\tests\BaseApiTest;
use Symfony\Component\HttpFoundation\Response;

class GetCommentTest extends BaseApiTest
{
    /**
     * @test
     */
    public function it_get_comment(): void
    {
        $client = self::createAuthenticatedClient();

        $postData = self::createPost($client);
        $commentData = self::createComment($client, $postData['id']);

        $client->request('GET', '/api/comment/' . $commentData['id']);
        $this->assertResponseIsSuccessful();

        $response = $client->getResponse();
        $data = json_decode($response->getContent(), true);

        $this->assertEquals($commentData['id'], $data['id']);
        $this->assertEquals(self::COMMENT_CONTENT, $data['content']);
    }

    /**
     * @test
     */
    public function it_get_comment_not_blank_id(): void
    {
        $client = self::createAuthenticatedClient();

        $client->request('GET', '/api/comment/');
        $response = $client->getResponse();
        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function it_get_comment_bad_id(): void
    {
        $client = self::createAuthenticatedClient();

        $client->request('GET', '/api/comment/00000000-0000-0000-0000-000000000000');
        $response = $client->getResponse();
        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }
}
