<?php
session_start();
if (isset($_SESSION["user"])) {
  header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
 <div class="container">
  <?php
  if (isset($_POST["log-in"])) {
   $email = $_POST["email"];
   $password = $_POST["password"];
   require_once "database.php";
   $sql = "SELECT * FROM users WHERE email = '$email'";
   $result = mysqli_query($conn, $sql);
   $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
   if ($user && password_verify($password, $user["password"])) {
      session_start();
      $_SESSION["user"] = "yes";
      header("Location: index.php");
      die();
   }
    else {
    echo "<div class='alert alert-danger'>Error write again</div>";
   }

  }
  ?>
  <form action="login.php" method="post">
  <div class="form-group">
   <input type="email" placeholder="Enter Email:" name="email" class="form-control">
  </div> 
  <div class="form-group">
   <input type="password" placeholder="Enter Password:" name="password" class="form-control">
</div>
   <div class="form-btn">
   <input type="submit" value="Log in" name="log-in" class="btn btn-primary"> 
  </div>   
</form>
<div><p>Not registered yet</p><a href="registration.php">Register Here</a></p></div>
</div>
</body>
</html>