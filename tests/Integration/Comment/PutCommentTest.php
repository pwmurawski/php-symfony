<?php

namespace App\tests\Integration\Comment;

use App\tests\BaseApiTest;
use Symfony\Component\HttpFoundation\Response;

class PutCommentTest extends BaseApiTest
{
    /**
     * @test
     */
    public function it_comment_put(): void
    {
        $client = self::createAuthenticatedClient();

        $postData = self::createPost($client);
        $commentData = self::createComment($client, $postData['id']);

        $client->request('GET', '/api/comment/' . $commentData['id']);
        $response = $client->getResponse();
        $data = json_decode($response->getContent(), true);

        $this->assertEquals($commentData['id'], $data['id']);
        $this->assertEquals(self::COMMENT_CONTENT, $data['content']);
        $this->assertEquals(false, $data['isEdited']);

        $commentContent = 'edit';
        $client->request('PUT', '/api/comment/' . $commentData['id'], [
            'content' => $commentContent,
        ]);
        $response = $client->getResponse();
        $this->assertEquals(Response::HTTP_NO_CONTENT, $response->getStatusCode());

        $client->request('GET', '/api/comment/' . $commentData['id']);
        $response = $client->getResponse();
        $data = json_decode($response->getContent(), true);

        $this->assertEquals($commentData['id'], $data['id']);
        $this->assertEquals($commentContent, $data['content']);
        $this->assertEquals(true, $data['isEdited']);
    }

    /**
     * @test
     */
    public function it_comment_put_content_not_blank(): void
    {
        $client = self::createAuthenticatedClient();

        $postData = self::createPost($client);
        $commentData = self::createComment($client, $postData['id']);

        $client->request('PUT', '/api/comment/' . $commentData['id'], [
            'content' => '',
        ]);
        $response = $client->getResponse();
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function it_comment_put_commentId_not_blank(): void
    {
        $client = self::createAuthenticatedClient();

        $client->request('PUT', '/api/comment/', [
            'content' => 'edit',
        ]);
        $response = $client->getResponse();
        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function it_comment_put_bad_commentId(): void
    {
        $client = self::createAuthenticatedClient();

        $client->request('PUT', '/api/comment/' . '00000000-0000-0000-0000-000000000000', [
            'content' => 'edit',
        ]);
        $response = $client->getResponse();
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }
}
