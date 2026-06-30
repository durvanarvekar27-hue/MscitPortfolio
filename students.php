<?php
require_once("db.php");

/* ===========================
        PAGINATION
=========================== */

$limit = 10;

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

if($page < 1){
    $page = 1;
}

$offset = ($page - 1) * $limit;

/* ===========================
        SEARCH
=========================== */

$search = "";

if(isset($_GET['search']) && !empty(trim($_GET['search'])))
{
    $search = mysqli_real_escape_string($conn, trim($_GET['search']));

    $countQuery = mysqli_query($conn,"
        SELECT COUNT(*) AS total
        FROM students
        WHERE full_name LIKE '%$search%'
        OR student_id LIKE '%$search%'
    ");

    $countData = mysqli_fetch_assoc($countQuery);
    $totalStudents = $countData['total'];

    $students = mysqli_query($conn,"
        SELECT *
        FROM students
        WHERE full_name LIKE '%$search%'
        OR student_id LIKE '%$search%'
        ORDER BY created_at DESC
        LIMIT $offset,$limit
    ");
}
else
{
    $countQuery = mysqli_query($conn,"
        SELECT COUNT(*) AS total
        FROM students
    ");

    $countData = mysqli_fetch_assoc($countQuery);
    $totalStudents = $countData['total'];

    $students = mysqli_query($conn,"
        SELECT *
        FROM students
        ORDER BY created_at DESC
        LIMIT $offset,$limit
    ");
}

$totalPages = ceil($totalStudents / $limit);
?>

<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta
name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Students | MS-CIT Portfolio Hub</title>

<link rel="stylesheet" href="css/style.css">

<link
href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
rel="stylesheet">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

</head>

<body>

<!-- ===========================
        HEADER
=========================== -->

<header>

<nav class="navbar">

<div class="logo">

<img
src="images/students/logo.png"
alt="Logo">

<h2>

MS-CIT Portfolio Hub

</h2>

</div>

<ul
class="nav-links"
id="navLinks">

<li>

<a href="index.php">

Home

</a>

</li>

<li>

<a href="about.php">

About

</a>

</li>

<li>

<a
href="students.php"
class="active">

Students

</a>

</li>

<li>

<a href="contact.php">

Contact

</a>

</li>

<li>

<a
href="admin/login.php"
class="admin-btn">

<i class="fa-solid fa-user-shield"></i>

Admin

</a>

</li>

</ul>

<div class="menu-btn">

<i class="fa-solid fa-bars"></i>

</div>

</nav>

</header>

<section class="page-hero">

    <div class="container">

        <h1>Our Students</h1>

        <p>
            Explore all MS-CIT students and their digital portfolios.
        </p>

        <div class="student-count">

            <h3>
                Total Students :
                <?php echo $totalStudents; ?>
            </h3>

        </div>

    </div>

</section>

<!-- ===========================
        SEARCH SECTION
=========================== -->

<section class="search-section">

<div class="container">

<form action="students.php" method="GET" class="search-form">

<input
type="text"
name="search"
placeholder="Search by Student Name or Student ID..."
value="<?php echo htmlspecialchars($search); ?>">

<button type="submit">

<i class="fa-solid fa-magnifying-glass"></i>

Search

</button>

<?php
if(!empty($search))
{
?>

<a href="students.php" class="clear-btn">

Clear

</a>

<?php
}
?>

</form>

</div>

</section>

<!-- ===========================
        STUDENTS SECTION
=========================== -->

<section class="students-section">

<div class="container">

<div class="section-title">

<h2>Our Students</h2>

<p>

Browse all MS-CIT students and explore their portfolios.

</p>

</div>

<div class="student-grid">

<?php

if(mysqli_num_rows($students)>0)
{

while($student=mysqli_fetch_assoc($students))
{

?>

<div class="student-card">

<?php

if(!empty($student['profile_image']) &&
file_exists($student['profile_image']))
{

?>

<img
src="<?php echo $student['profile_image']; ?>"
alt="<?php echo htmlspecialchars($student['full_name']); ?>">

<?php

}
else
{

?>

<img
src="images/default/student.png"
alt="Student">

<?php

}

?>

<div class="student-content">

<h3>

<?php echo htmlspecialchars($student['full_name']); ?>

</h3>

<p>

<strong>Student ID :</strong>

<?php echo htmlspecialchars($student['student_id']); ?>

</p>

<?php

if(!empty($student['email']))
{

?>

<p>

<strong>Email :</strong>

<?php echo htmlspecialchars($student['email']); ?>

</p>

<?php

}

?>

<?php

if(!empty($student['skills']))
{

?>

<p>

<strong>Skills :</strong>

<?php

echo htmlspecialchars(substr($student['skills'],0,60));

if(strlen($student['skills'])>60)
{
echo "...";
}

?>

</p>

<?php

}

?>

<a
href="student.php?id=<?php echo $student['id']; ?>"
class="btn">

View Portfolio

</a>

</div>

</div>

<?php

}

}
else
{

?>

<div class="no-students">

<h2>No Students Found</h2>

<p>

No student records are available.

</p>

</div>

<?php

}

?>

</div>

</div>

</section>
<!-- ===================================
            PAGINATION
=================================== -->

<!-- ===========================
        PAGINATION
=========================== -->

<?php if($totalPages > 1){ ?>

<section class="pagination-section">

<div class="container">

<div class="pagination">

<?php

if($page > 1)
{

?>

<a href="?page=<?php echo $page-1; ?>&search=<?php echo urlencode($search); ?>">

&laquo; Previous

</a>

<?php

}

for($i=1;$i<=$totalPages;$i++)
{

?>

<a
href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>"
class="<?php echo ($page==$i)?'active':''; ?>">

<?php echo $i; ?>

</a>

<?php

}

if($page < $totalPages)
{

?>

<a href="?page=<?php echo $page+1; ?>&search=<?php echo urlencode($search); ?>">

Next &raquo;

</a>

<?php

}

?>

</div>

</div>

</section>

<?php } ?>
<!-- ===========================
            FOOTER
=========================== -->

<footer>

<div class="container footer-container">

    <!-- About -->

    <div class="footer-about">

        <h2>MS-CIT Portfolio Hub</h2>

        <p>

        A professional platform to showcase
        students' creativity, technical skills,
        projects and achievements.

        </p>

    </div>

    <!-- Quick Links -->

    <div class="footer-links">

        <h3>Quick Links</h3>

        <a href="index.php">Home</a>

        <a href="about.php">About</a>

        <a href="students.php">Students</a>

        <a href="contact.php">Contact</a>

    </div>

    <!-- Contact -->

    <div class="footer-contact">

        <h3>Contact</h3>

        <p>

        Email :
        info@mscitportfolio.com

        </p>

        <p>

        Phone :
        +91 9876543210

        </p>

    </div>

    <!-- Social -->

    <div class="footer-social">

        <h3>Follow Us</h3>

        <a href="#">
            <i class="fab fa-facebook-f"></i>
        </a>

        <a href="#">
            <i class="fab fa-instagram"></i>
        </a>

        <a href="#">
            <i class="fab fa-linkedin-in"></i>
        </a>

        <a href="#">
            <i class="fab fa-youtube"></i>
        </a>

    </div>

</div>

<div class="copyright">

&copy; <?php echo date("Y"); ?>

MS-CIT Portfolio Hub

| All Rights Reserved.

</div>

</footer>

<!-- ===========================
        SCROLL TO TOP
=========================== -->

<button id="topBtn">

<i class="fa-solid fa-arrow-up"></i>

</button>

<!-- ===========================
        JAVASCRIPT
=========================== -->

<script>

// Mobile Menu

const menuBtn=document.querySelector(".menu-btn");
const navLinks=document.querySelector("#navLinks");

menuBtn.addEventListener("click",()=>{

navLinks.classList.toggle("active");

});

// Scroll Button

const topBtn=document.getElementById("topBtn");

window.onscroll=function(){

if(document.body.scrollTop>300 ||
document.documentElement.scrollTop>300)
{

topBtn.style.display="block";

}
else
{

topBtn.style.display="none";

}

};

topBtn.onclick=function(){

window.scrollTo({

top:0,

behavior:"smooth"

});

};

</script>

</body>

</html>