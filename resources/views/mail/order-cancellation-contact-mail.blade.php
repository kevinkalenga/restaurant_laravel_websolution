<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Concernant votre commande</title>
</head>
<body>
    <h2>Bonjour {{ $order->user->name ?? '' }},</h2>

    <p>
        Nous vous contactons au sujet de votre commande
        <strong>{{ $order->invoice_id }}</strong>.
    </p>

    <p>
        Nous souhaitons vous informer du problème suivant :
    </p>

    <p>
        {{ $cancellationReason }}
    </p>

    <p>
        Ce message constitue notre prise de contact avant
        l'annulation de votre commande.
    </p>

    <p>
        Cordialement,<br>
        L'équipe du restaurant
    </p>
</body>
</html>