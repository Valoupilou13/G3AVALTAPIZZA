<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paiement Carte Bancaire - avalTApizza</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <header>
        <h1>avalTApizza</h1>
        <p>Commandes en ligne - Étape de paiement sécurisé</p>
    </header>

        <section>
            <h2>Payer avec une carte bancaire</h2>

            <form action="/traitement-paiement" method="POST">
                
                <fieldset>
                    <legend>Information de la carte bancaire</legend>

                    <p>
                        <label for="cardholder">Nom figurant sur la carte :</label><br>
                        <input 
                            type="text" 
                            id="cardholder" 
                            name="cardholder" 
                            required 
                            autocomplete="cc-name"
                        >
                    </p>

                    <p>
                        <label for="cardnumber">Numéro de carte bancaire :</label><br>
                        <input 
                            type="text" 
                            id="cardnumber" 
                            name="cardnumber" 
                            required 
                            inputmode="numeric" 
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
                            inputmode="numeric" 
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
                            inputmode="numeric" 
                            maxlength="4" 
                            autocomplete="cc-csc"
                        >
                    </p>

                    <p>
                        <input type="checkbox" id="savecard" name="savecard">
                        <label for="savecard">Enregistrer cette carte pour mes prochain achats</label>
                    </p>

                </fieldset>

                <p>
                    <button type="submit">Valider et payer</button>
                </p>

            </form>
        </section>

    </main>

    <footer>
        <hr>
        <p><small>&copy; 2026 avalTApizza - Tous droits réservés. Transactions sécurisées SSL.</small></p>
    </footer>

</body>
</html>