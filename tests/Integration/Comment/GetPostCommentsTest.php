<?php

namespace App\tests\Integration\Comment;

use App\tests\BaseApiTest;
use Symfony\Component\HttpFoundation\Response;

class GetPostCommentsTest extends BaseApiTest
{
    /**
     * @test
     */
    public function it_get_post_comments(): void
    {
        $client = self::createAuthenticatedClient();

        $postData = self::createPost($client);
        $commentData = self::createComment($client, $postData['id']);

        $client->request('GET', '/api/comment/post/' . $postData['id']);
        $this->assertResponseIsSuccessful();

        $response = $client->getResponse();
        $data = json_decode($response->getContent(), true);

        $this->assertEquals($commentData['id'], $data[0]['id']);
        $this->assertEquals(self::COMMENT_CONTENT, $data[0]['content']);
    }
}
