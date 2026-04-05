@extends('admin.layouts.master')  

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Products Gallery ({{$product->name}})</h1>
    </div>

    <div>
        <a href="{{route('admin.product.index')}}" class="btn btn-primary my-2">Go Back</a>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h4>All Images</h4>
            
        </div>

        <div class="card-body">
            <div class="col-md-8">
                <form action="{{route('admin.product-gallery.store')}}" method="POST" enctype="multipart/form-data">
                  @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <div class="form-group">
                        <input type="file" class="form-control" name="image">
                    </div>
                    <div class="form-group">
                       <button type="submit" class="btn btn-primary">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="card card-primary">
      

        <div class="card-body">
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
        </div>
    </div>
</section>
@endsection

