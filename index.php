<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link href="public/css/style.css" type="text/css" rel="stylesheet">
</head>
<body>

<div class="gallery_wrapper">
    <div class="header">
        <h1> Hello</h1>
        <a class="adm_link" href="admin.php">admin area</a>
    </div>
    <div class="gallery">
        <?php
        include 'functions.php';
        createGallery();
        ?>
    </div>


</div>


</body>
</html>