@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Create Slider</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{ route('admin.sliders.index') }}">Sliders</a></div>
            <div class="breadcrumb-item active">Create</div>
        </div>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h4>Create New Slider</h4>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.sliders.store') }}" method="POST" enctype="multipart/form-data" novalidate>
                @csrf

                @if(session('success'))
                  <div class="alert alert-success">
                   {{ session('success') }}
                 </div>
                @endif
                
                <div class="form-group">
                   <label for="image-upload">Image</label>
                    <div id="image-preview" class="image-preview" 
                       style="border: 2px dashed #ccc; width: 200px; height: 200px; display: block; overflow: hidden;">
                      <label for="image-upload" id="image-label" style="cursor:pointer; display:block; text-align:center; line-height:200px;">
                          Choose File
                      </label>
                      <input type="file" name="image" id="image-upload" class="form-control @error('image') is-invalid @enderror" style="display:none;" required>
                    </div>
                   @error('image')
                       <span class="text-danger">{{ $message }}</span>
                   @enderror
                </div>



                <div class="form-group">
                    <label for="offer">Offer</label>
                    <input type="text" name="offer" class="form-control @error('offer') is-invalid @enderror" required>
                    @error('offer')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" required>
                    @error('title')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="sub_title">Sub Title</label>
                    <input type="text" name="sub_title" class="form-control @error('sub_title') is-invalid @enderror">
                    @error('sub_title')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="short_description">Short Description</label>
                    <textarea name="short_description" class="form-control @error('short_description') is-invalid @enderror"></textarea>
                    @error('short_description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="button_link">Button Link</label>
                    <input type="url" name="button_link" class="form-control @error('button_link') is-invalid @enderror">
                    @error('button_link')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" class="form-control @error('status') is-invalid @enderror">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                    @error('status')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
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

