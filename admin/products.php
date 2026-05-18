<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: /cakeshop/pages/login.php');
    exit;
}

require_once '../classes/Product.php';
require_once '../classes/Category.php';

$productObj = new Product();
$categoryObj = new Category();
$categories = $categoryObj->getAll();

$message = '';
$action = $_GET['action'] ?? 'list';
$editId = $_GET['id'] ?? 0;

// DELETE
if ($action === 'delete' && $editId) {
    $productObj->id = $editId;
    if ($productObj->delete()) {
        $message = '<div class="alert alert-success">Produit supprimé !</div>';
    }
    $action = 'list';
}

// CREATE
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create'])) {
    $productObj->name = $_POST['name'];
    $productObj->description = $_POST['description'];
    $productObj->price = $_POST['price'];
    $productObj->category_id = $_POST['category_id'];
    $productObj->stock = $_POST['stock'];

    // Image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $uploadDir = '../assets/images/uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $imageName = time() . '_' . basename($_FILES['image']['name']);
        $targetPath = $uploadDir . $imageName;
        
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
            $productObj->image = $imageName;
        }
    }

    if ($productObj->create()) {
        $message = '<div class="alert alert-success">Produit ajouté avec succès !</div>';
    } else {
        $message = '<div class="alert alert-danger">Erreur lors de l\'ajout.</div>';
    }
}

// UPDATE
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $productObj->id = $_POST['id'];
    $productObj->name = $_POST['name'];
    $productObj->description = $_POST['description'];
    $productObj->price = $_POST['price'];
    $productObj->category_id = $_POST['category_id'];
    $productObj->stock = $_POST['stock'];
    $productObj->is_available = isset($_POST['is_available']) ? 1 : 0;
    $productObj->image = '';

    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $uploadDir = '../assets/images/uploads/';
        $imageName = time() . '_' . basename($_FILES['image']['name']);
        $targetPath = $uploadDir . $imageName;
        
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
            $productObj->image = $imageName;
        }
    }

    if ($productObj->update()) {
        $message = '<div class="alert alert-success">Produit mis à jour !</div>';
        $action = 'list';
    } else {
        $message = '<div class="alert alert-danger">Erreur lors de la mise à jour.</div>';
    }
}

$products = $productObj->getAll();
$editProduct = ($action === 'edit' && $editId) ? $productObj->getById($editId) : null;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gérer les Produits - Admin</title>
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
        .form-card { background: white; padding: 30px; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); max-width: 600px; }
        .product-thumb { width: 60px; height: 60px; object-fit: cover; border-radius: 8px; }
    </style>
</head>
<body>
<div class="admin-layout">
    <aside class="sidebar-admin">
        <h2>🍰 CakeShop Admin</h2>
        <a href="index.php"><i class="fas fa-tachometer-alt"></i> Tableau de bord</a>
        <a href="products.php" class="active"><i class="fas fa-birthday-cake"></i> Produits</a>
        <a href="categories.php"><i class="fas fa-list"></i> Catégories</a>
        <a href="orders.php"><i class="fas fa-shopping-cart"></i> Commandes</a>
        <a href="users.php"><i class="fas fa-users"></i> Clients</a>
        <hr style="border-color:#34495e; margin:20px 0;">
        <a href="/cakeshop/"><i class="fas fa-store"></i> Voir le site</a>
        <a href="/cakeshop/pages/logout.php"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
    </aside>

    <main class="main-admin">
        <?php echo $message; ?>

        <?php if ($action === 'add' || $action === 'edit'): ?>
            <h2><?php echo $action === 'add' ? '➕ Ajouter un produit' : '✏️ Modifier le produit'; ?></h2>
            <div class="form-card" style="margin-top:20px;">
                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="<?php echo $action === 'add' ? 'create' : 'update'; ?>" value="1">
                    <?php if ($editProduct): ?>
                        <input type="hidden" name="id" value="<?php echo $editProduct['id']; ?>">
                    <?php endif; ?>

                    <div class="form-group">
                        <label>Nom du produit</label>
                        <input type="text" name="name" value="<?php echo $editProduct['name'] ?? ''; ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" rows="4" required><?php echo $editProduct['description'] ?? ''; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label>Prix (€)</label>
                        <input type="number" name="price" step="0.01" value="<?php echo $editProduct['price'] ?? ''; ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Catégorie</label>
                        <select name="category_id" required>
                            <option value="">— Choisir —</option>
                            <?php foreach ($categories as $cat): ?>
                            <option value="<?php echo $cat['id']; ?>" 
                                <?php echo (isset($editProduct) && $editProduct['category_id'] == $cat['id']) ? 'selected' : ''; ?>>
                                <?php echo $cat['name']; ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Stock</label>
                        <input type="number" name="stock" value="<?php echo $editProduct['stock'] ?? 0; ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Image</label>
                        <?php if ($editProduct && $editProduct['image']): ?>
                            <p>Image actuelle : <?php echo $editProduct['image']; ?></p>
                            <img src="/cakeshop/assets/images/uploads/<?php echo $editProduct['image']; ?>" 
                                 style="width:100px; border-radius:8px; margin-bottom:10px;">
                        <?php endif; ?>
                        <input type="file" name="image" accept="image/*" <?php echo $action === 'add' ? 'required' : ''; ?>>
                    </div>
                    <?php if ($editProduct): ?>
                    <div class="form-group">
                        <label>
                            <input type="checkbox" name="is_available" <?php echo $editProduct['is_available'] ? 'checked' : ''; ?>>
                            Disponible
                        </label>
                    </div>
                    <?php endif; ?>
                    <button type="submit" class="btn btn-primary">
                        <?php echo $action === 'add' ? 'Ajouter' : 'Mettre à jour'; ?>
                    </button>
                    <a href="products.php" class="btn btn-outline" style="color:var(--primary);border-color:var(--primary);margin-left:10px;">Annuler</a>
                </form>
            </div>
        <?php else: ?>
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
                <h2>🎂 Gérer les Produits</h2>
                <a href="products.php?action=add" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Ajouter un produit
                </a>
            </div>

            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Prix</th>
                        <th>Stock</th>
                        <th>Dispo</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $p): ?>
                    <tr>
                        <td>
                            <img src="/cakeshop/assets/images/uploads/<?php echo $p['image'] ?: 'placeholder.jpg'; ?>" 
                                 class="product-thumb" onerror="this.src='/cakeshop/assets/images/placeholder.jpg'">
                        </td>
                        <td>#<?php echo $p['id']; ?></td>
                        <td><?php echo $p['name']; ?></td>
                        <td>€<?php echo number_format($p['price'], 2); ?></td>
                        <td><?php echo $p['stock']; ?></td>
                        <td><?php echo $p['is_available'] ? '✅' : '❌'; ?></td>
                        <td>
                            <a href="products.php?action=edit&id=<?php echo $p['id']; ?>" 
                               class="btn btn-primary btn-sm">✏️</a>
                            <a href="products.php?action=delete&id=<?php echo $p['id']; ?>" 
                               class="btn btn-danger btn-sm" 
                               onclick="return confirm('Supprimer ce produit ?')">🗑️</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </main>
</div>
</body>
</html>