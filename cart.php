<?php
require "header.php";
if(!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['add_id'])){
  $id = (int)$_POST['add_id']; $qty = max(1, (int)($_POST['qty'] ?? 1));
  $_SESSION['cart'][$id] = ($_SESSION['cart'][$id] ?? 0) + $qty;
  header("Location: cart.php?msg=Added+to+cart");
  exit;
}
if(isset($_GET['remove'])){
  unset($_SESSION['cart'][(int)$_GET['remove']]);
  header("Location: cart.php");
  exit;
}
if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['update'])){
  foreach($_POST['qty'] as $pid=>$q){
    $q = max(0,(int)$q);
    if($q==0) unset($_SESSION['cart'][$pid]); else $_SESSION['cart'][$pid] = $q;
  }
}

$ids = array_keys($_SESSION['cart']);
$items = [];
$total = 0;
if($ids){
  $in = implode(",", array_fill(0, count($ids), "?"));
  $types = str_repeat("i", count($ids));
  $stmt = $conn->prepare("SELECT id, name, price, image FROM products WHERE id IN ($in)");
  $stmt->bind_param($types, ...$ids);
  $stmt->execute();
  $res = $stmt->get_result();
  while($r=$res->fetch_assoc()){
    $r['qty'] = $_SESSION['cart'][$r['id']];
    $r['line'] = $r['qty'] * $r['price'];
    $total += $r['line'];
    $items[] = $r;
  }
}
?>
<h1>Your Cart</h1>
<?php if(!$items): ?>
  <p class="empty">Cart is empty.</p>
<?php else: ?>
<form method="post">
<table>
<thead><tr><th>Product</th><th>Price</th><th>Qty</th><th>Subtotal</th><th></th></tr></thead>
<tbody>
<?php foreach($items as $it): ?>
<tr>
  <td>
    <div class="flex">
      <img src="<?php echo e($it['image'] ?: 'assets/images/placeholder.jpg'); ?>" style="width:70px;height:70px;object-fit:cover;border-radius:10px">
      <strong><?php echo e($it['name']); ?></strong>
    </div>
  </td>
  <td><?php echo price($it['price']); ?></td>
  <td><input type="number" name="qty[<?php echo $it['id']; ?>]" min="0" value="<?php echo $it['qty']; ?>" style="width:80px"></td>
  <td><?php echo price($it['line']); ?></td>
  <td><a class="btn-outline" href="?remove=<?php echo $it['id']; ?>">Remove</a></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
<div class="flex" style="justify-content:space-between; margin-top:12px">
  <div><strong>Total: <?php echo price($total); ?></strong></div>
  <div class="actions">
    <button type="submit" name="update" value="1" class="btn-outline">Update quantities</button>
    <a class="btn" href="checkout.php">Proceed to checkout</a>
  </div>
</div>
</form>
<?php endif; ?>
<?php require "footer.php"; ?>
