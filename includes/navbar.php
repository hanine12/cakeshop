<nav class="navbar">
    <div class="container">
        <a href="/cakeshop" class="logo">🍰 Cake<span>Shop</span></a>
        <ul class="nav-links">
            <li><a href="/cakeshop">Accueil</a></li>
            <li><a href="/cakeshop/pages/shop.php">Boutique</a></li>
            <?php if (isset($_SESSION['user_id'])): ?>
                <li><a href="/cakeshop/pages/cart.php">
                    <i class="fas fa-shopping-cart"></i> Panier
                    <?php 
                    $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
                    $count = array_sum(array_column($cart, 'quantity'));
                    if ($count > 0): ?>
                        <span class="cart-count"><?php echo $count; ?></span>
                    <?php endif; ?>
                </a></li>
                <li><a href="/cakeshop/pages/profile.php">
                    <i class="fas fa-user"></i> <?php echo $_SESSION['user_name']; ?>
                </a></li>
                <li><a href="/cakeshop/pages/logout.php">Déconnexion</a></li>
            <?php else: ?>
                <li><a href="/cakeshop/pages/login.php">Connexion</a></li>
                <li><a href="/cakeshop/pages/register.php" class="btn btn-primary" style="padding: 10px 25px !important;">Inscription</a></li>
            <?php endif; ?>
        </ul>
    </div>
</nav>