<?php
        include 'functions.php';
        authUser();
        checkAuth();
?>
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
        <h1> administrator panel</h1>
        <a href="?logout">Logout</a>
    </div>
    <a href="createProduct.php" class="p_create_link">create new product</a>
    <div class="products">
        <?php
        renderProductsA();
        ?>
    </div>


</div>


</body>
</html>
