<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
    <i class="fal fa-times"></i>
</button>

<form action="" id="modal_add_to_cart_form">
   
  <input type="hidden" name="product_id" value="{{$product->id}}">

    <div class="fp__cart_popup_img">
        <img src="{{asset($product->thumb_image)}}" alt="{{$product->name}}" class="img-fluid w-100">
    </div>

    <div class="fp__cart_popup_text">
        <a href="{{route('product.show', $product->slug)}}" class="title">
            {!! $product->name !!}
        </a>

        <p class="rating">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
            <i class="far fa-star"></i>
            <span>(201)</span>
        </p>

        <h4 class="price">
            @if($product->offer_price > 0)
                <input type="hidden" name="base_price" value="{{$product->offer_price}}">
                {{currencyPosition($product->offer_price)}}
                <del>{{currencyPosition($product->price)}}</del>
            @else 
                <input type="hidden" name="base_price" value="{{$product->price}}">
                {{currencyPosition($product->price)}}
            @endif
        </h4>

        @if($product->productSizes()->exists())
            <div class="details_size">
                <h5>select size</h5>

                @foreach($product->productSizes as $productSize)
                    <div class="form-check">
                        <input class="form-check-input" value="{{$productSize->id}}" type="radio" name="product_size" data-price="{{$productSize->price}}" id="size-{{$productSize->id}}">
                        
                        <label class="form-check-label" for="size-{{$productSize->id}}">
                            {{$productSize->name}} <span>+ ${{$productSize->price}}</span>
                        </label>
                    </div>
                @endforeach
            </div>
        @endif

        @if ($product->productOptions()->exists())
            <div class="details_extra_item">
                <h5>select option <span>(optional)</span></h5>

                @foreach($product->productOptions as $productOption)
                    <div class="form-check">
                        <input class="form-check-input" value="{{$productOption->id}}" name="product_option[]" data-price="{{$productOption->price}}" type="checkbox" value="" id="option-{{$productOption->id}}">
                        
                        <label class="form-check-label" for="option-{{$productOption->id}}">
                            {{$productOption->name}} <span>+ ${{$productOption->price}}</span>
                        </label>
                    </div>
                @endforeach
            </div>
        @endif

        <div class="details_quentity">
            <h5>select quentity</h5>

            <div class="quentity_btn_area d-flex flex-wrapa align-items-center">
                <div class="quentity_btn">
                    <button class="btn btn-danger decrement">
                        <i class="fal fa-minus"></i>
                    </button>

                    <input id="quantity" name="quantity" type="text" placeholder="1" value="1" readonly>

                    <button class="btn btn-success increment">
                        <i class="fal fa-plus"></i>
                    </button>
                </div>
                @if($product->offer_price > 0)
                  <h3 id="total_price"> {{currencyPosition($product->offer_price)}}</h3>
                @else 
                  <h3 id="total_price"> {{currencyPosition($product->price)}}</h3>
                @endif
            </div>
        </div>

        <ul class="details_button_area d-flex flex-wrap">
            <li>
                <button type="submit" class="common_btn" href="#">add to cart</button>
            </li>
           
        </ul>
    </div>
</form>

<script>
    $(document).ready(function(){
        $('input[name="product_size"]').on('change', function(){
           updateTotalPrice()
        })
        $('input[name="product_option[]"]').on('change', function(){
           updateTotalPrice()
        })
        // Event handlers for increment and decrement buttons
        $('.increment').on('click', function(e){
            e.preventDefault();
            let quantity = $('#quantity');
            let currentQuantity = parseFloat(quantity.val());
            quantity.val(currentQuantity + 1)
            updateTotalPrice()
        })
        $('.decrement').on('click', function(e){
            e.preventDefault();
            let quantity = $('#quantity');
            let currentQuantity = parseFloat(quantity.val());
            if(currentQuantity > 1){
              quantity.val(currentQuantity - 1)
              updateTotalPrice()
            }
        })
        
        // Function to update the total price base on selected option
        function updateTotalPrice() {
          let basePrice = parseFloat($('input[name="base_price"]').val())
          let selectedSizePrice = 0;
          let selectedOptionsPrice = 0; 
          let quantity = parseFloat($('#quantity').val())

          // Calculate the selected size price 
          let selectedSize = $('input[name="product_size"]:checked') ;
          
          if(selectedSize.length > 0) {
            selectedSizePrice = parseFloat(selectedSize.data("price"))
           
          }
          // Calculate selected options price 
          let selectedOptions = $('input[name="product_option[]"]:checked')
          $(selectedOptions).each(function(){
            selectedOptionsPrice += parseFloat($(this).data("price"))
          })

          // Calculate the total price 
          let totalPrice = (basePrice + selectedSizePrice + selectedOptionsPrice) * quantity;

          $('#total_price').text("{{config('settings.site_currency_icon')}}" + totalPrice);
        }

        // Add to cart function
        $("#modal_add_to_cart_form").on('submit', function(e) {
            e.preventDefault();
            
            // Validation
              // SIZE validation seulement si le produit en a
            let sizeInputs = $("input[name='product_size']");
            let selectedSize = $("input[name='product_size']:checked").val();
            
            if (sizeInputs.length > 0 && !selectedSize) {
               iziToast.error({
                 title: 'Error',
                 message: 'Please select a size before adding to cart',
                 position: 'topRight',
                 timeout: 4000
                });
              return;
            //   alert("Please select a size before adding to cart");
              
            }
            // this is the form
            let formData = $(this).serialize();
            $.ajax({
                method: 'POST',
                url: '{{route("add-to-cart")}}',
                data: formData,
                success: function(response){
                    iziToast.success({
                        title: 'Success',
                        message: response.message,
                        position: 'topRight'
                    });
                },
                error: function(xhr, status, error){
                    iziToast.error({
                     title: 'Error',
                     message: xhr.responseJSON.message,
                     position: 'topRight'
                    });
                }
            })
        })
    })
</script>