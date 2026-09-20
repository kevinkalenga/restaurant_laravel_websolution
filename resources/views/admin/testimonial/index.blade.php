```blade
@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Why Choose Us</h1>
    </div>

    <div class="card">
        <div class="card-body">
            <div id="accordion">
                <div class="accordion">
                    <div class="accordion-header collapsed bg-primary text-light p-3"
                         role="button"
                         data-toggle="collapse"
                         data-target="#panel-body-1"
                         aria-expanded="false">
                        <h4>Testimonial Section Title</h4>
                    </div>

                    <div class="accordion-body collapse"
                         id="panel-body-1"
                         data-parent="#accordion"
                         style="">

                        <form action="{{ route('admin.why-choose-title.update') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="">Top Title</label>
                                <input type="text"
                                       class="form-control"
                                       name="why_choose_top_title"
                                       value="{{ @$titles['why_choose_top_title'] }}">
                            </div>

                            <div class="form-group">
                                <label for="">Main Title</label>
                                <input type="text"
                                       class="form-control"
                                       name="why_choose_main_title"
                                       value="{{ @$titles['why_choose_main_title'] }}">
                            </div>

                            <div class="form-group">
                                <label for="">Sub Title</label>
                                <input type="text"
                                       class="form-control"
                                       name="why_choose_sub_title"
                                       value="{{ @$titles['why_choose_sub_title'] }}">
                            </div>

                            <button class="btn btn-primary" type="submit">
                                Save
                            </button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="section">
    <div class="section-header">
        <h1>Testimonials</h1>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h4>All Testimonials</h4>

            <div class="card-header-action">
                <a href="{{ route('admin.testimonial.create') }}"
                   class="btn btn-primary">
                    Create New
                </a>
            </div>
        </div>

        <div class="card-body">
            <table class="table table-bordered" id="testimonials-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Title</th>
                        <th>Review</th>
                        <th>Rating</th>
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


@push('scripts')
<script>
$(function () {
    $('#testimonials-table').DataTable({
        processing: true,
        serverSide: true,

        ajax: '{{ route("admin.testimonial.index") }}',

        columns: [
            {
                data: 'id',
                name: 'id'
            },

            {
                data: 'image',
                name: 'image',
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    return '<img src="' + data + '" width="80">';
                }
            },

            {
                data: 'name',
                name: 'name'
            },

            {
                data: 'title',
                name: 'title'
            },

            {
                data: 'review',
                name: 'review'
            },

            {
                data: 'rating',
                name: 'rating'
            },

            {
                data: 'show_at_home',
                name: 'show_at_home',
                render: function(data) {
                    return data ? 'Yes' : 'No';
                }
            },

            {
                data: 'status',
                name: 'status',
                render: function(data) {
                    return data ? 'Active' : 'Inactive';
                }
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

