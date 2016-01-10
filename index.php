<?php
/**
 * Created by PhpStorm.
 * User: Andrew
 * Date: 06/01/2016
 * Time: 10:25 AM
 */
if (!isset($_GET['board'])) { // if board parameter undefined initialize board to empty
    $squares = '---------';
    $first_move = 1;
} else {
    $squares = $_GET['board'];
    $first_move = 0;
}

$game = new Game($squares);
if ($first_move == 0) { // If it is not the first move the bot will place an 'o' on the board
    $game->pick_move();
}
$game->display();

// link to game with empty board parameter to 'restart' the game
$play_again = '<td><a href="http://localhost:60/Lab1/index.php" style="text-decoration: none">Play Again</a></td>';

if ($game->winner('x')) {
    echo 'You win. Lets play a real game like chess.</br></br>';
    echo $play_again;
} else if ($game->winner('o')) {
    echo 'I win and YOU lose, HA!</br></br>';
    echo $play_again;
} else if ($game->tie()) {
    echo 'Tie Game, booooooring.</br></br>';
    echo $play_again;
} else {
    echo 'I haven\'t beat you yet...';
}

class Game {
    var $position;
    var $newposition;

    function __construct($squares) {
        $this->position = str_split($squares);
    }

    // determine if the board still contains an unused space, if no new moves game is a tie
    function tie() {
        for ($i = 0; $i < 9; $i++) {
            if($this->position[$i] == '-') {
                return false;
            }
        }
        return true;
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
        $token = $this->position[$which];

        // deal with the easy case
        if ($token <> '-') {
            return '<td>' . $token . '</td>';
        }

        // now the hard case
        $this->newposition = $this->position; //copy the original

        $this->newposition[$which] = 'x'; //this would be our move

        $move = implode($this->newposition); // make a string from the board array
        $link = 'http://localhost:60/Lab1/index.php?board=' . $move; // this is what we want the link to be
                                    // so return a cell containing an anchor and showing a hyphen
        return '<td><a href="'. $link . '" style="text-decoration: none">-</a></td>';
    }

    function pick_move() {
        // Row loss defense
        for ($row = 0; $row < 3; $row++) {
            if (($this->position[3 * $row] == 'x') && ($this->position[3 * $row + 1]
                    == '-') && ($this->position[3 * $row + 2] == 'x')
            ) {
                $this->position[3 * $row + 1] = 'o';
                return;
            }
            if (($this->position[3 * $row] == '-') && ($this->position[3 * $row + 1]
                    == 'x') && ($this->position[3 * $row + 2] == 'x')
            ) {
                $this->position[3 * $row] = 'o';
                return;
            }
            if (($this->position[3 * $row] == 'x') && ($this->position[3 * $row + 1]
                    == 'x') && ($this->position[3 * $row + 2] == '-')
            ) {
                $this->position[3 * $row + 2] = 'o';
                return;
            }
        }

        // Column loss defense
        for ($col = 0; $col < 3; $col++) {
            if (($this->position[$col] == 'x') && ($this->position[$col + 3]
                    == '-') && ($this->position[$col + 6] == 'x')
            ) {
                $this->position[$col + 3] = 'o';
                return;
            }
            if (($this->position[$col] == '-') && ($this->position[$col + 3]
                    == 'x') && ($this->position[$col + 6] == 'x')
            ) {
                $this->position[$col] = 'o';
                return;
            }
            if (($this->position[$col] == 'x') && ($this->position[$col + 3]
                    == 'x') && ($this->position[$col + 6] == '-')
            ) {
                $this->position[$col + 6] = 'o';
                return;
            }
        }

        //Left to Right diagonal loss defense
        if($this->position[0] == 'x' && $this->position[8] == 'x') {
            $this->position[4] = 'o';
            return;
        }
        if($this->position[0] == 'x' && $this->position[4] == 'x') {
            $this->position[8] = 'o';
            return;
        }
        if($this->position[4] == 'x' && $this->position[8] == 'x') {
            $this->position[0] = 'o';
            return;
        }


        //Right to Left diagonal loss defense
        if($this->position[2] == 'x' && $this->position[6] == 'x') {
            $this->position[4] = 'o';
            return;
        }
        if($this->position[2] == 'x' && $this->position[4] == 'x') {
            $this->position[6] = 'o';
            return;
        }
        if($this->position[4] == 'x' && $this->position[6] == 'x') {
            $this->position[2] = 'o';
            return;
        }

        for($i=0; $i<9; $i++) {
            if($this->position[$i] == '-') {
                $this->position[$i] = 'o';
                return;
            }
        }
    }
}