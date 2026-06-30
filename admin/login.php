<?php
session_start();
require_once("../db.php");

$error = "";

/* ===========================
    LOGIN PROCESS
=========================== */

if(isset($_POST['login']))
{
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $query = mysqli_query($conn,"
        SELECT * FROM admin
        WHERE username='$username'
        LIMIT 1
    ");

    if(mysqli_num_rows($query) == 1)
    {
        $admin = mysqli_fetch_assoc($query);

        // plain password (we will improve later with hash)
        if($password == $admin['password'])
        {
            $_SESSION['admin_login'] = true;
            $_SESSION['admin_user'] = $admin['username'];

            header("Location: dashboard.php");
            exit;
        }
        else
        {
            $error = "Invalid Password!";
        }
    }
    else
    {
        $error = "Invalid Username!";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>

<body>

<div class="login-box">

    <h2>Admin Login</h2>

    <?php if($error != "") { ?>
        <p style="color:red;"><?php echo $error; ?></p>
    <?php } ?>

    <form method="POST">

        <input type="text" name="username" placeholder="Username" required>

        <input type="password" name="password" placeholder="Password" required>

        <button type="submit" name="login">Login</button>

    </form>

</div>

</body>
</html>