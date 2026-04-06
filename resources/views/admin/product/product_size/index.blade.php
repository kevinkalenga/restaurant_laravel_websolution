@extends('admin.layouts.master')  

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Products Variants ({{$product->name}})</h1>
    </div>

    <div>
        <a href="{{route('admin.product.index')}}" class="btn btn-primary my-2">Go Back</a>
    </div>

    <div class="row">

        {{-- COLONNE 1 --}}
        <div class="col-md-6">

            {{-- FORM --}}
            <div class="card card-primary">
                <div class="card-header">
                    <h4>Create Product Size</h4>
                </div>

                <div class="card-body">
                    <form action="{{route('admin.product-size.store')}}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" class="form-control" name="name">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Price</label>
                                    <input type="text" class="form-control" name="price">
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Create</button>
                    </form>
                </div>
            </div>

            {{-- TABLE --}}
            <div class="card card-primary">
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sizes as $size)
                            <tr>
                                <td>{{++$loop->index}}</td>
                                <td>{{$size->name}}</td>
                                <td>{{$size->price}}</td>
                                <td>
                                    <form action="{{ route('admin.product-size.destroy', $size->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Are you sure?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form> 
                                </td>
                            </tr>
                            @endforeach

                            @if(count($sizes) === 0)
                            <tr>
                                <td colspan="3" class="text-center">No data found!</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

        </div> {{-- FIN COL 1 --}}


        {{-- COLONNE 2 --}}
        <div class="col-md-6">

            {{-- FORM --}}
            <div class="card card-primary">
                <div class="card-header">
                    <h4>Create Product Options</h4>
                </div>

                <div class="card-body">
                    <form action="{{route('admin.product-option.store')}}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" class="form-control" name="name">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Price</label>
                                    <input type="text" class="form-control" name="price">
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Create</button>
                    </form>
                </div>
            </div>

            {{-- TABLE --}}
            <div class="card card-primary">
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($options as $option)
                            <tr>
                                <td>{{++$loop->index}}</td>
                                <td>{{$option->name}}</td>
                                <td>{{$option->price}}</td>
                                <td>
                                    <form action="{{ route('admin.product-option.destroy', $option->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Are you sure?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form> 
                                </td>
                            </tr>
                            @endforeach

                            @if(count($options) === 0)
                            <tr>
                                <td colspan="3" class="text-center">No data found!</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

        </div> {{-- FIN COL 2 --}}

    </div> {{-- FIN ROW --}}

</section>
@endsection