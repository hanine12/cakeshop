<?php
require_once '../includes/header.php';
require_once '../includes/navbar.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$cart = $_SESSION['cart'] ?? [];
?>
<link rel="stylesheet" href="assets/css/style.css">
<div class="container">
    <h2 class="section-title">🛒 Votre Panier</h2>
    
    <?php if (empty($cart)): ?>
        <p style="text-align:center; padding:50px;">
            Votre panier est vide. <a href="shop.php">Continuer le shopping</a>
        </p>
    <?php else: ?>
        <table class="cart-table">
            <thead>
                <tr>
                    <th>Produit</th>
                    <th>Prix</th>
                    <th>Quantité</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $total = 0;
                foreach ($cart as $item): 
                    $subtotal = $item['price'] * $item['quantity'];
                    $total += $subtotal;
                ?>
                <tr>
                    <td><?php echo $item['name']; ?></td>
                    <td>€<?php echo number_format($item['price'], 2); ?></td>
                    <td>
                        <input type="number" value="<?php echo $item['quantity']; ?>" 
                               min="1" class="qty-update" data-id="<?php echo $item['id']; ?>"
                               style="width:60px; padding:5px;">
                    </td>
                    <td>€<?php echo number_format($subtotal, 2); ?></td>
                    <td>
                        <a href="remove-from-cart.php?id=<?php echo $item['id']; ?>" 
                           class="btn btn-danger btn-sm">Supprimer</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <p class="cart-total">Total: €<?php echo number_format($total, 2); ?></p>
        <div style="text-align:right; margin:20px 0;">
            <a href="shop.php" class="btn btn-outline" style="color:var(--primary);border-color:var(--primary);">Continuer</a>
            <a href="checkout.php" class="btn btn-primary">Commander</a>
        </div>
    <?php endif; ?>
</div>

<?php require_once '../includes/footer.php'; ?>