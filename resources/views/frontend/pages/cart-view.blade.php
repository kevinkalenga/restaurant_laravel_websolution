@extends('frontend.layouts.master')


@section('content') 





    <!--=============================
        BREADCRUMB START
    ==============================-->
    <section class="fp__breadcrumb" style="background: url({{asset('frontend/images/counter_bg.jpg')}});">
        <div class="fp__breadcrumb_overlay">
            <div class="container">
                <div class="fp__breadcrumb_text">
                    <h1>cart view</h1>
                    <ul>
                        <li><a href="index.html">home</a></li>
                        <li><a href="#">cart view</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!--=============================
        BREADCRUMB END
    ==============================-->


    <!--============================
        CART VIEW START
    ==============================-->
    <section class="fp__cart_view mt_125 xs_mt_95 mb_100 xs_mb_70">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 wow fadeInUp" data-wow-duration="1s">
                    <div class="fp__cart_list">
                        <div class="table-responsive">
                            <table>
                                <tbody>
                                    <tr>
                                        <th class="fp__pro_img">
                                            Image
                                        </th>

                                        <th class="fp__pro_name">
                                            details
                                        </th>

                                        <th class="fp__pro_status">
                                            price
                                        </th>

                                        <th class="fp__pro_select">
                                            quantity
                                        </th>

                                        <th class="fp__pro_tk">
                                            total
                                        </th>

                                        <th class="fp__pro_icon">
                                            <a class="clear_all" href="{{route('cart.destroy')}}">clear all</a>
                                        </th>
                                    </tr>
                                    @foreach(Cart::content() as $product)
                                        <tr>
                                            <td class="fp__pro_img"><img src="{{$product->options->product_info['image']}}" alt="product"
                                                    class="img-fluid w-100">
                                            </td>

                                            <td class="fp__pro_name">
                                                <a href="{{$product->options->product_info['slug']}}">{{$product->name}}</a>
                                                <span>{{@$product->options->product_size['name']}} {{@$product->options->product_size['price'] ? '('.currencyPosition(@$product->options->product_size['price']).')' : ''}}</span>
                                                @foreach($product->options->product_options as $option)
                                                  <p>{{$option['name']}} ({{currencyPosition($option['price'])}})</p>
                                                @endforeach
                                            </td>

                                            <td class="fp__pro_status">
                                                <h6>{{currencyPosition($product->price)}}</h6>
                                            </td>

                                            <td class="fp__pro_select">
                                                <div class="quentity_btn">
                                                    <button class="btn btn-danger decrement"><i class="fal fa-minus"></i></button>
                                                    <input type="text" placeholder="1" class="quantity" data-id="{{$product->rowId}}" value="{{$product->qty}}" readonly>
                                                    <button class="btn btn-success increment"><i class="fal fa-plus"></i></button>
                                                </div>
                                            </td>

                                            <td class="fp__pro_tk">
                                                <h6 class="product_cart_total">{{currencyPosition(productTotal($product->rowId))}}</h6>
                                            </td>

                                            <td class="fp__pro_icon">
                                                <a href="#" class="remove_cart_product" data-id="{{$product->rowId}}"><i class="far fa-times"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    @if(Cart::content()->count() === 0) 
                                      <tr>
                                         <td colspan="6" class="text-center fp__pro_name" style="width: 100%; display:inline;">Cart is empty</td>
                                      </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 wow fadeInUp" data-wow-duration="1s">
                    <div class="fp__cart_list_footer_button">
                        <h6>total cart</h6>
                        <p>subtotal: <span id="subtotal">{{currencyPosition(cartTotal())}}</span></p>
                        <p>delivery: <span>$00.00</span></p>
                        <p>discount: <span id="discount">{{config('settings.site_currency_icon')}}0</span></p>
                        <p class="total"><span>total:</span> <span id="final_total">{{config('settings.site_currency_icon')}}0</span></p>
                        <form id="coupon_form">
                            <input type="text" id="coupon_code" name="code" placeholder="Coupon Code">
                            <button type="submit">apply</button>
                        </form>
                        <a class="common_btn" href=" #">checkout</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--============================
        CART VIEW END
    ==============================-->



@endsection 

@push('scripts')

