<?php

// Read any status message from query string in adminLoginSubmit
$status = $_GET['status'] ?? '';
$error_message = $_GET['error_message'] ?? '';
$success_message = $_GET['success_message'] ?? '';

// Prefill older email if it was passed back into query string
$old_email = $_GET['email'] ?? '';
$pageTitle = 'Admin Login - Dbay';
$pageDesc = 'Registered admins will use this page to login';
require 'templates/head.php';
?>


    <section class="register-section">
        <div class="register-container">
            <h1>Admin Login</h1>
            <p>Login to access the DBay admin dashboard.</p>

            <?php if ($status === 'error' && $error_message): ?>
                <div class="form-error">
                    <?php echo htmlspecialchars($error_message); ?>
                </div>
            <?php elseif ($status === 'success' && $success_message): ?>
                <div class="form-success">
                    <?php echo htmlspecialchars($success_message); ?>
                </div>
            <?php endif; ?>

            <form action="adminLoginSubmit.php" method="post" class="register-form">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        required
                        value="<?php echo htmlspecialchars($old_email); ?>"
                    >
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        required
                    >
                </div>

                <button type="submit" class="register-submit">Login</button>
            </form>
        </div>
    </section>
<?php require 'templates/footer.php'; ?>