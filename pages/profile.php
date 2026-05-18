<?php
require_once '../classes/User.php';
require_once '../classes/Order.php';
require_once '../includes/header.php';
require_once '../includes/navbar.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$userObj = new User();
$user = $userObj->getById($_SESSION['user_id']);

$orderObj = new Order();
$orders = $orderObj->getByUser($_SESSION['user_id']);
?>

<div class="container">
    <h2 class="section-title">👤 Mon Compte</h2>

    <!-- User Info -->
    <div style="background:white; padding:25px; border-radius:10px; margin-bottom:30px;">
        <h3>Informations personnelles</h3>
        <p><strong>Nom :</strong> <?php echo htmlspecialchars($user['full_name'] ?? 'Inconnu'); ?></p>
        <p><strong>Email :</strong> <?php echo htmlspecialchars($user['email'] ?? ''); ?></p>
        <p><strong>Téléphone :</strong> <?php echo htmlspecialchars($user['phone'] ?? 'Non renseigné'); ?></p>
        <p><strong>Membre depuis :</strong> <?php echo !empty($user['created_at']) ? date('d/m/Y', strtotime($user['created_at'])) : 'N/A'; ?></p>
    </div>

    <!-- Orders History -->
    <div style="background:white; padding:25px; border-radius:10px;">
        <h3>📦 Mes Commandes</h3>
        <?php if (count($orders) > 0): ?>
        <table class="cart-table">
            <thead>
                <tr>
                    <th>N° Commande</th>
                    <th>Date</th>
                    <th>Produits</th>
                    <th>Total</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                <tr>
                    <td>#<?php echo $order['id']; ?></td>
                    <td><?php echo date('d/m/Y', strtotime($order['order_date'])); ?></td>
                    <td><?php echo $order['products'] ?? '—'; ?></td>
                    <td>€<?php echo number_format($order['total_amount'], 2); ?></td>
                    <td>
                        <span style="padding:5px 12px; border-radius:20px; font-size:12px;
                            <?php
                            $statusColors = [
                                'pending' => 'background:#fff3cd; color:#856404;',
                                'confirmed' => 'background:#cce5ff; color:#004085;',
                                'preparing' => 'background:#fff3cd; color:#856404;',
                                'delivered' => 'background:#d4edda; color:#155724;',
                                'cancelled' => 'background:#f8d7da; color:#721c24;'
                            ];
                            echo $statusColors[$order['status']] ?? '';
                            ?>">
                            <?php 
                            $statuses = [
                                'pending' => 'En attente',
                                'confirmed' => 'Confirmée',
                                'preparing' => 'En préparation',
                                'delivered' => 'Livrée',
                                'cancelled' => 'Annulée'
                            ];
                            echo $statuses[$order['status']] ?? $order['status']; 
                            ?>
                        </span>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php else: ?>
            <p style="text-align:center; padding:30px; color:#888;">
                Aucune commande pour le moment. <a href="shop.php">Commander maintenant</a>
            </p>
        <?php endif; ?>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>