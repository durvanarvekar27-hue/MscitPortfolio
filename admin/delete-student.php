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
    GET ID
=========================== */

if(!isset($_GET['id']))
{
    die("Invalid Request");
}

$id = intval($_GET['id']);

/* ===========================
    FETCH STUDENT DATA
=========================== */

$query = mysqli_query($conn, "SELECT * FROM students WHERE id=$id");

if(mysqli_num_rows($query) == 0)
{
    die("Student Not Found");
}

$student = mysqli_fetch_assoc($query);

/* ===========================
    DELETE FILES FROM SERVER
=========================== */

function deleteFile($path)
{
    if(!empty($path) && file_exists("../" . $path))
    {
        unlink("../" . $path);
    }
}

/* Profile, Cover, Resume delete */
deleteFile($student['profile_image']);
deleteFile($student['cover_image']);
deleteFile($student['resume']);

/* ===========================
    DELETE STUDENT PROJECTS
=========================== */

$student_id = $student['student_id'];

$projects = mysqli_query($conn, "SELECT * FROM projects WHERE student_id='$student_id'");

while($project = mysqli_fetch_assoc($projects))
{
    deleteFile($project['file_path']);
}

/* Delete projects from DB */
mysqli_query($conn, "DELETE FROM projects WHERE student_id='$student_id'");

/* ===========================
    DELETE STUDENT
=========================== */

$delete = mysqli_query($conn, "DELETE FROM students WHERE id=$id");

if($delete)
{
    header("Location: students.php?msg=deleted");
    exit;
}
else
{
    echo "Error deleting student: " . mysqli_error($conn);
}
?>