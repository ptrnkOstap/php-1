<?php

function createGallery()
{
    $db = mysqli_connect('127.0.0.1', 'root', 'root', 'php_course');
    if (!$db) echo 'error with connection' . mysqli_error($db);

    $select = mysqli_query($db, 'select pPath, id, price,pName FROM products');
    $result = '';
    foreach ($select as $value) {

        $result .= '<div class="product_card">
            <a href ="' . 'product.php' . '?id=' . $value['id'] . '" >' . '<img  src="' . $value['pPath'] . '"'
            . 'class= "picture">' . '</a> <div class="product_tags">   <p class="name">' . $value['pName'] .
            '</p> <p class="price">' . $value['price'] . '&#36;' . '</p><form method="post"><button type="submit" name="add_to_cart" value=  '
            . $value['id'] . '> buy</button></form></div>
    </div>';
    }
    echo $result;
}

function getImgByID()
{
    if (isset($_GET['id'])) {
        $db = mysqli_connect('127.0.0.1', 'root', 'root', 'php_course');
        if (!$db) echo 'error with connection' . mysqli_error($db);

        $id = saveSQLInsert($db, $_GET['id']);

        $select = mysqli_query($db, "select pPath, id,pDes FROM products where id= {$id}");
        foreach ($select as $result) {

            echo '<img  src="' . ($result['pPath']) . '"' . 'class= "picture"  >';
        }
    }
}

function showForm($path = '', $price = '', $name = '', $description = '')
{
    echo '<form class="loadImgForm" enctype="multipart/form-data" method="post">
        <input type="file" name="p_file" value="' . $path . '">
        <label for="price">Price</label>
        <input type="number" name="price" value="' . $price . '">
        <label for="p_name">Product name</label>
        <input type="text" name="p_name" value="' . $name . '">
        <label for="p_description">Description</label>
        <input type="text" name="p_description" value="' . $description . '">
        <input type="submit" name="submit">
    </form>';
}

function getProductByID()
{
    updateProduct();

    if (isset($_GET['id'])) {
        $db = mysqli_connect('127.0.0.1', 'root', 'root', 'php_course');
        if (!$db) echo 'error with connection' . mysqli_error($db);

        $id = saveSQLInsert($db, $_GET['id']);

        $select = mysqli_query($db, "select pName, pDes, price, pPath FROM products where id= {$id}");
        foreach ($select as $result) {

            $path = $result['pPath'];
            $price = $result['price'];
            $name = $result['pName'];
            $description = $result['pDes'];

            echo '<img  src="' . ($result['pPath']) . '"' . 'class= "picture" width="100%" height="100%"  >';
            $_POST = null;
//            var_dump($_POST);
            showForm($path, $price, $name, $description);

        }
    }
}

