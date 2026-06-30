<?php
session_start();
require_once("../db.php");


/* ===========================
    SECURITY CHECK
=========================== */

if(!isset($_SESSION['admin_login']))
{
    header("Location: login.php");
    exit;
}

/* ===========================
    COUNTS
=========================== */

$studentCount = mysqli_num_rows(mysqli_query($conn,"SELECT id FROM students"));
$projectCount = mysqli_num_rows(mysqli_query($conn,"SELECT id FROM projects"));
$adminName = $_SESSION['admin_user'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>

    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>

<body>

<!-- ===========================
        SIDEBAR + DASHBOARD
=========================== -->

<div class="admin-wrapper">
    <!-- MAIN CONTENT -->
     <?php include("includes/sidebar.php"); ?>
    <div class="main-content">

        <h1>Dashboard</h1>

        <div class="card-container">

            <div class="card">
                <i class="fa fa-users"></i>
                <h3>Total Students</h3>
                <p><?php echo $studentCount; ?></p>
            </div>

            <div class="card">
                <i class="fa fa-folder"></i>
                <h3>Total Projects</h3>
                <p><?php echo $projectCount; ?></p>
            </div>

        </div>

    </div>

</div>

</body>
</html>