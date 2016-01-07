<?php
/**
 * Created by PhpStorm.
 * User: Andrew
 * Date: 06/01/2016
 * Time: 10:25 AM
 */
if (!isset($_GET['board'])) { // if board parameter empty initialize board to empty
    $squares = '---------';
} else {
    $squares = $_GET['board'];
}

$game = new Game($squares);
$game->display();

// link to game with empty board parameter to 'restart' the game
$play_again = '<td><a href="http://localhost:60/Lab1/index.php" style="text-decoration: none">Play Again</a></td>';

if ($game->winner('x')) {
    echo 'You win. Lucky guesses!</br></br>';
    echo $play_again;
} else if ($game->winner('o')) {
    echo 'I win. Muahahahaha</br></br>';
    echo $play_again;
} else {
    echo 'No winner yet, but you are losing.';
}

class Game
{
    var $position;
    var $newposition;

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

    function display() {
        echo '<p style="font-weight: bold; font-size: large">Welcome to Tic-Tac-Toe!</p></br>';
        echo '<table cellpadding="15" border ="1" style="font-size:large; font-weight:bold">';
        echo '<tr>'; // open the first row
        for ($pos=0; $pos<9;$pos++) {
            echo $this->show_cell($pos);
            if ($pos %3 == 2) {
                echo '</tr><tr>'; // start a new row for the next square
            }
        }
        echo '</tr>'; // close the last row
        echo '</table></br>';
    }

    function show_cell($which) {
        $move_count = 0; // keep track of number of moves to determine turn
        $token = $this->position[$which];

        // deal with the easy case
        if ($token <> '-') {
            return '<td>' . $token . '</td>';
        }

        // now the hard case
        $this->newposition = $this->position; //copy the original

        // checks each cell for x or o, if found increase move count by 1
        for($i = 0; $i < 9; $i++) {
            if($this->newposition[$i] <> '-') {
                $move_count++;
            }
        }

        if ($move_count % 2 == 0) { // if move count is even X's turn
            $this->newposition[$which] = 'x'; //this would be our move
        } else { // if move count is odd O's turn
            $this->newposition[$which] = 'o'; // this would be their move
        }

        $move = implode($this->newposition); // make a string from the board array
        $link = 'http://localhost:60/Lab1/index.php?board=' . $move; // this is what we want the link to be
                                    // so return a cell containing an anchor and showing a hyphen
        return '<td><a href="'. $link . '" style="text-decoration: none">-</a></td>';
    }
}