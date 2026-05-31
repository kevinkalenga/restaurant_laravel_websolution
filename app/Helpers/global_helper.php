<?php 

if(!function_exists('currencyPosition')) {
    function currencyPosition($price) {
      if(config('settings.site_currency_icon_position') === 'left') {
         return config('settings.site_currency_icon').$price;
      } else {
          return $price.config('settings.site_currency_icon');
      }
    }
}

/* Calcultate cart total price */ 
if(!function_exists('cartTotal')) {
    function cartTotal() 
    {
      $total = 0;
      
       foreach(Cart::content() as $item) {
         $productPrice = $item->price;
         $sizePrice = $item->options?->product_size['price'] ?? 0;
         $optionsPrice = 0;

         foreach( $item->options->product_options as $option) {
           $optionsPrice += $option['price'];
         }

         $total += ($productPrice + $sizePrice + $optionsPrice) * $item->qty;

        
       }
       
        return $total;
      
    }
}