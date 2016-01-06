<?php
/**
 * Created by PhpStorm.
 * User: Andrew
 * Date: 06/01/2016
 * Time: 10:25 AM
 */
$position = $_GET['board'];
$squares = str_split($position);

if (winner('x', $squares)) {
    echo 'You win.';
} else if (winner('o', $squares)) {
    echo 'I win.';
} else {
    echo 'No winner yet.';
}

function winner($token,$position) {

    $result = false;

    for ($row = 0; $row < 3; $row++) {
        if (($position[3 * $row] == $token) && ($position[3 * $row + 1]
                == $token) && ($position[3 * $row + 2] == $token)
        ) {
            $result = true;
        }
    }

    for ($col = 0; $col < 3; $col++) {
        if (($position[$col] == $token) && ($position[$col+3]
            == $token) && ($position[$col+6] == $token)) {
            $result = true;
        }
    }

    if (($position[0] == $token) &&
        ($position[4] == $token) &&
        ($position[8] == $token)) {
            $result = true;
    }
    if (($position[2] == $token) &&
        ($position[4] == $token) &&
        ($position[6] == $token)) {
            $result = true;
    }
        return $result;
}