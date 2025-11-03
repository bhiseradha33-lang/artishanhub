<?php
require "header.php";
// Featured products (latest 8)
$stmt = $conn->prepare("SELECT p.*, a.name AS artisan_name FROM products p LEFT JOIN artisans a ON a.id=p.artisan_id ORDER BY p.id DESC LIMIT 8");
$stmt->execute();
$res = $stmt->get_result();
?>
<h1>Discover local handcrafted treasures</h1>
<p>Support artisans around you. Browse pottery, textiles, jewelry, woodwork and more.</p>
<h2>Featured</h2>
<section class="grid">
<?php while($row = $res->fetch_assoc()): ?>
  <article class="card">
    <img src="<?php echo e($row['image'] ?: 'assets/images/placeholder.jpg'); ?>" alt="">
    <div class="body">
      <span class="badge"><?php echo e($row['category']); ?> • by <?php echo e($row['artisan_name']); ?></span>
      <h3><?php echo e($row['name']); ?></h3>
      <div class="price"><?php echo price($row['price']); ?></div>
      <div class="actions">
        <a class="btn-outline" href="product.php?id=<?php echo $row['id']; ?>">View</a>
        <form action="cart.php" method="post">
          <input type="hidden" name="add_id" value="<?php echo $row['id']; ?>">
          <input type="hidden" name="qty" value="1">
          <button type="submit">Add to cart</button>
        </form>
      </div>
    </div>
  </article>
<?php endwhile; ?>
</section>
<?php require "footer.php"; ?>
