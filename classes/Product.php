<?php
require_once __DIR__ . '/Database.php';

class Product {
    private $conn;
    private $table = 'products';

    public $id;
    public $name;
    public $description;
    public $price;
    public $image;
    public $category_id;
    public $stock;
    public $is_available;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Get all products with category name
    public function getAll() {
        $query = "SELECT p.*, c.name as category_name 
                  FROM " . $this->table . " p
                  LEFT JOIN categories c ON p.category_id = c.id
                  WHERE p.is_available = 1
                  ORDER BY p.created_at DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Get products by category
    public function getByCategory($category_id) {
        $query = "SELECT p.*, c.name as category_name 
                  FROM " . $this->table . " p
                  LEFT JOIN categories c ON p.category_id = c.id
                  WHERE p.category_id = :category_id AND p.is_available = 1
                  ORDER BY p.created_at DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Get single product
    public function getById($id) {
        $query = "SELECT p.*, c.name as category_name 
                  FROM " . $this->table . " p
                  LEFT JOIN categories c ON p.category_id = c.id
                  WHERE p.id = :id LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    // Add product (admin)
    public function create() {
        $query = "INSERT INTO " . $this->table . "
                  (name, description, price, image, category_id, stock)
                  VALUES (:name, :description, :price, :image, :category_id, :stock)";

        $stmt = $this->conn->prepare($query);

        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->description = htmlspecialchars(strip_tags($this->description));

        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':image', $this->image);
        $stmt->bindParam(':category_id', $this->category_id, PDO::PARAM_INT);
        $stmt->bindParam(':stock', $this->stock, PDO::PARAM_INT);

        return $stmt->execute();
    }

    // Update product (admin)
    public function update() {
        $query = "UPDATE " . $this->table . "
                  SET name = :name, description = :description, price = :price,
                      category_id = :category_id, stock = :stock,
                      is_available = :is_available";

        if ($this->image) {
            $query .= ", image = :image";
        }

        $query .= " WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->description = htmlspecialchars(strip_tags($this->description));

        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':category_id', $this->category_id, PDO::PARAM_INT);
        $stmt->bindParam(':stock', $this->stock, PDO::PARAM_INT);
        $stmt->bindParam(':is_available', $this->is_available, PDO::PARAM_INT);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);

        if ($this->image) {
            $stmt->bindParam(':image', $this->image);
        }

        return $stmt->execute();
    }

    // Delete product (admin)
    public function delete() {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Search products
    public function search($keyword) {
        $query = "SELECT p.*, c.name as category_name 
                  FROM " . $this->table . " p
                  LEFT JOIN categories c ON p.category_id = c.id
                  WHERE p.name LIKE :keyword AND p.is_available = 1
                  ORDER BY p.created_at DESC";

        $keyword = "%{$keyword}%";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':keyword', $keyword);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
?>