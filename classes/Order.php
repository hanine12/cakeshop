<?php
require_once __DIR__ . '/Database.php';

class Order {
    private $conn;
    private $table = 'orders';

    public $id;
    public $user_id;
    public $total_amount;
    public $status;
    public $delivery_address;
    public $notes;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Create order
    public function create() {
        $query = "INSERT INTO " . $this->table . "
                  (user_id, total_amount, delivery_address, notes)
                  VALUES (:user_id, :total_amount, :delivery_address, :notes)";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':user_id', $this->user_id, PDO::PARAM_INT);
        $stmt->bindParam(':total_amount', $this->total_amount);
        $stmt->bindParam(':delivery_address', $this->delivery_address);
        $stmt->bindParam(':notes', $this->notes);

        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        }
        return false;
    }

    // Add order items
    public function addOrderItem($order_id, $product_id, $quantity, $unit_price) {
        $query = "INSERT INTO order_items (order_id, product_id, quantity, unit_price)
                  VALUES (:order_id, :product_id, :quantity, :unit_price)";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
        $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
        $stmt->bindParam(':unit_price', $unit_price);

        return $stmt->execute();
    }

    // Get orders by user
    public function getByUser($user_id) {
        $query = "SELECT o.*, 
                  GROUP_CONCAT(p.name SEPARATOR ', ') as products
                  FROM " . $this->table . " o
                  LEFT JOIN order_items oi ON o.id = oi.order_id
                  LEFT JOIN products p ON oi.product_id = p.id
                  WHERE o.user_id = :user_id
                  GROUP BY o.id
                  ORDER BY o.order_date DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Get all orders (admin)
    public function getAll() {
        $query = "SELECT o.*, u.full_name, u.email,
                  GROUP_CONCAT(p.name SEPARATOR ', ') as products
                  FROM " . $this->table . " o
                  LEFT JOIN users u ON o.user_id = u.id
                  LEFT JOIN order_items oi ON o.id = oi.order_id
                  LEFT JOIN products p ON oi.product_id = p.id
                  GROUP BY o.id
                  ORDER BY o.order_date DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Update order status (admin)
    public function updateStatus() {
        $query = "UPDATE " . $this->table . "
                  SET status = :status
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':status', $this->status);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    // Get order details
    public function getDetails($order_id) {
        $query = "SELECT oi.*, p.name, p.image
                  FROM order_items oi
                  JOIN products p ON oi.product_id = p.id
                  WHERE oi.order_id = :order_id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Dashboard stats (admin)
    public function getStats() {
        $stats = [];

        // Total orders
        $query = "SELECT COUNT(*) as total_orders FROM " . $this->table;
        $stmt = $this->conn->query($query);
        $stats['total_orders'] = $stmt->fetch()['total_orders'];

        // Total revenue
        $query = "SELECT SUM(total_amount) as total_revenue FROM " . $this->table . " WHERE status != 'cancelled'";
        $stmt = $this->conn->query($query);
        $stats['total_revenue'] = $stmt->fetch()['total_revenue'] ?? 0;

        // Total clients
        $query = "SELECT COUNT(*) as total_clients FROM users WHERE role = 'client'";
        $stmt = $this->conn->query($query);
        $stats['total_clients'] = $stmt->fetch()['total_clients'];

        // Total products
        $query = "SELECT COUNT(*) as total_products FROM products WHERE is_available = 1";
        $stmt = $this->conn->query($query);
        $stats['total_products'] = $stmt->fetch()['total_products'];

        // Orders by status
        $query = "SELECT status, COUNT(*) as count FROM " . $this->table . " GROUP BY status";
        $stmt = $this->conn->query($query);
        $stats['orders_by_status'] = $stmt->fetchAll();

        return $stats;
    }
}
?>