@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Category</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{ route('admin.sliders.index') }}">Sliders</a></div>
            <div class="breadcrumb-item active">Create</div>
        </div>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h4>Create Category</h4>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.category.store') }}" method="POST" enctype="multipart/form-data" novalidate>
                @csrf

             
                
                 @if(session('success'))
                  <div class="alert alert-success">
                   {{ session('success') }}
                 </div>
                @endif



                <div class="form-group">
                    <label for="offer">Name</label>
                    <input type="text" name="name" class="form-control">
                  
                </div>

                <div class="form-group">
                    <label>Show At Home</label>
                    <select name="show_at_home" class="form-control">
                        <option value="1">Yes</option>
                        <option selected value="0">No</option>
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

