<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: /cakeshop/pages/login.php');
    exit;
}

require_once '../classes/Category.php';

$categoryObj = new Category();
$message = '';

// CREATE
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create'])) {
    $categoryObj->name = $_POST['name'];
    $categoryObj->description = $_POST['description'];
    if ($categoryObj->create()) {
        $message = '<div class="alert alert-success">Catégorie ajoutée !</div>';
    }
}

// DELETE
if (isset($_GET['delete'])) {
    $categoryObj->id = $_GET['delete'];
    $categoryObj->delete();
    $message = '<div class="alert alert-success">Catégorie supprimée !</div>';
}

$categories = $categoryObj->getAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gérer les Catégories - Admin</title>
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
    </style>
</head>
<body>
<div class="admin-layout">
    <aside class="sidebar-admin">
        <h2>🍰 CakeShop Admin</h2>
        <a href="index.php"><i class="fas fa-tachometer-alt"></i> Tableau de bord</a>
        <a href="products.php"><i class="fas fa-birthday-cake"></i> Produits</a>
        <a href="categories.php" class="active"><i class="fas fa-list"></i> Catégories</a>
        <a href="orders.php"><i class="fas fa-shopping-cart"></i> Commandes</a>
        <a href="users.php"><i class="fas fa-users"></i> Clients</a>
        <hr style="border-color:#34495e; margin:20px 0;">
        <a href="/cakeshop/"><i class="fas fa-store"></i> Voir le site</a>
        <a href="/cakeshop/pages/logout.php"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
    </aside>

    <main class="main-admin">
        <?php echo $message; ?>
        <h2>📂 Gérer les Catégories</h2>

        <div class="form-card" style="background:white; padding:25px; border-radius:12px; margin-bottom:30px;">
            <h3>Ajouter une catégorie</h3>
            <form method="POST" style="display:flex; gap:15px; align-items:flex-end;">
                <div class="form-group" style="flex:1; margin:0;">
                    <label>Nom</label>
                    <input type="text" name="name" required>
                </div>
                <div class="form-group" style="flex:2; margin:0;">
                    <label>Description</label>
                    <input type="text" name="description">
                </div>
                <button type="submit" name="create" class="btn btn-primary">Ajouter</button>
            </form>
        </div>

        <table class="admin-table">
            <thead>
                <tr><th>ID</th><th>Nom</th><th>Description</th><th>Action</th></tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $cat): ?>
                <tr>
                    <td>#<?php echo $cat['id']; ?></td>
                    <td><?php echo $cat['name']; ?></td>
                    <td><?php echo $cat['description']; ?></td>
                    <td>
                        <a href="categories.php?delete=<?php echo $cat['id']; ?>" 
                           class="btn btn-danger btn-sm" 
                           onclick="return confirm('Supprimer ?')">🗑️</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>
</div>
</body>
</html>