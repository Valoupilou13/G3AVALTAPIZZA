<?php
session_start();

function db_connect(): PDO {
    $dsn = 'mysql:host=localhost;dbname=G3AVALTAPIZZA;charset=utf8mb4'; 
    $user = 'root'; 
    $password = ''; 

    try {
        $dbh = new PDO($dsn, $user, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $dbh;
    } catch (PDOException $ex) {
        die("Erreur de connexion à la BDD : " . $ex->getMessage());
    }
}

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dbh = db_connect();

    $login = trim($_POST['login'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $pass  = $_POST['mdp'] ?? '';

    if (!empty($login) && !empty($email) && !empty($pass)) {
        $passwordHash = password_hash($pass, PASSWORD_DEFAULT);
        $sql = "INSERT INTO utilisateur (login, password, email) VALUES (:login, :password, :email)";

        try {
            $sth = $dbh->prepare($sql);
            $sth->execute([
                ':login'    => $login,
                ':password' => $passwordHash,
                ':email'    => $email
            ]);

            if ($sth->rowCount() > 0) {
                header('Location: connexion.php?inscription=succes');
                exit();
            }
        } catch (PDOException $ex) {
            $message = "<div style='color:#ff4444; background:#ffe5e5; padding:10px; margin-bottom:15px; border-radius:5px; text-align:center;'>Cet e-mail ou cet identifiant est déjà utilisé.</div>";
        }
    } else {
        $message = "<div style='color:#ff4444; background:#ffe5e5; padding:10px; margin-bottom:15px; border-radius:5px; text-align:center;'>Veuillez remplir tous les champs.</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AVALTAPIZZA - Inscription</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <header>
        <img src="img/logo.png" alt="Logo AVALTAPIZZA">
        <h1>AVALTAPIZZA</h1>
        <nav>
            <a href="index.php">Accueil</a>
            <a href="produits.php">Carte & Produits</a>
            <a href="connexion.php">Connexion</a>
            <a href="inscription.php">Inscription</a>
            <a href="deconnexion.php">Déconnexion</a>
        </nav>
    </header>

    <main class="container">
        <div class="form-box">
            <h2>Inscription</h2>

            <?= $message ?>

            <form id="formulaire" action="" method="POST">
                <div class="form-group">
                    <label>Identifiant :</label>
                    <input type="text" name="login" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="nom@exemple.com" required>
                </div>
                <div class="form-group">
                    <label for="mdp">Mot de passe</label>
                    <input type="password" id="mdp" name="mdp" required>
                </div>
                <button type="submit" name="submit" class="btn-primary">S'inscrire</button>
            </form>
            <p class="form-text-link">
                Vous avez déjà un compte ? <a href="connexion.php">Se connecter</a>
            </p>
        </div>
    </main>

    <footer>
        <p>&copy; 2026 AVALTAPIZZA - Tous droits réservés</p>
    </footer>

</body>
</html>