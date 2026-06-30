<?php


/* ===========================
   SECURITY CHECK
=========================== */

if(!isset($_SESSION['admin_login']))
{
    header("Location: login.php");
    exit;
}

/* ===========================
   ADMIN NAME (fallback safe)
=========================== */

$adminName = isset($_SESSION['admin_user']) ? $_SESSION['admin_user'] : "Admin";
?>

<div class="sidebar">

    <h2>MS-CIT Admin</h2>

    <p>Welcome, <?php echo $adminName; ?></p>

    <a href="dashboard.php">
        <i class="fa fa-dashboard"></i> Dashboard
    </a>

    <a href="add-student.php">
        <i class="fa fa-user-plus"></i> Add Student
    </a>

    <a href="students.php">
        <i class="fa fa-users"></i> Students
    </a>

    <a href="add-project.php">
        <i class="fa fa-folder-plus"></i> Add Project
    </a>

    <a href="projects.php">
        <i class="fa fa-folder"></i> Projects
    </a>

        <a href="../students.php" target="_blank">
        <i class="fa fa-globe"></i> View Website
    </a>

    <a href="logout.php">
        <i class="fa fa-sign-out"></i> Logout
    </a>

</div>