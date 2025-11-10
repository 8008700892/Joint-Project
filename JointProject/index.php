<?php
$pageTitle = 'Dbay Home Page';
$pageDesc = 'Dbay marketplace home page';
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
        <div class="shop-feature">
            <h2>Ready to Start Shopping?</h2>
            <p>Anything you can think of can be found browsing through our shop.
                Click the button below to head over to our shop page. </p>
            <a class="btn btn-primary" href="shop.php">Shop Now</a>
        </div>
        <div class="product-feature">
            <h2>Some Products We Have</h2>
            <div class="product-rotator">
                <img src="imgs/apple1.jpg" alt="Featured product 1">
                <img src="imgs/apple2.jpg" alt="Featured product 2">
                <img src="imgs/apple3.jpg" alt="Featured product 3">
            </div>
        </div>
    </div>
</section>


<?php require 'templates/footer.php'; ?>
