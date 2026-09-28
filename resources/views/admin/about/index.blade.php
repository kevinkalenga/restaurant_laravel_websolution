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
                      <input type="hidden" name="old_image" id="image-upload" class="form-control" style="display:none;" value="">
                    </div>
                   
                </div>



                <div class="form-group">
                    <label>Title</label>
                    <input type="text" name="title" class="form-control">
                   
                </div>

                <div class="form-group">
                    <label>Main Title</label>
                    <input type="text" name="main_title" class="form-control" >
                   
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" class="form-control"></textarea>
                   
                </div>

                <div class="form-group">
                    <label>Youtube Video Link</label>
                    <input type="text" name="video_link" class="form-control">
                  
                </div>

                

                <button type="submit" class="btn btn-primary">Update</button>
               
            </form>
        </div>
    </div>
</section>
@endsection


@push('scripts')
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

