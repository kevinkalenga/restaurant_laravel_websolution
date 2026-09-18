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
            <form action="{{ route('admin.banner-slider.update', $bannerSlider->id) }}" method="POST" enctype="multipart/form-data" novalidate>
                @csrf
                @method('PUT')
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
                    <input type="text" name="title" class="form-control" value="{{$bannerSlider->title}}">
                   
                </div>
            
                
                <div class="form-group">
                    <label>Sub Title</label>
                    <input type="text" name="sub_title" class="form-control" value="{{$bannerSlider->sub_title}}">
                   
                </div>

                <div class="form-group">
                    <label>Url</label>
                    <input type="text" name="url" class="form-control" value="{{$bannerSlider->url}}">
                  
                </div>
                
                
                <div class="form-group">
                     <label for="status">Status</label>
                     <select name="status" class="form-control ">
                        <option  @selected($bannerSlider->status === 1) value="1">Active</option>
                        <option  @selected($bannerSlider->status === 0) value="0">Inactive</option>
                    </select>
                    
                </div>

               
                <button type="submit" class="btn btn-primary">Update</button>
                
            </form>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    $(document).ready(function(){
        $('.image-preview').css({
            'background-image': 'url({{ asset($bannerSlider->banner) }})',
            'background-size': 'cover',
            'background-position': 'center center'
        });
    });
</script>
@endpush



