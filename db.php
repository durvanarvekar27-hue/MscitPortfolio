<?php
/* =====================================
   MS-CIT Portfolio Hub
   Database Configuration
===================================== */

$host = "127.0.0.1";
$username = "root";
$password = "";          // XAMPP default password
$database = "mscit_portfolio";
$port = 3307;

/* =====================================
   Create Database Connection
===================================== */

$conn = mysqli_connect($host, $username, $password, $database,$port);

/* =====================================
   Check Connection
===================================== */

if (!$conn) {
    die("Database Connection Failed: " . mysqli_connect_error());
}

/* =====================================
   Character Set
===================================== */

mysqli_set_charset($conn, "utf8");

/* =====================================
   Time Zone
===================================== */

date_default_timezone_set("Asia/Kolkata");

/* =====================================
   Website URL
===================================== */

define("SITE_URL", "http://localhost/Maaya-MSCIT-Portfolio");

/* =====================================
   Upload Paths
===================================== */

define("UPLOAD_STUDENTS", "uploads/students/");
define("UPLOAD_PROJECTS", "uploads/projects/");
define("UPLOAD_CANVA", "uploads/canva/");

?>