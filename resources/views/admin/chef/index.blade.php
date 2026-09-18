```blade
@extends('admin.layouts.master')

@section('content')
<section class="section">

    <div class="section-header">
        <h1>Chefs</h1>
    </div>

    <div class="card card-primary">

        <div class="card-header">
            <h4>All Chefs</h4>

            <div class="card-header-action">
                <a href="{{ route('admin.chefs.create') }}"
                   class="btn btn-primary">
                    Create New
                </a>
            </div>
        </div>

        <div class="card-body">

            <table class="table table-bordered" id="banner-sliders-table">

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Banner</th>
                        <th>Title</th>
                        <th>Sub Title</th>
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



