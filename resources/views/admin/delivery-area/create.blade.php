@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Delivery Area</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{ route('admin.delivery-area.index') }}">Delivery Areas</a></div>
            <div class="breadcrumb-item active">Delivery Area</div>
        </div>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h4>Create Delivery Area</h4>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.delivery-area.store') }}" method="POST" novalidate>
                @csrf

                <div class="form-group">
                    <label for="offer">Area Name</label>
                    <input type="text" name="area_name" class="form-control">
                  
                </div>
                
                 <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="offer">Minimum Delivery Time </label>
                            <input type="text" name="min_delivery_time" class="form-control">
                  
                        </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="offer">Maximum Delivery Time</label>
                        <input type="text" name="max_delivery_time" class="form-control">
                  
                      </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="offer">Delivery Fee</label>
                            <input type="text" name="delivery_fee" class="form-control">
                  
                        </div>
                    
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" class="form-control ">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                    
                        </div>

                    </div>
                 </div>
                <button type="submit" class="btn btn-primary">Create</button>
                
            </form>
        </div>
    </div>
</section>
@endsection


