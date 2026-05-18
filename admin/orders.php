<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: /cakeshop/pages/login.php');
    exit;
}

require_once '../classes/Order.php';

$orderObj = new Order();
$message = '';

// UPDATE STATUS
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $orderObj->id = $_POST['order_id'];
    $orderObj->status = $_POST['status'];
    if ($orderObj->updateStatus()) {
        $message = '<div class="alert alert-success">Statut mis à jour !</div>';
    }
}

$orders = $orderObj->getAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gérer les Commandes - Admin</title>
    <link rel="stylesheet" href="/cakeshop/assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .admin-layout { display: flex; min-height: 100vh; }
        .sidebar-admin { width: 260px; background: #2c3e50; color: white; padding: 20px; }
        .sidebar-admin h2 { color: #e91e63; margin-bottom: 30px; font-size: 24px; }
        .sidebar-admin a { color: #bdc3c7; display: block; padding: 12px 15px; margin-bottom: 5px; border-radius: 8px; transition: 0.3s; text-decoration: none; }
        .sidebar-admin a:hover, .sidebar-admin a.active { background: #e91e63; color: white; }
        .sidebar-admin i { margin-right: 10px; width: 20px; }
        .main-admin { flex: 1; background: #f5f6fa; padding: 30px; }
        .admin-table { width: 100%; background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        .admin-table th { background: #e91e63; color: white; padding: 15px; text-align: left; }
        .admin-table td { padding: 12px 15px; border-bottom: 1px solid #eee; }
        .status-badge { padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; }
        .status-pending { background: #fff3cd; color: #856404; }
        .status-confirmed { background: #cce5ff; color: #004085; }
        .status-preparing { background: #fff3cd; color: #856404; }
        .status-delivered { background: #d4edda; color: #155724; }
        .status-cancelled { background: #f8d7da; color: #721c24; }
    </style>
</head>
<body>
<div class="admin-layout">
    <aside class="sidebar-admin">
        <h2>🍰 CakeShop Admin</h2>
        <a href="index.php"><i class="fas fa-tachometer-alt"></i> Tableau de bord</a>
        <a href="products.php"><i class="fas fa-birthday-cake"></i> Produits</a>
        <a href="categories.php"><i class="fas fa-list"></i> Catégories</a>
        <a href="orders.php" class="active"><i class="fas fa-shopping-cart"></i> Commandes</a>
        <a href="users.php"><i class="fas fa-users"></i> Clients</a>
        <hr style="border-color:#34495e; margin:20px 0;">
        <a href="/cakeshop/"><i class="fas fa-store"></i> Voir le site</a>
        <a href="/cakeshop/pages/logout.php"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
    </aside>

    <main class="main-admin">
        <?php echo $message; ?>
        <h2>🛒 Gérer les Commandes</h2>

        <table class="admin-table" style="margin-top:20px;">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Client</th>
                    <th>Produits</th>
                    <th>Total</th>
                    <th>Date</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                <tr>
                    <td>#<?php echo $order['id']; ?></td>
                    <td><?php echo $order['full_name']; ?><br><small><?php echo $order['email']; ?></small></td>
                    <td><?php echo $order['products']; ?></td>
                    <td>€<?php echo number_format($order['total_amount'], 2); ?></td>
                    <td><?php echo date('d/m/Y H:i', strtotime($order['order_date'])); ?></td>
                    <td>
                        <form method="POST" style="display:flex; gap:5px;">
                            <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                            <select name="status" class="status-badge status-<?php echo $order['status']; ?>">
                                <option value="pending" <?php echo $order['status'] === 'pending' ? 'selected' : ''; ?>>En attente</option>
                                <option value="confirmed" <?php echo $order['status'] === 'confirmed' ? 'selected' : ''; ?>>Confirmée</option>
                                <option value="preparing" <?php echo $order['status'] === 'preparing' ? 'selected' : ''; ?>>En préparation</option>
                                <option value="delivered" <?php echo $order['status'] === 'delivered' ? 'selected' : ''; ?>>Livrée</option>
                                <option value="cancelled" <?php echo $order['status'] === 'cancelled' ? 'selected' : ''; ?>>Annulée</option>
                            </select>
                            <button type="submit" name="update_status" class="btn btn-primary btn-sm">✓</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>
</div>
</body>
</html>