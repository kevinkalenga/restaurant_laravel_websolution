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