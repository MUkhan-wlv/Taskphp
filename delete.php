<?php

session_start();
include("workbtask1.php");
$mysqli = connectToDatabase();

if (isset($_POST['player_name'], $_POST['position'], $_POST['team'])) {
    $player_name = $mysqli->real_escape_string($_POST['player_name']);
    $position = $mysqli->real_escape_string($_POST['position']);
    $team = $mysqli->real_escape_string($_POST['team']);
    $sql = "DELETE FROM Cricket_players WHERE Players = '$player_name' AND Position = '$position' AND Team = '$team'";


    if ($mysqli->query($sql) === TRUE) {
        echo "Player deleted successfully!";

        header("Location: page1.php"); 
        exit();  
    } else {
        echo "Error deleting record: " . $mysqli->error;
    }
} else {
    echo "Error: Missing required data.";
}

$mysqli->close();
?>