<script>
    $(document).ready(function(){
       $('.increment').on('click', function(){
         let inputField = $(this).siblings(".quantity");
         let currentValue = parseInt(inputField.val());
         let rowId = inputField.data("id");
         
          inputField.val(currentValue + 1);
         
         cartQtyUpdate(rowId, inputField.val(), function(response){
            console.log(response)
            if(response.status === 'success') {
                inputField.val(response.qty);
                let productTotal = response.product_total
                // console.log(productTotal)
                inputField.closest("tr").find(".product_cart_total")
                                        .text("{{currencyPosition(':productTotal')}}"
                                        .replace(":productTotal", productTotal));
                   
                    updateSubtotal(response.cart_total);
            } else if(response.status === 'error') {
                 inputField.val(response.qty);
               
               
            }
         })
       })

        function updateSubtotal(total) {
            $('#subtotal').text(
                "{{ currencyPosition(':total') }}".replace(':total', total)
            );
        }
       
       $('.decrement').on('click', function(){

            let inputField = $(this).siblings(".quantity");
            let currentValue = parseInt(inputField.val());
            let rowId = inputField.data("id");

            if(currentValue <= 1) return;

            let newQty = currentValue - 1;

            cartQtyUpdate(rowId, newQty, function(response){
                  console.log(response)
                if(response.status === 'success') {

                    inputField.val(response.qty);

                    let productTotal = response.product_total;

                    inputField.closest("tr")
                        .find(".product_cart_total")
                        .text("{{currencyPosition(':productTotal')}}"
                        .replace(":productTotal", productTotal));
                    updateSubtotal(response.cart_total);

                } 
                else if(response.status === 'error') {

                    inputField.val(response.qty);
                }
            });
        });

       function cartQtyUpdate(rowId, qty, callBack) {
            $.ajax({
                method: 'post',
                url: '{{route("cart.quantity-update")}}',
                data: {
                    'rowId': rowId,
                    'qty': qty
                },
                beforeSend: function(){
                    showLoader();
                
                },
                success: function(response) {
                    if(callBack && typeof callBack === "function") {
                    callBack(response)
                    }

                    if(response.status === 'success') {
                        iziToast.success({
                            title: 'Success',
                            message: response.message,
                            position: 'topRight'
                        });
                    } 
                    else {
                        iziToast.error({
                            title: 'Error',
                            message: response.message,
                            position: 'topRight'
                        });
                    }
                
                },
                
                error: function(xhr, status, error) {
                    hideLoader();
                    iziToast.error({
                        title: 'Error',
                        message: xhr.responseJSON.message,
                        position: 'topRight'
                    });
                },
                complete: function(){
                    hideLoader();
                }
            })
       }

        $('.remove_cart_product').on('click', function(e){
            e.preventDefault()
            let rowId = $(this).data('id');
            removeCartProduct(rowId);
            $(this).closest('tr').remove()
        })

      
       
        function removeCartProduct(rowId) {
        
            $.ajax({
                method: 'get',
                url: '{{route("cart-product-remove", ":rowId")}}'.replace(":rowId", rowId),
                
                beforeSend: function(){
                    showLoader();
                
                },
                success: function(response) {
                    
                    iziToast.success({
                        title: 'Success',
                        message: response.message,
                        position: 'topRight'
                    });
                    updateSidebarCart()
                },
                error: function(xhr, status, error) {
                    hideLoader();
                    iziToast.error({
                        title: 'Error',
                        message: xhr.responseJSON.message,
                        position: 'topRight'
                    });
                },
                complete: function(){
                    hideLoader();
                }
            })
        }

        
        $('#coupon_form').on('submit', function(e){
            e.preventDefault()
            let code = $("#coupon_code").val();
            let subtotal = getCartTotal();
            //alert(subtotal);
            couponApply(code, subtotal);
        })

     
        
        
        
        function couponApply(code, subtotal) {
          $.ajax({
            method: 'POST',
            url: '{{route("apply.coupon")}}',
            data: {
                code: code,
                subtotal: subtotal
            },
            beforeSend: function(){
                 showLoader();
            },
            success: function(response) {
              $('#discount').text("{{config('settings.site_currency_icon')}}"+response.discount);
              $('#final_total').text("{{config('settings.site_currency_icon')}}"+response.finalTotal);

               iziToast.success({
                    title: 'Success',
                    message: response.message,
                    position: 'topRight'
                });
            },
            error: function(xhr, status, error) {
                 hideLoader();
                iziToast.error({
                    title: 'Error',
                    message: xhr.responseJSON.message,
                    position: 'topRight'
                });
            },
            complete: function(){
                 hideLoader();
            }
          })
        }
    })
</script>

@endpush