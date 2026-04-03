@extends('admin.layouts.master')  

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Product Categories</h1>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h4>All Categories</h4>
            <div class="card-header-action">
                <a href="{{ route('admin.sliders.create') }}" class="btn btn-primary">
                    Create New
                </a>
            </div>
        </div>

        <div class="card-body">
            <table class="table table-bordered" id="sliders-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Offer</th>
                        <th>Title</th>
                        <th>Sub Title</th>
                        <th>Short Description</th>
                        <th>Button Link</th>
                        <th>Status</th>
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
    $('#sliders-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("admin.sliders.index") }}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'image', name: 'image', orderable: false, searchable: false,
              render: function(data, type, row) {
                  return '<img src="'+data+'" width="80">';
              }
            },
            { data: 'offer', name: 'offer' },
            { data: 'title', name: 'title' },
            { data: 'sub_title', name: 'sub_title' },
            { data: 'short_description', name: 'short_description' },
            { data: 'button_link', name: 'button_link',
              render: function(data, type, row) {
                  return '<a href="'+data+'" target="_blank">'+data+'</a>';
              }
            },
            { data: 'status', name: 'status',
              render: function(data) {
                  return data ? 'Active' : 'Inactive';
                
              }
            },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });
});
</script>
@endpush
