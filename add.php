<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Include New Player</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f4ff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .form-container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            padding: 20px 30px;
            width: 300px;
            text-align: center;
        }

        .form-container h2 {
            font-size: 20px;
            color: #000;
            margin-bottom: 20px;
        }

        .form-container label {
            display: block;
            font-size: 14px;
            margin-bottom: 5px;
            text-align: left;
        }

        .form-container input {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
            box-sizing: border-box;
        }

        .form-container button {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 0;
            width: 100%;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }

        .form-container button:hover {
            background-color: #218838;
        }
        #timer-container {
      display: none;
    }
    </style>
</head>
<body>
    
<?php
include("workbtask1.php");
session_start(); // Start the session
$mysqli = connectToDatabase();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['name']) && !empty($_POST['name']) && 
        isset($_POST['position']) && !empty($_POST['position']) && 
        isset($_POST['team']) && !empty($_POST['team'])) {


        $player_name = $mysqli->real_escape_string($_POST['name']);
        $position = $mysqli->real_escape_string($_POST['position']);
        $team = $mysqli->real_escape_string($_POST['team']);


        $sql = "INSERT INTO Cricket_players (Players, Position, Team) VALUES ('$player_name', '$position', '$team')";

        if ($mysqli->query($sql)) {
            echo "Player added successfully!";
            header("Location: page1.php"); 
        } else {
            echo "Error: " . $mysqli->error;
        }
    } else {
        echo "Error: All fields must be filled out.";
    }
}
if (!isset($_SESSION['startTime'])) {
    $_SESSION['startTime'] = time(); // Store the start time in session
  }

$mysqli->close();
?>
<div id="timer-container">
    Time elapsed: <span id="timer">00:00:00</span>
  </div>

    <div class="form-container">
        <h2>Include new player</h2>
        <form action="#" method="post">
            <label for="player-name">Player's Name:</label>
            <input type="text" name="name" placeholder="Player Name" class="form-control" style="display:inline; width:auto;">
            
            
            <label for="position">Position:</label>
            <input type="text" name="position" placeholder="Position" class="form-control" style="display:inline; width:auto;">
            
            <label for="club">Team:</label>
            <input type="text" name="team" placeholder="Team" class="form-control" style="display:inline; width:auto;">
            
            <button type="submit">Add</button>
        </form>
    </div>
</body>
<script>

  
function getCookie(name) {
  const value = `; ${document.cookie}`;
  const parts = value.split(`; ${name}=`);
  if (parts.length === 2) return parts.pop().split(';').shift();
  return null;
}


let startTime = getCookie('startTime');
if (!startTime) {
  startTime = Date.now(); 
  document.cookie = `startTime=${startTime}; path=/; max-age=31536000`;
}

function formatTime(ms) {
  const seconds = Math.floor(ms / 1000);
  const hrs = Math.floor(seconds / 3600);
  const mins = Math.floor((seconds % 3600) / 60);
  const secs = seconds % 60;

  return `${hrs.toString().padStart(2, '0')}:${mins.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
}

function updateTimer() {
  const currentTime = Date.now();
  const elapsedTime = currentTime - startTime;
  document.getElementById('timer').textContent = formatTime(elapsedTime);
}

window.addEventListener('load', function () {
  const timerContainer = document.getElementById('timer-container');
  timerContainer.style.display = 'block'; 
  updateTimer(); 
  setTimeout(() => {
    timerContainer.style.display = 'none'; 
  }, 1000);
});


setInterval(updateTimer, 1000);
</script>
</html>


