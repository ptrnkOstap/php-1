<?php
if (isset($_GET['id'])) {
    $db = mysqli_connect('127.0.0.1', 'root', 'root', 'php_course');
    if (!$db) echo 'error with connection' . mysqli_error($db);

    $select = mysqli_query($db, "select pPath, id,pDes FROM pictures where id= {$_GET['id']}");
    foreach ($select as $result){

        echo '<img  src="' . ($result['pPath']) . '"' . 'class= "picture" width="100%" height="100%"  >';
    }

}