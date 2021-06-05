<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link href="public/css/style.css" type="text/css" rel="stylesheet">
</head>
<body>

<div class="gallery_wrapper">
    <h1> Hello</h1>
    <div class="gallery">
        <?php
        include 'pastImages.php';
        createImg();
        ?>
    </div>

    <form enctype="multipart/form-data" method="post">
        <input type="file" name="pic">
        <input type="submit" name="pic">
    </form>
</div>


</body>
</html>