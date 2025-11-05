<?php
    require_once 'configs.php';
?>

<!DOCTYPE html>
	<html>
		<head>
			<title>Article</title>
		</head>
	<body>
		<?php
			if (ctype_digit($_GET['category'])) { // Vérifier si chaque caractère dans la valeur de category est un chiffre
				$category = mysqli_real_escape_string($db, $_GET['category']);
				$p_query = $db->prepare("SELECT id, title, DATE_FORMAT(date, '%d/%m/%Y') AS date FROM articles WHERE category_id = ?");
				$p_query->bind_param('id','category');
				$p_query->execute();
				$p_query->bind_result($id, $title, $date);
				while($p_query->fetch()) {
					echo "<li><a href=\"#\">".$id." ".$title." ".$date."</a></li><br>";
				}
			}
		?>
	</body>
</html>