<?php
$pageTitle = 'DBay product page';
$pageDesc  = 'View details for a DBay product';
$rootPath = '';
require 'templates/head.php';

require_once 'includes/Database.php';
require_once 'includes/ProductCRUD.php';

// Read id from query string
$id = $_GET['id'] ?? '';

// Prepare variables
$product = null;
$error_message = '';

// Basic id validation
if ($id === '' || !is_numeric($id)) {
    $error_message = 'Invalid product id.';
} else {
    // Get database connection
    $database    = new Database();
    $db          = $database->getConnection();
    $productCRUD = new ProductCRUD($db);


    $product = $productCRUD->readOneProduct($id);

    if (!$product) {
        $error_message = 'Product not found.';
    }
}
?>

    <main class="site-main">
        <section class="single-product-section">
            <div class="single-product-container">

                <?php if ($error_message): ?>

                    <h1>Product details</h1>
                    <p><?php echo htmlspecialchars($error_message); ?></p>

                <?php else: ?>

                    <h1 class="single-product-title">
                        <?php echo htmlspecialchars($product['name']); ?>
                    </h1>

                    <div class="single-product-layout">

                        <div class="single-product-image">
                            <?php if (!empty($product['image_path'])): ?>
                                <img
                                        src="<?php echo htmlspecialchars($rootPath . $product['image_path']); ?>"
                                        alt="<?php echo htmlspecialchars($product['name']); ?>"
                                >
                            <?php else: ?>
                                <div class="no-image">No image available</div>
                            <?php endif; ?>
                        </div>

                        <div class="single-product-info">

                            <p class="single-product-price">
                                Price: $<?php echo htmlspecialchars($product['price']); ?>
                            </p>

                            <?php if (!empty($product['category'])): ?>
                                <p class="single-product-category">
                                    Category: <?php echo htmlspecialchars($product['category']); ?>
                                </p>
                            <?php endif; ?>

                            <?php if (!empty($product['description'])): ?>
                                <p class="single-product-description">
                                    <?php echo htmlspecialchars($product['description']); ?>
                                </p>
                            <?php endif; ?>

                            <a href="<?php echo $rootPath; ?>shop.php" class="back-link">Back to shop</a>
                        </div>

                    </div>

                <?php endif; ?>

            </div>
        </section>
    </main>

<?php require 'templates/footer.php'; ?>