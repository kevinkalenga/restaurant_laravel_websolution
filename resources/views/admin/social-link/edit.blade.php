@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Social Link</h1>
        
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h4>Update Link</h4>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.social-link.update', $socialLink->id) }}" method="POST" enctype="multipart/form-data" novalidate>
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label>Icon</label>
                    <button type="button" class="btn btn-secondary" role="iconpicker" name="icon" data-icon=""  value="{{$socialLink->icon}}"></button>
                </div>  

                <div class="form-group">
                    <label for="title">Name</label>
                    <input type="text" name="name" class="form-control" value="{{$socialLink->name}}">
                    
                </div>

                <div class="form-group">
                    <label for="sub_title">Link</label>
                    <input type="text" name="link" class="form-control" value="{{$socialLink->link}}">
                    
                </div>

              

                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" class="form-control">
                        <option @selected($socialLink->status === 1) value="1">Yes</option>
                        <option @selected($socialLink->status === 0) value="0">No</option>
                    </select>
                  
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
               
            </form>
        </div>
    </div>
</section>
@endsection




