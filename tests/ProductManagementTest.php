<?php

use PHPUnit\Framework\TestCase;

class ProductManagementTest extends TestCase
{
    private $baseUrl = 'http://localhost/cat-kery/admin';

    protected function setUp(): void
    {
        $this->loginAsAdmin();
        $this->addTestProduct();
    }

    private function loginAsAdmin()
    {
        $data = ['name' => 'admin', 'pass' => '111'];
        $response = $this->makePostRequest('/admin_login.php', $data);
        $this->assertStringContainsString('', $response, 'Incorrect username or password!');
    }

    private function addTestProduct()
    {
        $data = [
            'action' => 'add',
            'product_name' => 'Test Product',
            'price' => 9.99,
            'quantity' => 10
        ];
        $this->makePostRequest('/products.php', $data);
    }

    public function testListProducts()
    {
        $response = file_get_contents($this->baseUrl . '/products.php');
        $this->assertNotFalse($response, 'Failed to access the product list.');
    }

    public function testAddProduct()
    {
        $data = [
            'action' => 'add',
            'product_name' => 'New Product',
            'price' => 19.99,
            'quantity' => 5
        ];
        $response = $this->makePostRequest('/products.php', $data);
    }

    public function testUpdateProduct()
    {
        $data = [
            'product_id' => 1,
            'product_name' => 'Updated Product',
            'price' => 15.99,
            'quantity' => 20
        ];
        $response = $this->makePostRequest('/update_product.php', $data);
    }

    public function testDeleteProduct()
    {
        $data = ['action' => 'delete', 'product_id' => 1];
        $response = $this->makePostRequest('/products.php', $data);
    }

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
