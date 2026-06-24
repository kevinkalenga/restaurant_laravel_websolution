@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Product</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{ route('admin.product.index') }}">Products</a></div>
            <div class="breadcrumb-item active">Edit</div>
        </div>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h4>Edit Product</h4>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.product.update', $product->id) }}" method="POST" enctype="multipart/form-data" novalidate>
                @csrf
                @method('PUT')

                @if(session('success'))
                  <div class="alert alert-success">
                     {{ session('success') }}
                  </div>
                @endif

                <!-- Name -->
                <div class="form-group">
                    <label for="name">Product Name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
                </div>

                <!-- Category -->
                <div class="form-group">
                    <label for="category_id">Category</label>
                    <select name="category_id" class="form-control" required>
                        <option value="">-- Select Category --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Thumbnail Image -->
                <div class="form-group">
                    <label for="thumb_image">Thumbnail Image</label>
                    <input type="file" name="thumb_image" id="image-upload" class="form-control">
                    <div id="image-preview" style="margin-top:10px; width:200px; height:200px; border:1px solid #ccc;">
                        @if($product->thumb_image)
                            <img src="{{ asset($product->thumb_image) }}" style="width:100%; height:100%; object-fit:cover; display:block;">
                        @endif
                    </div>
                </div>

                <!-- Short Description -->
                <div class="form-group">
                    <label for="short_description">Short Description</label>
                    <textarea name="short_description" class="form-control">{{ old('short_description', $product->short_description) }}</textarea>
                </div>

                <!-- Long Description -->
                <div class="form-group">
                    <label for="long_description">Long Description</label>
                    <textarea name="long_description" class="form-control summernote">{{ old('long_description', $product->long_description) }}</textarea>
                </div>

                <!-- Price & Offer -->
                <div class="form-group">
                    <label for="price">Price</label>
                    <input type="number" name="price" step="0.01" class="form-control" value="{{ old('price', $product->price) }}" required>
                </div>
                <div class="form-group">
                    <label for="offer_price">Offer Price</label>
                    <input type="number" name="offer_price" step="0.01" class="form-control" value="{{ old('offer_price', $product->offer_price) }}">
                </div>
                <div class="form-group">
                    <label>Quantity</label>
                    <input type="text" name="quantity" class="form-control" value="{{ old('quantity', $product->quantity) }}">
                </div>

                <!-- SKU -->
                <div class="form-group">
                    <label for="sku">SKU</label>
                    <input type="text" name="sku" class="form-control" value="{{ old('sku', $product->sku) }}">
                </div>

                <!-- SEO -->
                <div class="form-group">
                    <label for="seo_title">SEO Title</label>
                    <input type="text" name="seo_title" class="form-control" value="{{ old('seo_title', $product->seo_title) }}">
                </div>
                <div class="form-group">
                    <label for="seo_description">SEO Description</label>
                    <textarea name="seo_description" class="form-control">{{ old('seo_description', $product->seo_description) }}</textarea>
                </div>

                <!-- Show at Home -->
                <div class="form-group">
                    <label>Show At Home</label>
                    <select name="show_at_home" class="form-control">
                        <option value="1" {{ old('show_at_home', $product->show_at_home) == 1 ? 'selected' : '' }}>Yes</option>
                        <option value="0" {{ old('show_at_home', $product->show_at_home) == 0 ? 'selected' : '' }}>No</option>
                    </select>
                </div>

                <!-- Status -->
                <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="1" {{ old('status', $product->status) == 1 ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ old('status', $product->status) == 0 ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Update Product</button>
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