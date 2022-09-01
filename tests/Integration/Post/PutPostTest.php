<?php

namespace App\tests\Integration\Post;

use App\tests\BaseApiTest;
use Symfony\Component\HttpFoundation\Response;

class PutPostTest extends BaseApiTest
{
    /**
     * @test
     */
    public function it_put_post(): void
    {
        $client = self::createAuthenticatedClient();

        $postData = self::createPost($client);

        $client->request('GET', '/api/post/' . $postData['id']);
        $response = $client->getResponse();
        $data = json_decode($response->getContent(), true);

        $this->assertEquals($postData['id'], $data['id']);
        $this->assertEquals(self::POST_TITLE, $data['title']);
        $this->assertEquals(self::POST_CONTENT, $data['content']);

        $newTitle = 'edit';
        $newContent = 'edit';
        $client->request('PUT', '/api/post/' . $postData['id'], [
            'title' => $newTitle,
            'content' => $newContent,
        ]);
        $response = $client->getResponse();
        $this->assertEquals(Response::HTTP_NO_CONTENT, $response->getStatusCode());

        $client->request('GET', '/api/post/' . $postData['id']);
        $response = $client->getResponse();
        $data = json_decode($response->getContent(), true);

        $this->assertEquals($postData['id'], $data['id']);
        $this->assertEquals($newTitle, $data['title']);
        $this->assertEquals($newContent, $data['content']);
    }

    /**
     * @test
     */
    public function it_put_post_title_not_blank(): void
    {
        $client = self::createAuthenticatedClient();

        $postData = self::createPost($client);

        $client->request('PUT', '/api/post/' . $postData['id'], [
            'title' => '',
            'content' => 'content',
        ]);
        $response = $client->getResponse();
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function it_put_post_content_not_blank(): void
    {
        $client = self::createAuthenticatedClient();

        $postData = self::createPost($client);

        $client->request('PUT', '/api/post/' . $postData['id'], [
            'title' => 'title',
            'content' => '',
        ]);
        $response = $client->getResponse();
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function it_put_post_id_not_blank(): void
    {
        $client = self::createAuthenticatedClient();

        $client->request('PUT', '/api/post/', [
            'title' => 'title',
            'content' => 'content',
        ]);
        $response = $client->getResponse();
        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }
}
