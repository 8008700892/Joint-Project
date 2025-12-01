<?php
$pageTitle = 'DBay shop page';
$pageDesc  = 'Browse all DBay products';
$rootPath = '';

require 'templates/head.php';

// Database and Product CRUD
require_once 'includes/Database.php';
require_once 'includes/ProductCRUD.php';

// Get database connection and CRUD object
$database    = new Database();
$db          = $database->getConnection();
$productCRUD = new ProductCRUD($db);

// Get all products (PDOStatement)
$stmt = $productCRUD->readAllProducts();
?>

<section class="shop-hero">
    <div class="shop-container">
        <h1 class="shop-title">Shop our products</h1>
    </div>
</section>

<section class="shop-grid">
    <div class="shop-container grid-3">

        <?php if ($stmt && $stmt->rowCount() > 0): ?>

            <?php while ($product = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                <div class="product">
                    <a class="thumb"
                       href="<?php echo $rootPath; ?>product.php?id=<?php echo htmlspecialchars($product['id']); ?>">
                        <?php if (!empty($product['image_path'])): ?>
                            <img
                                    src="<?php echo htmlspecialchars($rootPath . $product['image_path']); ?>"
                                    alt="<?php echo htmlspecialchars($product['name']); ?>"
                            >
                        <?php else: ?>
                            <div class="no-image">No image</div>
                        <?php endif; ?>
                    </a>

                    <p class="product-name">
                        <?php echo htmlspecialchars($product['name']); ?>
                    </p>

                    <p class="product-price">
                        $<?php echo htmlspecialchars($product['price']); ?>
                    </p>
                </div>
            <?php endwhile; ?>

        <?php else: ?>

            <p>No products available right now.</p>

        <?php endif; ?>

    </div>
</section>

<?php require 'templates/footer.php'; ?>
