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