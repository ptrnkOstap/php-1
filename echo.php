<?php
echo '<pre>';

var_dump(array_filter( scandir('./public/img/'), function ($file){
    return preg_match("/\.jpg$/",$file) && !is_dir($file);
} ));

echo '</pre>';