@extends('admin.layouts.master')  

@section('content')
<section class="section">
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

