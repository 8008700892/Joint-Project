<?php

// read any status messages from the query string in adminRegisterSubmit
$status = $_GET['status'] ?? '';
$error_message = $_GET['error_message'] ?? '';
$success_message = $_GET['success_message'] ?? '';

// prefill older username and email if the were passed back into query string
$old_username = $_GET['username'] ?? '';
$old_email = $_GET['email'] ?? '';
$pageTitle = 'Admin Register - Dbay';
$pageDesc = 'Users can Register as an admin on this page';
require 'templates/head.php';
?>


    <section class="register-section">
        <div class="register-container">
            <div class="register-hero">
                <h1>Admin Registration</h1>
                <p>Use the form below to register an admin account</p>
            </div>

            <?php if ($status === 'success' && $success_message !== ''): ?>
            <?php echo htmlspecialchars($success_message); ?>
            <?php elseif ($status === 'error' && $error_message !== ''): ?>
            <?php echo htmlspecialchars($error_message); ?>
            <?php endif; ?>

            <form class="register-form" action="adminRegisterSubmit.php" method="post">
                <div class="form-field">
                    <label for="username">Username</label>
                    <input
                        type="text"
                        id="username"
                        name="username"
                        value="<?php echo htmlspecialchars($old_username); ?>"
                        required>
                </div>

                <div class="form-field">
                    <label for="email">Email address</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="<?php echo htmlspecialchars($old_email); ?>"
                        required>
                </div>

                <div class="form-field">
                    <label for="password">Password</label>
                    <input
                    type="password"
                    id="password"
                    name="password"
                    required>
                </div>


                <div class="form-field">
                    <label for="confirm_password">Confirm Password</label>
                    <input
                    type="password"
                    id="confirm_password"
                    name="confirm_password"
                    required>
                </div>

                <button type="submit" class="register-submit">Create Admin</button>
            </form>


        </div>
    </section>
<?php require 'templates/footer.php'; ?>