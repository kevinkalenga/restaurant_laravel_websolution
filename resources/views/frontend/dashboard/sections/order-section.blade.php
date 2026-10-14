
<div class="tab-pane fade" id="v-pills-profile" role="tabpanel"
    aria-labelledby="v-pills-profile-tab">

    <div class="fp_dashboard_body">
        <h3>Mes commandes</h3>

        <div class="fp_dashboard_order">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr class="t_header">
                            <th>Commande</th>
                            <th>Date</th>
                            <th>Statut</th>
                            <th>Montant</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($orders as $order)
                            <tr>
                                <td>
                                    <h5>#{{ $order->invoice_id }}</h5>
                                </td>

                                <td>
                                    <p>{{ $order->created_at->format('d/m/Y') }}</p>
                                </td>

                                <td>
                                    @switch($order->order_status)
                                        @case('pending')
                                            <span class="active">En attente</span>
                                            @break
                                        @case('accepted')
                                            <span class="active">Acceptée</span>
                                            @break
                                        @case('in_process')
                                            <span class="active">En préparation</span>
                                            @break
                                        @case('in_delivery')
                                            <span class="active">En livraison</span>
                                            @break
                                        @case('delivered')
                                            <span class="complete">Livrée</span>
                                            @break
                                        @case('waiting_equipment_return')
                                            <span class="active">Retour du matériel attendu</span>
                                            @break
                                        @case('completed')
                                            <span class="complete">Terminée</span>
                                            @break
                                        @case('declined')
                                            <span class="cancel">Refusée</span>
                                            @break
                                        @case('cancelled')
                                            <span class="cancel">Annulée</span>
                                            @break
                                        @default
                                            <span>{{ ucfirst(str_replace('_', ' ', $order->order_status)) }}</span>
                                    @endswitch
                                </td>

                                <td>
                                    <h5>{{ currencyPosition($order->grand_total) }}</h5>
                                </td>

                                <td>
                                    <a class="view_invoice"
                                       href="javascript:void(0);"
                                       onclick="viewInvoice('{{ $order->id }}')">
                                        Voir
                                    </a>

                                    @if($order->order_status === 'pending' && $order->catering_menu_id)
                                        <a href="{{ route('catering-orders.edit', $order->id) }}"
                                           class="btn btn-primary btn-sm">
                                            Modifier
                                        </a>
                                    @endif

                                    @if($order->order_status === 'completed' && $order->catering_menu_id)
                                        @if(!$order->cateringReview)
                                            <a href="{{ route('catering-orders.review.create', $order->id) }}"
                                               class="btn btn-success btn-sm">
                                                Laisser un avis
                                            </a>
                                        @else
                                            <a href="#v-pills-messages"
                                               class="btn btn-outline-primary btn-sm"
                                               onclick="openCateringReviews(event)">
                                                Voir mon avis
                                            </a>
                                        @endif
                                    @endif

                                    @if($order->order_status === 'pending')
                                        <form action="{{ route('order.cancel', $order->id) }}"
                                              method="POST"
                                              style="display:inline-block; margin-left:5px;"
                                              onsubmit="return confirm('Voulez-vous vraiment annuler cette commande ?');">
                                            @csrf
                                            @method('PUT')

                                            <button type="submit" class="btn btn-danger btn-sm">
                                                Annuler
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">
                                    Vous n'avez encore aucune commande.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- DÉTAILS ET FACTURES DES COMMANDES --}}
        @foreach($orders as $order)
            <div class="fp__invoice invoice_details_{{ $order->id }}"
                 id="invoice_{{ $order->id }}">

                <a class="go_back" href="javascript:void(0);">
                    <i class="fas fa-long-arrow-alt-left"></i>
                    Retour aux commandes
                </a>

                {{-- SUIVI ET HISTORIQUE --}}
                <div class="fp__track_order">
                    <h4>Suivi de la commande</h4>

                    <p>
                        Statut actuel :
                        <strong>{{ ucfirst(str_replace('_', ' ', $order->order_status)) }}</strong>
                    </p>

                    <div class="order-status-history">
                        <h4>Historique de la commande</h4>

                        @forelse($order->statusHistories as $history)
                            <div class="history-item">
                                <strong>{{ ucfirst(str_replace('_', ' ', $history->new_status)) }}</strong>

                                <small>{{ $history->created_at->format('d/m/Y à H:i') }}</small>

                                @if($history->old_status)
                                    <p>
                                        Statut précédent :
                                        {{ ucfirst(str_replace('_', ' ', $history->old_status)) }}
                                    </p>
                                @endif

                                @if($history->note)
                                    <p>{{ $history->note }}</p>
                                @endif
                            </div>
                        @empty
                            <p>Aucun historique disponible pour cette commande.</p>
                        @endforelse
                    </div>
                </div>

                {{-- AVIS TRAITEUR DANS LES DÉTAILS --}}
                @if($order->catering_menu_id && $order->cateringReview)
                    <div class="fp__track_order mt-4">
                        <h4>Mon avis sur cette commande</h4>

                        <div class="mb-2">
                            <span style="color:#e5a000; font-size:20px; letter-spacing:2px;">
                                @for($i = 1; $i <= 5; $i++)
                                    {{ $i <= $order->cateringReview->rating ? '★' : '☆' }}
                                @endfor
                            </span>

                            <strong>{{ $order->cateringReview->rating }}/5</strong>
                        </div>

                        <p>{{ $order->cateringReview->review }}</p>

                        @if($order->cateringReview->status)
                            <span class="status active">Approuvé</span>
                        @else
                            <span class="status inactive">En attente de validation</span>
                        @endif
                    </div>
                @endif

                {{-- INFORMATIONS DE FACTURATION --}}
                <div class="fp__invoice_header">
                    <div class="header_address">
                        <h4>Facturé à</h4>

                        @php
                            $address = $order->user?->addresses
                                ?->where('delivery_area_id', $order->delivery_area_id)
                                ->first();

                            $isCateringOrder = !is_null($order->catering_menu_id);

                            $customerName = $isCateringOrder
                                ? trim(($order->catering_first_name ?? '') . ' ' . ($order->catering_last_name ?? ''))
                                : ($order->user?->name ?? '');

                            $customerPhone = $isCateringOrder
                                ? $order->catering_phone
                                : ($address->phone ?? '');

                            $customerEmail = $isCateringOrder
                                ? $order->catering_email
                                : ($address->email ?? '');
                        @endphp

                        <p>{{ $customerName }}</p>
                        <p>Adresse : {{ $order->address }}</p>
                        <p>Téléphone : {{ $customerPhone ?: 'Non renseigné' }}</p>
                        <p>Email : {{ $customerEmail ?: 'Non renseigné' }}</p>
                    </div>

                    <div class="header_address" style="width:50%">
                        <p><b>Facture n° :</b> {{ $order->invoice_id }}</p>
                        <p><b>Statut du paiement :</b> {{ $order->payment_status }}</p>
                        <p><b>Moyen de paiement :</b> {{ $order->payment_method }}</p>
                        <p><b>Transaction :</b> {{ $order->transaction_id }}</p>
                        <p><b>Date :</b> {{ $order->created_at->format('d/m/Y') }}</p>
                    </div>
                </div>

                {{-- ARTICLES --}}
                <div class="fp__invoice_body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr class="border_none">
                                    <th class="sl_no">N°</th>
                                    <th class="package">Article</th>
                                    <th class="price">Prix</th>
                                    <th class="qnty">Quantité</th>
                                    <th class="total">Total</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($order->orderItems as $item)
                                    <tr>
                                        <td class="sl_no">{{ $loop->iteration }}</td>

                                        <td class="package">
                                            <p>{{ $item->product_name }}</p>

                                            @if($item->product_size)
                                                @php
                                                    $size = $item->product_size;

                                                    if (is_string($size)) {
                                                        $size = json_decode($size, true);
                                                    }
                                                @endphp

                                                @if(!empty($size))
                                                    <span class="size">
                                                        <strong>Taille :</strong>

                                                        @if(is_array($size))
                                                            {{ $size['name'] ?? '' }}

                                                            @if(isset($size['price']))
                                                                (+{{ currencyPosition($size['price']) }})
                                                            @endif
                                                        @else
                                                            {{ currencyPosition($size) }}
                                                        @endif
                                                    </span>
                                                @endif
                                            @endif

                                            @if($item->product_option)
                                                @php
                                                    $options = $item->product_option;

                                                    if (is_string($options)) {
                                                        $options = json_decode($options, true);
                                                    }
                                                @endphp

                                                @if(!empty($options))
                                                    <span class="coca_cola">
                                                        <strong>Options :</strong>

                                                        @if(is_array($options))
                                                            @foreach($options as $option)
                                                                @if(is_array($option))
                                                                    {{ $option['name'] ?? '' }}

                                                                    @if(isset($option['price']))
                                                                        (+{{ currencyPosition($option['price']) }})
                                                                    @endif
                                                                @else
                                                                    {{ is_numeric($option) ? currencyPosition($option) : $option }}
                                                                @endif

                                                                @if(!$loop->last), @endif
                                                            @endforeach
                                                        @else
                                                            {{ $options }}
                                                        @endif
                                                    </span>
                                                @endif
                                            @endif
                                        </td>

                                        <td class="price">
                                            <b>{{ currencyPosition($item->unit_price) }}</b>
                                        </td>

                                        <td class="qnty">
                                            <b>{{ $item->qty }}</b>
                                        </td>

                                        <td class="total">
                                            <b>{{ currencyPosition($item->unit_price * $item->qty) }}</b>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                            {{-- TOTAUX --}}
                            <tfoot>
                                <tr>
                                    <td class="package" colspan="3"><b>Sous-total</b></td>
                                    <td class="qnty">-</td>
                                    <td class="total"><b>{{ currencyPosition($order->subtotal) }}</b></td>
                                </tr>

                                <tr>
                                    <td class="package coupon" colspan="3"><b>Remise</b></td>
                                    <td class="qnty"></td>
                                    <td class="total coupon"><b>{{ currencyPosition($order->discount) }}</b></td>
                                </tr>

                                <tr>
                                    <td class="package coast" colspan="3"><b>Livraison</b></td>
                                    <td class="qnty"></td>
                                    <td class="total coast"><b>{{ currencyPosition($order->delivery_charge) }}</b></td>
                                </tr>

                                <tr>
                                    <td class="package" colspan="3"><b>Total payé</b></td>
                                    <td class="qnty"></td>
                                    <td class="total"><b>{{ currencyPosition($order->grand_total) }}</b></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <a class="print_btn common_btn"
                   href="javascript:void(0);"
                   onclick="printInvoice('{{ $order->id }}')">
                    <i class="far fa-print"></i>
                    Imprimer la facture
                </a>
            </div>
        @endforeach
    </div>
