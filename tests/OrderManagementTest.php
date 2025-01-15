<?php

use PHPUnit\Framework\TestCase;

class OrderManagementTest extends TestCase
{
    private $baseUrl = 'http://localhost:8000/';

    public function testPlaceOrder()
    {
        $data = [
            'action' => 'checkout',
            'user_id' => 1,
            'order_total' => 49.99,
            'order_items' => json_encode([
                ['product_id' => 101, 'quantity' => 2],
                ['product_id' => 102, 'quantity' => 1],
            ])
        ];

        $response = $this->makePostRequest('/checkout.php', $data);

        // Assert the HTTP response is not empty
        $this->assertNotEmpty($response, 'Response from checkout.php is empty.');
    }

    public function testViewOrders()
    {
        $response = file_get_contents($this->baseUrl . '/orders.php?user_id=1');

        // Assert the HTTP response is not empty
        $this->assertNotEmpty($response, 'Response from orders.php is empty.');
    }

    public function testAdminViewOrders()
    {
        $response = file_get_contents($this->baseUrl . '/admin/placed_orders.php');

        // Assert the HTTP response is not empty
        $this->assertNotEmpty($response, 'Response from placed_orders.php is empty.');
    }

    private function makePostRequest($endpoint, $data)
    {
        $options = [
            'http' => [
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data),
            ],
        ];
        $context  = stream_context_create($options);
        return file_get_contents($this->baseUrl . $endpoint, false, $context);
    }
}
