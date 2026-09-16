<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paiement Carte Bancaire - AVALTAPIZZA</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <header>
        <img src="img/logo.png" alt="Logo AVALTAPIZZA">
        <h1>AVALTAPIZZA</h1>
        <p>Paiement sécurisé de votre commande</p>
    </header>

    <main class="container">
        <div class="form-box" style="max-width: 550px;">
            <h2>Payer par Carte Bancaire</h2>

            <form action="traitement-paiement.php" method="POST">
                <fieldset>
                    <legend>Informations de la carte</legend>

                    <div class="form-group">
                        <label for="cardholder">Nom figurant sur la carte</label>
                        <input type="text" id="cardholder" name="cardholder" required autocomplete="cc-name">
                    </div>

<<<<<<< HEAD
                    <div class="form-group">
                        <label for="cardnumber">Numéro de carte bancaire</label>
                        <input type="text" id="cardnumber" name="cardnumber" required inputmode="numeric" maxlength="19" autocomplete="cc-number" placeholder="1234 5678 9101 1121">
                    </div>

                    <div style="display: flex; gap: 1rem;">
                        <div class="form-group" style="flex: 1;">
                            <label for="cardexpiry">Expiration (MM/AA)</label>
                            <input type="text" id="cardexpiry" name="cardexpiry" required inputmode="numeric" maxlength="5" placeholder="MM/AA" autocomplete="cc-exp">
                        </div>

                        <div class="form-group" style="flex: 1;">
                            <label for="cardcvc">Code CVC / CVV</label>
                            <input type="text" id="cardcvc" name="cardcvc" required inputmode="numeric" maxlength="4" placeholder="123" autocomplete="cc-csc">
                        </div>
                    </div>
=======
                    <p>
                        <label for="cardnumber">Numéro de carte bancaire :</label><br>
                        <input 
                            type="text" 
                            id="cardnumber" 
                            name="cardnumber" 
                            required  
                            maxlength="19"
                            autocomplete="cc-number"
                        >
                    </p>

                    <p>
                        <label for="cardexpiry">Date d'expiration (MM/AA) :</label><br>
                        <input 
                            type="text" 
                            id="cardexpiry" 
                            name="cardexpiry" 
                            required 
                            maxlength="5" 
                            autocomplete="cc-exp"
                        >
                    </p>

                    <p>
                        <label for="cardcvc">Code de sécurité CVC / CVV :</label><br>
                        <input 
                            type="text" 
                            id="cardcvc" 
                            name="cardcvc" 
                            required 
                            maxlength="4" 
                            autocomplete="cc-csc"
                        >
                    </p>
>>>>>>> 2ac5a7e18ad5e6d1a15a2864cddc625b4b573a8f

                    <div style="margin-top: 0.5rem;">
                        <input type="checkbox" id="savecard" name="savecard">
                        <label for="savecard" style="font-weight: normal; font-size: 0.9rem;">Enregistrer cette carte pour mes prochains achats</label>
                    </div>
                </fieldset>

                <button type="submit" class="btn-primary" style="width: 100%;">Valider et payer</button>
            </form>
        </div>
    </main>

    <footer>
        <p>&copy; 2026 AVALTAPIZZA - Tous droits réservés. Transactions sécurisées SSL.</p>
    </footer>

</body>
</html>