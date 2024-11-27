<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>
	<?php
	include("workbtask1.php");

	$mysqli = connectToDatabase();
	
	$sql = "SELECT Movie_name, Genre, Price FROM Movie";
	$result = $mysqli -> query($sql);?>
	<table class="table">
	<?php while($a_row = $result->fetch_assoc()):?>

		<tr>
			<td><?=$a_row['Movie_name']?></td>
			<td><?=$a_row['Genre']?></td>
			<td><?=$a_row['Price']?></td>
		</tr>
	
	<?php endwhile;?>
	</table>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>