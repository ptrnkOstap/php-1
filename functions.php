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
            '</p> <p class="price">' . $value['price'] . '&#36;' . '</p><button type="submit" name="product" value=  '
            . $value['id'] . '> buy</button></div>
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
    var_dump($_SESSION['login']);
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

function renderCart()
{

}

function cartAdd()
{
    if ($_POST['product'] != null) {
        $_SESSION['cart']['product']++;
        $_POST['product'] = null;
    }
}

function showCart()
{
    var_dump($_SESSION['cart']);
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
    if (!empty($_SESSION['cart'])) {

    }
    $_SESSION['cart'] = [];
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
            if (password_verify($password, $user['password_hash'])) {
                header('Location: admin.php');
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


