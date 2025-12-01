<?php
// admin product CRUD page
// only admins allowed
require_once '../includes/adminAuth.php';
require_once '../includes/Database.php';
require_once '../includes/ProductCRUD.php';

// connect to database
$database = new Database();
$db = $database->getConnection();
$productCRUD = new ProductCRUD($db);

// read all products for the table
$products = $productCRUD->readAllProducts() ?? [];

// read status messages from query string
$status = $_GET['status'] ?? '';
$error_message = $_GET['error_message'] ?? '';
$success_message = $_GET['success_message'] ?? '';
?>

<?php
$rootPath = '../';
require '../templates/head.php';
?>

<main class="site-main">
    <section class="admin-section">
        <div class="admin-container">

            <h1>Manage Products</h1>
            <p>Create, view, edit, and delete products.</p>

            <?php if ($status === 'error' && $error_message): ?>
                <div class="form-error">
                    <?php echo htmlspecialchars($error_message); ?>
                </div>
            <?php elseif ($status === 'success' && $success_message): ?>
                <div class="form-success">
                    <?php echo htmlspecialchars($success_message); ?>
                </div>
            <?php endif; ?>

            <!-- CREATE PRODUCT FORM -->
            <h2>Create New Product</h2>

            <form action="adminProductCreateSubmit.php" method="post" enctype="multipart/form-data" class="admin-form">

                <div class="form-group">
                    <label for="name">Product Name</label>
                    <input type="text" id="name" name="name" required>
                </div>

                <div class="form-group">
                    <label for="price">Price (numbers only)</label>
                    <input type="text" id="price" name="price" required>
                </div>

                <div class="form-group">
                    <label for="category">Category</label>
                    <input type="text" id="category" name="category">
                </div>

                <div class="form-group">
                    <label for="image_path">Product Image</label>
                    <input type="file" id="image_path" name="image_path" accept="image/png, image/jpeg">
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" rows="4"></textarea>
                </div>

                <button type="submit" class="admin-submit-btn">Create Product</button>
            </form>

            <hr>

            <!-- PRODUCT TABLE -->
            <h2>Current Products</h2>

            <table class="admin-table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Price ($)</th>
                    <th>Category</th>
                    <th>Image</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
                </thead>

                <tbody>
                <?php if (!empty($products)): ?>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($product['id']); ?></td>
                            <td><?php echo htmlspecialchars($product['name']); ?></td>
                            <td><?php echo htmlspecialchars($product['price']); ?></td>
                            <td><?php echo htmlspecialchars($product['category']); ?></td>

                            <td>
                                <?php if (!empty($product['image_path'])): ?>
                                    <img src="../<?php echo htmlspecialchars($product['image_path']); ?>" alt="" class="admin-thumb">
                                <?php else: ?>
                                    No Image
                                <?php endif; ?>
                            </td>

                            <td><?php echo htmlspecialchars($product['description']); ?></td>

                            <td>
                                <a href="adminProductEdit.php?id=<?php echo $product['id']; ?>" class="table-btn edit-btn">Edit</a>

                                <a href="adminProductDelete.php?id=<?php echo $product['id']; ?>"
                                   class="table-btn delete-btn"
                                   onclick="return confirm('Delete this product?');">
                                    Delete
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="7">No products found.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>

        </div>
    </section>
</main>

<?php
// Include site footer template
require '../templates/footer.php';
?>
