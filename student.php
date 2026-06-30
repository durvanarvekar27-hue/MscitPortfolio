<?php
require_once("db.php");

/* ===========================
   CHECK STUDENT ID
=========================== */
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid Student ID.");
}

$id = intval($_GET['id']);

/* ===========================
   GET STUDENT
=========================== */
$studentQuery = mysqli_query($conn, "
SELECT * FROM students
WHERE id = '$id'
LIMIT 1
");

if (mysqli_num_rows($studentQuery) == 0) {
    die("Student Not Found.");
}

$student = mysqli_fetch_assoc($studentQuery);

/* ===========================
   GET PROJECTS (ONLY ONCE)
=========================== */
$projectsQuery = mysqli_query($conn, "
SELECT * 
FROM projects
WHERE student_id = '".$student['student_id']."'
ORDER BY created_at DESC
");

/* ===========================
   PROJECT COUNT
=========================== */
$totalProjects = mysqli_num_rows($projectsQuery);

/* ===========================
   CATEGORY WISE COUNT
=========================== */
$categoryResult = mysqli_query($conn, "
SELECT category, COUNT(*) AS total
FROM projects
WHERE student_id='".$student['student_id']."'
GROUP BY category
");

$categoryCounts = [];

while ($row = mysqli_fetch_assoc($categoryResult)) {
    $categoryCounts[$row['category']] = $row['total'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta
name="viewport"
content="width=device-width, initial-scale=1.0">

<title>

<?php echo htmlspecialchars($student['full_name']); ?>

| Portfolio

</title>

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

<img src="images/students/logo.png">

<h2>MS-CIT Portfolio Hub</h2>

</div>

<ul class="nav-links" id="navLinks">

<li><a href="index.php">Home</a></li>

<li><a href="about.php">About</a></li>

<li><a href="students.php">Students</a></li>

<li><a href="contact.php">Contact</a></li>

</ul>

<div class="menu-btn">

<i class="fa-solid fa-bars"></i>

</div>

</nav>

</header>
<!-- ===========================
        PROFILE HEADER
=========================== -->

<section class="profile-header">

    <!-- Cover Image 

    <div class="cover-image">

        <?php if(!empty($student['cover_image']) && file_exists($student['cover_image'])) { ?>

            <img src="<?php echo $student['cover_image']; ?>"
                 alt="Cover Image">

        <?php } else { ?>

            <img src="images/default/cover.jpg"
                 alt="Default Cover">

        <?php } ?>-->

    </div>

    <div class="container">

        <div class="profile-info">

            <!-- Profile Image -->

            <div class="profile-photo">

                <?php if(!empty($student['profile_image']) && file_exists($student['profile_image'])) { ?>

                    <img src="<?php echo $student['profile_image']; ?>"
                         alt="<?php echo htmlspecialchars($student['full_name']); ?>">

                <?php } else { ?>

                    <img src="images/default/student.png"
                         alt="Student">

                <?php } ?>

            </div>

            <!-- Student Details -->

            <div class="profile-details">

                <h1><?php echo htmlspecialchars($student['full_name']); ?></h1>

                <p>

                    <strong>Student ID :</strong>

                    <?php echo htmlspecialchars($student['student_id']); ?>

                </p>

                <?php if(!empty($student['email'])) { ?>

                <p>

                    <strong>Email :</strong>

                    <?php echo htmlspecialchars($student['email']); ?>

                </p>

                <?php } ?>

                <?php if(!empty($student['phone'])) { ?>

                <p>

                    <strong>Phone :</strong>

                    <?php echo htmlspecialchars($student['phone']); ?>

                </p>

                <?php } ?>

                <!-- Resume Button -->

                <?php if(!empty($student['resume'])) { ?>

                    <a href="<?php echo $student['resume']; ?>"
                       class="btn"
                       target="_blank">

                        <i class="fa-solid fa-download"></i>

                        Download Resume

                    </a>

                <?php } ?>

            </div>

        </div>

    </div>

</section>
<!-- ===========================
        ABOUT & SKILLS
=========================== -->

<section class="profile-section">

<div class="container">

<div class="profile-grid">

<!-- About -->

<div class="profile-box">

<h2>

<i class="fa-solid fa-user"></i>

About Me

</h2>

<p>

<?php

if(!empty($student['about']))
{
    echo nl2br(htmlspecialchars($student['about']));
}
else
{
    echo "No information available.";
}

?>

</p>

</div>

<!-- Skills -->

<div class="profile-box">

<h2>

<i class="fa-solid fa-code"></i>

Skills

</h2>

<p>

<?php

if(!empty($student['skills']))
{
    echo nl2br(htmlspecialchars($student['skills']));
}
else
{
    echo "Skills not added.";
}

?>

</p>

</div>

</div>

<!-- Statistics -->

<div class="stats-grid">

    <div class="stat-card">
        <h2><?php echo $totalProjects; ?></h2>
        <p>Total Projects</p>
    </div>

    <div class="stat-card">
        <h2><?php echo $categoryCounts['Canva'] ?? 0; ?></h2>
        <p>Canva</p>
    </div>

    <div class="stat-card">
        <h2><?php echo $categoryCounts['Word'] ?? 0; ?></h2>
        <p>MS Word</p>
    </div>

    <div class="stat-card">
        <h2><?php echo $categoryCounts['Excel'] ?? 0; ?></h2>
        <p>MS Excel</p>
    </div>

    <div class="stat-card">
        <h2><?php echo $categoryCounts['PowerPoint'] ?? 0; ?></h2>
        <p>PowerPoint</p>
    </div>

    <div class="stat-card">
        <h2><?php echo $categoryCounts['Photoshop'] ?? 0; ?></h2>
        <p>Photoshop</p>
    </div>

    <div class="stat-card">
        <h2><?php echo $categoryCounts['CorelDRAW'] ?? 0; ?></h2>
        <p>CorelDRAW</p>
    </div>

    <div class="stat-card">
        <h2><?php echo $categoryCounts['Webpage'] ?? 0; ?></h2>
        <p>Web Development</p>
    </div>

</div>

</section>
<!-- ===========================
        PROJECTS SECTION
=========================== -->
<div class="project-grid">

<?php if ($totalProjects > 0) { ?>

    <?php while ($project = mysqli_fetch_assoc($projectsQuery)) { ?>

        <div class="project-card">

            <h3><?php echo htmlspecialchars($project['title']); ?></h3>

            <p><b>Category:</b> <?php echo htmlspecialchars($project['category']); ?></p>

            <p><b>File Type:</b> <?php echo htmlspecialchars($project['file_type']); ?></p>

            <p><b>Uploaded:</b> <?php echo date("d M Y", strtotime($project['created_at'])); ?></p>

            <?php if (!empty($project['file_path'])) { ?>

                <div class="project-buttons">

                    <a href="/Maaya-MSCIT-Portfolio/<?php echo ltrim($project['file_path'], './'); ?>" target="_blank">
                        View
                    </a>

                    <a href="<?php echo '/Maaya-MSCIT-Portfolio/' . ltrim($project['file_path'], '/'); ?>" download>
                        Download
                    </a>

                </div>

            <?php } ?>

        </div>

    <?php } ?>

<?php } else { ?>

    <div class="no-projects">
        <h2>No Projects Available</h2>
    </div>

<?php } ?>

</div>
</section>
<!-- ===================================
                FOOTER
=================================== -->
<footer>

    <div class="container footer-container">

        <!-- About -->

        <div class="footer-about">

            <h2>MS-CIT Portfolio Hub</h2>

            <p>
                A professional platform to showcase students'
                creativity, technical skills and project work.
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

                <i class="fa-solid fa-envelope"></i>

                info@mscitportfolio.com

            </p>

            <p>

                <i class="fa-solid fa-phone"></i>

                +91 9876543210

            </p>

        </div>

        <!-- Social -->

        <div class="footer-social">

            <h3>Follow Us</h3>

            <a href="#"><i class="fab fa-facebook-f"></i></a>

            <a href="#"><i class="fab fa-instagram"></i></a>

            <a href="#"><i class="fab fa-linkedin-in"></i></a>

            <a href="#"><i class="fab fa-youtube"></i></a>

        </div>

    </div>

    <div class="copyright">

        &copy; <?php echo date("Y"); ?>

        MS-CIT Portfolio Hub |

        All Rights Reserved.

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

const menuBtn = document.querySelector(".menu-btn");
const navLinks = document.querySelector("#navLinks");

menuBtn.addEventListener("click", () => {

    navLinks.classList.toggle("active");

});

// Scroll To Top

const topBtn = document.getElementById("topBtn");

window.addEventListener("scroll", function(){

    if(window.scrollY > 300)
    {
        topBtn.style.display = "block";
    }
    else
    {
        topBtn.style.display = "none";
    }

});

topBtn.addEventListener("click", function(){

    window.scrollTo({

        top:0,

        behavior:"smooth"

    });

});

</script>

</body>
</html>