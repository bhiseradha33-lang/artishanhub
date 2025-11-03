<?php
require "header.php";

$q = trim($_GET['q'] ?? '');
$cat = trim($_GET['category'] ?? '');
$sql = "SELECT p.*, a.name AS artisan_name FROM products p LEFT JOIN artisans a ON a.id=p.artisan_id WHERE 1 ";
$params = [];
$types = "";

if($q !== ""){
  $sql .= " AND (p.name LIKE CONCAT('%',?,'%') OR a.name LIKE CONCAT('%',?,'%') OR p.category LIKE CONCAT('%',?,'%'))";
  $params[]=$q; $params[]=$q; $params[]=$q; $types.="sss";
}
if($cat !== ""){
  $sql .= " AND p.category=?";
  $params[]=$cat; $types.="s";
}
$sql .= " ORDER BY p.id DESC";
$stmt = $conn->prepare($sql);
if($types){
  $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$res = $stmt->get_result();

$cats = $conn->query("SELECT DISTINCT category FROM products ORDER BY category");
?>
<h1>Crafts</h1>
<form class="flex" method="get">
  <input type="text" name="q" placeholder="Search..." value="<?php echo e($q); ?>">
  <select name="category">
    <option value="">All categories</option>
    <?php while($c = $cats->fetch_assoc()): ?>
      <option value="<?php echo e($c['category']); ?>" <?php if($cat==$c['category']) echo "selected"; ?>><?php echo e($c['category']); ?></option>
    <?php endwhile; ?>
  </select>
  <button type="submit">Filter</button>
</form>
<section class="grid" style="margin-top:16px">
<?php if($res->num_rows==0): ?>
  <p class="empty">No products found.</p>
<?php endif; ?>
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
          <input type="number" name="qty" min="1" value="1" style="width:70px">
          <button type="submit">Add</button>
        </form>
      </div>
    </div>
  </article>
<?php endwhile; ?>
</section>
<?php require "footer.php"; ?>
