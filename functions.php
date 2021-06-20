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
            '</p> <p class="price">' . $value['price'] . '&#36;' . '</p></div>
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




