@extends('admin.layouts.master')  

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Why Choose Us</h1>
    </div>

    <!-- <div class="card card-primary">
        <div class="card-header">
            <h4>All Items</h4>
           
        </div>

    </div> -->
   
      <div class="card">
        
         <div class="card-body">
           <div id="accordion">
            <div class="accordion">
               <div class="accordion-header collapsed bg-primary text-light p-3" role="button" data-toggle="collapse" data-target="#panel-body-1" aria-expanded="false">
                   <h4>Why choose us section titles</h4>
               </div>
               <div class="accordion-body collapse" id="panel-body-1" data-parent="#accordion" style="">
                 <form action="{{route('admin.why-choose-title.update')}}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                     <label for="">Top Title</label>
                     <input type="text" class="form-control" name="why_choose_top_title" value="{{@$titles['why_choose_top_title']}}">
                    </div>
                    <div class="form-group">
                     <label for="">Main Title</label>
                     <input type="text" class="form-control" name="why_choose_main_title"  value="{{@$titles['why_choose_main_title']}}">
                    </div>
                    <div class="form-group">
                     <label for="">Sub Title</label>
                     <input type="text" class="form-control" name="why_choose_sub_title" value="{{@$titles['why_choose_sub_title']}}">
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
    <div class="section-header">
        <h1>Why Choose Us</h1>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h4>All Items</h4>
            <div class="card-header-action">
                <a href="{{route('admin.why-choose-us.create')}}" class="btn btn-primary">Create New</a>
            </div>
        </div>

        <div class="card-body">
            <table class="table table-bordered" id="sliders-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Icon</th>
                        <th>Title</th>
                        <th>Short Description</th>
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
    ajax: '{{ route("admin.why-choose-us.index") }}',

    columns: [
        { data: 'id', name: 'id' },

        { data: 'icon', name: 'icon',
            render: function(data){
                return '<i class="'+data+'"></i>';
            }
        },

        { data: 'title', name: 'title' },

        { data: 'short_description', name: 'short_description' },

        { data: 'status', name: 'status',
            render: function(data){
                return data == 1 
                ? '<span class="badge badge-success">Active</span>'
                : '<span class="badge badge-danger">Inactive</span>';
            }
        },

        { data: 'action', name: 'action', orderable:false, searchable:false }
    ]

});

/* DELETE */
$(document).on('click', '.delete-item', function(e){

    e.preventDefault();

    let id = $(this).data('id');

    if(confirm('Are you sure?')){

        $.ajax({
            url: '/admin/why-choose-us/' + id,
            type: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response){

               table.ajax.reload(null, false); // ← recharge la table sans recharger la page
                alert(response.message);         // affiche un petit message

            }
        });

    }

});



});






</script>
@endpush
