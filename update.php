<?php

$mysqli = new mysqli('localhost', 'root', '', 'Cricket_players');


if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $name = $mysqli->real_escape_string($_POST['player_name']);
    $position = $mysqli->real_escape_string($_POST['position']);
    $team = $mysqli->real_escape_string($_POST['team']);

    if (empty($name)) {
        echo "Error: Player name cannot be empty.";
    } else {
        
        $sql = "UPDATE Cricket_players SET Players='$name' , Position='$position', Team='$team'";

        if ($mysqli->query($sql) === TRUE) {
            echo "Player updated successfully!";
            header("Location: page1.php"); 
        } else {
            echo "Error updating record: " . $mysqli->error;
        }
    }
}

$mysqli->close();
?>
