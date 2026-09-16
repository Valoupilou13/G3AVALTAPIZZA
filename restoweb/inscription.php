<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
</head>
<body>
    <h1>Bienvenue dans la page d'inscription</h1>

    <form id="formulaire" action="inscription.php" method="post">
    <label for="email" >Email</label> <br>
    <input type="text" id="email" name="email" value="Mon email"/> <br><br>
    <label for="pseudo" >Pseudo</label> <br>
    <input type="text" id="pseudo" name="pseudo" value="Mon pseudo"/> <br><br>
    <label for="Mot de passe">Mot de passe</label>
    <input name="mdp" id="Mot de passe" type="password" size="10" value="" /> <br><br>
    <input type="submit" name="submit" value="S'inscrire" />
    </form>
</body>
</html>