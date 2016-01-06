<?php
/**
 * Created by PhpStorm.
 * User: Andrew
 * Date: 06/01/2016
 * Time: 10:25 AM
 */

$temp = 'Jim';
echo 'Hi, my name is';
echo $temp;
$temp = 'geek';
echo 'I am a';
echo $temp;
$temp = 10;
echo 'My level is';
echo $temp;

echo '<br/>';

$hoursworked = $_GET['hours'];
$rate = 12;
$total = $hoursworked * $rate;

if ($hoursworked > 40) {
    $total = $hoursworked * $rate * 1.5;
} else {
    $total = $hoursworked * $rate;
}
echo ($total > 0) ? 'You owe me '.$total : 'Youre welcome';