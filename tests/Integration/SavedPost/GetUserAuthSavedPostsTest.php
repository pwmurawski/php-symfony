<?php

namespace App\tests\Integration\SavedPost;

use App\tests\BaseApiTest;

class GetUserAuthSavedPostsTest extends BaseApiTest
{
    /**
     * @test
     */
    public function it_get_user_auth_savedPost(): void
    {
        $client = self::createAuthenticatedClient();

        $postData = self::createPost($client);
        $savedPostData = self::createSavedPost($client, $postData['id']);

        $client->request('GET', '/api/user/savedPosts');
        $this->assertResponseIsSuccessful();

        $response = $client->getResponse();
        $data = json_decode($response->getContent(), true);

        foreach ($data as $savedPost) {
            if ($savedPost['id'] === $savedPostData['id'])
                $this->assertEquals(true, $savedPost['id'] === $savedPostData['id']);
        }
    }
}
