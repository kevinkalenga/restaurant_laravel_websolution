<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Donnez votre avis</title>
</head>
<body style="margin:0; padding:20px; background:#eeeeee; font-family:Arial, sans-serif; color:#333;">
    <div style="max-width:600px; margin:0 auto; background:#ffffff; border-radius:8px; overflow:hidden;">
        <div style="background:#F44336; padding:25px; color:#ffffff; text-align:center;">
            <h1 style="margin:0;">{{ config('settings.site_name') }}</h1>
        </div>

        <div style="padding:30px;">
            <h2>Votre avis nous intéresse !</h2>

            <p>Bonjour {{ $order->user->name ?? 'cher client' }},</p>

            <p>
                Votre commande <strong>#{{ $order->invoice_id }}</strong>
                est terminée. Nous espérons que votre expérience vous a plu.
            </p>

            <p>
                Nous vous invitons à vous connecter à votre compte pour
                partager votre expérience et attribuer une note de 1 à 5.
                Votre retour nous aide à améliorer notre service.
            </p>

            <p style="text-align:center; margin:30px 0;">
                <a href="{{ route('login') }}"
                   style="display:inline-block; background:#F44336; color:#ffffff;
                          padding:12px 24px; text-decoration:none; border-radius:4px;">
                    Me connecter pour donner mon avis
                </a>
            </p>

            <p>Merci pour votre confiance !</p>
            <p>L'équipe {{ config('settings.site_name') }}</p>
        </div>
    </div>
</body>
</html>
