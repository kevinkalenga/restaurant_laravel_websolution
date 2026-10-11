
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détail de la commande #{{ $order->id }}</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            background: #f5f5f5;
            color: #333;
        }

        .container {
            max-width: 900px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
        }

        h1 { color: #6b3e26; }

        .info {
            margin-bottom: 20px;
            line-height: 1.8;
        }

        form { margin: 18px 0; }

        label {
            display: inline-block;
            margin: 5px 0;
        }

        input, select, textarea, button {
            padding: 9px;
            margin: 5px 0;
            max-width: 100%;
        }

        button {
            cursor: pointer;
            background: #6b3e26;
            color: white;
            border: 0;
            border-radius: 4px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        th { background: #eee; }

        .back {
            display: inline-block;
            margin-top: 20px;
            color: #6b3e26;
        }

        .message {
            padding: 12px;
            margin: 12px 0;
            border-radius: 4px;
        }

        .success {
            color: #155724;
            background: #d4edda;
        }

        .error {
            color: #721c24;
            background: #f8d7da;
        }

        .history {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
        }

        .history-item {
            margin: 15px 0;
            padding: 12px 15px;
            background: #f9f6f3;
            border-left: 4px solid #6b3e26;
            border-radius: 4px;
        }

        .history-item p { margin: 5px 0; }

        .history-date {
            color: #666;
            font-size: 0.9em;
        }

        .field {
            display: block;
            width: 100%;
            box-sizing: border-box;
            margin: 6px 0 12px;
        }
    </style>
</head>

<body>
<div class="container">
    <h1>Détail de la commande #{{ $order->id }}</h1>

    @if (session('success'))
        <div class="message success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="message error">{{ session('error') }}</div>
    @endif

    @if ($errors->any())
        <div class="message error">
            <strong>Veuillez corriger les erreurs suivantes :</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="info">
        <strong>Client :</strong>
        {{ $order->user->name ?? 'Client inconnu' }}<br>

        <strong>Email :</strong>
        {{ $order->user->email ?? 'Non renseigné' }}<br>

        <strong>Téléphone :</strong>
        {{ $order->user->phone ?? 'Non renseigné' }}<br>

        <strong>Adresse de livraison :</strong>
        {{ $order->address }}<br>

        <strong>Statut :</strong>
        {{ $order->order_status }}<br>

        <strong>Matériel prêté :</strong>
        {{ $order->equipment_loaned ? 'Oui' : 'Non' }}<br>

        <strong>Total :</strong>
        {{ number_format($order->grand_total, 2, ',', ' ') }} €
    </div>

    @if (!in_array($order->order_status, ['completed', 'cancelled'], true))
        <h2>Matériel prêté</h2>

        <form action="{{ route('employe.orders.updateEquipment', $order->id) }}"
              method="POST">
            @csrf
            @method('PATCH')

            @if ($order->order_status === 'waiting_equipment_return'
                && $order->equipment_loaned)

                <p>
                    Confirme la restitution réelle du matériel avant
                    de terminer la commande.
                </p>

                <input type="hidden" name="equipment_loaned" value="0">

                <label>
                    <input type="checkbox"
                           name="equipment_return_confirmed"
                           value="1"
                           required>
                    Je confirme que le matériel a bien été restitué.
                </label>

                <button type="submit">
                    Confirmer la restitution et terminer
                </button>
            @else
                <label for="equipment_loaned">
                    Matériel prêté au client ?
                </label>

                <select name="equipment_loaned"
                        id="equipment_loaned"
                        class="field"
                        required>
                    <option value="0"
                        {{ !$order->equipment_loaned ? 'selected' : '' }}>
                        Non
                    </option>

                    <option value="1"
                        {{ $order->equipment_loaned ? 'selected' : '' }}>
                        Oui
                    </option>
                </select>

                <button type="submit">Enregistrer le matériel</button>
            @endif
        </form>

        <h2>Modifier le statut</h2>

        @php
            $statusLabels = [
                'pending' => 'En attente',
                'accepted' => 'Acceptée',
                'in_process' => 'En préparation',
                'in_delivery' => 'En cours de livraison',
                'delivered' => 'Livrée',
                'waiting_equipment_return' => 'En attente du retour du matériel',
                'completed' => 'Terminée',
                'cancelled' => 'Annulée',
            ];

            $allowedTransitions = [
                'pending' => ['accepted', 'cancelled'],
                'accepted' => ['in_process', 'cancelled'],
                'in_process' => ['in_delivery'],
                'in_delivery' => ['delivered'],
                'delivered' => [
                    'completed',
                    'waiting_equipment_return',
                ],
                'waiting_equipment_return' => [],
                'completed' => [],
                'cancelled' => [],
            ];

            $nextStatuses = $allowedTransitions[$order->order_status] ?? [];
        @endphp

        @if (count($nextStatuses))
            <form action="{{ route('employe.orders.updateStatus', $order->id) }}"
                  method="POST">
                @csrf
                @method('PATCH')

                <label for="order_status">
                    Nouveau statut :
                </label>

                <select name="order_status"
                        id="order_status"
                        class="field"
                        required>
                    @foreach ($nextStatuses as $status)
                        @if (
                            $status !== 'completed'
                            || !$order->equipment_loaned
                        )
                            <option value="{{ $status }}">
                                {{ $statusLabels[$status] }}
                            </option>
                        @endif
                    @endforeach
                </select>

                <div id="cancellation-fields" hidden>
                    <h3>Informations obligatoires pour l'annulation</h3>

                    <label>
                        <input type="checkbox"
                               name="contact_confirmed"
                               value="1"
                               id="contact_confirmed"
                               disabled>
                        Je confirme avoir contacté le client au préalable.
                    </label>

                    <label for="contact_method">
                        Moyen de contact :
                    </label>

                    <select name="contact_method"
                            id="contact_method"
                            class="field"
                            disabled>
                        <option value="">Choisir un moyen de contact</option>
                        <option value="phone">Téléphone</option>
                        <option value="email">E-mail</option>
                        <option value="sms">SMS</option>
                        <option value="in_person">En personne</option>
                    </select>

                    <label for="cancellation_reason">
                        Motif de l'annulation :
                    </label>

                    <textarea name="cancellation_reason"
                              id="cancellation_reason"
                              class="field"
                              rows="3"
                              maxlength="1000"
                              disabled></textarea>
                </div>

                <button type="submit">Enregistrer le statut</button>
            </form>
        @else
            <p>
                Aucun changement de statut n'est autorisé depuis
                l'état actuel de cette commande.
            </p>
        @endif
    @endif

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
                    <td>
                        {{ number_format($item->unit_price, 2, ',', ' ') }} €
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">Aucun article trouvé.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="history">
        <h2>Historique des statuts</h2>

        @forelse ($order->statusHistories as $history)
            <div class="history-item">
                <p>
                    <strong>
                        {{ $statusLabels[$history->old_status] ?? ($history->old_status ?? 'Création') }}
                        →
                        {{ $statusLabels[$history->new_status] ?? $history->new_status }}
                    </strong>
                </p>

                <p class="history-date">
                    {{ $history->created_at->format('d/m/Y à H:i') }}
                </p>

                <p>
                    <strong>Modifié par :</strong>
                    {{ $history->employee->name ?? 'Utilisateur inconnu' }}
                </p>

                @if ($history->note)
                    <p><strong>Note :</strong> {{ $history->note }}</p>
                @endif
            </div>
        @empty
            <p>Aucun changement de statut enregistré pour cette commande.</p>
        @endforelse
    </div>

    <a class="back" href="{{ route('employe.dashboard') }}">
        ← Retour au tableau de bord
    </a>
</div>

<script>
    const statusSelect = document.getElementById('order_status');
    const cancellationFields = document.getElementById('cancellation-fields');

    function toggleCancellationFields() {
        if (!statusSelect || !cancellationFields) return;

        const cancelling = statusSelect.value === 'cancelled';

        cancellationFields.hidden = !cancelling;

        cancellationFields.querySelectorAll('input, select, textarea')
            .forEach(field => {
                field.disabled = !cancelling;
                field.required = cancelling;
            });
    }

    if (statusSelect) {
        statusSelect.addEventListener('change', toggleCancellationFields);
        toggleCancellationFields();
    }
</script>
</body>
</html>
