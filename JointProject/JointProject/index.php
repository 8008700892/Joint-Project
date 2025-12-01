<?php
$pageTitle = 'Dbay Home Page';
$pageDesc = 'Dbay marketplace home page';
$rootPath = '';
require 'templates/head.php';
?>

<section class="hero">
    <div class="hero-container">
        <h1>Welcome to DBay</h1>
        <p>DBay is your all encompassing e-commerce marketplace. Find anything you desire
            with our vast inventory of products.</p>
    </div>
</section>
<section class="home-features">
    <div class="features-container">
        <?php require 'templates/cta.php'; ?>
        <div class="product-feature">
            <h2>Some Products We Have</h2>
            <div class="product-rotator">
                <img src="img/baseball.jpg" alt="Featured product 1">
                <img src="img/hat.jpg" alt="Featured product 2">
                <img src="img/shoe.jpg" alt="Featured product 3">
            </div>
        </div>
    </div>
</section>


<?php require 'templates/footer.php'; ?>