</div>

@push('scripts')
<script>
    function viewInvoice(id) {
        $(".fp_dashboard_order").fadeOut();
        $(".invoice_details_" + id).fadeIn();
    }

    $(document).on('click', '.go_back', function (event) {
        event.preventDefault();

        $(this).closest('.fp__invoice').fadeOut();
        $(".fp_dashboard_order").fadeIn();
    });

    function openCateringReviews(event) {
        event.preventDefault();

        const tabButton = document.getElementById('v-pills-messages-tab');

        if (tabButton && window.bootstrap && bootstrap.Tab) {
            bootstrap.Tab.getOrCreateInstance(tabButton).show();
        } else if (tabButton) {
            tabButton.click();
        }
    }

    function printInvoice(id) {
        const invoice = document.getElementById('invoice_' + id);

        if (!invoice) {
            console.error('Facture introuvable : ' + id);
            return;
        }

        const printWindow = window.open('', '_blank', 'width=1000,height=800');

        if (!printWindow) {
            alert('Veuillez autoriser les fenêtres pop-up pour imprimer la facture.');
            return;
        }

        printWindow.document.write(`
            <!DOCTYPE html>
            <html lang="fr">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1">
                <title>Facture #${id}</title>
                <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}">
                <link rel="stylesheet" href="{{ asset('frontend/css/spacing.css') }}">
                <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">
                <link rel="stylesheet" href="{{ asset('frontend/css/custom.css') }}">
                <style>
                    body { background: #fff !important; padding: 30px; }
                    .fp__invoice { display: block !important; width: 100%; max-width: 100%; background: #fff; }
                    .go_back, .print_btn { display: none !important; }
                    .table-responsive { overflow: visible !important; }
                    table { width: 100%; }
                    @media print {
                        body { padding: 20px; }
                        .go_back, .print_btn { display: none !important; }
                    }
                </style>
            </head>
            <body>
                <div class="fp__invoice">${invoice.innerHTML}</div>
            </body>
            </html>
        `);

        printWindow.document.close();

        printWindow.onload = function () {
            setTimeout(function () {
                printWindow.focus();
                printWindow.print();
                printWindow.close();
            }, 500);
        };
    }
</script>
@endpush
