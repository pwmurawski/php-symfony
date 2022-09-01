<?php

namespace App\tests;

use Symfony\Component\HttpKernel\HttpKernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class BaseApiTest extends WebTestCase
{
    protected const POST_TITLE = 'POST_TITLE';
    protected const POST_CONTENT = 'POST_CONTENT';
    protected const COMMENT_CONTENT = 'COMMENT_CONTENT';

    protected static function createAuthenticatedClient(
        $username = 'user@email.com',
        $password = 'password'
    ): HttpKernelBrowser {
        $client = static::createClient();
        $client->jsonRequest(
            'POST',
            '/api/login',
            [
                'username' => $username,
                'password' => $password
            ],
        );

        $data = json_decode($client->getResponse()->getContent(), true, 512, JSON_THROW_ON_ERROR);
        $token = $data['token'];

        $client->setServerParameter('HTTP_Authorization', sprintf('Bearer %s', $token));

        return $client;
    }

    protected static function createPost(HttpKernelBrowser $client): array
    {
        $client->request('POST', '/api/post', [
            'title' => self::POST_TITLE,
            'content' => self::POST_CONTENT
        ]);
        $response = $client->getResponse();
        $data = json_decode($response->getContent(), true);

        return $data;
    }

    protected static function createComment(HttpKernelBrowser $client, string $postId): array
    {
        $client->request('POST', '/api/comment', [
            'postId' => $postId,
            'content' => self::COMMENT_CONTENT
        ]);
        $response = $client->getResponse();
        $data = json_decode($response->getContent(), true);

        return $data;
    }

    protected static function createSavedPost(HttpKernelBrowser $client, string $postId): array
    {
        $client->request('POST', '/api/savedPost', [
            'postId' => $postId,
        ]);
        $response = $client->getResponse();
        $data = json_decode($response->getContent(), true);

        return $data;
    }
}
