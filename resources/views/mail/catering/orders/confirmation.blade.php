
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Confirmation de commande traiteur</title>
</head>
<body>
    <h1>Bonjour {{ $order->catering_first_name }},</h1>

    <p>
        Nous avons bien reçu votre commande traiteur.
        Elle est en attente de validation par notre équipe.
    </p>

    <h2>Récapitulatif</h2>

    <p>
        <strong>Référence :</strong>
        {{ $order->invoice_id }}
    </p>

    <p>
        <strong>Menu :</strong>
        {{ $order->cateringMenu?->title ?? 'Menu traiteur' }}
    </p>

    <p>
        <strong>Date :</strong>
        {{ $order->delivery_date }}
    </p>

    <p>
        <strong>Heure souhaitée :</strong>
        {{ $order->delivery_time }}
    </p>

    <p>
        <strong>Nombre de personnes :</strong>
        {{ $order->number_of_persons }}
    </p>

    <p>
        <strong>Adresse de livraison :</strong>
        {{ $order->address }}
    </p>

    <hr>

    <p>
        Prix du menu :
        {{ number_format((float) $order->subtotal, 2, ',', ' ') }} €
    </p>

    <p>
        Livraison :
        {{ number_format((float) $order->delivery_charge, 2, ',', ' ') }} €
    </p>

    <p>
        Réduction :
        {{ number_format((float) $order->discount, 2, ',', ' ') }} €
    </p>

    <h3>
        Total :
        {{ number_format((float) $order->grand_total, 2, ',', ' ') }} €
    </h3>

    <p>
        Vous serez informé(e) lorsque notre équipe aura traité votre commande.
    </p>

    <p>Merci pour votre confiance !</p>
</body>
</html>
