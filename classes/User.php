<?php
require_once __DIR__ . '/Database.php';

class User {
    private $conn;
    private $table = 'users';

    public $id;
    public $full_name;
    public $email;
    public $phone;
    public $password;
    public $role;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Register a new user
    public function register() {
        $query = "INSERT INTO " . $this->table . " 
                  (full_name, email, phone, password) 
                  VALUES (:full_name, :email, :phone, :password)";

        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->full_name = htmlspecialchars(strip_tags($this->full_name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->phone = htmlspecialchars(strip_tags($this->phone));
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);

        // Bind parameters
        $stmt->bindParam(':full_name', $this->full_name);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':phone', $this->phone);
        $stmt->bindParam(':password', $this->password);

        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        }
        return false;
    }

    // Login user
    public function login() {
    $query = "SELECT id, full_name, email, password, role 
              FROM " . $this->table . " 
              WHERE email = :email LIMIT 1";

    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':email', $this->email);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch();
        
        
        if (password_verify($this->password, $row['password'])) {
            $this->id = $row['id'];
            $this->full_name = $row['full_name'];
            $this->role = $row['role'];
            return true;
        }
    }
    return false;
}

    // Get user by ID
    // Get user by ID
    public function getById($id) {
        $query = "SELECT id, full_name, email, phone, role, created_at 
                FROM " . $this->table . " 
                WHERE id = :id LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        $result = $stmt->fetch();
        
        // If no user found, return empty array instead of false
        if (!$result) {
            return [
                'id' => '',
                'full_name' => 'Inconnu',
                'email' => '',
                'phone' => '',
                'role' => 'client',
                'created_at' => ''
            ];
        }
        
        return $result;
    }
    // Check if email exists
    public function emailExists($email) {
        $query = "SELECT id FROM " . $this->table . " WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    // Get all users (admin)
    public function getAll() {
        $query = "SELECT id, full_name, email, phone, role, created_at 
                  FROM " . $this->table . " 
                  ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
?>