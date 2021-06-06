<?php
array_filter(scandir('./public/img/'), function ($file) {
    return preg_match("/\.jpg$/", $file) && !is_dir($file);
});


//function createImg($path)
//{
//    $result = '';
//    $imgNames = array_filter(scandir($path), function ($fileName) {
//        return preg_match("/\.jpg$/", $fileName) && !is_dir($fileName);
//    });
//
//    foreach ($imgNames as $value) {
//        $result .= '<a href ="' . ($path . '/' . $value) . '" target="new" >' . '<img  src="' . ($path . '/' . $value) . '"' . 'class= "picture" width="250" height="200">' . '</a>';
//    }
//    echo $result;
//
//
//    if (isset($_FILES['pic']) && $_FILES['pic']['error'] == 0) {
//        if (preg_match("/\.jpg$/", $_FILES['pic']['name'])) {
//            if (move_uploaded_file($_FILES['pic']['temp_name'], 'public/img/' . $_FILES['pic']['name'])) {
//                echo "image uploaded";
//            } else {
//                echo "something went wrong";
//            };
//        } else {
//            echo 'no image';
//        }
//    }
//}

function createImg()
{
    $db = mysqli_connect('127.0.0.1', 'root', 'root', 'php_course');
    if (!$db) echo 'error with connection' . mysqli_error($db);

    $select = mysqli_query($db, 'select pPath, id FROM pictures');
    $result = '';
    foreach ($select as $value) {
        $result .= '<a href ="' . 'viewImage.php' . '?id=' . $value['id'] . '" target="new" >' . '<img  src="' . $value['pPath'] . '"' . 'class= "picture" width="250" height="200">' . '</a>';
    }


    echo $result;

    if (isset($_FILES['pic']) && $_FILES['pic']['error'] == 0) {
        if (preg_match("/\.jpg$/", $_FILES['pic']['name'])) {
            $fileName = 'public/img/' . $_FILES['pic']['name'];
            $insert = mysqli_query($db, "insert into pictures (pPath,pName,pDes) values ('{$fileName}','test','test')");
            if ($insert) {
                if (move_uploaded_file($_FILES['pic']['tmp_name'], 'public/img/' . $_FILES['pic']['name'])) {
                }
                echo 'File uploaded';
            } else {
                echo "something went wrong" . mysqli_error($db);
            };
        } else {
            echo 'no image';
        }
    }

}










