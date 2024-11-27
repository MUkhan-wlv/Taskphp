<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Cricket Players Search</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <style>
    .centerPara {
      display: flex;
      text-align: center;
      justify-content: center;
      align-items: center;
      font-size: 30px;
      padding: 39px 22px;
    }
    .add {
    padding: 0px 4px 4px 60px;
}
.formup{
  margin-top: 6px;
    width: 139px;

}
.btnup{
    margin-top: 11px;

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


  if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['searchTerms'])) {
      $searchTerms = $mysqli->real_escape_string($_POST['searchTerms']);
      $sql = "SELECT Players, Position, Team 
              FROM Cricket_Players 
              WHERE Players LIKE '%$searchTerms%' 
              OR Position LIKE '%$searchTerms%' 
              OR Team LIKE '%$searchTerms%'";
  } else {
      $sql = "SELECT Players, Position, Team FROM Cricket_players";
  }
  if (!empty($searchTerm)) {
    if (!isset($_SESSION['searchHistory'])) {
        $_SESSION['searchHistory'] = [];
    }


    array_unshift($_SESSION['searchHistory'], $searchTerm);
    $_SESSION['searchHistory'] = array_slice($_SESSION['searchHistory'], 0, 5); 
  }

  $result = $mysqli->query($sql);
  if (!$result) {
      die("Query failed: " . $mysqli->error);
  }
  if (!isset($_SESSION['startTime'])) {
    $_SESSION['startTime'] = time(); 
  }
  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['clearSession']) && $_POST['clearSession'] === 'true') {
    session_destroy();
    exit; 
}


?>

<div class="container">
  <nav class="navbar navbar-expand-lg bg-body-tertiary" data-bs-theme="dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Cricket Database</a>
      
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" href="page1.php">Page 1</a>
          </li>
          <li class="nav-item">
          </li>
        </ul>
        <form class="d-flex" role="search" action="page1.php" method="post">
          <input name="searchTerms" class="form-control me-2" type="search" placeholder="Search Player" aria-label="Search" autocomplete="on">
          <button class="btn btn-outline-success"  type="submit">Search</button>
          
          <button type="submit" class="btn btn-outline-success"><a  href="logout.php">Logout</a></button>
          
        </form>
      </div>
    </div>
  </nav>
  <div id="timer-container">
    Time elapsed: <span id="timer">00:00:00</span>
  </div>

  <section>
    <div class="centerPara">
      <h2>Cricket Players Database</h2>
      
      <form action="add.php" class="add">
               
        <button href="add.php" type="submit" style="width: 100px;"class="btn  btn-outline-success">Add</button>
      </form>
    </div>
    <input name="searchTerms" class="form-control me-2" type="search" placeholder="Search Player" aria-label="Search" autocomplete="on">

    <table class="table table-bordered" >
      <thead class="thead-dark">
        <tr style="text-align:center; font-weight:600; font-size:19px;">
          <th>Player</th>
          <th>Position</th>
          <th>Team</th>
          <th>Delete</th>
          <th>Update</th>
          <th>Add</th>
        </tr>
      </thead>
        <tbody id="tableBody">
        <?php while ($a_row = $result->fetch_assoc()): ?>
            <tr style="text-align:center;">
            <td><a href="detail.php?name=<?= urlencode($a_row['Players']) ?>"><?= htmlspecialchars($a_row['Players']) ?></a></td>
              <td><?= htmlspecialchars($a_row['Position']) ?></td>
              <td><?= htmlspecialchars($a_row['Team']) ?></td>
              <td>
                <form action="delete.php" method="POST" style="display:inline;">
                  <input type="hidden" name="player_name" value="<?= htmlspecialchars($a_row['Players']) ?>" required>
                  <input type="hidden" name="position" value="<?= htmlspecialchars($a_row['Position']) ?>" required>
                  <input type="hidden" name="team" value="<?= htmlspecialchars($a_row['Team']) ?>" required>
                  <button type="submit" class="btn btn-danger">Delete</button>
                </form>
              </td>
              <td>
              <button type="submit" class="btn btn-warning" onclick="showForm(this)">Update</button>

                <form action="update.php" method="POST" style="display:none; width:50px; ">
                  <input class="formup form-control me-2"  type="text" name="player_name" value="<?= htmlspecialchars($a_row['Players']) ?>" required>
                  <input class="formup form-control me-2"  type="text" name="position" value="<?= htmlspecialchars($a_row['Position']) ?>" required>
                  <input class="formup form-control me-2"  type="text" name="team" value="<?= htmlspecialchars($a_row['Team']) ?>" required>
                  <button type="submit" class="btn btnup btn-warning">Update</button>
                </form>

              </td>
              <td colspan="4">
              <form action="add.php" >
               
                <button href="add.php" type="submit" class="btn btn-primary">Add</button>
              </form>


            </td>
            </tr>
          <?php endwhile; ?>
          
      </tbody>

    </table>
  </section>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>
  function showForm(button) {
    button.style.display = 'none';
    const form = button.nextElementSibling;
    form.style.display = 'block';
  }

let inactivityTimer;

const INACTIVITY_LIMIT = 4000000;

function resetInactivityTimer() {
  clearTimeout(inactivityTimer);
  inactivityTimer = setTimeout(destroySession, INACTIVITY_LIMIT);
}

function destroySession() {
  navigator.sendBeacon('/path-to-your-script.php', new URLSearchParams({ clearSession: 'true' }));
  document.cookie = "startTime=; path=/; expires=Thu, 01 Jan 1970 00:00:00 UTC;";

  alert('Session has been destroyed due to inactivity.');
  window.location.reload(); 
}


document.addEventListener('click', resetInactivityTimer);
document.addEventListener('keydown', resetInactivityTimer);
document.addEventListener('mousemove', resetInactivityTimer);
document.addEventListener('scroll', resetInactivityTimer);


window.addEventListener('load', resetInactivityTimer);

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

</body>
</html>
