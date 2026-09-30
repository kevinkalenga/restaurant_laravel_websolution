```blade
@extends('admin.layouts.master')

@section('content')


<section class="section">

    <div class="section-header">
        <h1>Reservation Times</h1>
    </div>

    <div class="card card-primary">

        <div class="card-header">
            <h4>All Times</h4>

            <div class="card-header-action">
                <a href="{{ route('admin.reservation-time.create') }}"
                   class="btn btn-primary">
                    Create New
                </a>
            </div>
        </div>

        <div class="card-body">

            <table class="table table-bordered" id="chefs-table">

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Title</th>
                        <th>Show At Home</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

            </table>

        </div>
    </div>

</section>
@endsection



