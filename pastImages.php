<?php
array_filter(scandir('./public/img/'), function ($file) {
    return preg_match("/\.jpg$/", $file) && !is_dir($file);
});

function getImgNames($path)
{
    return array_filter(scandir($path), function ($fileName) {
        return preg_match("/\.jpg$/", $fileName) && !is_dir($fileName);
    });
}

function createImg($path)
{
    $result = '';
    $imgNames = array_filter(scandir($path), function ($fileName) {
        return preg_match("/\.jpg$/", $fileName) && !is_dir($fileName);
    });

    foreach ($imgNames as $value) {
        $result .= '<a href ="' . ($path . '/' . $value) . '" target="new" >' . '<img src="' . ($path . '/' . $value) . '"' . 'class= "picture" width="250" height="200">' . '</a>';
    }
    echo $result;
}


if (isset($_FILES['pic']) && $_FILES['pic']['error'] == 0) {
    if (preg_match("/\.jpg$/", $_FILES['pic']['name'])) {
        if (move_uploaded_file($_FILES['pic']['temp_name'], 'public/img/' . $_FILES['pic']['name'])) {
            echo "image uploaded";
        } else {
            echo "something went wrong";
        };
    } else {
        echo 'no image';
    }
}









