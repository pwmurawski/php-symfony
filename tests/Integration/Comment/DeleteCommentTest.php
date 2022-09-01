<?php

namespace App\tests\Integration\Comment;

use App\tests\BaseApiTest;

class DeleteCommentTest extends BaseApiTest
{
    /**
     * @test
     */
    public function it_delete_comment(): void
    {
        $client = self::createAuthenticatedClient();

        $postData = self::createPost($client);
        $commentData = self::createComment($client, $postData['id']);

        $client->request('DELETE', '/api/comment/' . $commentData['id']);
        $response = $client->getResponse();
        $this->assertEquals(204, $response->getStatusCode());

        $client->request('GET', '/api/comment/' . $commentData['id']);
        $response = $client->getResponse();
        $this->assertEquals(404, $response->getStatusCode());
    }
}
