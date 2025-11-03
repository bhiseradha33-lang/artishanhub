<?php
require "header.php";
requireLogin();
$uid = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT o.*, p.name AS product_name FROM orders o LEFT JOIN products p ON p.id=o.product_id WHERE o.user_id=? ORDER BY o.id DESC");
$stmt->bind_param("i", $uid);
$stmt->execute();
$res = $stmt->get_result();
?>
<h1>My Orders</h1>
<table>
<thead><tr><th>ID</th><th>Product</th><th>Qty</th><th>Total</th><th>Date</th><th>Status</th></tr></thead>
<tbody>
<?php while($o=$res->fetch_assoc()): ?>
<tr>
  <td><?php echo $o['id']; ?></td>
  <td><?php echo e($o['product_name']); ?></td>
  <td><?php echo (int)$o['quantity']; ?></td>
  <td><?php echo price($o['total_price']); ?></td>
  <td><?php echo e($o['order_date']); ?></td>
  <td><?php echo e($o['status']); ?></td>
</tr>
<?php endwhile; ?>
</tbody>
</table>
<?php require "footer.php"; ?>
