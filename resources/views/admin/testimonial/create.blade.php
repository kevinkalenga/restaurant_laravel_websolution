@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Testimonial</h1>
      
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h4>Create Testimonials</h4>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.testimonial.store') }}" method="POST" enctype="multipart/form-data" novalidate>
                @csrf

                <div class="form-group">
                   <label>Image</label>
                    <div id="image-preview" class="image-preview">
                      <label for="image-upload" id="image-label">
                          Choose File
                      </label>
                      <input type="file" name="image" id="image-upload" class="form-control">
                    </div>
                 
                </div>

                   
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control">
                   
                </div>
                
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" name="title" class="form-control">
                   
                </div>
                <br>
                
               
                <div class="form-group">
                     <label for="status">Rating</label>
                     <select name="rating" class="form-control ">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                       
                    </select>
                    
                </div>
                
                 <div class="form-group">
                    <label>Review</label>
                    <textarea name="review" id="" class="form-control"></textarea>
                   
                </div>
                
                
                <div class="form-group">
                     <label for="status">Show At Home</label>
                     <select name="show_at_home" class="form-control ">
                        <option value="0">No</option>
                        <option value="1">Yes</option>
                    </select>
                    
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




