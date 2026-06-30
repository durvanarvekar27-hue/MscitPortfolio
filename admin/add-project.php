<?php
session_start();
include("../db.php");

$message = "";

if (isset($_POST['submit'])) {

    // TEXT FIELDS
    $student_id = $_POST['student_id'] ?? '';
    $category   = $_POST['category'] ?? '';
    $title      = $_POST['title'] ?? '';
    $file_type  = $_POST['file_type'] ?? '';

    // FILE CHECK
    if (!isset($_FILES['file']) || $_FILES['file']['error'] != 0) {
        $message = "File not uploaded properly!";
    } else {

        $fileName = $_FILES['file']['name'];
        $tmpName  = $_FILES['file']['tmp_name'];

        // unique file name
        $newFileName = time() . "_" . $fileName;

        // IMPORTANT: correct folder
        $folder = "../uploads/students/";

        if (!file_exists($folder)) {
            mkdir($folder, 0777, true);
        }

        $targetPath = $folder . $newFileName;

        // upload file
        if (move_uploaded_file($tmpName, $targetPath)) {

            // store CLEAN path for browser use
            $dbPath = "uploads/students/" . $newFileName;

            $insert = mysqli_query($conn, "
                INSERT INTO projects 
                (student_id, category, title, file_name, file_type, file_path)
                VALUES 
                ('$student_id', '$category', '$title', '$newFileName', '$file_type', '$dbPath')
            ");

            if ($insert) {
                $message = "Project uploaded successfully!!";
            } else {
                $message = "Database insert failed!";
            }

        } else {
            $message = "File upload failed!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add Project</title>

    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>

<body>

<div class="admin-wrapper">

    <?php include("includes/sidebar.php"); ?>

    <div class="main-content">

        <h1>Add Project</h1>

        <?php if (!empty($message)) { ?>
            <p style="color:green;">
                <?php echo $message; ?>
            </p>
        <?php } ?>

        <form method="POST" enctype="multipart/form-data">

            <input type="text" name="student_id" placeholder="Student ID (e.g. 101)" required><br><br>

            <select name="category" required>
                <option value="">Select Category</option>
                <option value="Canva">Canva</option>
                <option value="Excel">Excel</option>
                <option value="Word">Word</option>
                <option value="PowerPoint">PowerPoint</option>
                <option value="Photoshop">Photoshop</option>
                <option value="CorelDRAW">CorelDRAW</option>
                <option value="Webpage">Webpage</option>
            </select><br><br>

            <input type="text" name="title" placeholder="Project Title" required><br><br>

            <label>Upload File</label>
            <input type="file" name="file" required><br><br>

            <button type="submit" name="submit">Add Project</button>

        </form>

    </div>

</div>

</body>
</html>