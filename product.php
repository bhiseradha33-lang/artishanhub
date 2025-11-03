<?php
require "header.php";
$id = (int)($_GET['id'] ?? 0);
$stmt = $conn->prepare("SELECT p.*, a.name AS artisan_name, a.biography FROM products p LEFT JOIN artisans a ON a.id=p.artisan_id WHERE p.id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$item = $stmt->get_result()->fetch_assoc();
if(!$item){ echo "<p class='empty'>Product not found.</p>"; require "footer.php"; exit; }
?>
<article class="grid" style="grid-template-columns: 1fr 1fr; align-items:start">
  <img src="<?php echo e($item['image'] ?: 'assets/images/placeholder.jpg'); ?>" style="border-radius:16px;width:100%;height:420px;object-fit:cover">
  <div>
    <span class="badge"><?php echo e($item['category']); ?></span>
    <h1><?php echo e($item['name']); ?></h1>
    <div class="price"><?php echo price($item['price']); ?></div>
    <p><?php echo nl2br(e($item['description'])); ?></p>
    <p class="muted">By <strong><?php echo e($item['artisan_name']); ?></strong></p>
    <form action="cart.php" method="post" class="actions">
      <input type="hidden" name="add_id" value="<?php echo $item['id']; ?>">
      <input type="number" name="qty" min="1" value="1" style="width:90px">
      <button type="submit">Add to cart</button>
    </form>
  </div>
</article>
<?php require "footer.php"; ?>
