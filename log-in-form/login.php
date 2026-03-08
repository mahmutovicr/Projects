<?php
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 1);
ini_set('session.cookie_samesite', 'Strict');
session_start();

if (isset($_SESSION["user"])) {
    header("Location: index.php");
    exit();
}

$csrf_token = bin2hex(random_bytes(32));
$_SESSION["csrf_token"] = $csrf_token;
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
        if (!isset($_POST["csrf_token"]) || !hash_equals($_SESSION["csrf_token"], $_POST["csrf_token"])) {
            die("Invalid CSRF token.");
        }

        $email = $_POST["email"];
        $password = $_POST["password"];
        require_once "database.php";

        $sql = "SELECT id, password, failed_attempts, lockout_time FROM users WHERE email = ?";
        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, $sql);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_array($result, MYSQLI_ASSOC);

        if ($user) {
            if ($user["lockout_time"] && (time() - strtotime($user["lockout_time"])) < 900) {
                echo "<div class='alert alert-danger'>Too many failed attempts. Try again in 15 minutes.</div>";
            } elseif (password_verify($password, $user["password"])) {
                $reset = "UPDATE users SET failed_attempts = 0, lockout_time = NULL WHERE id = ?";
                $stmt2 = mysqli_stmt_init($conn);
                mysqli_stmt_prepare($stmt2, $reset);
                mysqli_stmt_bind_param($stmt2, "i", $user["id"]);
                mysqli_stmt_execute($stmt2);

                session_regenerate_id(true);
                $_SESSION["user"] = $user["id"];
                header("Location: index.php");
                exit();
            } else {
                $attempts = $user["failed_attempts"] + 1;
                if ($attempts >= 5) {
                    $lock = "UPDATE users SET failed_attempts = ?, lockout_time = NOW() WHERE id = ?";
                } else {
                    $lock = "UPDATE users SET failed_attempts = ?, lockout_time = NULL WHERE id = ?";
                }
                $stmt3 = mysqli_stmt_init($conn);
                mysqli_stmt_prepare($stmt3, $lock);
                mysqli_stmt_bind_param($stmt3, "ii", $attempts, $user["id"]);
                mysqli_stmt_execute($stmt3);

                echo "<div class='alert alert-danger'>Invalid email or password.</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>Invalid email or password.</div>";
        }
    }
    ?>
    <form action="login.php" method="post">
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token); ?>">
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
  <div style="margin-top: 10px;">
    <a href="registration.php" class="btn btn-primary">Register</a>
</div>
</div>
</body>
</html>
