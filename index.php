<?php 
	require '_config.php';
?>

<!DOCTYPE html>
<html lang="ru">
	<head>
		<title>Простой новостной портал</title>
		<meta charset="utf-8">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
		<link href="All.css" rel=" stylesheet" type=" text/css">
		<script src="All.js" defer></script>
	</head>

	<body>
		<div class="wrapper">
			<?php 
				require_once('Repeat/Header.php');
			?>
			<div class="content">
				<h1>Простой Новостной портал</h1>
				<?php echo ($dir);
						?>
				<table class="maintable">
				<?php
					$sql = 'SELECT * FROM `news` ORDER BY `date` DESC ';
					$sql = mysqli_query($mysqli, $sql);
					while ($row = mysqli_fetch_assoc($sql)){
						echo	
							'<tbody class="news"><tr><td rowspan = "3" width="100px"><a class="anews" href="' . $www . '/news.php?id=' . $row['id'] . '"><img src="' . $www . '/images/' . $row['id'] . '.jpg" width="100px" /></a></td><td><a class="anews" href="' . $www . '/news.php?id=' . $row['id'] . '"><b>' . $row['title'] . '</b></a></td></tr>' .
							'<tr><td><a class="anews" href="' . $www . '/news.php?id=' . $row['id'] . '">' . $row['date'];
						if($row['dateedit'] !="0000-00-00 00:00:00"){ 
							echo ' / ' . $row['dateedit']; 
						}
						echo '</a></td></tr>'.
							'<tr><td><a class="anews" href="' . $www . '/news.php?id=' . $row['id'] . '">' . $row['abstract'] . '</a></td></tr></tbody>'.
							'<tr><td colspan = "2"><br /></tr>';
					}
				?>	
				</table>
			</div>
			<?php 
					require_once('Repeat/footer.php');
			?>
		</div>
	</body>
</html>	