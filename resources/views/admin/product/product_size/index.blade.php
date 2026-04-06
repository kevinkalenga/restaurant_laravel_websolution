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
      

        {{--<div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                  @foreach($images as $img)
                    <tr>
                        <td>
                          <img width="100px"  src="{{asset($img->image)}}" alt="">
                        </td>
                        <td>
                           <form action="{{ route('admin.product-gallery.destroy', $img->id) }}" method="POST" style="display:inline;">
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
                   @if(count($images) === 0 )

                      <tr>
                        <td colspan="2" class="text-center">No data found!</td>
                      </tr>

                   @endif
                </tbody>
            </table>
        </div>--}}
    </div>
</section>
@endsection

