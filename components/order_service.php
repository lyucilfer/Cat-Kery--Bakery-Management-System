class OrderService {
    private $orderRepo;
    private $cartRepo;

    public function __construct(OrderRepository $orderRepo, CartRepository $cartRepo) {
        $this->orderRepo = $orderRepo;
        $this->cartRepo = $cartRepo;
    }

    public function createOrder(array $userData, array $cartItems): array {
        try {
            $this->validateOrderData($userData);
            
            $orderSummary = $this->calculateOrderSummary($cartItems);
            $orderData = array_merge($userData, $orderSummary);
            
            $orderId = $this->orderRepo->createOrder($orderData);
            $this->cartRepo->clearCart($userData['user_id']);
            
            return [
                'success' => true,
                'message' => 'Order placed successfully!'
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    private function calculateOrderSummary(array $cartItems): array {
        $total = 0;
        $products = [];
        
        foreach ($cartItems as $item) {
            $total += $item['price'] * $item['quantity'];
            $products[] = "{$item['name']} ({$item['quantity']})";
        }
        
        return [
            'total_price' => $total,
            'total_products' => implode(', ', $products)
        ];
    }
}

