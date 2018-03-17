@if($cartCount != 0)
<a href="{{URL::to('/'.(App::getLocale().'/cart')) }}">  
    <li class="basket" id="basket">
        <i class="fa fa-shopping-basket" aria-hidden="true"></i>
        <div class="basket_item"><span class="bas_count">{{ $cartCount ?? 0 }}</span></div>
        
    </li> 
</a>
@else
<a href="{{URL::to('/'.(App::getLocale().'/cart')) }}">  
    <li class="basket_em" id="basket">
        <div class="basket_empty"><span class="bas_count"></span></div>
    </li> 
</a>
<style type="text/css">
	.basket_empty {
	    background-image: url(/public/images/image_1.png);
	    width: 36px;
	    height: 36px;
	    background-size: contain;
	}
</style>
@endif
