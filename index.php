<?php include 'functions.php'; ?>
<?php
startSession();
authUser();
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
        <h1> Hello</h1>
        <a class="adm_link" href="admin.php">admin area</a>
        <a class="view_cart" href="viewCart.php">View cart</a>
        <div class="login_form"><?php authForm() ?></div>

    </div>
    <div class="gallery">
        <?php
        createGallery();
        cartAdd();
        ?>
        <div class="cart_view"><?php showCart(); ?></div>
    </div>


</div>


</body>
</html>