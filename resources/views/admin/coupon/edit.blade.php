@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Update Coupon</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{ route('admin.sliders.index') }}">Coupons</a></div>
            <div class="breadcrumb-item active">Coupon</div>
        </div>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h4>Update Coupon</h4>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.coupon.update', $coupon->id) }}" method="POST" novalidate>
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" value="{{$coupon->name}}">
                   
                </div>
                <div class="form-group">
                    <label>Coupon Code</label>
                    <input type="text" name="code" class="form-control" value="{{$coupon->code}}">
                   
                </div>
                <div class="form-group">
                    <label>Coupon Quantity</label>
                    <input type="text" name="quantity" class="form-control" value="{{$coupon->quantity}}">
                   
                </div>
               
                <div class="form-group">
                    <label>Coupon Minimum Purchase Price</label>
                    <input type="text" name="min_purchase_amount" class="form-control" value="{{$coupon->min_purchase_amount}}">
                   
                </div>
                <div class="form-group">
                    <label>Expire Date</label>
                    <input type="date" name="expire_date" class="form-control" value="{{$coupon->expire_date}}">
                   
                </div>
              

                <div class="form-group">
                    <label>Discount Type</label>
                    <select name="discount_type" class="form-control">
                        <option @selected($coupon->discount_type === 'percent') value="percent">Percent</option>
                        <option @selected($coupon->discount_type === 'amount') value="amount">Amount ({{config('settings.site_current_icon')}})</option>
                    </select>
                 
                </div>
                   
                <div class="form-group">
                    <label>Discount Amount</label>
                    <input type="text" name="discount" class="form-control" value="{{$coupon->discount}}">
                   
                </div>
             

                <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option @selected($coupon->status === 1) value="1">Active</option>
                        <option @selected($coupon->status === 0) value="0">Inactive</option>
                    </select>
                 
                </div>

                <button type="submit" class="btn btn-primary">Create Coupon</button>
              
            </form>
        </div>
    </div>
</section>
@endsection




