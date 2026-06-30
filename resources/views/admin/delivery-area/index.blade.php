@extends('admin.layouts.master')  

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Delivery Area</h1>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h4>All Delivery Areas</h4>
            <div class="card-header-action">
                <a href="{{ route('admin.delivery-area.create') }}" class="btn btn-primary">
                    Create New
                </a>
            </div>
        </div>

        <div class="card-body">
            <table class="table table-bordered" id="products-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Thumb Image</th>
                        <th>Price</th>
                        <th>Offer Price</th>
                        <th>Show at Home</th>
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

