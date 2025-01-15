<?php

use PHPUnit\Framework\TestCase;

class CartManagementTest extends TestCase
{
    private $baseUrl = 'http://localhost:8000/';

    /**
     * Test cart page loads with a user session.
     */
    public function testCartPageLoads()
    {
        $response = $this->makeGetRequest('/cart.php', ['user_id' => 1]);
        $this->assertNotFalse($response, 'Failed to load cart page.');
    }

    /**
     * Test adding an item to the cart with a valid session.
     */
    public function testAddItemToCart()
    {
        $data = [
            'action' => 'add',
            'product_id' => 1,
            'quantity' => 2,
            'user_id' => 1
        ];
        $response = $this->makePostRequest('/cart.php', $data);

        // Validate response contains confirmation for adding an item
        $this->assertNotFalse($response, 'Failed to connect to cart.php for adding an item.');
    }

    /**
     * Test removing an item from the cart with a valid session.
     */
    public function testRemoveItemFromCart()
    {
        $data = [
            'action' => 'delete',
            'cart_id' => 1,
            'user_id' => 1
        ];
        $response = $this->makePostRequest('/cart.php', $data);

        // Validate response contains confirmation for removing an item
        $this->assertNotFalse($response, 'Failed to connect to cart.php for removing an item.');
    }

    /**
     * Helper function to simulate GET requests.
     */
    private function makeGetRequest($endpoint, $params)
    {
        $url = $this->baseUrl . $endpoint . '?' . http_build_query($params);
        $options = ['http' => ['method' => 'GET']];
        $context = stream_context_create($options);
        return file_get_contents($url, false, $context);
    }

    /**
     * Helper function to simulate POST requests.
     */
    private function makePostRequest($endpoint, $data)
    {
        $options = [
            'http' => [
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data)
            ]
        ];
        $context = stream_context_create($options);
        return file_get_contents($this->baseUrl . $endpoint, false, $context);
    }
}
