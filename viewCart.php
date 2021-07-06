<?php
include 'functions.php';
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
        <a href="index.php"><h1> Hello</h1></a>
        <h1> Your cart</h1>
        <div class="login_form"><?php authForm() ?></div>
    </div>
    <div class="cart_products">
        <?php
        renderShoppingCart();
        ?>
    </div>
    <div class="send_form">
        <?php
            orderCreate();
            sendForm();
        ?>
    </div>

</div>


</body>
</html>

