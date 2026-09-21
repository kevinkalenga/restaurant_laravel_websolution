@extends('admin.layouts.master')

@section('content')

<section class="section">
    <div class="section-header">
        <h1>Testimonial</h1>

```
</div>

<div class="card card-primary">
    <div class="card-header">
        <h4>Edit Testimonials</h4>
    </div>

    <div class="card-body">
        <form action="{{ route('admin.testimonial.update', $testimonial->id) }}" method="POST" enctype="multipart/form-data" novalidate>
            @csrf
            @method('PUT')

            <div class="form-group">
               <label>Image</label>
                <div id="image-preview" class="image-preview">
                  <label for="image-upload" id="image-label">
                      Choose File
                  </label>
                  <input type="file" name="image" id="image-upload" class="form-control">

                  @if($testimonial->image)
                      <img src="{{ asset($testimonial->image) }}"
                           style="width: 100%; height: 100%; object-fit: cover; display: block;">
                  @endif
                </div>
             
            </div>

               
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $testimonial->name) }}">
               
            </div>
            
            <div class="form-group">
                <label>Title</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $testimonial->title) }}">
               
            </div>
            <br>
            
           
            <div class="form-group">
                 <label for="status">Rating</label>
                 <select name="rating" class="form-control ">
                    <option value="1" {{ old('rating', $testimonial->rating) == 1 ? 'selected' : '' }}>1</option>
                    <option value="2" {{ old('rating', $testimonial->rating) == 2 ? 'selected' : '' }}>2</option>
                    <option value="3" {{ old('rating', $testimonial->rating) == 3 ? 'selected' : '' }}>3</option>
                    <option value="4" {{ old('rating', $testimonial->rating) == 4 ? 'selected' : '' }}>4</option>
                    <option value="5" {{ old('rating', $testimonial->rating) == 5 ? 'selected' : '' }}>5</option>
                   
                </select>
                
            </div>
            
             <div class="form-group">
                <label>Review</label>
                <textarea name="review" id="" class="form-control">{{ old('review', $testimonial->review) }}</textarea>
               
            </div>
            
            
            <div class="form-group">
                 <label for="status">Show At Home</label>
                 <select name="show_at_home" class="form-control ">
                    <option value="0" {{ old('show_at_home', $testimonial->show_at_home) == 0 ? 'selected' : '' }}>No</option>
                    <option value="1" {{ old('show_at_home', $testimonial->show_at_home) == 1 ? 'selected' : '' }}>Yes</option>
                </select>
                
            </div>
            
            <div class="form-group">
                 <label for="status">Status</label>
                 <select name="status" class="form-control ">
                    <option value="1" {{ old('status', $testimonial->status) == 1 ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ old('status', $testimonial->status) == 0 ? 'selected' : '' }}>Inactive</option>
                </select>
                
            </div>

           
            <button type="submit" class="btn btn-primary">Update</button>
            
        </form>
    </div>
</div>
```

</section>
@endsection

@push('scripts')

<script>
$(document).ready(function(){
    $('.iconpicker').iconpicker();
});
</script>

<script>
const imageUpload = document.getElementById('image-upload');
const imagePreview = document.getElementById('image-preview');
const imageLabel = document.getElementById('image-label');

imageUpload.addEventListener('change', function() {
    const [file] = this.files;
    if(file) {
        // Supprimer l’ancien aperçu
        const oldImg = imagePreview.querySelector('img');
        if(oldImg) oldImg.remove();

        // Créer la nouvelle image
        const img = document.createElement('img');
        img.src = URL.createObjectURL(file);

        // Faire remplir le cadre
        img.style.width = '100%';
        img.style.height = '100%';
        img.style.objectFit = 'cover'; // <-- important
        img.style.display = 'block';

        imagePreview.appendChild(img);

        // Cacher le label
        imageLabel.style.display = 'none';
    }
});

</script>

@endpush
