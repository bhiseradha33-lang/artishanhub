<?php
require "header.php";
if(isLoggedIn()){ header("Location: index.php"); exit; }
$msg = "";
if($_SERVER['REQUEST_METHOD']==='POST'){
  $name = trim($_POST['name'] ?? '');
  $email = trim($_POST['email'] ?? '');
  $pass  = $_POST['password'] ?? '';
  if(!$name || !$email || !$pass){
    $msg = "All fields are required";
  } else {
    $hash = password_hash($pass, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?,?,?)");
    $stmt->bind_param("sss", $name, $email, $hash);
    if($stmt->execute()){
      header("Location: login.php?msg=Registered+successfully");
      exit;
    } else {
      $msg = "Email already used or error occurred.";
    }
  }
}
?>
<h1>Create Account</h1>
<?php if($msg): ?><div class="alert"><?php echo e($msg); ?></div><?php endif; ?>
<form class="form" method="post">
  <label>Name</label><input type="text" name="name" required>
  <label>Email</label><input type="email" name="email" required>
  <label>Password</label><input type="password" name="password" required>
  <input class="btn" type="submit" value="Register">
</form>
<?php require "footer.php"; ?>
