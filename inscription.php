<?php
    require_once 'configs.php';
?>

<!DOCTYPE>
<html>
    <head>
        <title>Inscription</title>
        <style>
            input
                {
                    display: block;
                }
        </style>
    </head>
    <body>
        <h1>Inscription</h1>
        <?php
            if(!empty($_GET['username']) && !empty($_GET['password']))
            {
                $username = $_GET['username'];
                $password = $_GET['password'];
                $password = hash("md2", $password); // Hasher le mot de passe
                $query = "SELECT username FROM users WHERE username = '".$username."'";
                try {
                    $rs = mysqli_query($db, $query);
                    $exist = (mysqli_num_rows($rs) >= 1);
                } catch(Exception $e) {
                    $rs=null;
                    $exist=false;
                }
                if ($exist) {
                    echo "Ce pseudo est déjà utilisé.\n";
                } else {
                    mysqli_query($db, "INSERT INTO users (username, password, rank) VALUES ('".$username."', '".$password."', 2)");
                }
                mysqli_free_result($rs);
                mysqli_close($db);
            }
        ?>
        <form action="inscription.php" method="GET">
            <b>Pseudo :</b> <input type="text" name="username"/>
            <b>Mot de passe :</b> <input type="text" name="password" />
            <input type="submit" value="S'inscrire" />
        </form>
    </body>
</html>