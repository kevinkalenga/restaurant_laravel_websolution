<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détail de la commande</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; background: #f5f5f5; color: #333; }
        .container { max-width: 900px; margin: auto; background: white; padding: 25px; border-radius: 10px; }
        h1 { color: #6b3e26; }
        .info { margin-bottom: 20px; line-height: 1.8; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { padding: 10px; border-bottom: 1px solid #ddd; text-align: left; }
        th { background: #eee; }
        .back { display: inline-block; margin-top: 20px; color: #6b3e26; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Détail de la commande #{{ $order->id }}</h1>

        <div class="info">
            <strong>Client :</strong> {{ $order->user->name ?? 'Client inconnu' }}<br>
            <strong>Email :</strong> {{ $order->user->email ?? 'Non renseigné' }}<br>
            <strong>Téléphone :</strong> {{ $order->user->phone ?? 'Non renseigné' }}<br>
            <strong>Adresse de livraison :</strong> {{ $order->address }}<br>
            <strong>Statut :</strong> {{ $order->order_status }}<br>
            
           
            @if (session('success'))
                <p style="color: green;">{{ session('success') }}</p>
            @endif

            <form action="{{ route('employe.orders.updateStatus', $order->id) }}"
                method="POST"
                style="margin-top: 15px;">
                @csrf
                @method('PATCH')

                <label for="order_status"><strong>Modifier le statut :</strong></label>

                <select name="order_status" id="order_status" required>
                    <option value="pending" {{ $order->order_status === 'pending' ? 'selected' : '' }}>
                        En attente
                    </option>
                    <option value="in_process" {{ $order->order_status === 'in_process' ? 'selected' : '' }}>
                        En préparation
                    </option>
                    <option value="delivered" {{ $order->order_status === 'delivered' ? 'selected' : '' }}>
                        Livrée
                    </option>
                </select>

                <button type="submit">Enregistrer le statut</button>
            </form>

            
            
            
            <strong>Total :</strong> {{ number_format($order->grand_total, 2, ',', ' ') }} €
        </div>

        <h2>Articles commandés</h2>

        <table>
            <thead>
                <tr>
                    <th>Article</th>
                    <th>Quantité</th>
                    <th>Prix unitaire</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($order->orderItems as $item)
                    <tr>
                        <td>{{ $item->product_name }}</td>
                        <td>{{ $item->qty }}</td>
                        <td>{{ number_format($item->unit_price, 2, ',', ' ') }} €</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">Aucun article trouvé.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <a class="back" href="{{ route('employe.dashboard') }}">← Retour au tableau de bord</a>
    </div>
</body>
</html>
