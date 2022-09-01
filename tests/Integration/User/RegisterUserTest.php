<?php

namespace App\tests\Integration\User;

use App\tests\BaseApiTest;

class RegisterUserTest extends BaseApiTest
{
    /**
     * @test
     */
    public function it_test_user_register(): void
    {
        $email = 'qwerty6@qwerty.com';
        $password  = 'qwerty123';

        $client = self::createAuthenticatedClient();
        $client->request('POST', '/api/register', ['email' => $email, 'password' => $password]);
        $this->assertResponseIsSuccessful();

        $response = $client->getResponse();
        $data = json_decode($response->getContent(), true);

        $client->request('GET', "/api/user/{$data['id']}");
        $this->assertResponseIsSuccessful();

        $response = $client->getResponse();
        $data = json_decode($response->getContent(), true);

        $this->assertEquals($email, $data['email']);
        $this->assertArrayNotHasKey('password', $data);
    }

    /**
     * @test
     */
    public function it_not_register_user_when_email_already_exist(): void
    {
        $email = 'qwerty6@qwerty.com';
        $password  = 'qwerty123';

        $client = self::createAuthenticatedClient();
        $client->request('POST', '/api/register', ['email' => $email, 'password' => $password]);

        $response = $client->getResponse();
        $this->assertEquals(400, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function it_not_email_type(): void
    {
        $email = 'qwerty6qwertycom';
        $password  = 'qwerty123';

        $client = self::createAuthenticatedClient();
        $client->request('POST', '/api/register', ['email' => $email, 'password' => $password]);

        $response = $client->getResponse();
        $this->assertEquals(400, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function it_not_blank_email(): void
    {
        $email = '';
        $password  = 'qwerty123';

        $client = self::createAuthenticatedClient();
        $client->request('POST', '/api/register', ['email' => $email, 'password' => $password]);

        $response = $client->getResponse();
        $this->assertEquals(400, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function it_not_blank_password(): void
    {
        $email = 'qwerty6@qwerty.com';
        $password  = '';

        $client = self::createAuthenticatedClient();
        $client->request('POST', '/api/register', ['email' => $email, 'password' => $password]);

        $response = $client->getResponse();
        $this->assertEquals(400, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function it_password_short_lenght(): void
    {
        $email = 'qwerty6@qwerty.com';
        $password  = '1234';

        $client = self::createAuthenticatedClient();
        $client->request('POST', '/api/register', ['email' => $email, 'password' => $password]);

        $response = $client->getResponse();
        $this->assertEquals(400, $response->getStatusCode());
    }
}
