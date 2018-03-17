<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="delivery_adress">
        <h1 class="title left">
            @lang('messages.DELIVERY_ADRESS'):
        </h1>
      
        <div class="group" id="delivery_hidden" style="display: none;">
           
                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 widht_100">
                    <div class="group_check">
                        <label for="checkbox-1">@lang('messages.PHYSICAL_PERSON')</label>
                        <input  form="order_form" name="physical" type="checkbox"  id="checkbox-1">
                    </div>
                    <div class="group_check">
                        <label for="checkbox-2">@lang('messages.LEGAL_PERSON')</label>
                        <input form="order_form" name="legal" class="legal_p" type="checkbox"  id="checkbox-2">
                    </div> 
                 </div> 
                <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 widht_50_input">
                    <div class="login delivery">
                        <div class="group clearfix">
                            <label for="country">@lang('messages.COUNTRY')</label>
                            <input @if($cart->OrderNotEdit()) disabled="disabled" @endif form="order_form" value="{{ $cart->order_country }}" name="post_country" id="country"  type="text">
                        </div>

                        <div class="group clearfix">
                            <label for="company">@lang('messages.COMPANY')</label>
                            <input @if($cart->OrderNotEdit()) disabled="disabled" @endif form="order_form" value="{{ $cart->order_company }}" name="company" id="company"  type="text">
                        </div>

                        <div class="group clearfix">
                            <label for="region">@lang('messages.REGION')</label>
                            <input @if($cart->OrderNotEdit()) disabled="disabled" @endif form="order_form" name="region" value="{{ $cart->order_region }}" id="region"  type="text">
                        </div>

                        <div class="group clearfix">
                            <label for="city">@lang('messages.CITY')</label>
                            <input @if($cart->OrderNotEdit()) disabled="disabled" @endif form="order_form" name="post_city" value="{{ $cart->order_city }}" id="city"  type="text">
                        </div>

                        <div class="group clearfix">
                            <label for="street">@lang('messages.STREET')</label>
                            <input @if($cart->OrderNotEdit()) disabled="disabled" @endif form="order_form" name="post_street" value="{{ $cart->order_street }}" id="street"  type="text">
                        </div>

                        <div class="group clearfix">
                            <label for="build">@lang('messages.BUILD')</label>
                            <input @if($cart->OrderNotEdit()) disabled="disabled" @endif form="order_form" name="post_build" value="{{ $cart->order_build }}" id="build"  type="text">
                        </div>

                        <div class="group clearfix">
                            <label for="post">@lang('messages.POST_CODE')</label>
                            <input @if($cart->OrderNotEdit()) disabled="disabled" @endif form="order_form" name="post_post_code" id="post_post_code" value="{{ $cart->order_post_code }}"  type="text">
                        </div>

                        <div class="group clearfix">
                            <label for="phone">@lang('messages.PHONE_NUMBER')</label>
                            <input @if($cart->OrderNotEdit()) disabled="disabled" @endif form="order_form" name="phone" id="phone"  value="{{ $cart->order_phone }}" type="tel">
                        </div>
                        <div class="group clearfix">
                            <label for="email">Email</label>
                            <input @if($cart->OrderNotEdit()) disabled="disabled" @endif id="email"  form="order_form" value="{{ $cart->order_email }}" name="order_email" type="email">
                        </div>
                    </div>
                </div>
                <input form="order_form" type="hidden" name="buyer"  value="{{$cart->buyer_user_1c}}">
                <input form="order_form" type="hidden" name="order"  value="{{$cart->id}}">
                <input form="order_form" type="hidden" name="person" value="{{$cart->person}}">

                <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 widht_50_textarea">
                    <div class="login delivery block">
                        <div class="group clearfix">
                            <label for="comment">@lang('messages.COMMENT_TO_DELIVERY')</label>
                            <textarea name="comment"  form="order_form" name="comment" id="comment" cols="30" rows="11"></textarea>
                        </div>
                    </div>
                </div>
        
        </div>
    </div>
</div>
<!--                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="payment">
        <h1 class="title left">
            Payment method:
        </h1>
        <div class="group" id="payment_hidden" style="display: none;">
            <div class="group_check">
                <img src="images/PayPal_small.png" alt="paypal">
                <label for="checkbox-3">PayPal</label>
                <input type="checkbox" name="checkbox-3" id="checkbox-3">
            </div>
            <div class="group_check">
                <img src="images/stripe_small.png" alt="stripe">
                <label for="checkbox-4">Stripe</label>
                <input type="checkbox" name="checkbox-4" id="checkbox-4">
            </div>
            <div class="group_check">
                <img src="images/visa-master_small.png" alt="stripe">
                <label for="checkbox-5">Visa / MasterCard</label>
                <input type="checkbox" name="checkbox-5" id="checkbox-5">
            </div>
        </div>
     </div>
  </div>-->

@if($cart->OrderNotEdit())
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="text-align: center">
        <div class="group_but clearfix" style="float:none; display: inline-block">
            <a href="{{ URL::to('/'.App::getLocale().'/catalog/monica-loretti') }}">@lang('messages.BACK_TO_CATALOG')</a>
        </div>
    </div>
@else
     <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="group_but clearfix">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 col_center">
                <a href="{{ URL::to('/'.App::getLocale().'/catalog/monica-loretti') }}">@lang('messages.BACK_TO_CATALOG')</a>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 col_center">
                <input type="submit" form="order_form" value="@lang('messages.CONFIRM_ORDER')">
            </div>
        </div>
    </div>
@endif