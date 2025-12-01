<?php
if (!isset($rootPath)) {
    $rootPath = '';
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="no index, nofollow">
    <meta name="description" content="<?php echo $pageDesc ?>">
    <title><?php echo $pageTitle ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Aldrich&family=Honk&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= $rootPath ?>css/style.css">


</head>
<body>
<header class="site-header">
    <nav class="site-nav">
        <a href="index.php" class="brand-name">DBay</a>
        <ul>
            <a href="<?= $rootPath ?>index.php">Home</a>
            <a href="<?= $rootPath ?>about.php">About</a>
            <a href="<?= $rootPath ?>shop.php">Shop</a>
            <a href="<?= $rootPath ?>contact.php">Contact</a>
            <a href="<?= $rootPath ?>admin/adminLogin.php">Admin</a>
            <a href="<?= $rootPath ?>admin/adminRegister.php">Sign Up</a>
        </ul>
    </nav>
</header>
<main class="site-main">
