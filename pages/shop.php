<?php
require_once '../classes/Product.php';
require_once '../classes/Category.php';
require_once '../includes/header.php';
require_once '../includes/navbar.php';

$product = new Product();
$categoryObj = new Category();

$categories = $categoryObj->getAll();
$category_id = isset($_GET['category']) ? $_GET['category'] : null;
$search = isset($_GET['search']) ? $_GET['search'] : '';

if ($search) {
    $products = $product->search($search);
} elseif ($category_id) {
    $products = $product->getByCategory($category_id);
} else {
    $products = $product->getAll();
}
?>

<!-- Shop Header -->
<div style="background: var(--light); padding: 60px 0; text-align: center;">
    <h1 style="font-family: 'Playfair Display', serif; font-size: 3rem; font-weight: 300; letter-spacing: 4px; margin-bottom: 10px;">Our Cakes</h1>
    <p style="color: var(--text); font-size: 14px; letter-spacing: 1px;">Home / Shop</p>
</div>

<div class="container" style="padding: 40px 0;">
    
    <!-- Category Filters -->
    <div style="display: flex; justify-content: center; flex-wrap: wrap; gap: 10px; margin-bottom: 50px;">
        <a href="shop.php" 
           style="padding: 10px 25px; border: 1px solid var(--border); text-decoration: none; color: <?php echo !$category_id ? 'white' : 'var(--text)'; ?>; 
                  background: <?php echo !$category_id ? 'var(--primary)' : 'transparent'; ?>; 
                  font-size: 12px; letter-spacing: 2px; text-transform: uppercase; transition: 0.3s;
                  font-family: 'Montserrat', sans-serif;">
            All
        </a>
        <?php foreach ($categories as $cat): ?>
        <a href="?category=<?php echo $cat['id']; ?>" 
           style="padding: 10px 25px; border: 1px solid var(--border); text-decoration: none; color: <?php echo $category_id == $cat['id'] ? 'white' : 'var(--text)'; ?>; 
                  background: <?php echo $category_id == $cat['id'] ? 'var(--primary)' : 'transparent'; ?>; 
                  font-size: 12px; letter-spacing: 2px; text-transform: uppercase; transition: 0.3s;
                  font-family: 'Montserrat', sans-serif;">
            <?php echo $cat['name']; ?>
        </a>
        <?php endforeach; ?>
    </div>

    <!-- Search Bar -->
    <div style="max-width: 400px; margin: 0 auto 50px;">
        <form method="GET" style="display: flex; gap: 0;">
            <input type="text" name="search" 
                   placeholder="Search cakes..." 
                   value="<?php echo htmlspecialchars($search); ?>"
                   style="flex:1; padding:14px 20px; border:1px solid var(--border); border-right:none; 
                          font-family:'Montserrat',sans-serif; font-size:13px; letter-spacing:1px;">
            <?php if ($category_id): ?>
                <input type="hidden" name="category" value="<?php echo $category_id; ?>">
            <?php endif; ?>
            <button type="submit" style="padding:14px 25px; background:var(--primary); color:white; border:none; 
                                             cursor:pointer; font-size:12px; letter-spacing:2px; text-transform:uppercase;">
                Search
            </button>
        </form>
    </div>

    <!-- Products Grid -->
    <?php if (count($products) > 0): ?>
    <div class="products-grid">
        <?php foreach ($products as $cake): ?>
        <div class="product-card">
            <a href="product-detail.php?id=<?php echo $cake['id']; ?>">
                <img src="/cakeshop/assets/images/uploads/<?php echo $cake['image'] ?: 'placeholder.jpg'; ?>" 
                     alt="<?php echo $cake['name']; ?>"
                     onerror="this.src='/cakeshop/assets/images/placeholder.jpg'">
            </a>
            <div class="product-info" style="text-align: center; padding: 20px;">
                <span class="category"><?php echo $cake['category_name']; ?></span>
                <h3>
                    <a href="product-detail.php?id=<?php echo $cake['id']; ?>" 
                       style="color: var(--dark); text-decoration: none;">
                        <?php echo $cake['name']; ?>
                    </a>
                </h3>
                <p class="price">€<?php echo number_format($cake['price'], 2); ?></p>
                
                <?php if ($cake['stock'] > 0 && isset($_SESSION['user_id'])): ?>
                <form action="add-to-cart.php" method="POST" style="margin-top: 10px;">
                    <input type="hidden" name="id" value="<?php echo $cake['id']; ?>">
                    <input type="hidden" name="name" value="<?php echo $cake['name']; ?>">
                    <input type="hidden" name="price" value="<?php echo $cake['price']; ?>">
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit" class="btn btn-primary btn-sm" style="width: 100%;">Add to Cart</button>
                </form>
                <?php elseif ($cake['stock'] <= 0): ?>
                    <p style="color: var(--danger); font-size: 11px; letter-spacing: 1px; margin-top: 10px;">Out of Stock</p>
                <?php else: ?>
                    <a href="login.php" class="btn btn-outline btn-sm" style="width: 100%; margin-top: 10px; color: var(--primary); border-color: var(--primary);">Login to Order</a>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php else: ?>
        <div class="no-products">
            <p>No products found. Try a different search.</p>
        </div>
    <?php endif; ?>
</div>

<?php require_once '../includes/footer.php'; ?>