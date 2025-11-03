<?php
require "header.php";
requireLogin();
if(empty($_SESSION['cart'])){ echo "<p class='empty'>Your cart is empty.</p>"; require "footer.php"; exit; }

// Load items
$ids = array_keys($_SESSION['cart']);
$in = implode(",", array_fill(0, count($ids), "?"));
$types = str_repeat("i", count($ids));
$stmt = $conn->prepare("SELECT id, price FROM products WHERE id IN ($in)");
$stmt->bind_param($types, ...$ids);
$stmt->execute();
$res = $stmt->get_result();
$prices = [];
while($r=$res->fetch_assoc()){ $prices[$r['id']] = $r['price']; }

if($_SERVER['REQUEST_METHOD']==='POST'){
  $uid = $_SESSION['user_id'];
  $status = "COD - Pending";
  $now = date('Y-m-d H:i:s');
  $conn->begin_transaction();
  try {
    foreach($_SESSION['cart'] as $pid=>$qty){
      $price = $prices[$pid] ?? 0;
      $total = $price * $qty;
      $stmt2 = $conn->prepare("INSERT INTO orders (user_id, product_id, quantity, total_price, order_date, status) VALUES (?,?,?,?,?,?)");
      $stmt2->bind_param("iiidss", $uid, $pid, $qty, $total, $now, $status);
      $stmt2->execute();
    }
    $conn->commit();
    $_SESSION['cart'] = [];
    header("Location: thankyou.php");
    exit;
  } catch(Exception $e){
    $conn->rollback();
    echo "<div class='alert'>Error placing order. ".$e->getMessage()."</div>";
  }
}
?>
<h1>Checkout</h1>
<p>Payment method: <strong>Cash on Delivery</strong></p>
<form method="post">
  <button class="btn" type="submit">Place order</button>
</form>
<?php require "footer.php"; ?>
