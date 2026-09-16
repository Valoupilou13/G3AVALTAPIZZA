<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>connexion</title>
</head>
<body>

    <h2>Veuillez vous connecter à votre compte </h2>

    <p>Vous n'avez pas de compte ? <a href="inscription.php" title="Linktitle">S'inscrire</a></p>

    <form action="produits.php" method="POST">

        <label>Adresse mail :</label></br>
        <input name="email" id="mail" type="text" value="" /></br></br>

        <label>Mot de passe:</label></br>
        <input name="mdp" id="mdp" type="password" size="10" value="" /></br></br>

        <input type="submit" name="submit" value="Se connecter"/>
        
    </form>
</body>
</html>