class ProductRepository {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function findByName($name) {
        $stmt = $this->conn->prepare("SELECT * FROM `products` WHERE name = ?");
        $stmt->execute([$name]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data, $image) {
        $stmt = $this->conn->prepare("INSERT INTO `products`(name, category, price, image) VALUES(?,?,?,?)");
        return $stmt->execute([$data['name'], $data['category'], $data['price'], $image]);
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM `products` WHERE id = ?");
        $deleteCart = $this->conn->prepare("DELETE FROM `cart` WHERE pid = ?");
        
        $this->conn->beginTransaction();
        try {
            $stmt->execute([$id]);
            $deleteCart->execute([$id]);
            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollBack();
            throw $e;
        }
    }
}
