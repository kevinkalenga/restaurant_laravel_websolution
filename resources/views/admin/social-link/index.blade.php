@extends('admin.layouts.master')

@section('content')

<section class="section">

```
<div class="section-header">
    <h1>Social Links</h1>
</div>

<div class="card card-primary">

    <div class="card-header">
        <h4>All Social Links</h4>

        <div class="card-header-action">
            <a href="{{ route('admin.social-link.create') }}" class="btn btn-primary">
                Create New
            </a>
        </div>
    </div>

    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-bordered" id="social-links-table">

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Icon</th>
                        <th>Name</th>
                        <th>Link</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

            </table>
        </div>

    </div>
</div>
```

</section>
@endsection

@push('scripts')

<script>
$(function () {

    $('#social-links-table').DataTable({
        processing: true,
        serverSide: true,

        ajax: "{{ route('admin.social-link.index') }}",

        columns: [
            {
                data: 'id',
                name: 'id'
            },
            {
                data: 'icon',
                name: 'icon',
                orderable: false,
                searchable: false
            },
            {
                data: 'name',
                name: 'name'
            },
            {
                data: 'link',
                name: 'link'
            },
            {
                data: 'status',
                name: 'status',
                orderable: false,
                searchable: false
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            }
        ]
    });

});
</script>

@endpush
