<?php

use PHPUnit\Framework\TestCase;

class UserManagementTest extends TestCase
{
    private $baseUrl = 'http://localhost:8000/';

    public function testUserLogin()
    {
        $data = [
            'username' => 'testuser',
            'password' => 'testpassword'
        ];
        $response = $this->makePostRequest('/login.php', $data);

        $this->assertNotEmpty($response, 'Login response is empty.');
    }

    public function testAdminLogin()
    {
        $data = [
            'username' => 'admin',
            'password' => '111'
        ];
        $response = $this->makePostRequest('/admin/admin_login.php', $data);

        $this->assertNotEmpty($response, 'Admin login response is empty.');
    }

    public function testUserRegistration()
    {
        $data = [
            'username' => 'newuser',
            'email' => 'newuser@example.com',
            'password' => 'password123',
            'confirm_password' => 'password123'
        ];
        $response = $this->makePostRequest('/register.php', $data);

        $this->assertNotEmpty($response, 'Registration response is empty.');
    }

    public function testProfileUpdate()
    {
        $data = [
            'user_id' => 1,
            'email' => 'updateduser@example.com',
            'password' => 'newpassword123'
        ];
        $response = $this->makePostRequest('/update_profile.php', $data);

        $this->assertNotEmpty($response, 'Profile update response is empty.');
    }

    public function testAddressUpdate()
    {
        $data = [
            'user_id' => 1,
            'address' => '123 New Address, City, Country'
        ];
        $response = $this->makePostRequest('/update_address.php', $data);

        $this->assertNotEmpty($response, 'Address update response is empty.');
    }

    private function makePostRequest($endpoint, $data)
    {
        $options = [
            'http' => [
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data)
            ]
        ];
        $context  = stream_context_create($options);
        return file_get_contents($this->baseUrl . $endpoint, false, $context);
    }
}
