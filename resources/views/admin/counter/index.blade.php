@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Counter</h1>
      
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h4>Update Counter</h4>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.counter.update') }}" method="POST" enctype="multipart/form-data" novalidate>
                @csrf
                @method('PUT')

                <div class="form-group">
                   <label for="image-upload">Background</label>
                    <div id="image-preview" class="image-preview">
                      <label for="image-upload" id="image-label">
                          Choose File
                      </label>
                      <input type="file" name="background" id="image-upload" class="form-control">
                    </div>
                   
                </div>
                
                <h6>Counter One</h6>
                <hr>

                <div class="form-group">
                    <label>Counter Icon One</label>
                    <button type="button" class="btn btn-secondary" role="iconpicker" name="counter_icon_one" data-icon="{{$counter->counter_icon_one}}"></button>
                </div>
                   
                <div class="form-group">
                    <label>Counter Count One</label>
                    <input type="text" name="counter_count_one" class="form-control" value="{{$counter->counter_count_one}}">
                </div>

                <div class="form-group">
                    <label>Counter Count Name</label>
                    <input type="text" name="counter_name_one" class="form-control" value="{{$counter->counter_name_one}}">
                </div>
                
                <h6>Counter Two</h6>
                <hr>

                <div class="form-group">
                    <label>Counter Icon Two</label>
                    <button class="btn btn-secondary" role="iconpicker" name="counter_icon_two" data-icon="{{$counter->counter_icon_two}}"></button>
                </div>
                   
                <div class="form-group">
                    <label>Counter Count Two</label>
                    <input type="text" name="counter_count_two" class="form-control" value="{{$counter->counter_count_two}}">
                </div>

                <div class="form-group">
                    <label>Counter Count Name Two</label>
                    <input type="text" name="counter_name_two" class="form-control" value="{{$counter->counter_name_two}}">
                </div>
                
                <h6>Counter Three</h6>
                <hr>

                <div class="form-group">
                    <label>Counter Icon Three</label>
                    <button class="btn btn-secondary" role="iconpicker" name="counter_icon_three" data-icon="{{$counter->counter_icon_three}}"></button>
                </div>
                   
                <div class="form-group">
                    <label>Counter Count Three</label>
                    <input type="text" name="counter_count_three" class="form-control" value="{{$counter->counter_count_three}}">
                </div>

                <div class="form-group">
                    <label>Counter Count Name Three</label>
                    <input type="text" name="counter_name_three" class="form-control" value="{{$counter->counter_name_three}}">
                </div>
                
                <h6>Counter Four</h6>
                <hr>

                <div class="form-group">
                    <label>Counter Icon Four</label>
                    <button class="btn btn-secondary" role="iconpicker" name="counter_icon_four" data-icon="{{$counter->counter_icon_four}}"></button>
                </div>
                   
                <div class="form-group">
                    <label>Counter Count Four</label>
                    <input type="text" name="counter_count_four" class="form-control" value="{{$counter->counter_count_four}}">
                </div>

                <div class="form-group">
                    <label>Counter Count Name Four</label>
                    <input type="text" name="counter_name_four" class="form-control" value="{{$counter->counter_name_four}}">
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
          'background-image': 'url({{asset($counter->background)}})',
          'background-size': 'cover',
          'background-position': 'center center'
        })
     })
  </script>

@endpush