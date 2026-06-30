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
    FILTER (OPTIONAL)
=========================== */

$filter = "";
$where = "1";

if(isset($_GET['category']) && $_GET['category'] != "")
{
    $category = mysqli_real_escape_string($conn, $_GET['category']);
    $where = "category='$category'";
}

/* ===========================
    FETCH PROJECTS
=========================== */

$query = mysqli_query($conn, "
    SELECT * FROM projects
    WHERE $where
    ORDER BY id DESC
");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Projects List</title>

    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>

<body>

<div class="admin-wrapper">
    <?php include("includes/sidebar.php"); ?>

    <!-- MAIN -->
    <div class="main-content">

        <h1>Projects List</h1>

        <!-- FILTER -->
        <form method="GET" style="margin-bottom:20px;">

            <select name="category">
                <option value="">All Categories</option>
                <option value="Canva">Canva</option>
                <option value="Excel">Excel</option>
                <option value="Word">Word</option>
                <option value="PowerPoint">PowerPoint</option>
                <option value="Photoshop">Photoshop</option>
                <option value="CorelDRAW">CorelDRAW</option>
                <option value="Webpage">Webpage</option>
            </select>

            <button type="submit">Filter</button>

        </form>

        <!-- TABLE -->
        <table>

            <tr>
                <th>ID</th>
                <th>Student ID</th>
                <th>Category</th>
                <th>Title</th>
                <th>Type</th>
                <th>File</th>
                <th>Actions</th>
            </tr>

            <?php while($row = mysqli_fetch_assoc($query)) { ?>

            <tr>

                <td><?php echo $row['id']; ?></td>

                <td><?php echo $row['student_id']; ?></td>

                <td><?php echo $row['category']; ?></td>

                <td><?php echo $row['title']; ?></td>

                <td><?php echo $row['file_type']; ?></td>

                <td>
                    <a href="../<?php echo $row['file_path']; ?>" target="_blank">
                        View
                    </a>
                </td>

                <td>

                    <a href="edit-project.php?id=<?php echo $row['id']; ?>" class="btn-edit">
                        Edit
                    </a>

                    <a href="delete-project.php?id=<?php echo $row['id']; ?>"
                       onclick="return confirm('Delete this project?')"
                       class="btn-delete">
                        Delete
                    </a>

                </td>

            </tr>

            <?php } ?>

        </table>

    </div>

</div>

</body>
</html>