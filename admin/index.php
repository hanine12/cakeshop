<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: /cakeshop/pages/login.php');
    exit;
}

require_once '../classes/Order.php';
require_once '../classes/User.php';

$orderObj = new Order();
$stats = $orderObj->getStats();
$userObj = new User();
$users = $userObj->getAll();
$recentUsers = array_slice($users, 0, 5);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - CakeShop</title>
    <link rel="stylesheet" href="/cakeshop/assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .admin-layout {
            display: flex;
            min-height: 100vh;
        }
        .sidebar-admin {
            width: 260px;
            background: #2c3e50;
            color: white;
            padding: 20px;
        }
        .sidebar-admin h2 {
            color: var(--primary);
            margin-bottom: 30px;
            font-size: 24px;
        }
        .sidebar-admin a {
            color: #bdc3c7;
            display: block;
            padding: 12px 15px;
            margin-bottom: 5px;
            border-radius: 8px;
            transition: 0.3s;
        }
        .sidebar-admin a:hover,
        .sidebar-admin a.active {
            background: var(--primary);
            color: white;
        }
        .sidebar-admin i {
            margin-right: 10px;
            width: 20px;
        }
        .main-admin {
            flex: 1;
            background: #f5f6fa;
            padding: 30px;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            text-align: center;
        }
        .stat-card i {
            font-size: 40px;
            color: var(--primary);
            margin-bottom: 10px;
        }
        .stat-card .number {
            font-size: 32px;
            font-weight: bold;
            color: var(--dark);
        }
        .stat-card .label {
            color: #888;
            margin-top: 5px;
        }
        .admin-table {
            width: 100%;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .admin-table th {
            background: var(--primary);
            color: white;
            padding: 15px;
            text-align: left;
        }
        .admin-table td {
            padding: 12px 15px;
            border-bottom: 1px solid #eee;
        }
        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        .top-bar h1 {
            font-size: 28px;
        }
    </style>
</head>
<body>
<div class="admin-layout">
    <!-- Sidebar -->
    <aside class="sidebar-admin">
        <h2>🍰 CakeShop Admin</h2>
        <a href="index.php" class="active">
            <i class="fas fa-tachometer-alt"></i> Tableau de bord
        </a>
        <a href="products.php">
            <i class="fas fa-birthday-cake"></i> Produits
        </a>
        <a href="categories.php">
            <i class="fas fa-list"></i> Catégories
        </a>
        <a href="orders.php">
            <i class="fas fa-shopping-cart"></i> Commandes
        </a>
        <a href="users.php">
            <i class="fas fa-users"></i> Clients
        </a>
        <hr style="border-color:#34495e; margin:20px 0;">
        <a href="/cakeshop/">
            <i class="fas fa-store"></i> Voir le site
        </a>
        <a href="/cakeshop/pages/logout.php">
            <i class="fas fa-sign-out-alt"></i> Déconnexion
        </a>
    </aside>

    <!-- Main Content -->
    <main class="main-admin">
        <div class="top-bar">
            <h1>Tableau de bord</h1>
            <span>Bienvenue, <?php echo $_SESSION['user_name']; ?></span>
        </div>

        <!-- Stats Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <i class="fas fa-shopping-bag"></i>
                <div class="number"><?php echo $stats['total_orders']; ?></div>
                <div class="label">Commandes totales</div>
            </div>
            <div class="stat-card">
                <i class="fas fa-euro-sign"></i>
                <div class="number">€<?php echo number_format($stats['total_revenue'], 2); ?></div>
                <div class="label">Revenus</div>
            </div>
            <div class="stat-card">
                <i class="fas fa-users"></i>
                <div class="number"><?php echo $stats['total_clients']; ?></div>
                <div class="label">Clients</div>
            </div>
            <div class="stat-card">
                <i class="fas fa-birthday-cake"></i>
                <div class="number"><?php echo $stats['total_products']; ?></div>
                <div class="label">Produits actifs</div>
            </div>
        </div>

        <!-- Recent Users -->
        <h2 style="margin-bottom:20px;">👥 Nouveaux clients</h2>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Téléphone</th>
                    <th>Date d'inscription</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($recentUsers as $u): ?>
                <tr>
                    <td>#<?php echo $u['id']; ?></td>
                    <td><?php echo $u['full_name']; ?></td>
                    <td><?php echo $u['email']; ?></td>
                    <td><?php echo $u['phone'] ?: '—'; ?></td>
                    <td><?php echo date('d/m/Y', strtotime($u['created_at'])); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>
</div>
</body>
</html>