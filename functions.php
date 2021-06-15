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

        $select = mysqli_query($db, "select pPath, id,pDes FROM products where id= {$_GET['id']}");
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
    if (isset($_GET['id'])) {
        $db = mysqli_connect('127.0.0.1', 'root', 'root', 'php_course');
        if (!$db) echo 'error with connection' . mysqli_error($db);

        $select = mysqli_query($db, "select pName, pDes, price, pPath FROM products where id= {$_GET['id']}");
        foreach ($select as $result) {

            $path = $result['pPath'];
            $price = $result['price'];
            $name = $result['pName'];
            $description = $result['pDes'];

            echo '<img  src="' . ($result['pPath']) . '"' . 'class= "picture" width="100%" height="100%"  >';
            showForm($path, $price, $name, $description);

        }

    }


}


function updateProduct()
{
    if (isset($_POST['submit'])) {
        $db = mysqli_connect('127.0.0.1', 'root', 'root', 'php_course');
        if (!$db) echo 'error with connection' . mysqli_error($db);

        $update = mysqli_query($db, "update products set 
                    pName= {$_POST['p_name']},
                    price={$_POST['price']},
                    pDes={$_POST['p_description']},
                    where id={$_GET['id']}");
        if (!$update) mysqli_error($db);
        echo 'product updated';

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

function addProduct()
{
    if (isset($_FILES['p_file']) && $_FILES['p_file']['error'] == 0) {
        if (preg_match("/\.jpg$/", $_FILES['p_file']['name'])) {
            $fileName = 'public/img/' . $_FILES['p_file']['name'];
            $db = mysqli_connect('127.0.0.1', 'root', 'root', 'php_course');
            $insert = mysqli_query($db, "insert into products (pPath,pName,price,pDes) 
                values ('{$fileName}','{$_POST['p_name']}','{$_POST['price']}','{$_POST['p_description']}')");
            if ($insert) {
                if (move_uploaded_file($_FILES['p_file']['tmp_name'], 'public/img/' . $_FILES['p_file']['name'])) {
                }
                $_POST = array();
                echo 'File uploaded';
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

        $delete = mysqli_query($db, "delete from products where id= {$_GET['id']}");
        if (!$delete) mysqli_error($db);
        echo 'product deleted';
    }
}




