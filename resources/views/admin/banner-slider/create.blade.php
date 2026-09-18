@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Banner Slider</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{ route('admin.delivery-area.index') }}">Delivery Areas</a></div>
            <div class="breadcrumb-item active">Delivery Area</div>
        </div>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h4>Create Banner Slider</h4>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.banner-slider.store') }}" method="POST" enctype="multipart/form-data" novalidate>
                @csrf

                <div class="form-group">
                   <label>Image</label>
                    <div id="image-preview" class="image-preview">
                      <label for="image-upload" id="image-label">
                          Choose File
                      </label>
                      <input type="file" name="banner" id="image-upload" class="form-control">
                    </div>
                 
                </div>

                   
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" name="title" class="form-control">
                   
                </div>
            
                
                <div class="form-group">
                    <label>Sub Title</label>
                    <input type="text" name="sub_title" class="form-control">
                   
                </div>
                
                
                <div class="form-group">
                     <label for="status">Status</label>
                     <select name="status" class="form-control ">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                    
                </div>

               
                <button type="submit" class="btn btn-primary">Create</button>
                
            </form>
        </div>
    </div>
</section>
@endsection



