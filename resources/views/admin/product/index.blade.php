@extends('admin.layouts.master')  

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Products</h1>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h4>All Products</h4>
            <div class="card-header-action">
                <a href="{{ route('admin.product.create') }}" class="btn btn-primary">
                    Create New
                </a>
            </div>
        </div>

        <div class="card-body">
            <table class="table table-bordered" id="products-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Thumb Image</th>
                        <th>Category</th>
                        <th>Short Description</th>
                        <th>Long Description</th>
                        <th>Price</th>
                        <th>Offer Price</th>
                        <th>SKU</th>
                        <th>SEO Title</th>
                        <th>SEO Description</th>
                        <th>Show at Home</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
$(function () {
    $('#products-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("admin.product.index") }}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'slug', name: 'slug' },
            { data: 'thumb_image', name: 'thumb_image',
              render: function(data) {
                  return data ? '<img src="'+data+'" width="50">' : '';
              }
            },
            { data: 'category.name', name: 'category.name' },
            { data: 'short_description', name: 'short_description' },
            { data: 'long_description', name: 'long_description' },
            { data: 'price', name: 'price' },
            { data: 'offer_price', name: 'offer_price' },
            { data: 'sku', name: 'sku' },
            { data: 'seo_title', name: 'seo_title' },
            { data: 'seo_description', name: 'seo_description' },

            { data: 'show_at_home', name: 'show_at_home',
              render: function(data) {
                  return data == 1 
                  ? '<span class="badge badge-success">Yes</span>'
                  : '<span class="badge badge-danger">No</span>';
              }
            },

            { data: 'status', name: 'status',
              render: function(data) {
                  return data == 1 
                  ? '<span class="badge badge-success">Active</span>'
                  : '<span class="badge badge-danger">Inactive</span>';
              }
            },

            { data: 'created_at', name: 'created_at',
              render: function(data) {
                  return new Date(data).toLocaleString('fr-FR', {
                      day: '2-digit',
                      month: '2-digit',
                      year: 'numeric',
                      hour: '2-digit',
                      minute: '2-digit'
                  });
              }
            },

            { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });
});
</script>
@endpush