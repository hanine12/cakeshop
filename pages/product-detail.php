<?php
require_once '../classes/Product.php';
require_once '../includes/header.php';
require_once '../includes/navbar.php';

$id = isset($_GET['id']) ? $_GET['id'] : 0;
$productObj = new Product();
$product = $productObj->getById($id);

if (!$product) {
    header('Location: shop.php');
    exit;
}

// Get lowest price from sizes
$lowestPrice = $product['price'];
if (!empty($product['sizes'])) {
    $sizesArray = explode(',', $product['sizes']);
    $prices = [];
    foreach ($sizesArray as $size) {
        preg_match('/€([\d.]+)/', $size, $matches);
        if (isset($matches[1])) {
            $prices[] = (float)$matches[1];
        }
    }
    if (!empty($prices)) {
        $lowestPrice = min($prices);
    }
}
?>

<div class="container" style="margin-top:40px;">
    <a href="shop.php" style="color:var(--primary);">← Retour à la boutique</a>
    
    <div style="display:flex; gap:40px; margin-top:30px; flex-wrap:wrap;">
        <!-- Product Image -->
        <div style="flex:1; min-width:300px;">
            <img src="/cakeshop/assets/images/uploads/<?php echo $product['image'] ?: 'placeholder.jpg'; ?>" 
                 alt="<?php echo $product['name']; ?>"
                 style="width:100%; border-radius:15px; box-shadow:0 5px 20px rgba(0,0,0,0.2);"
                 onerror="this.src='/cakeshop/assets/images/placeholder.jpg'">
        </div>

        <!-- Product Info -->
        <div style="flex:1; min-width:300px;">
            <span style="color:#888;"><?php echo $product['category_name']; ?></span>
            <h1 style="font-size:2rem; margin:10px 0;"><?php echo $product['name']; ?></h1>
            
            <!-- Price - shows lowest size price -->
            <p style="font-size:1.8rem; font-weight:bold; color:var(--primary); margin:15px 0;">
                €<?php echo number_format($lowestPrice, 2); ?>
            </p>
            
            <p style="line-height:1.8; color:#555; margin-bottom:20px;">
                <?php echo $product['description']; ?>
            </p>
            
            <!-- Ingredients -->
            <?php if (!empty($product['ingredients'])): ?>
                <h3 style="color:var(--primary); margin-bottom:10px;">🥄 Ingrédients</h3>
                <ul style="line-height:2; color:#555; padding-left:20px; margin-bottom:20px;">
                    <?php 
                    $ingredients = explode(', ', $product['ingredients']);
                    foreach ($ingredients as $ingredient): 
                    ?>
                        <li><?php echo htmlspecialchars($ingredient); ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
            
            <!-- Size Selection -->
            <?php if (!empty($product['sizes'])): ?>
                <div style="margin: 20px 0; background: #fdfaf6; padding: 20px; border-radius: 8px; border: 1px solid #e8e0d5;">
                    <h3 style="color: var(--dark); font-size: 16px; margin-bottom: 5px;">📏 Choisir la taille</h3>
                    <div style="display: flex; flex-direction: column; gap: 8px; margin-top: 12px;">
                        <?php 
                        $sizes = explode(',', $product['sizes']);
                        foreach ($sizes as $index => $size): 
                            $size = trim($size);
                            $checked = ($index === 0) ? 'checked' : '';
                        ?>
                            <label style="display: flex; align-items: center; gap: 10px; 
                                          padding: 12px 15px; border: 1px solid #e8e0d5; border-radius: 4px; 
                                          cursor: pointer; transition: 0.3s; font-size: 14px; color: var(--dark);
                                          background: white;">
                                <input type="radio" name="selected_size" value="<?php echo htmlspecialchars($size); ?>" 
                                       <?php echo $checked; ?>
                                       style="accent-color: var(--primary); width: 18px; height: 18px;">
                                <?php echo htmlspecialchars($size); ?>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
            
            <?php if ($product['stock'] > 0): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> En stock — Livraison sous 24-48h
                </div>
            <?php else: ?>
                <div class="alert alert-danger">
                    <i class="fas fa-times-circle"></i> Rupture de stock
                </div>
            <?php endif; ?>

            <?php if ($product['stock'] > 0 && isset($_SESSION['user_id'])): ?>
            <form action="add-to-cart.php" method="POST">
                <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                <input type="hidden" name="name" value="<?php echo $product['name']; ?>">
                <input type="hidden" name="price" value="<?php echo $lowestPrice; ?>">
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="btn btn-primary" style="font-size:16px; padding:15px 40px; width:100%;">
                    <i class="fas fa-shopping-cart"></i> Ajouter au panier
                </button>
            </form>
            <?php elseif (!isset($_SESSION['user_id'])): ?>
                <a href="login.php" class="btn btn-primary" style="width:100%;">Connectez-vous pour commander</a>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>