function updateProduct()
{
    if (isset($_POST['submit'])) {
        $db = mysqli_connect('127.0.0.1', 'root', 'root', 'php_course');
        if (!$db) echo 'error with connection' . mysqli_error($db);

        $id = saveSQLInsert($db, $_GET['id']);
        $nameSQL = saveSQLInsert($db, $_POST['p_name']);
        $priceSQL = (float)$_POST['price'];
        $descriptionSQL = saveSQLInsert($db, $_POST['p_description']);

        $filePathSQL = saveSQLInsert($db, ('public/img/' . $_FILES['p_file']['name']));
        $getPath = mysqli_query($db, "select pPath from products where id={$id}");
        foreach ($getPath as $path) {
            $oldPath = $path['pPath'];
        }

        $update = mysqli_query($db, "update products set
                    pPath='{$filePathSQL}',
                    pName= '{$nameSQL}',
                    price='{$priceSQL}',
                    pDes='{$descriptionSQL}'
                    where id='{$id}'");
        if (!$update) mysqli_error($db);
        elseif ($filePathSQL != $oldPath) {
            move_uploaded_file($_FILES['p_file']['tmp_name'], 'public/img/' . $_FILES['p_file']['name']);
            unlink($oldPath);
            echo ' product updated';
        }

    }
}

function renderProductsA()
{
    $db = mysqli_connect('127.0.0.1', 'root', 'root', 'php_course');
    if (!$db) echo 'error with connection' . mysqli_error($db);

    $select = mysqli_query($db, 'select pPath, id, price,pName FROM products');
    $result = '';
    foreach ($select as $value) {
        $result .= '<div class="product">
            <div class="p_img"><img  src="' . $value['pPath'] . '".'
            . 'class= "picture" width="150" height="100"></div> <div class="p_name">' . $value["pName"] .
            '</div> <div class="p_price">' . $value["price"] .
            '&#36;</div><a href="' . 'deleteProduct.php' . '?id=' . $value["id"] .
            '" class="p_delete">delete</a><a href="' .
            'editProduct.php' . '?id=' . $value["id"] . '" class="p_edit">' .
            'edit</a></div>';
    }
    echo $result;

}

function saveSQLInsert($db, $param): string
{
    return mysqli_real_escape_string($db, htmlspecialchars(strip_tags($param)));
}

function addProduct()
{
    if (isset($_FILES['p_file']) && $_FILES['p_file']['error'] == 0) {
        if (preg_match("/\.jpg$/", $_FILES['p_file']['name'])) {
            $fileName = 'public/img/' . $_FILES['p_file']['name'];
            $db = mysqli_connect('127.0.0.1', 'root', 'root', 'php_course');

            $nameSQL = saveSQLInsert($db, $_POST['p_name']);
            $priceSQL = (float)$_POST['price'];
            $descriptionSQL = saveSQLInsert($db, $_POST['p_description']);

            $insert = mysqli_query($db, "insert into products (pPath,pName,price,pDes) 
                values ('$fileName','$nameSQL', '$priceSQL','$descriptionSQL')");
            if ($insert) {
                if (move_uploaded_file($_FILES['p_file']['tmp_name'], 'public/img/' . $_FILES['p_file']['name'])) {
                    echo 'File uploaded';
                }
                $_POST = array();

            } else {
                echo "something went wrong " . mysqli_error($db);
            };
        } else {
            echo 'no image';
        }
    }
    showForm();
}

function deleteProduct()
{
    if (isset($_GET['id'])) {
        $db = mysqli_connect('127.0.0.1', 'root', 'root', 'php_course');
        if (!$db) echo 'error with connection' . mysqli_error($db);

        $id = saveSQLInsert($db, $_GET['id']);

        $delete = mysqli_query($db, "delete from products where id= {$id}");
        if (!$delete) mysqli_error($db);
        echo 'product deleted';
    }
}

function authForm()
{
    if (isset($_SESSION['login'])) {
        echo 'Logged in as <b>' . $_SESSION['login'] . '</b> <a href=' . '?logout' . '>Logout</a>';
    } else {
        echo '<form  method="post">
    <input type="text" name="login">
    <input type="password" name="password">
    <input type="submit" name="login_form">
    </form>';
    }
}

function startSession()
{
    session_start();
}

function authUser()
{
    startSession();
    if (isset($_GET['logout'])) {
        unset($_SESSION['login']);
        header('Location: index.php');
    }

    if (isset($_POST['login_form'])) {
        $db = mysqli_connect("localhost", "root", "root", "php_course");
        $login = mysqli_real_escape_string($db, htmlspecialchars(strip_tags($_POST['login'])));
        $password = $_POST['password'] ?? "";
        $select = mysqli_query($db, "SELECT password_hash FROM users WHERE login = '$login'");
        if ($user = mysqli_fetch_assoc($select)) {
            // password_hash("password", PASSWORD_BCRYPT)
            if (password_verify($password, $user['password_hash']) && $login == 'test1') {
                header('Location: admin.php');
                $_SESSION['login'] = $login;
            } else if (password_verify($password, $user['password_hash'])) {
                header('Location: index.php');
                $_SESSION['login'] = $login;
            } else {
                echo "Пароль неверный ";
            }
        }

    }
}

function checkAuth()
{
    if (!$_SESSION['login'] == 'test1') {
        echo '404 not found';
        exit();
    }
}

function cartAddItem()
{
    if (isset($_POST["add_to_cart"])) {
        if (isset($_SESSION["shopping_cart"])) {
            $item_array_id = array_column($_SESSION["shopping_cart"], "item_id");
            if (!in_array($_POST["id"], $item_array_id)) {
                $count = count($_SESSION["shopping_cart"]);
                $item_array = array(
                    'item_id' => $_POST["add_to_cart"],
                    'item_quantity' => $_POST["quantity"] ?? 1
                );
                $_SESSION["shopping_cart"][$count] = $item_array;
            } else {
                echo '<script>alert("Item Already Added")</script>';
            }
        } else {
            $item_array = array(
                'item_id' => $_POST["add_to_cart"],
                'item_quantity' => $_POST["quantity"] ?? 1
            );
            $_SESSION["shopping_cart"][0] = $item_array;
        }
    }
}

function renderShoppingCart()
{
    $db = mysqli_connect('127.0.0.1', 'root', 'root', 'php_course');
    if (!$db) echo 'error with connection' . mysqli_error($db);
    $items_array_id = array_column($_SESSION["shopping_cart"], "item_id");

    $ids = join(',', $items_array_id);

    $select = mysqli_query($db, "select pPath, id, price,pName FROM products where id in ($ids)");
    if (!$select) {
        die (mysqli_error($db));
    }
    $items_list = '';
    $totalValue = 0;
    $totalQuantity = 0;

    if (mysqli_num_rows($select) > 0) {
        foreach ($select as $row) {

            $orderQuantity = searchMultidimArr($row['id'], $_SESSION['shopping_cart'])['item_quantity'];
            $totalQuantity += (int)$orderQuantity;
            $totalValue += ((int)$orderQuantity * (float)$row['price']);

            $items_list .= '<div class="product">
            <div class="p_img"><img  src="' . $row['pPath'] . '".'
                . 'class= "picture" width="150" height="100"></div> <div class="p_name">' . $row["pName"] .
                '</div> <div class="p_price">' . $row["price"] .
                '&#36; x  <div class="div">&nbsp;' . $orderQuantity . ' <b>- Total</b>  ' . $orderQuantity * $row['price'] .
                '&#36;</div></div>  <a href="' . 'viewCart.php?action=delete&id=' . $row["id"] .
                '" class="p_delete">delete</a></div>';
        }
    }
    echo '<p> In the cart <b>' . $totalQuantity . '</b> items for <b>' . $totalValue . '</b>&#36;</p>';
    if (isset($_GET["action"])) {
        if ($_GET["action"] == "delete") {
            foreach ($_SESSION["shopping_cart"] as $keys => $values) {
                if ($values["item_id"] == $_GET["id"]) {
                    unset($_SESSION["shopping_cart"][$keys]);
                    echo '<script> window.location="viewCart.php"</script>';
                }
            }
        }
    }
    echo $items_list;
}

function searchMultidimArr($id, $array)
{
    foreach ($array as $key) {
        if ($key['item_id'] == $id) {
            return $key;
        }
    }
    return null;
}

function sendForm()
{
    if (isset($_SESSION["shopping_cart"])) {
        echo '<h2 class="send_form_header">Fill the form to place your order</h2>
        <form method="post" class="">
        <label for="c_name">Your name</label>
        <input type="text" name="c_name">
        <label for="c_address">Address</label>
        <input type="text" name="c_address">
        <label for="c_phone">Phone number</label>
        <input type="text" name="c_phone">
        <input type="submit" name="send_form" value="Order">
    </form>';
    }

//    echo var_dump($_SESSION["shopping_cart"]);
}

function orderCreate()
{
    if (isset($_POST["send_form"])) {
        if (!empty($_POST['c_name']) && !empty($_POST['c_address']) && !empty($_POST['c_phone'])) {

            $db = mysqli_connect('127.0.0.1', 'root', 'root', 'php_course');

            $uName = saveSQLInsert($db, $_POST['c_name']);
            $uPhone = (float)$_POST['c_phone'];
            $uAddress = saveSQLInsert($db, $_POST['c_address']);
            $uID = getUserID();

            $insert = mysqli_query($db, "insert into orders (user_id,user_name,user_phone,address) 
                values ('$uID','$uName', '$uPhone','$uAddress')");
            if ($insert) {
                $orderID = mysqli_insert_id($db);

                foreach ($_SESSION['shopping_cart'] as $cartItem) {
                    $itemID = $cartItem['item_id'];
                    $itemPrice = getPrice($itemID);
                    $itemInsert = mysqli_query($db, "insert into order_items(product_id,prod_quantity,prod_price,order_id)
                    values ('$itemID',
                            '{$cartItem['item_quantity']}',
                            '$itemPrice',
                            '$orderID')");
                    if (!$itemInsert) mysqli_error($db);
                }
                $_SESSION['shopping_cart'] = array();
                echo 'Order created';
                echo '</br>' . 'Order number - ' . $orderID;
                $_POST = array();

            } else {
                echo "something went wrong " . mysqli_error($db);
            };
        } else {
            echo 'fill all the field in the send form';
        }
    }
}

function getPrice($id)
{
    if (!empty($id)) {
        $db = mysqli_connect('127.0.0.1', 'root', 'root', 'php_course');
        $query = mysqli_query($db, "select price from products where id='$id'");
        foreach ($query as $row) {
            return $row['price'];
        }
    }
}

function getUserID()
{
    if (!empty($_SESSION['login'])) {

        $db = mysqli_connect('127.0.0.1', 'root', 'root', 'php_course');
        $passLogin = saveSQLInsert($db, $_SESSION['login']);
        $select = mysqli_query($db, "select id from users where login='$passLogin'");
        foreach ($select as $row) {
            return $row['id'];
        }
    }
}




