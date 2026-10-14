
<div class="tab-pane fade" id="v-pills-messages" role="tabpanel"
    aria-labelledby="v-pills-messages-tab">

    <div class="fp_dashboard_body dashboard_review">
        <h3>Mes avis</h3>

        <div class="fp__review_area">
            <div class="fp__comment pt-0 mt_20">

                {{-- AVIS CLASSIQUES --}}
                @foreach($reviews as $review)
                    <div class="fp__single_comment m-0 border-0">
                        <img src="{{ asset($review->user->avatar) }}"
                             alt="review"
                             class="img-fluid">

                        <div class="fp__single_comm_text">
                            <h3>
                                <a href="#">{{ $review->user->name }}</a>
                                <span>{{ date('d/m/Y', strtotime($review->created_at)) }}</span>
                            </h3>

                            <span class="rating">
                                @for($i = 1; $i <= $review->rating; $i++)
                                    <i class="fas fa-star"></i>
                                @endfor
                            </span>

                            <p>{{ $review->review }}</p>

                            @if($review->status === 1)
                                <span class="status active">Active</span>
                            @else
                                <span class="status inactive">Pending</span>
                            @endif
                        </div>
                    </div>
                @endforeach

                {{-- AVIS DES COMMANDES TRAITEUR --}}
                @foreach($cateringReviews as $review)
                    <div class="fp__single_comment m-0 border-0">
                        <img src="{{ asset($review->user->avatar ?? 'frontend/images/default-user.png') }}"
                             alt="review"
                             class="img-fluid">

                        <div class="fp__single_comm_text">
                            <h3>
                                <a href="#">{{ $review->user->name ?? 'Client' }}</a>
                                <span>{{ $review->created_at->format('d/m/Y') }}</span>
                            </h3>

                            <span class="rating">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star"
                                       style="color: {{ $i <= $review->rating ? '#f0ad4e' : '#ddd' }}"></i>
                                @endfor
                            </span>

                            <p class="text-muted small mb-1">Avis sur une commande traiteur</p>

                            <p>{{ $review->review }}</p>

                            @if($review->status)
                                <span class="status active">Approuvé</span>
                            @else
                                <span class="status inactive">En attente de validation</span>
                            @endif
                        </div>
                    </div>
                @endforeach

                @if($reviews->isEmpty() && $cateringReviews->isEmpty())
                    <div class="alert alert-warning mt-4">
                        Vous n'avez encore laissé aucun avis.
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>
