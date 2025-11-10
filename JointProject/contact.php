<?php
$pageTitle = 'Contact DBay';
$pageDesc  = 'Contact DBay support.';
require 'templates/head.php';
?>

    <section class="contact-hero">
        <div class="contact-container">
            <h1>Contact DBay</h1>
        </div>
    </section>

    <section class="contact-section">
        <div class="contact-container">
            <form class="contact-form" method="POST" action="#">
                <div class="form-field">
                    <label for="first_name">First name</label>
                    <input type="text" id="first_name" name="first_name" required>
                </div>

                <div class="form-field">
                    <label for="last_name">Last name</label>
                    <input type="text" id="last_name" name="last_name" required>
                </div>

                <div class="form-field">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div class="form-field">
                    <label for="message">Whats your issue?</label>
                    <textarea id="message" name="message" rows="6" required></textarea>
                </div>

                <button type="submit" class="contact-submit">Send message</button>
            </form>
        </div>
    </section>

<?php require 'templates/footer.php'; ?>