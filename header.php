<?php
require_once __DIR__."/includes/db.php";
require_once __DIR__."/includes/auth.php";
require_once __DIR__."/includes/helpers.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>ArtisanHub</title>
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<header class="site-header">
  <div class="container flex">
    <a class="logo" href="index.php">ArtisanHub</a>
    <form class="search" action="products.php" method="get">
      <input type="text" name="q" placeholder="Search crafts or artisans..." value="<?php echo e($_GET['q'] ?? '') ?>">
      <button type="submit">Search</button>
    </form>
    <nav>
      <a href="index.php">Home</a>
      <a href="products.php">Products</a>
      <a href="cart.php">Cart</a>
      <?php if(isLoggedIn()): ?>
        <span class="welcome">Hi, <?php echo e($_SESSION['user_name']); ?></span>
        <a href="logout.php" class="btn-outline">Logout</a>
      <?php else: ?>
        <a href="login.php">Login</a>
        <a href="register.php" class="btn">Register</a>
      <?php endif; ?>
    </nav>
  </div>
</header>
<main class="container">
