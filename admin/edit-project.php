<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Project</title>

<link rel="stylesheet" href="../css/admin.css">

<!-- Font Awesome -->
<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>
<body>

<!-- ================= SIDEBAR ================= -->
    <?php include("includes/sidebar.php"); ?>

<!-- ================= CONTENT ================= -->
<div class="admin-content">

    <h2>Edit Project</h2>

    <div class="form-box">

        <form>

            <!-- Hidden ID (future DB use) -->
            <input type="hidden" value="1">

            <label>Project Name</label>
            <input type="text" value="Portfolio Website">

            <label>Student Name</label>
            <input type="text" value="Rahul Patil">

                       <label>Category</label>
<select required>

    <option value="">-- Select Category --</option>

    <option value="word">Word</option>
    <option value="powerpoint">PowerPoint</option>
    <option value="excel">Excel</option>
    <option value="webpage">Webpage</option>
    <option value="canva">Canva</option>
    <option value="photoshop">Photoshop</option>
    <option value="coreldraw">CorelDraw</option>

</select>


            <label>Project File</label>
            <input type="file">

            <p style="font-size:13px; color:gray;">
                Current File: portfolio.pdf
            </p>

            <label>Description</label>
            <textarea rows="4">This is a portfolio website project built using HTML, CSS, JS.</textarea>

            <button type="submit">
                <i class="fas fa-save"></i> Update Project
            </button>

        </form>

    </div>

</div>

</body>
</html>