@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Banner Slider</h1>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h4>All Banner Slider</h4>
            <div class="card-header-action">
                <a href="{{ route('admin.coupon.create') }}" class="btn btn-primary">
                    Create New
                </a>
            </div>
        </div>

        <div class="card-body">
            <table class="table table-bordered" id="coupons-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Coupon Code</th>
                        <th>Quantity</th>
                        <th>Minimum Purchase</th>
                        <th>Expire Date</th>
                        <th>Discount Type</th>
                        <th>Discount</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</section>
@endsection

