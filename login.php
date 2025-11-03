<?php
require "header.php";
if(isLoggedIn()){ header("Location: index.php"); exit; }
$msg = e($_GET['msg'] ?? '');
if($_SERVER['REQUEST_METHOD']==='POST'){
  $email = $_POST['email'] ?? '';
  $pass  = $_POST['password'] ?? '';
  $stmt = $conn->prepare("SELECT id, name, password FROM users WHERE email=?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $u = $stmt->get_result()->fetch_assoc();
  if($u && password_verify($pass, $u['password'])){
    $_SESSION['user_id']=$u['id']; $_SESSION['user_name']=$u['name'];
    header("Location: index.php");
    exit;
  } else {
    $msg = "Invalid email or password";
  }
}
?>
<h1>Login</h1>
<?php if($msg): ?><div class="alert"><?php echo $msg; ?></div><?php endif; ?>
<form class="form" method="post">
  <label>Email</label><input type="email" name="email" required>
  <label>Password</label><input type="password" name="password" required>
  <input class="btn" type="submit" value="Login">
</form>
<p style="text-align:center">New here? <a href="register.php">Create an account</a></p>
<?php require "footer.php"; ?>
