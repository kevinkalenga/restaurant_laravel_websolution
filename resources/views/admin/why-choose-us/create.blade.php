@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Create Slider</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{ route('admin.sliders.index') }}">Why Choose Us Section</a></div>
            <div class="breadcrumb-item active">Why Choose Us Section</div>
        </div>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h4>Create Item</h4>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.why-choose-us.store') }}" method="POST" enctype="multipart/form-data" novalidate>
                @csrf

                @if(session('success'))
                  <div class="alert alert-success">
                   {{ session('success') }}
                 </div>
                @endif
                
                



                <div class="form-group">
                    <label for="offer">Icon</label>
                    <br>
                    <button class="btn btn-primary iconpicker" name="icon"></button>
                   
                </div>

                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="title" class="form-control" required>
                  
                </div>

               

                <div class="form-group">
                    <label for="short_description">Short Description</label>
                    <textarea name="short_description" class="form-control"></textarea>
                  
                </div>

              

                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" class="form-control" required>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                  
                </div>

                <button type="submit" class="btn btn-primary">Create Slider</button>
                <a href="{{ route('admin.sliders.index') }}" class="btn btn-secondary">Cancel</a>
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

