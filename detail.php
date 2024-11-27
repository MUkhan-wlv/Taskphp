<?php
include("workbtask1.php");

$mysqli = connectToDatabase(); 

$player_name = $_GET['name'];


$sql = "SELECT Players, Position, Team FROM Cricket_players  WHERE Players = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param('s', $player_name); 
$stmt->execute();
$result = $stmt->get_result();
$player = $result->fetch_assoc(); 

if (!$player) {
    echo "Player not found.";
    exit;
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Player Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<div class="card" style="width: 18rem;">
  <div class="card-body">
    <h5 class="card-title">Player Details</h5>
    <p class="card-text"><?= htmlspecialchars($player['Players']) ?> is a <?= htmlspecialchars($player['Position']) ?> in  <?= htmlspecialchars($player['Team']) ?> Cricket Team.</p>
    <a href="page1.php" class="btn btn-primary">Back</a>
  </div>
</div>
    
</body>
</html>
