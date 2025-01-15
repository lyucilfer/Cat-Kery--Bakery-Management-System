<?php

use PHPUnit\Framework\TestCase;

class ProductManagementTest extends TestCase
{
    private $baseUrl = 'http://localhost/cat-kery';

    protected function setUp(): void
    {
        $data = [
            'name' => 'admin',
            'pass' => '111'
        ];

        $options = [
            'http' => [
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data)
            ]
        ];

        $context = stream_context_create($options);
        $response = file_get_contents($this->baseUrl . 'admin/admin_login.php', false, $context);

        $this->assertStringContainsString('Welcome', $response, 'Login failed. Update credentials in the test.');
    }


    public function testListProducts()
    {
        $response = file_get_contents($this->baseUrl . 'admin/products.php');
        $this->assertStringContainsString('Product List', $response, 'Failed to load product list.');
    }

    public function testAddProduct()
    {
        $data = [
            'action' => 'add',
            'product_name' => 'Test Cake',
            'price' => 10.99,
            'quantity' => 50
        ];

        $response = $this->makePostRequest('/products.php', $data);
        $this->assertStringContainsString('Product added successfully', $response, 'Failed to add product.');
    }

    public function testUpdateProduct()
    {
        $data = [
            'product_id' => 1, // Replace with an actual product ID in your database
            'product_name' => 'Updated Cake',
            'price' => 12.99,
            'quantity' => 30
        ];

        $response = $this->makePostRequest('/update_products.php', $data);
        $this->assertStringContainsString('Product updated successfully', $response, 'Failed to update product.');
    }

    public function testDeleteProduct()
    {
        $data = [
            'action' => 'delete',
            'product_id' => 1 // Replace with an actual product ID in your database
        ];

        $response = $this->makePostRequest('/products.php', $data);
        $this->assertStringContainsString('Product deleted successfully', $response, 'Failed to delete product.');
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
