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

$message = "";

/* ===========================
    CREATE FOLDERS SAFELY
=========================== */

$profileDir = "../uploads/students/profile/";
$coverDir   = "../uploads/students/cover/";
$resumeDir  = "../uploads/students/resume/";

if(!file_exists($profileDir)) mkdir($profileDir, 0777, true);
if(!file_exists($coverDir))   mkdir($coverDir, 0777, true);
if(!file_exists($resumeDir))  mkdir($resumeDir, 0777, true);

/* ===========================
    FORM SUBMIT
=========================== */

if(isset($_POST['submit']))
{
    $student_id = mysqli_real_escape_string($conn, $_POST['student_id']);
    $full_name  = mysqli_real_escape_string($conn, $_POST['full_name']);
    $phone      = mysqli_real_escape_string($conn, $_POST['phone']);
    $about      = mysqli_real_escape_string($conn, $_POST['about']);
    $skills     = mysqli_real_escape_string($conn, $_POST['skills']);

    /* ===========================
        DUPLICATE CHECK
    =========================== */

    $check = mysqli_query($conn, "SELECT id FROM students WHERE student_id='$student_id'");

    if(mysqli_num_rows($check) > 0)
    {
        $message = "❌ Student ID already exists!";
    }
    else
    {
        /* ===========================
            FILE UPLOAD
        =========================== */

        $profile_image = "";
        $cover_image   = "";
        $resume        = "";

        if(!empty($_FILES['profile_image']['name']))
        {
            $profile_image = "uploads/students/profile/" . time() . "_" . $_FILES['profile_image']['name'];
            move_uploaded_file($_FILES['profile_image']['tmp_name'], "../" . $profile_image);
        }

        if(!empty($_FILES['cover_image']['name']))
        {
            $cover_image = "uploads/students/cover/" . time() . "_" . $_FILES['cover_image']['name'];
            move_uploaded_file($_FILES['cover_image']['tmp_name'], "../" . $cover_image);
        }

        if(!empty($_FILES['resume']['name']))
        {
            $resume = "uploads/students/resume/" . time() . "_" . $_FILES['resume']['name'];
            move_uploaded_file($_FILES['resume']['tmp_name'], "../" . $resume);
        }

        /* ===========================
            INSERT QUERY
        =========================== */

        $query = mysqli_query($conn,"
            INSERT INTO students
            (student_id, full_name, phone, about, skills, profile_image)
            VALUES
            ('$student_id','$full_name','$phone','$about','$skills','$profile_image')
        ");

        if($query)
        {
            echo "<script>
                    alert('Student Added Successfully!');
                    window.location.href='add-student.php';
                  </script>";
            exit;
        }
        else
        {
            $message = "❌ Error: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add Student</title>

    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>

<body>

<div class="admin-wrapper">

    <!-- SIDEBAR -->
    <?php include("includes/sidebar.php"); ?>

    <!-- MAIN CONTENT -->
    <div class="main-content">

        <h1>Add Student</h1>

        <?php if($message != "") { ?>
            <p style="color:red;"><?php echo $message; ?></p>
        <?php } ?>

        <form method="POST" enctype="multipart/form-data">

            <input type="text" name="student_id" placeholder="Student ID" required><br><br>

            <input type="text" name="full_name" placeholder="Full Name" required><br><br>

            <input type="text" name="phone" placeholder="Phone"><br><br>

            <textarea name="about" placeholder="About Student"></textarea><br><br>

            <textarea name="skills" placeholder="Skills"></textarea><br><br>

            <label>Profile Image</label>
            <input type="file" name="profile_image"><br><br>

            <!-- <label>Cover Image</label>
            <input type="file" name="cover_image"><br><br> -->

            <!-- <label>Resume (PDF)</label>
            <input type="file" name="resume"><br><br> -->

            <button type="submit" name="submit">Add Student</button>

        </form>

    </div>

</div>

</body>
</html>