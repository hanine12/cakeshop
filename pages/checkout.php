<?php
require_once '../classes/Order.php';
require_once '../includes/header.php';
require_once '../includes/navbar.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$cart = $_SESSION['cart'] ?? [];
if (empty($cart)) {
    header('Location: cart.php');
    exit;
}

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $total = 0;
    foreach ($cart as $item) {
        $total += $item['price'] * $item['quantity'];
    }

    $order = new Order();
    $order->user_id = $_SESSION['user_id'];
    $order->total_amount = $total;
    $order->delivery_address = $_POST['address'];
    $order->notes = $_POST['notes'] ?? '';

    $orderId = $order->create();

    if ($orderId) {
        foreach ($cart as $item) {
            $order->addOrderItem($orderId, $item['id'], $item['quantity'], $item['price']);
        }
        $_SESSION['cart'] = [];
        $success = "Commande #{$orderId} confirmée ! Merci pour votre achat. 🎉";
    } else {
        $error = 'Erreur lors de la commande. Veuillez réessayer.';
    }
}

// Calculate total
$total = 0;
foreach ($cart as $item) {
    $total += $item['price'] * $item['quantity'];
}
?>

<div class="container" style="max-width:700px;">
    <h2 class="section-title">💳 Finaliser la commande</h2>

    <?php if ($success): ?>
        <div class="alert alert-success" style="text-align:center; font-size:18px; padding:30px;">
            <?php echo $success; ?>
            <br><br>
            <a href="/cakeshop/" class="btn btn-primary">Retour à l'accueil</a>
            <a href="profile.php" class="btn btn-outline" style="color:var(--primary);border-color:var(--primary);">Voir mes commandes</a>
        </div>
    <?php else: ?>
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <!-- Order Summary -->
        <div style="background:white; padding:25px; border-radius:10px; margin-bottom:20px;">
            <h3>Résumé de la commande</h3>
            <?php foreach ($cart as $item): ?>
            <div style="display:flex; justify-content:space-between; padding:10px 0; border-bottom:1px solid var(--border);">
                <span><?php echo $item['name']; ?> x<?php echo $item['quantity']; ?></span>
                <span>€<?php echo number_format($item['price'] * $item['quantity'], 2); ?></span>
            </div>
            <?php endforeach; ?>
            <div style="display:flex; justify-content:space-between; padding:15px 0; font-size:20px; font-weight:bold;">
                <span>Total</span>
                <span style="color:var(--primary);">€<?php echo number_format($total, 2); ?></span>
            </div>
        </div>

        <!-- Delivery Form -->
        <form method="POST" style="background:white; padding:25px; border-radius:10px;">
            <h3 style="margin-bottom:20px;">Adresse de livraison</h3>
            <div class="form-group">
                <label>Adresse complète *</label>
                <textarea name="address" rows="3" required 
                          placeholder="123 rue Example, Ville, Code postal"></textarea>
            </div>
            <div class="form-group">
                <label>Notes (optionnel)</label>
                <textarea name="notes" rows="2" 
                          placeholder="Instructions spéciales..."></textarea>
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%; font-size:18px; padding:15px;">
                Confirmer la commande — €<?php echo number_format($total, 2); ?>
            </button>
        </form>
    <?php endif; ?>
</div>

<?php require_once '../includes/footer.php'; ?>