<?php
require_once 'classes/Product.php';
require_once 'includes/header.php';
require_once 'includes/navbar.php';

$product = new Product();
$products = $product->getAll();
$latestProducts = array_slice($products, 0, 6);
?>

<!-- Hero Section - Full width -->
<section style="background: url('/cakeshop/assets/images/uploads/wedding_cake_hero.jpg'); background-size: cover; background-position: center; height: 80vh; display: flex; align-items: center; justify-content: center; position: relative;">
    <div style="background: rgba(0,0,0,0.4); position: absolute; top:0; left:0; right:0; bottom:0;"></div>
    <div style="position: relative; z-index: 1; text-align: center; color: white; padding: 40px;">
        <h1 style="font-size: 4rem; font-weight: 300; letter-spacing: 3px; margin-bottom: 15px;color: #fdf5ef !important;">The Cake Shop</h1>
        <p style="font-size: 1.3rem; font-weight: 300; margin-bottom: 30px; color: #fdf5ef !important;">Artisan cakes made with love since 1990</p>
        <a href="/cakeshop/pages/shop.php" class="btn btn-outline white" style="font-size: 18px; padding: 15px 40px;">Shop Now</a>
    </div>
</section>

<!-- Our Service Section -->
<div class="container" style="padding: 80px 0;">
    <h2 style="text-align:center; font-size:2.5rem; font-weight:300; margin-bottom:60px; letter-spacing:2px;">Our Service</h2>
    
    <!-- Cake -->
    <div style="display:flex; gap:60px; align-items:center; margin-bottom:80px; flex-wrap:wrap;">
        <div style="flex:1; min-width:300px;">
            <h3 style="font-size:2rem; font-weight:300; margin-bottom:20px;">Cake</h3>
            <p style="color:#666; line-height:1.8; margin-bottom:20px;">
                Discover the art of cake-making with our stunning and delicious creations, crafted to perfection for any occasion. From birthdays to weddings, our cakes are masterpieces of flavor and design.
            </p>
            <a href="/cakeshop/pages/shop.php?category=1" class="btn btn-outline" style="color:var(--primary); border-color:var(--primary);">Shop Now</a>
        </div>
        <div style="flex:1; min-width:300px;">
            <img src="/cakeshop/assets/images/uploads/chocolate_delight.jpg" style="width:100%; border-radius:15px; height:350px; object-fit:cover;">
        </div>
    </div>
    
    <!-- Pastries -->
    <div style="display:flex; gap:60px; align-items:center; margin-bottom:80px; flex-wrap:wrap; flex-direction:row-reverse;">
        <div style="flex:1; min-width:300px;">
            <h3 style="font-size:2rem; font-weight:300; margin-bottom:20px;">Pastries</h3>
            <p style="color:#666; line-height:1.8; margin-bottom:20px;">
                Experience the irresistible charm of our freshly baked pastries, crafted with love and the finest ingredients. Perfect for any time of day.
            </p>
            <a href="/cakeshop/pages/shop.php?category=4" class="btn btn-outline" style="color:var(--primary); border-color:var(--primary);">Shop Now</a>
        </div>
        <div style="flex:1; min-width:300px;">
            <img src="/cakeshop/assets/images/uploads/al

mond_croissant.jpg" style="width:100%; border-radius:15px; height:350px; object-fit:cover;">
        </div>
    </div>
    
    <!-- Cupcakes -->
    <div style="display:flex; gap:60px; align-items:center; flex-wrap:wrap;">
        <div style="flex:1; min-width:300px;">
            <h3 style="font-size:2rem; font-weight:300; margin-bottom:20px;">Cupcakes</h3>
            <p style="color:#666; line-height:1.8; margin-bottom:20px;">
                Indulge in our delightful cupcakes, each one a perfect balance of flavor and beauty. Ideal for gifting, parties, or treating yourself.
            </p>
            <a href="/cakeshop/pages/shop.php?category=3" class="btn btn-outline" style="color:var(--primary); border-color:var(--primary);">Shop Now</a>
        </div>
        <div style="flex:1; min-width:300px;">
            <img src="/cakeshop/assets/images/uploads/strawberry_cupcake.jpg" style="width:100%; border-radius:15px; height:350px; object-fit:cover;">
        </div>
    </div>
</div>

<!-- Featured Products -->
<div style="background:#fafafa; padding:80px 0;">
    <div class="container">
        <h2 style="text-align:center; font-size:2.5rem; font-weight:300; margin-bottom:50px; letter-spacing:2px;">Our Bestsellers</h2>
        <div class="products-grid">
            <?php foreach ($latestProducts as $cake): ?>
            <div class="product-card" style="border-radius:10px; overflow:hidden;">
                <img src="/cakeshop/assets/images/uploads/<?php echo $cake['image'] ?: 'placeholder.jpg'; ?>" 
                     alt="<?php echo $cake['name']; ?>"
                     style="width:100%; height:300px; object-fit:cover;"
                     onerror="this.src='/cakeshop/assets/images/placeholder.jpg'">
                <div style="padding:20px; text-align:center;">
                    <h3 style="font-weight:400; margin-bottom:5px;"><?php echo $cake['name']; ?></h3>
                    <p style="color:var(--primary); font-size:20px; margin-bottom:15px;">€<?php echo number_format($cake['price'], 2); ?></p>
                    <a href="/cakeshop/pages/product-detail.php?id=<?php echo $cake['id']; ?>" class="btn btn-outline btn-sm" style="color:var(--primary); border-color:var(--primary);">View Details</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- About Us -->
<div class="container" style="padding:80px 0; text-align:center;">
    <h2 style="font-size:2.5rem; font-weight:300; margin-bottom:30px; letter-spacing:2px;">About Us</h2>
    <p style="max-width:700px; margin:0 auto; color:#666; line-height:1.8;">
        Since 1990, The Cake Shop has been creating beautiful, delicious cakes for life's most special moments. 
        Using only the finest ingredients and traditional techniques, every creation is a work of art made with love and dedication.
        From intimate gatherings to grand celebrations, we're here to make your moments sweeter.
    </p>
</div>

<?php require_once 'includes/footer.php'; ?>