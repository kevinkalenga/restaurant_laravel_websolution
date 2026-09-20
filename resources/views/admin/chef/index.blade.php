```blade
@extends('admin.layouts.master')

@section('content')

<section class="section">
     <div class="section-header">
        <h1>Chefs</h1>
    </div>

   
   
      <div class="card">
        
         <div class="card-body">
           <div id="accordion">
            <div class="accordion">
               <div class="accordion-header collapsed bg-primary text-light p-3" role="button" data-toggle="collapse" data-target="#panel-body-1" aria-expanded="false">
                   <h4>Chefs section titles</h4>
               </div>
               <div class="accordion-body collapse" id="panel-body-1" data-parent="#accordion" style="">
                 <form action="{{route('admin.chefs-title.update')}}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                     <label for="">Top Title</label>
                     <input type="text" class="form-control" name="chef_top_title" value="{{@$titles['chef_top_title']}}">
                    </div>
                    <div class="form-group">
                     <label for="">Main Title</label>
                     <input type="text" class="form-control" name="chef_main_title"  value="{{@$titles['chef_main_title']}}">
                    </div>
                    <div class="form-group">
                     <label for="">Sub Title</label>
                     <input type="text" class="form-control" name="chef_sub_title" value="{{@$titles['chef_sub_title']}}">
                    </div>
                   <button class="btn btn-primary" type="submit">Save</button>
                  </form>
               </div>
            </div>
           </div>
         </div>
      </div>
   
</section>




<section class="section">

   

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

@push('scripts')

<script>
$(function () {

    $('#chefs-table').DataTable({

        processing: true,
        serverSide: true,

        ajax: "{{ route('admin.chefs.index') }}",

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
                render: function (data) {

                    if (!data) {
                        return 'N/A';
                    }

                    return `
                        <img src="${data}"
                             width="80"
                             height="50"
                             style="object-fit: cover;">
                    `;
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
                data: 'show_at_home',
                name: 'show_at_home',
                orderable: false
            },
            {
                data: 'status',
                name: 'status',
                orderable: false
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

