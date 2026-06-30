<?php
require_once("db.php");

/* ===============================
   FEATURED STUDENTS
================================= */

$featuredStudents = mysqli_query($conn, "
SELECT *
FROM students
ORDER BY id DESC
LIMIT 4
");

/* ===============================
   PROJECT CATEGORY COUNT
================================= */

$canvaCount = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM projects WHERE category='Canva'"));
$photoshopCount = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM projects WHERE category='Photoshop'"));
$coreldrawCount = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM projects WHERE category='CorelDRAW'"));
$wordCount = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM projects WHERE category='MS Word'"));
$excelCount = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM projects WHERE category='MS Excel'"));
$pptCount = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM projects WHERE category='PowerPoint'"));
$webCount = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM projects WHERE category='Web Development'"));
$programmingCount = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM projects WHERE category='Programming'"));

/* ===============================
   TOTAL STUDENTS
================================= */

$totalStudentsQuery = mysqli_query($conn, "
SELECT COUNT(*) AS total
FROM students
");

$totalStudents = mysqli_fetch_assoc($totalStudentsQuery)['total'];

/* ===============================
   TOTAL PROJECTS
================================= */

$totalProjectsQuery = mysqli_query($conn, "
SELECT COUNT(*) AS total
FROM projects
");

$totalProjects = mysqli_fetch_assoc($totalProjectsQuery)['total'];

/* ===============================
   WEBSITE SETTINGS (Optional)
================================= */

$settings = [];

$settingQuery = mysqli_query($conn, "
SELECT *
FROM settings
LIMIT 1
");

if ($settingQuery && mysqli_num_rows($settingQuery) > 0) {
    $settings = mysqli_fetch_assoc($settingQuery);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>

<?php
echo !empty($settings['site_name'])
? $settings['site_name']
: "MS-CIT Portfolio Hub";
?>

</title>

<link rel="stylesheet"
href="css/style.css">

<link rel="preconnect"
href="https://fonts.googleapis.com">

<link rel="preconnect"
href="https://fonts.gstatic.com"
crossorigin>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
rel="stylesheet">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

</head>

<body>

<!-- ==========================
        HEADER
========================== -->

<header>

<nav class="navbar">

<div class="logo">

<img
src="<?php
echo !empty($settings['logo'])
? $settings['logo']
: 'images/students/logo.png';
?>"

alt="Logo">

<h2>

<?php
echo !empty($settings['site_name'])
? $settings['site_name']
: "MS-CIT Portfolio Hub";
?>

</h2>

</div>

<ul class="nav-links" id="navLinks">

<li>
<a href="index.php" class="active">
Home
</a>
</li>

<li>
<a href="about.php">
About
</a>
</li>

<li>
<a href="students.php">
Students
</a>
</li>

<li>
<a href="contact.php">
Contact
</a>
</li>

<li>

<!-- <a href="admin/login.php"
class="admin-btn">

<i class="fa-solid fa-user-shield"></i>

Admin

</a> -->

</li>

</ul>

<div class="menu-btn">

<i class="fa-solid fa-bars"></i>

</div>

</nav>

</header>



<!-- ==========================
        HERO SECTION
========================== -->

<section class="hero">

    <div class="hero-content">

        <span class="welcome-text">
            <h2>Welcome to</h2>
        </span>

        <h1>
            MAAYA MS-CIT Portfolio Hub
        </h1>

        <p>

            A modern platform to showcase
            students' creativity, technical skills,
            and project work in one place.

        </p>

        <div class="hero-buttons">

            <a href="students.php" class="btn">
                Explore Students
            </a>

            <a href="about.php" class="btn-outline">
                Learn More
            </a>

        </div>

    </div>

    <div class="hero-image">

        <img src="images/students/banner.png"
        alt="Hero Image">

    </div>

</section>

<!-- ==========================
     HERO SHAPES (Optional)
========================== -->

<div class="hero-shape shape1"></div>

<div class="hero-shape shape2"></div>

<!-- ==========================
        ABOUT SECTION
========================== -->

<section class="about">

    <div class="container">

        <div class="section-title">

            <h2>About MS-CIT Portfolio Hub</h2>

            <p>
                MS-CIT Portfolio Hub is a platform where students can
                showcase their learning journey, creative projects,
                technical skills, and achievements in one place.
            </p>

        </div>

        <div class="about-content">

            <div class="about-image">

                <img src="images/students/banner1.png" alt="About">

            </div>

            <div class="about-text">

                <h3>Empowering Students Through Digital Portfolios</h3>

                <p>

                    Our mission is to provide every student with a
                    professional online portfolio where they can
                    present their MS-CIT projects, creativity,
                    technical knowledge, and achievements.

                </p>

                <a href="about.php" class="btn">
                    Read More
                </a>

            </div>

        </div>

    </div>

</section>

<!-- ==========================
        WHY CHOOSE US
========================== -->

<section class="features">

    <div class="container">

        <div class="section-title">

            <h2>Why Choose Our Institute?</h2>

            <p>
                We focus on practical learning, creativity,
                and professional portfolio development.
            </p>

        </div>

        <div class="feature-grid">

            <div class="feature-card">

                <i class="fa-solid fa-laptop-code"></i>

                <h3>Practical Learning</h3>

                <p>
                    Hands-on assignments and real-world projects.
                </p>

            </div>

            <div class="feature-card">

                <i class="fa-solid fa-award"></i>

                <h3>Certified Course</h3>

                <p>
                    Government-recognized MS-CIT certification.
                </p>

            </div>

            <div class="feature-card">

                <i class="fa-solid fa-user-graduate"></i>

                <h3>Student Portfolio</h3>

                <p>
                    Every student gets a professional online portfolio.
                </p>

            </div>

            <div class="feature-card">

                <i class="fa-solid fa-lightbulb"></i>

                <h3>Creative Projects</h3>

                <p>
                    Showcase Canva, Office, Web and Design projects.
                </p>

            </div>

        </div>

    </div>

</section>
<!-- ==========================
      FEATURED STUDENTS
========================== -->

<section class="students">

    <div class="container">

        <div class="section-title">
            <h2>Featured Students</h2>
            <p>Explore some of our talented students and their portfolios.</p>
        </div>

        <div class="student-grid">

        <?php
        if(mysqli_num_rows($featuredStudents) > 0)
        {
            while($student = mysqli_fetch_assoc($featuredStudents))
            {
        ?>

        <div class="student-card">

            <?php
            if(!empty($student['profile_image']))
            {
            ?>
                <img src="<?php echo $student['profile_image']; ?>"
                     alt="<?php echo $student['full_name']; ?>">
            <?php
            }
            else
            {
            ?>
                <img src="images/default/student.png"
                     alt="Student">
            <?php
            }
            ?>

            <h3><?php echo $student['full_name']; ?></h3>

            <span>
                Student ID :
                <?php echo $student['student_id']; ?>
            </span>

            <br><br>

            <a href="student.php?id=<?php echo $student['id']; ?>"
               class="btn">
                View Portfolio
            </a>

        </div>

        <?php
            }
        }
        else
        {
            echo "<h3>No Students Found</h3>";
        }
        ?>

        </div>

        <div style="text-align:center;margin-top:40px;">

            <a href="students.php" class="btn">
                View All Students
            </a>

        </div>

    </div>

</section>
<!-- ==========================
        WHY CHOOSE US
========================== -->

<section class="features">

    <div class="container">

        <div class="section-title">
            <h2>Why Choose Our Institute?</h2>
            <p>
                We focus on practical learning, creativity,
                and professional portfolio development.
            </p>
        </div>

        <div class="feature-grid">

            <div class="feature-card">
                <i class="fa-solid fa-laptop-code"></i>
                <h3>Practical Learning</h3>
                <p>Hands-on assignments and real-world projects.</p>
            </div>

            <div class="feature-card">
                <i class="fa-solid fa-award"></i>
                <h3>Certified Course</h3>
                <p>Government-recognized MS-CIT certification.</p>
            </div>

            <div class="feature-card">
                <i class="fa-solid fa-user-graduate"></i>
                <h3>Student Portfolio</h3>
                <p>Professional digital portfolio for every student.</p>
            </div>

            <div class="feature-card">
                <i class="fa-solid fa-lightbulb"></i>
                <h3>Creative Projects</h3>
                <p>Canva, Office, Web Development and Design Projects.</p>
            </div>

        </div>

    </div>

</section>

<!-- ==========================
      PROJECT CATEGORIES
========================== -->

<section class="projects">

<div class="container">

<div class="section-title">

<h2>Project Categories</h2>

<p>
Explore different MS-CIT practical assignments.
</p>

</div>

<div class="project-grid">

<div class="project-card">
<i class="fa-solid fa-palette"></i>
<h3>Canva</h3>
<span><?php echo $canvaCount; ?> Projects</span>
</div>

<div class="project-card">
<i class="fa-solid fa-image"></i>
<h3>Photoshop</h3>
<span><?php echo $photoshopCount; ?> Projects</span>
</div>

<div class="project-card">
<i class="fa-solid fa-pen-ruler"></i>
<h3>CorelDRAW</h3>
<span><?php echo $coreldrawCount; ?> Projects</span>
</div>

<div class="project-card">
<i class="fa-solid fa-file-word"></i>
<h3>MS Word</h3>
<span><?php echo $wordCount; ?> Projects</span>
</div>

<div class="project-card">
<i class="fa-solid fa-file-excel"></i>
<h3>MS Excel</h3>
<span><?php echo $excelCount; ?> Projects</span>
</div>

<div class="project-card">
<i class="fa-solid fa-file-powerpoint"></i>
<h3>PowerPoint</h3>
<span><?php echo $pptCount; ?> Projects</span>
</div>

<div class="project-card">
<i class="fa-solid fa-globe"></i>
<h3>Web Development</h3>
<span><?php echo $webCount; ?> Projects</span>
</div>

<div class="project-card">
<i class="fa-solid fa-laptop-code"></i>
<h3>Programming</h3>
<span><?php echo $programmingCount; ?> Projects</span>
</div>

</div>

</div>

</section>

<!-- ==========================
      CONTACT CTA
========================== -->

<section class="contact-cta">

<div class="container">

<h2>Ready to Explore Student Portfolios?</h2>

<p>
Discover creativity, technical knowledge,
and practical projects developed by our students.
</p>

<a href="students.php" class="btn">
Explore Students
</a>

</div>

</section>
<!-- ===================================
                FOOTER
=================================== -->

<footer>

<div class="container footer-container">

    <!-- About -->

    <div class="footer-about">

        <h2>
            <?php
            echo !empty($settings['site_name'])
            ? $settings['site_name']
            : "MS-CIT Portfolio Hub";
            ?>
        </h2>

        <p>

        <?php

        if(!empty($settings['footer_description']))
        {
            echo $settings['footer_description'];
        }
        else
        {
            echo "A professional platform to showcase students' projects, creativity and technical skills.";
        }

        ?>

        </p>

    </div>

    <!-- Quick Links -->

    <div class="footer-links">

        <h3>Quick Links</h3>

        <a href="index.php">Home</a>

        <a href="about.php">About</a>

        <a href="students.php">Students</a>

        <a href="contact.php">Contact</a>

        <a href="admin/login.php">Admin Login</a>

    </div>

    <!-- Contact -->

    <div class="footer-contact">

        <h3>Contact</h3>

        <p>

        <?php

        echo !empty($settings['email'])

        ? $settings['email']

        : "info@mscitportfolio.com";

        ?>

        </p>

        <p>

        <?php

        echo !empty($settings['phone'])

        ? $settings['phone']

        : "+91 9876543210";

        ?>

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

© <?php echo date("Y"); ?>

<?php

echo !empty($settings['site_name'])

? $settings['site_name']

: "MS-CIT Portfolio Hub";

?>

| All Rights Reserved.

</div>

</footer>

<!-- ==========================
        MOBILE MENU
========================== -->

<script>

const menuBtn=document.querySelector(".menu-btn");

const navLinks=document.querySelector("#navLinks");

menuBtn.addEventListener("click",()=>{

navLinks.classList.toggle("active");

});

</script>

</body>

</html>