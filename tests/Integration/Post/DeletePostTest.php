<?php

namespace App\tests\Integration\Post;

use App\tests\BaseApiTest;
use Symfony\Component\HttpFoundation\Response;

class DeletePostTest extends BaseApiTest
{
    /**
     * @test
     */
    public function it_post_delete(): void
    {
        $client = self::createAuthenticatedClient();

        $postData = self::createPost($client);

        $client->request('GET', '/api/post/' . $postData['id']);
        $this->assertResponseIsSuccessful();

        $client->request('DELETE', '/api/post/' . $postData['id']);
        $response = $client->getResponse();
        $this->assertEquals(Response::HTTP_NO_CONTENT, $response->getStatusCode());

        $client->request('GET', '/api/post/' . $postData['id']);
        $response = $client->getResponse();
        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }
}
