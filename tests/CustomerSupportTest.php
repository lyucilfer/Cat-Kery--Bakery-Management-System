<?php

use PHPUnit\Framework\TestCase;

class CustomerSupportTest extends TestCase
{
    private $baseUrl = 'http://localhost/cat-kery';

    // Test customer message submission via contact.php
    public function testSubmitCustomerMessage()
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'message' => 'I have an inquiry about the products.',
        ];

        $response = $this->makePostRequest('/contact.php', $data);

        // Assert the response is not false
        $this->assertNotFalse($response, 'Failed to submit customer message.');
    }

    // Test if admin can view customer messages via messages.php
    public function testViewCustomerMessages()
    {
        $response = file_get_contents($this->baseUrl . '/admin/messages.php');

        // Assert the response is not false
        $this->assertNotFalse($response, 'Failed to load customer messages page.');
    }

    // Utility method for sending POST requests
    private function makePostRequest($endpoint, $data)
    {
        $options = [
            'http' => [
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data),
            ],
        ];
        $context = stream_context_create($options);

        return file_get_contents($this->baseUrl . $endpoint, false, $context);
    }
}
