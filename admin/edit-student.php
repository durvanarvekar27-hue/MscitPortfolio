<?php
session_start();
require_once("../db.php");

/* ===========================
    SECURITY CHECK
=========================== */
if(!isset($_SESSION['admin_login'])) {
    header("Location: login.php");
    exit;
}

/* ===========================
    GET STUDENT ID
=========================== */
if(!isset($_GET['id'])) {
    die("Invalid Request");
}

$id = intval($_GET['id']);

/* ===========================
    FETCH EXISTING DATA
=========================== */
$query = mysqli_query($conn, "SELECT * FROM students WHERE id=$id");
$student = mysqli_fetch_assoc($query);

if(!$student) {
    die("Student Not Found");
}

/* ===========================
    MESSAGE
=========================== */
$message = "";

/* ===========================
    UPDATE FORM
=========================== */
if(isset($_POST['update'])) {

    $student_id = mysqli_real_escape_string($conn, $_POST['student_id']);
    $full_name  = mysqli_real_escape_string($conn, $_POST['full_name']);
    $email      = mysqli_real_escape_string($conn, $_POST['email']);
    $phone      = mysqli_real_escape_string($conn, $_POST['phone']);
    $about      = mysqli_real_escape_string($conn, $_POST['about']);
    $skills     = mysqli_real_escape_string($conn, $_POST['skills']);

    /* ===========================
        OLD VALUES (IMPORTANT)
    =========================== */
    $profile_image = $student['profile_image'];
    $cover_image   = $student['cover_image'];
    $resume        = $student['resume'];

    /* ===========================
        PROFILE IMAGE UPLOAD
    =========================== */
    if(!empty($_FILES['profile_image']['name'])) {

        $profile_image_name = time() . "_" . $_FILES['profile_image']['name'];
        $tmp = $_FILES['profile_image']['tmp_name'];

        $folder = "../uploads/students/profile/";

        if(!file_exists($folder)) {
            mkdir($folder, 0777, true);
        }

        move_uploaded_file($tmp, $folder . $profile_image_name);

        $profile_image = "uploads/students/profile/" . $profile_image_name;
    }

    /* ===========================
        COVER IMAGE UPLOAD
    =========================== */
    if(!empty($_FILES['cover_image']['name'])) {

        $cover_image_name = time() . "_" . $_FILES['cover_image']['name'];
        $tmp = $_FILES['cover_image']['tmp_name'];

        $folder = "../uploads/students/cover/";

        if(!file_exists($folder)) {
            mkdir($folder, 0777, true);
        }

        move_uploaded_file($tmp, $folder . $cover_image_name);

        $cover_image = "uploads/students/cover/" . $cover_image_name;
    }

    /* ===========================
        RESUME UPLOAD
    =========================== */
    if(!empty($_FILES['resume']['name'])) {

        $resume_name = time() . "_" . $_FILES['resume']['name'];
        $tmp = $_FILES['resume']['tmp_name'];

        $folder = "../uploads/students/resume/";

        if(!file_exists($folder)) {
            mkdir($folder, 0777, true);
        }

        move_uploaded_file($tmp, $folder . $resume_name);

        $resume = "uploads/students/resume/" . $resume_name;
    }

    /* ===========================
        UPDATE QUERY
    =========================== */
    $update = mysqli_query($conn,"
        UPDATE students SET
        student_id='$student_id',
        full_name='$full_name',
        email='$email',
        phone='$phone',
        about='$about',
        skills='$skills',
        profile_image='$profile_image',
        cover_image='$cover_image',
        resume='$resume'
        WHERE id=$id
    ");

    if($update) {
        $message = "Student Updated Successfully!";
    } else {
        $message = "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Student</title>

    <link rel="stylesheet" href="../css/admin.css">
</head>

<body>

<div class="admin-wrapper">

    <?php include("includes/sidebar.php"); ?>

    <div class="main-content">

        <h1>Edit Student</h1>

        <?php if(!empty($message)) { ?>
            <p class="success"><?php echo $message; ?></p>
        <?php } ?>

        <form method="POST" enctype="multipart/form-data">

            <input type="text" name="student_id"
                   value="<?php echo $student['student_id']; ?>" required><br>

            <input type="text" name="full_name"
                   value="<?php echo $student['full_name']; ?>" required><br>

            <input type="email" name="email"
                   value="<?php echo $student['email']; ?>"><br>

            <input type="text" name="phone"
                   value="<?php echo $student['phone']; ?>"><br>

            <textarea name="about"><?php echo $student['about']; ?></textarea><br>

            <textarea name="skills"><?php echo $student['skills']; ?></textarea><br>

            <label>Profile Image</label>
            <input type="file" name="profile_image"><br>

            <label>Cover Image</label>
            <input type="file" name="cover_image"><br>

            <label>Resume</label>
            <input type="file" name="resume"><br>

            <button type="submit" name="update">Update Student</button>

        </form>

    </div>

</div>

</body>
</html>