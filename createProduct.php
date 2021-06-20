

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
        <a href="index.php"><h1> Hello</h1></a>
        <a class="adm_link" href="admin.php">admin area</a>
    </div>
    <div class="pop_add">
        <?php
        include 'functions.php';
        addProduct();
        ?>
    </div>
    </div>
</div>


</body>
</html>


