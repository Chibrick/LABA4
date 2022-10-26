<?php 
	require '_config.php';

	if (isset($_GET['id'])){
		$id = (int) $_GET['id'];
	} else {
		header('Location: ' . $www);
		exit;
	}

	$sql = 'SELECT * FROM `news` WHERE `id`=' . $id;
	$sql = mysqli_query($mysqli, $sql);

	if (mysqli_affected_rows($mysqli) == 0) {
?>

	<h4>Новости с указанным номером не существует</h4>
	<a href = "<?php echo $www; ?>">На главную</a>

	<?php
		exit;
		}



		$row = mysqli_fetch_assoc($sql);
	?>

<!DOCTYPE html>
<html lang="ru">
	<head>
		<title><?php echo $row['title']; ?></title>
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
				<h1 align="center"><?php echo $row['title']; ?></h1>
				<?php
					echo $row['date'] . '<br />' .
					'<img src="' . $www . '/images/' . $row['id'] . '.jpg" width="300 px" /><br /><br />' .
					'<i>' . $row['abstract'] . '</i><br /><br />' .
					nl2br($row['text']) . '<br /><br />';
				?>
			</div>
			<?php 
					require_once('Repeat/footer.php');
			?>
		</div>
	</body>
</html>	