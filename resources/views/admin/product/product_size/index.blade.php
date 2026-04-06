@extends('admin.layouts.master')  

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Products Sizes ({{$product->name}})</h1>
    </div>

    <div>
        <a href="{{route('admin.product.index')}}" class="btn btn-primary my-2">Go Back</a>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h4>Create Size</h4>
            
        </div>

        <div class="card-body">
           
                <form action="{{route('admin.product-size.store')}}" method="POST" enctype="multipart/form-data">
                  @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                               <label for="">Name</label>
                               <input type="text" class="form-control" name="name">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                              <label for="">Price</label>
                              <input type="text" class="form-control" name="price">
                            </div>
                        </div>
                    </div>
                    
                    
                   
                    <div class="form-group">
                       <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                </form>
           
        </div>
    </div>
    <div class="card card-primary">
      

        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                  @foreach($sizes as $size)
                    <tr>
                        <td>
                           {{$size->name}}
                        </td>
                        <td>
                           {{$size->price}}
                        </td>
                        <td>
                           <form action="{{ route('admin.product-size.destroy', $size->id) }}" method="POST" style="display:inline;">
                               @csrf
                               @method('DELETE')

                               <button type="submit" class="btn btn-sm btn-danger"
                                   onclick="return confirm('Are you sure you want to delete?')">
                                   <i class="fas fa-trash"></i>
                               </button>
                           </form> 
                        </td>
                    </tr>
                   @endforeach
                   @if(count($sizes) === 0 )

                      <tr>
                        <td colspan="3" class="text-center">No data found!</td>
                      </tr>

                   @endif
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection

