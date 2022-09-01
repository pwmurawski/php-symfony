<?php

namespace App\tests\Integration\Comment;

use App\tests\BaseApiTest;
use Symfony\Component\HttpFoundation\Response;

class PostCommentTest extends BaseApiTest
{
    /**
     * @test
     */
    public function it_create_comment(): void
    {
        $client = self::createAuthenticatedClient();

        $postData = self::createPost($client);
        $commentData = self::createComment($client, $postData['id']);
        $this->assertResponseIsSuccessful();

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
    public function it_create_comment_content_not_blank(): void
    {
        $client = self::createAuthenticatedClient();

        $postData = self::createPost($client);

        $client->request('POST', '/api/comment', [
            'postId' => $postData['id'],
            'content' => ''
        ]);
        $response = $client->getResponse();
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function it_create_comment_postId_not_blank(): void
    {
        $client = self::createAuthenticatedClient();

        self::createComment($client, '');
        $response = $client->getResponse();
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function it_create_comment_postId_postExist(): void
    {
        $client = self::createAuthenticatedClient();

        self::createComment($client, '00000000-0000-0000-0000-000000000000');
        $response = $client->getResponse();
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }
}
