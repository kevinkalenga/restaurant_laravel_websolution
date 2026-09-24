@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Blog Category</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{ route('admin.delivery-area.index') }}">Delivery Areas</a></div>
            <div class="breadcrumb-item active">Delivery Area</div>
        </div>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h4>Create Blog Category</h4>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.blog-category.update', $category->id) }}" method="POST" enctype="multipart/form-data" novalidate>
                @csrf
                @method('PUT')
             

                   
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" value="{{$category->name}}">
                   
                </div>
                
                
                <div class="form-group">
                     <label for="status">Status</label>
                     <select name="status" class="form-control ">
                        <option  @selected($category->status === 1) value="1">Active</option>
                        <option  @selected($category->status === 0) value="0">Inactive</option>
                    </select>
                    
                </div>

               
                <button type="submit" class="btn btn-primary">Update</button>
                
            </form>
        </div>
    </div>
</section>
@endsection



