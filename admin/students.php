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
    FETCH STUDENTS
=========================== */

$query = mysqli_query($conn, "SELECT * FROM students ORDER BY id DESC");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Students List</title>

    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>

<body>

<div class="admin-wrapper">
    <?php include("includes/sidebar.php"); ?>
    <!-- MAIN -->
    <div class="main-content">

        <h1>Students List</h1>

        <table class="table">

            <tr>
                <th>ID</th>
                <th>Student ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Actions</th>
            </tr>

            <?php while($row = mysqli_fetch_assoc($query)) { ?>

            <tr>

                <td><?php echo $row['id']; ?></td>

                <td><?php echo $row['student_id']; ?></td>

                <td><?php echo $row['full_name']; ?></td>

                <td><?php echo $row['email']; ?></td>

                <td><?php echo $row['phone']; ?></td>

                <td>

                    <a href="edit-student.php?id=<?php echo $row['id']; ?>" class="btn-edit">
                        Edit
                    </a>

                    <a href="delete-student.php?id=<?php echo $row['id']; ?>"
                       onclick="return confirm('Are you sure?')"
                       class="btn-delete">
                        Delete
                    </a>

                    <a href="../student.php?id=<?php echo $row['id']; ?>" target="_blank"
                       class="btn-view">
                        View
                    </a>

                </td>

            </tr>

            <?php } ?>

        </table>

    </div>

</div>

</body>
</html>