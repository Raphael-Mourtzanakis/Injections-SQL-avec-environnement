<?php
require_once __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load(); // charge les variables d’environnement avec la méthode load() de la classe Dotenv

// Paramètres de la base de données
$host = $_ENV['DB_HOST']; // l'hôte de la base de données
$database = $_ENV['DB_NAME']; // nom de la base de données
$user_mysql = $_ENV['DB_USER']; // nom d'utilisateur de l'utilisateur de MySQL
$password_mysql = $_ENV['DB_PASS']; // mot de passe de l'utilisateur de MySQL

// Mode DEBUG
$debug = filter_var($_ENV['DEBUG'], FILTER_VALIDATE_BOOLEAN);

// Connexion à la base de données
$db = mysqli_connect($host, $user_mysql, $password_mysql, $database);
mysqli_set_charset($db, "utf8");
if ($debug) {
    echo "Connexion à la base de données réussie";
}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Connexion</title>
		<style>
			input {
				display: block;
			}
		</style>
	</head>
	<body>
		<h1>Connexion au site d'administration</h1>
		<?php
			if (!empty($_GET['username']) && !empty($_GET['password']))
			{
				$username = mysqli_real_escape_string($db, $_GET['username']); // Mettre des "\" pour pouvoir insérer tous les caractères comme des chaînes de caractère, comme les caractères pour les commentaires sans créer des commentaires
				$password = mysqli_real_escape_string($db, $_GET['password']); // Mettre des "\" pour pouvoir insérer tous les caractères comme des chaînes de caractère, comme les caractères pour les commentaires sans créer des commentaires
				$password = hash("md2",$password); // Hasher le mot de passe
				$p_query = $db->prepare("SELECT id, username FROM users WHERE username = ? AND password = ?");
				$p_query->bind_param("ss", $username, $password); // Lier les variables avec les "?", le ss c'est pour dire que c'est des string
				$p_query->execute();
				$p_query->store_result();
				if ($p_query->num_rows == 1) {
					$p_query->bind_result($id, $username);
					$p_query->fetch();
					echo "Bienvenue ".htmlspecialchars($username);
				} else {
					echo "Mauvais nom d'utilisateur et/ou mot de passe !";
				}
				$p_query->close();
				$db->close();
			}
		?>
		<form action="connexion.php" method="GET">
			<b>Nom d'utilisateur :</b> <input type="text" name="username"/>
			<b>Mot de passe :</b> <input type="text" name="password" />
			<input type="submit" value="Connexion" />
		</form>
	</body>
</html>