<?php
session_start();
include("workbtask1.php");
$mysqli = connectToDatabase();

if (isset($_POST['searchTerms'])) {
    $searchTerms = $mysqli->real_escape_string($_POST['searchTerms']);


    $sql = "SELECT Players, Position, Team 
            FROM Cricket_Players 
            WHERE Players LIKE '%$searchTerms%' 
            OR Position LIKE '%$searchTerms%' 
            OR Team LIKE '%$searchTerms%'";

    $result = $mysqli->query($sql);

    if ($result->num_rows > 0) {
        echo '<ul class="list-group">';
        while ($row = $result->fetch_assoc()) {
            echo '<li class="list-group-item">' . htmlspecialchars($row['Players']) . ' - ' . htmlspecialchars($row['Position']) . ' - ' . htmlspecialchars($row['Team']) . '</li>';
        }
        echo '</ul>';
    } else {
        echo '<p>No results found.</p>';
    }

    if (!empty($searchTerms)) {
        if (!isset($_SESSION['searchHistory'])) {
            $_SESSION['searchHistory'] = [];
        }
        array_unshift($_SESSION['searchHistory'], $searchTerms);
        $_SESSION['searchHistory'] = array_slice($_SESSION['searchHistory'], 0, 5); 
    }
}
?>
