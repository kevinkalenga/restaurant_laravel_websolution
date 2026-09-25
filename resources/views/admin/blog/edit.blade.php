@extends('admin.layouts.master')

@section('content')

<section class="section">

    <div class="section-header">

        <h1>Blog</h1>

        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item">
                <a href="{{ route('admin.blogs.index') }}">Blogs</a>
            </div>

            <div class="breadcrumb-item active">
                Edit
            </div>
        </div>

    </div>

    <div class="card card-primary">

        <div class="card-header">
            <h4>Update Blog</h4>
        </div>

        <div class="card-body">

            <form action="{{ route('admin.blogs.update', $blog->id) }}"
                  method="POST"
                  enctype="multipart/form-data"
                  novalidate>

                @csrf
                @method('PUT')

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Title -->
                <div class="form-group">

                    <label for="title">Title</label>

                    <input type="text"
                           name="title"
                           class="form-control"
                           value="{{ old('title', $blog->title) }}"
                           required>

                </div>


                <!-- Category -->
                <div class="form-group">

                    <label for="category_id">Category</label>

                    <select name="category_id"
                            class="form-control"
                            required>

                        <option value="">
                            -- Select Category --
                        </option>

                        @foreach($categories as $category)

                            <option value="{{ $category->id }}"
                                {{ old('category_id', $blog->category_id) == $category->id ? 'selected' : '' }}>

                                {{ $category->name }}

                            </option>

                        @endforeach

                    </select>

                </div>


                <!-- Thumbnail Image -->
                <div class="form-group">

                    <label for="image-upload">
                        Thumbnail Image
                    </label>

                    <input type="file"
                           name="image"
                           id="image-upload"
                           class="form-control">

                    <div id="image-preview"
                         style="margin-top:10px;
                                width:200px;
                                height:200px;
                                border:1px solid #ccc;">

                        @if($blog->image)

                            <img src="{{ asset($blog->image) }}"
                                 alt="Blog Image"
                                 style="width:100%;
                                        height:100%;
                                        object-fit:cover;
                                        display:block;">

                        @endif

                    </div>

                </div>


                <!-- Description -->
                <div class="form-group">

                    <label for="description">
                        Description
                    </label>

                    <textarea name="description"
                              class="form-control summernote">{{ old('description', $blog->description) }}</textarea>

                </div>


                <!-- SEO -->
                <div class="form-group">

                    <label for="seo_title">
                        SEO Title
                    </label>

                    <input type="text"
                           name="seo_title"
                           class="form-control"
                           value="{{ old('seo_title', $blog->seo_title) }}">

                </div>


                <div class="form-group">

                    <label for="seo_description">
                        SEO Description
                    </label>

                    <textarea name="seo_description"
                              class="form-control">{{ old('seo_description', $blog->seo_description) }}</textarea>

                </div>


                <!-- Status -->
                <div class="form-group">

                    <label>Status</label>

                    <select name="status"
                            class="form-control">

                        <option value="1"
                            {{ old('status', $blog->status) == 1 ? 'selected' : '' }}>
                            Active
                        </option>

                        <option value="0"
                            {{ old('status', $blog->status) == 0 ? 'selected' : '' }}>
                            Inactive
                        </option>

                    </select>

                </div>


                <button type="submit"
                        class="btn btn-primary">
                    Update Blog
                </button>

            </form>

        </div>

    </div>

</section>

@endsection


@push('scripts')

<script>

const imageUpload = document.getElementById('image-upload');
const imagePreview = document.getElementById('image-preview');

if (imageUpload) {

    imageUpload.addEventListener('change', function() {

        const [file] = this.files;

        if (file) {

            // Supprimer l'ancien aperçu
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