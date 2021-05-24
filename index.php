<?php
//$a = 2;
//$b = 4;
//
//if ($a >= 0 && $b >= 0) {
//    echo "разность " . ($a - $b);
//} elseif ($a < 0 && $b < 0) {
//    echo "произведение " . ($a * $b);
//} else {
//    echo "сумма " . ($a + $b);
//}

//$a = random_int(0, 15);
//
//switch ($a){
//    case 1:
//        echo 1 ." ";
//    case 2:
//        echo 2 ." ";
//    case 3:
//        echo 3 ." ";
//    case 4:
//        echo 4 ." ";
//    case 5:
//        echo 5 ." ";
//    case 6:
//        echo 6 ." ";
//    case 7:
//        echo 7 ." ";
//    case 8:
//        echo 8 ." ";
//    case 9:
//        echo 9 ." ";
//    case 10:
//        echo 10 ." ";
//    case 11:
//        echo 11 ." ";
//    case 12:
//        echo 12 ." ";
//    case 13:
//        echo 13 ." ";
//    case 14:
//        echo 14 ." ";
//    case 15:
//        echo 15;
//}
function divide($a, $b)
{
    if ($b != 0)
        return $a / $b;
}

function subtract($a, $b)
{
    return $a - $b;
}

function multiply($a, $b)
{
    return $a * $b;
}

function sum($a, $b)
{
    return $a + $b;
}

function mathOperation($arg1, $arg2, $operation)
{
    switch ($operation) {
        case "-":
            return subtract($arg1, $arg2);
        case "+":
            return sum($arg1, $arg2);
        case "*":
            return multiply($arg1, $arg2);
        case "/":
            return divide($arg1, $arg2);
        default:
            echo "enter correct operation";
            break;
    }
}

echo mathOperation(9, 3, "*");
$date=date("Y");
echo "<footer style='position: absolute; bottom:50px;left: 50%;font-weight: bold;font-size: 13pt;'>$date</footer>";
