<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Restitution du matériel</title>
</head>
<body style="margin:0; padding:20px; background:#eeeeee; font-family:Arial, sans-serif; color:#333;">
    <div style="max-width:600px; margin:0 auto; background:#ffffff; border-radius:8px; overflow:hidden;">
        <div style="background:#F44336; padding:25px; color:#ffffff; text-align:center;">
            <h1 style="margin:0;">{{ config('settings.site_name') }}</h1>
        </div>

        <div style="padding:30px;">
            <h2>Restitution du matériel prêté</h2>

            <p>Bonjour {{ $order->user->name ?? 'cher client' }},</p>

            <p>
                Dans le cadre de votre commande
                <strong>#{{ $order->invoice_id }}</strong>,
                du matériel vous a été prêté.
            </p>

            <p>
                Conformément aux conditions de prêt, vous disposez de
                <strong>10 jours ouvrés</strong> pour restituer le matériel.
                À défaut de restitution dans ce délai, un montant de
                <strong>600 €</strong> pourra être demandé conformément aux
                conditions applicables.
            </p>

            <p>
                Merci de contacter notre équipe afin de convenir des modalités
                et de la date de restitution du matériel.
            </p>

            <p style="text-align:center; margin:30px 0;">
                <a href="{{ url('/') }}"
                   style="display:inline-block; background:#F44336; color:#ffffff;
                          padding:12px 24px; text-decoration:none; border-radius:4px;">
                    Contacter notre entreprise
                </a>
            </p>

            <p>Merci de votre confiance.</p>
            <p>L'équipe {{ config('settings.site_name') }}</p>
        </div>
    </div>
</body>
</html>
