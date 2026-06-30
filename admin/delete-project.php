<?php
session_start();
require_once("../db.php");

/* ===========================
    SECURITY CHECK
=========================== */

if (!isset($_SESSION['admin_login'])) {
    header("Location: login.php");
    exit;
}

/* ===========================
    GET PROJECT ID
=========================== */

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid Request");
}

$id = intval($_GET['id']);

/* ===========================
    FETCH PROJECT DATA
=========================== */

$query = mysqli_query($conn, "
    SELECT *
    FROM projects
    WHERE id = $id
    LIMIT 1
");

if (!$query) {
    die("Query Failed: " . mysqli_error($conn));
}

if (mysqli_num_rows($query) == 0) {
    die("Project Not Found");
}

$project = mysqli_fetch_assoc($query);

/* ===========================
    DELETE FILE FROM SERVER
=========================== */

$filePath = "../" . $project['file_name']; // 👈 IMPORTANT FIX

if (!empty($project['file_name']) && file_exists($filePath)) {
    unlink($filePath);
}

/* ===========================
    DELETE PROJECT FROM DB
=========================== */

$delete = mysqli_query($conn, "
    DELETE FROM projects
    WHERE id = $id
");

if ($delete) {
    header("Location: projects.php?msg=deleted");
    exit;
} else {
    echo "Error deleting project: " . mysqli_error($conn);
}
?>