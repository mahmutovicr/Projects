<?php
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

        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, $sql);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_array($result, MYSQLI_ASSOC);

        if ($user && password_verify($password, $user["password"])) {
            session_regenerate_id(true);
            $_SESSION["user"] = $user["id"];
            header("Location: index.php");
            exit();
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
    <div><p>Not registered yet? <a href="registration.php">Register Here</a></p></div>
</div>
</body>
</html>
