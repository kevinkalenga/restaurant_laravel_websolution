@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Daily Offer</h1>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h4>All Daily Offer</h4>
            <div class="card-header-action">
                <a href="{{ route('admin.dayly-offer.create') }}" class="btn btn-primary">
                    Create New
                </a>
            </div>
        </div>

        <div class="card-body">
            <table class="table table-bordered" id="delivery-areas-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Area Name</th>
                        <th>Min Delivery Time</th>
                        <th>Max Delivery Time</th>
                        <th>Delivery Fee</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</section>
@endsection

