<?php

session_start();



if (isset($_GET['search'])) {
    $searchTerm = '%' . $_GET['search'] . '%';  

    $sql = "SELECT * FROM players WHERE Players LIKE ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();


    while ($a_row = $result->fetch_assoc()) {
        echo "<tr style='text-align:center;'>
                <td><a href='detail.php?name=" . urlencode($a_row['Players']) . "'>" . htmlspecialchars($a_row['Players']) . "</a></td>
                <td>" . htmlspecialchars($a_row['Position']) . "</td>
                <td>" . htmlspecialchars($a_row['Team']) . "</td>
                <td><button>Delete</button></td>
                <td><button>Update</button></td>
                <td><button>Add</button></td>
              </tr>";
    }

    if ($result->num_rows === 0) {
        echo "<tr><td colspan='6' style='text-align:center;'>No players found</td></tr>";
    }
}
?>
