<?php
    require_once 'configs.php';
?>

<!DOCTYPE html>
	<html lang="fr">
		<head>
			<title>User</title>
			<meta charset="UTF-8" />
		</head>
	<body>
		<?php
			if (ctype_digit($_GET['id'])) {
				$id = mysqli_real_escape_string($db, $_GET['id']);
				$p_query = $db->prepare("SELECT id, username FROM users WHERE id = ?");
				$p_query->bind_param("id");
				$p_query->execute();
				$p_query->store_result();
				if ($p_query->num_rows == 1) {
					$p_query->bind_result($id);
					$p_query->fetch();
					echo "<p>Utilisateur existant.</p>";
				} else {
					echo "<p>Utilisateur inexistant.</p>";
				}
				$p_query->close();
				$db->close();
			}
		?>
	</body>
</html>