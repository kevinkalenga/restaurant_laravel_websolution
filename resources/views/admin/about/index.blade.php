@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>About</h1>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h4>Update About</h4>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.about.update') }}" method="POST" enctype="multipart/form-data" novalidate>
                @csrf

                @method('PUT')
                
                <div class="form-group">
                   <label for="image-upload">Image</label>
                    <div id="image-preview" class="image-preview" 
                       style="border: 2px dashed #ccc; width: 200px; height: 200px; display: block; overflow: hidden;">
                      <label for="image-upload" id="image-label" style="cursor:pointer; display:block; text-align:center; line-height:200px;">
                          Choose File
                      </label>
                      <input type="file" name="image" id="image-upload" class="form-control" style="display:none;">
                      <input type="hidden" name="old_image" id="image-upload" class="form-control" style="display:none;" value="{{$about->image}}">
                    </div>
                   
                </div>



                <div class="form-group">
                    <label>Title</label>
                    <input type="text" name="title" class="form-control" value="{{$about->title}}">
                   
                </div>

                <div class="form-group">
                    <label>Main Title</label>
                    <input type="text" name="main_title" class="form-control"  value="{{$about->main_title}}">
                   
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" class="form-control">
                        {!! $about->description !!}
                    </textarea>
                   
                </div>

                <div class="form-group">
                    <label>Youtube Video Link</label>
                    <input type="text" name="video_link" class="form-control" value="{{$about->video_link}}">
                  
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
          'background-image': 'url({{asset(@$about->image)}})',
          'background-size': 'cover',
          'background-position': 'center center'
        })
     })
  </script>

@endpush




