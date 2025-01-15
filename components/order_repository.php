class OrderRepository {
    private $conn;
    private $table = 'orders';

    public function __construct(PDO $conn) {
        $this->conn = $conn;
    }

    public function createOrder(array $orderData): int {
        try {
            $stmt = $this->conn->prepare("
                INSERT INTO {$this->table} 
                (user_id, name, number, email, method, address, total_products, total_price, payment_status) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'Pending')
            ");

            $stmt->execute([
                $orderData['user_id'],
                $orderData['name'],
                $orderData['number'],
                $orderData['email'],
                $orderData['method'],
                $orderData['address'],
                $orderData['total_products'],
                $orderData['total_price']
            ]);

            return $this->conn->lastInsertId();
        } catch (PDOException $e) {
            throw new Exception('Failed to create order: ' . $e->getMessage());
        }
    }

    public function getUserOrders(int $userId): array {
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table} WHERE user_id = ? ORDER BY placed_on DESC");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}