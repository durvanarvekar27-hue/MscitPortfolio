<?php
$filename = time() . "_" . $_FILES['file']['name'];

$folder = "uploads/students/";
$filepath = $folder . $filename;

if (!file_exists($folder)) {
    mkdir($folder, 0777, true);
}

move_uploaded_file($_FILES['file']['tmp_name'], $filepath);
?>