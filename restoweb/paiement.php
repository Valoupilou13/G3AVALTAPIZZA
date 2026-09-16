<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paiement Carte Bancaire - avalTApizza</title>
</head>
<body>

    <header>
        <h1>avalTApizza</h1>
        <p>Commandes en ligne - Étape de paiement sécurisé</p>
        <hr>
    </header>

    <main>
        <section>
            <h2>Résumé de votre commande avalTApizza</h2>
            <article>
                <table border="1">
                    <thead>
                        <tr>
                            <th scope="col">Article</th>
                            <th scope="col">Quantité</th>
                            <th scope="col">Prix unitaire</th>
                            <th scope="col">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Pizza avalTA Regina (Sauce tomate, mozzarella, jambon, champignons)</td>
                            <td>1</td>
                            <td>12,90 €</td>
                            <td>12,90 €</td>
                        </tr>
                        <tr>
                            <td>Pizza avalTA 4 Fromages (Base crème, gorgonzola, chèvre, mozzarella, emmental)</td>
                            <td>1</td>
                            <td>14,50 €</td>
                            <td>14,50 €</td>
                        </tr>
                        <tr>
                            <td>Boisson Coca-Cola (33cl)</td>
                            <td>2</td>
                            <td>2,50 €</td>
                            <td>5,00 €</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th scope="row" colspan="3">Sous-total</th>
                            <td>32,40 €</td>
                        </tr>
                        <tr>
                            <th scope="row" colspan="3">Frais de livraison</th>
                            <td>2,50 €</td>
                        </tr>
                        <tr>
                            <th scope="row" colspan="3">Total à payer</th>
                            <td><strong>34,90 €</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </article>
        </section>

        <hr>

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
                            placeholder="ex: Jean Dupont" 
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
                            placeholder="1234 5678 9012 3456" 
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
                            placeholder="MM/AA" 
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
                            placeholder="123" 
                            autocomplete="cc-csc"
                        >
                    </p>

                    <p>
                        <input type="checkbox" id="savecard" name="savecard">
                        <label for="savecard">Enregistrer cette carte pour mes prochaines pizzas chez avalTApizza</label>
                    </p>

                </fieldset>

                <p>
                    <button type="submit">Valider et payer 34,90 €</button>
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