<?php
/**
 * Created by PhpStorm.
 * User: Andrew
 * Date: 06/01/2016
 * Time: 10:25 AM
 */
$squares = $_GET['board'];

$game = new Game($squares);
if ($game->winner('x'))
    echo 'You win. Lucky guesses!';
else if ($game->winner('o'))
    echo 'I win. Muahahahaha';
else
    echo 'No winner yet, but you are losing.';

class Game
{
    var $position;

    function __construct($squares)
    {
        $this->position = str_split($squares);
    }

    function winner($token) {

        $result = false;

        for ($row = 0; $row < 3; $row++) {
            if (($this->position[3 * $row] == $token) && ($this->position[3 * $row + 1]
                    == $token) && ($this->position[3 * $row + 2] == $token)
            ) {
                $result = true;
            }
        }

        for ($col = 0; $col < 3; $col++) {
            if (($this->position[$col] == $token) && ($this->position[$col + 3]
                    == $token) && ($this->position[$col + 6] == $token)
            ) {
                $result = true;
            }
        }

        if (($this->position[0] == $token) &&
            ($this->position[4] == $token) &&
            ($this->position[8] == $token)
        ) {
            $result = true;
        }
        if (($this->position[2] == $token) &&
            ($this->position[4] == $token) &&
            ($this->position[6] == $token)
        ) {
            $result = true;
        }
        return $result;
    }
}