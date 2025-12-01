<?php
// Protect page
require_once '../includes/adminAuth.php';

// databse and crud
require_once '../includes/Database.php';
require_once '../includes/ProductCRUD.php';

// read ID from query string
$id = $_GET['id'] ?? '';

if ($id === '' || !is_numeric($id)) {
    $redirect_url = 'adminProducts.php?status=error'
        . '&error_message=' . urlencode('Invalid product ID.');
    header("Location: $redirect_url");
    exit;
}


$database = new Database();
$db = $database->getConnection();
$productCRUD = new ProductCRUD($db);

// Fetch product
$product = $productCRUD->readOneProduct($id);

if (!$product) {
    $redirect_url = 'adminProducts.php?status=error'
        . '&error_message=' . urlencode('Product not found.');
    header("Location: $redirect_url");
    exit;
}

// read messages from redirects
$status = $_GET['status'] ?? '';
$error_message = $_GET['error_message'] ?? '';
$success_message = $_GET['success_message'] ?? '';

$rootPath = '../';
require '../templates/head.php';
?>



    <main class="site-main">
        <section class="admin-section">
            <div class="admin-container">

                <h1>Edit Product</h1>
                <p>Update the product details below.</p>

                <?php if ($status === 'error' && $error_message): ?>
                    <div class="form-error">
                        <?php echo htmlspecialchars($error_message); ?>
                    </div>
                <?php elseif ($status === 'success' && $success_message): ?>
                    <div class="form-success">
                        <?php echo htmlspecialchars($success_message); ?>
                    </div>
                <?php endif; ?>

                <form action="adminProductEditSubmit.php" method="post" class="admin-form">

                    <!-- ID field hidden -->
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($product['id']); ?>">

                    <div class="form-group">
                        <label for="name">Product Name</label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            required
                            value="<?php echo htmlspecialchars($product['name']); ?>"
                        >
                    </div>

                    <div class="form-group">
                        <label for="price">Price (numbers only)</label>
                        <input
                            type="text"
                            id="price"
                            name="price"
                            required
                            value="<?php echo htmlspecialchars($product['price']); ?>"
                        >
                    </div>

                    <div class="form-group">
                        <label for="category">Category</label>
                        <input
                            type="text"
                            id="category"
                            name="category"
                            value="<?php echo htmlspecialchars($product['category']); ?>"
                        >
                    </div>

                    <div class="form-group">
                        <label for="image_path">Image Path</label>
                        <input
                            type="text"
                            id="image_path"
                            name="image_path"
                            value="<?php echo htmlspecialchars($product['image_path']); ?>"
                        >
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea
                            id="description"
                            name="description"
                            rows="4"
                        ><?php echo htmlspecialchars($product['description']); ?></textarea>
                    </div>

                    <button type="submit" class="admin-submit-btn">Update Product</button>
                </form>

                <br>

                <a href="adminProducts.php" class="table-btn">Back to Products</a>

            </div>
        </section>
    </main>

<?php require '../templates/footer.php'; ?>