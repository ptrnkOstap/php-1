
<?php
    $h1="<h1> this year is " .date("Y") . "</h1>";
    $title = "<title> HW1 </title>";
    $a =114;
    $b=2;
    $start="<br> before swap: a = $a, b= $b";

    $b=$a+$b;
    $a=$b-$a;
    $b=$b-$a;

    $result="<br> after swap: a = $a, b = $b ";

    $page ="<html> $title $h1 $start $result </html>";
    echo $page;




