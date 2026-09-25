@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Blog</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{ route('admin.blogs.index') }}">Blogs</a></div>
            <div class="breadcrumb-item active">Create</div>
        </div>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h4>Create Blog</h4>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data" novalidate>
                @csrf

                @if(session('success'))
                  <div class="alert alert-success">
                     {{ session('success') }}
                  </div>
                @endif

                <!-- Name -->
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                </div>

                <!-- Category -->
                <div class="form-group">
                    <label for="category_id">Category</label>
                    <select name="category_id" class="form-control" required>
                        <option value="">-- Select Category --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Thumbnail Image -->
                <div class="form-group">
                    <label for="thumb_image">Thumbnail Image</label>
                    <input type="file" name="image" id="image-upload" class="form-control">
                    <div id="image-preview" style="margin-top:10px; width:200px; height:200px; border:1px solid #ccc;"></div>
                </div>

               

                <!-- Long Description -->
                <div class="form-group">
                    <label for="long_description">Description</label>
                    <textarea name="description" class="form-control summernote">{{ old('description') }}</textarea>
                </div>

              

                <!-- SEO -->
                <div class="form-group">
                    <label for="seo_title">SEO Title</label>
                    <input type="text" name="seo_title" class="form-control" value="{{ old('seo_title') }}">
                </div>
                <div class="form-group">
                    <label for="seo_description">SEO Description</label>
                    <textarea name="seo_description" class="form-control">{{ old('seo_description') }}</textarea>
                </div>

                <!-- Status -->
                <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Create Blog</button>
            </form>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
const imageUpload = document.getElementById('image-upload');
const imagePreview = document.getElementById('image-preview');

if(imageUpload) {
    imageUpload.addEventListener('change', function() {
        const [file] = this.files;
        if(file) {
            // Supprimer l’ancien aperçu
            imagePreview.innerHTML = '';
            const img = document.createElement('img');
            img.src = URL.createObjectURL(file);
            img.style.width = '100%';
            img.style.height = '100%';
            img.style.objectFit = 'cover';
            img.style.display = 'block';
            imagePreview.appendChild(img);
        }
    });
}
</script>
@endpush