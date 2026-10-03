
@extends('admin.layouts.master')

@section('content')

<section class="section">
     <div class="section-header">
        <h1>Subscribers</h1>
    </div>

   
   
      <div class="card">
        
         <div class="card-body">
           <div id="accordion">
            <div class="accordion">
               <div class="accordion-header collapsed bg-primary text-light p-3" role="button" data-toggle="collapse" data-target="#panel-body-1" aria-expanded="false">
                   <h4>Send News Letter...</h4>
               </div>
               <div class="accordion-body collapse" id="panel-body-1" data-parent="#accordion" style="">
                 <form action="{{route('admin.news-letter.send')}}" method="POST">
                    @csrf
                   
                    <div class="form-group">
                      <label for="">Subject</label>
                      <input type="text" class="form-control" name="subject" value="">
                    </div>
                   
                    <div class="form-group">
                      <label for="">Message</label>
                      <textarea name="message" class="form-control"></textarea>
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
                <h4>All Subscribers</h4> 
            </div> 
            <div class="card-body"> 
                <table class="table table-bordered" id="subscribers-table"> 
                    <thead> 
                        <tr> 
                            <th>ID</th> 
                            <th>Email</th> 
                            <th>Subscribed At</th> 
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

    $('#subscribers-table').DataTable({

        processing: true,
        serverSide: true,

        ajax: "{{ route('admin.news-letter.index') }}",

        columns: [
            {
                data: 'id',
                name: 'id'
            },
            {
                data: 'email',
                name: 'email'
            },
            {
                    data:'created_at',
                    name:'created_at',
                    render:function(data){

                        return new Date(data).toLocaleString('fr-FR',{
                            day:'2-digit',
                            month:'2-digit',
                            year:'numeric',
                            hour:'2-digit',
                            minute:'2-digit'
                        });
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



