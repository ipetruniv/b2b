<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="delivery_adress">
        <h1 class="title left">
            @lang('messages.DELIVERY_ADRESS'):
        </h1>
        <div class="group" id="delivery_hidden" style="display: none;">
           
                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 widht_100">
                    <div class="group_check">
                        <label for="checkbox-1"><?php echo __('messages.PHYSICAL_PERSON'); ?></label>
                        <input form="order_form" name="person" type="radio" value="physical" id="checkbox-1" class="cart-checkbox">
                    </div>
                    <div class="group_check">
                        <label for="checkbox-2"><?php echo __('messages.LEGAL_PERSON'); ?></label>
                        <input form="order_form" name="person" class="legal_p cart-checkbox" value="legal" type="radio"  id="checkbox-2">
                    </div>
                 </div> 
                <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 widht_50_input">
                    <div class="login delivery">

{{--                        {!! Form::open(['id'=>'edit_user', 'class'=>'login log_new', 'style' => 'width: 80%; margin: 30px auto']) !!}--}}

                        {{--<h2 class="title">Postal adress</h2><h2 class="title">Postal adress</h2>--}}

                        <div class="group clearfix">
                            {!! Form::label('autocomplete', __('messages.ADDRESS')) !!}
                            {!! Form::text('autocomplete', $buyer->address, ['placeholder'=>'Enter your address', 'onclick' => 'initAutocomplete(this)' ])!!}
                        </div>
                        <div class="postal_addr">
                   <!--          <div class="group clearfix">
                                {!! Form::label('post_build', __('messages.STREET')) !!}
                                {!! Form::text('post_build', $user->post_build, ['id' => 'street_number', 'style'=>'width:20%; display: inline-block;']) !!}
                                {!! Form::text('post_street', $user->post_street, ['id'=>'route', 'style'=>'width:50%; margin-left:5%; display: inline-block;']) !!}
                                <span class="err_post_street"></span>
                                <span class="err_post_build"></span>
                            </div> -->
                           <!--  <div class="group clearfix">
                                {!! Form::label('post_city', __('messages.CITY')) !!}
                                {!! Form::text('post_city', $buyer->post_city, ['id'=>'locality']) !!}
                                <span class="err_post_city"></span>
                            </div> -->
                            <!-- <div class="group clearfix">
                                {!! Form::label('post_province', __('messages.PROVINCE')) !!}
                                {!! Form::text('post_province', $buyer->province, ['id'=>'administrative_area_level_2']) !!}
                                <span class="err_post_province"></span>
                            </div> -->
                           <!--  <div class="group clearfix">
                                {!! Form::label('post_region', __('messages.REGION')) !!}
                                {!! Form::text('post_region', $buyer->post_region, ['id'=>'administrative_area_level_1']) !!}
                                <span class="err_post_region"></span>
                            </div> -->
                            <!-- <div class="group clearfix">
                                {!! Form::label('post_post_code', __('messages.POST_CODE')) !!}
                                {!! Form::text('post_post_code', $buyer->post_post_code, ['id'=>'postal_code']) !!}
                                <span class="err_post_post_code"></span>
                            </div> -->
                            <!-- <div class="group clearfix">
                                {!! Form::label('post_country', __('messages.COUNTRY')) !!}
                                {!! Form::text('post_country', $buyer->post_country, ['id'=>'country']) !!}
                                <span class="err_post_country"></span>
                            </div> -->
                            <div class="group clearfix cart-company">
                                {!! Form::label('cart-company', __('messages.COMPANY').' '.__('messages.NAME')) !!}
                                {{ Form::text('cart_company', $buyer->company, ['id'=>'cart_company']) }}
                                <span class="err_cart-company"></span>
                            </div>
                            <div class="group clearfix cart-vat">
                                {!! Form::label('vat', __('messages.VAT')) !!}
                                {{ Form::text('vat', $buyer->vat, ['id'=>'vat']) }}
                                <span class="err_vat"></span>
                            </div>
                            <div class="group clearfix cart-name" style="display: none;">
                                {!! Form::label('name', __('messages.NAME')) !!}
                                {{ Form::text('name', $buyer->name, ['id'=>'name']) }}
                                <span class="err_name"></span>
                            </div>
                            <div class="group clearfix cart-surname" style="display: none;">
                                {!! Form::label('surname', __('messages.SURNAME')) !!}
                                {{ Form::text('surname', $buyer->surname, ['id'=>'surname']) }}
                                <span class="err_surname"></span>
                            </div>
                            <div class="group clearfix cart-phone_company">
                                {!! Form::label('phone_company', __('messages.PHONE_NUMBER_COMPANY')) !!}
                                {!! Form::text('phone_company', $buyer->phone_company) !!}
                                <span class="err_phone"></span>
                            </div>
                            <div class="group clearfix cart-email_company">
                                {!! Form::label('email_company', __('messages.EMAIL_COMPANY')) !!}
                                {{ Form::email('email_company',$buyer->email_company) }}
                                <span class="err_email"></span>
                            </div>
                            <div class="group clearfix cart-phone_number">
                                {!! Form::label('phone', __('messages.PHONE_NUMBER')) !!}
                                {!! Form::text('order_phone', $buyer->phone, ['disabled' => 'disabled','id'=>'order_phone']) !!}
                                <span class="err_phone"></span>
                            </div>
                            <div class="group clearfix cart-email">
                                {!! Form::label('email', 'EMAIL') !!}
                                {{ Form::email('order_email',$buyer->email, ['disabled' => 'disabled']) }}
                                <span class="err_email"></span>
                            </div>
                            {{ Form::hidden('order_phone', $buyer->phone) }}
                            {{ Form::hidden('order_email', $buyer->email) }}
                            {{ Form::hidden('buyer_id', $buyer->id) }}
                        </div>
                        {{--<div class="group clearfix">--}}
                            {{--{!! Form::label('comment', 'Comment') !!}--}}
                            {{--{!! Form::textarea('comment', $buyer->comment, ['cols' => '30', 'rows' => '5']) !!}--}}
                            {{--<span class="err_comment"></span>--}}
                        {{--</div>--}}
                        {{--{!! Form::close() !!}--}}
                        {{--<div style="text-align: center">--}}
                            {{--<button onclick="EditUser()" id="click_register">Edit</button>--}}
                        {{--</div>--}}
                    </div>
                </div>
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

 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="group_but clearfix">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 col_center">
            <a href="{{ URL::to('/'.App::getLocale().'/catalog/monica-loretti') }}">@lang('messages.BACK_TO_CATALOG')</a>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 col_center">  
            <input type="submit" form="order_form" value="@lang('messages.CONFIRM_ORDER')">
            {!! Form::close() !!}
        </div>
    </div>
</div>

<script>
    //Google Places API ***************
    var placeSearch, autocomplete;
    var componentForm = {
        street_number: 'short_name',
        route: 'long_name',
        locality: 'long_name',
        administrative_area_level_1: 'short_name',
        administrative_area_level_2: 'short_name',
        country: 'long_name',
        postal_code: 'short_name'
    };



    function initAutocomplete() {
        // Create the autocomplete object, restricting the search to geographical
        // location types.
        autocomplete = new google.maps.places.Autocomplete(
            (document.getElementById('autocomplete')),
            {types: ['geocode']});


        // When the user selects an address from the dropdown, populate the address
        // fields in the form.
        autocomplete.addListener('place_changed', fillInAddress);
    }
    function fillInAddress() {
        // Get the place details from the autocomplete object.
        var place = autocomplete.getPlace();
        console.info(place);

        for (var component in componentForm) {
            document.getElementById(component).value = '';
            document.getElementById(component).disabled = false;
        }

        // Get each component of the address from the place details
        // and fill the corresponding field on the form.
        for (var i = 0; i < place.address_components.length; i++) {
            var addressType = place.address_components[i].types[0];
            if (componentForm[addressType]) {
                var val = place.address_components[i][componentForm[addressType]];
                document.getElementById(addressType).value = val;
            }
        }
    }

    // Bias the autocomplete object to the user's geographical location,
    // as supplied by the browser's 'navigator.geolocation' object.
    function geolocate() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var geolocation = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };
                var circle = new google.maps.Circle({
                    center: geolocation,
                    radius: position.coords.accuracy
                });
                autocomplete.setBounds(circle.getBounds());
            });
        }
    }

</script>
<script>
    $(document).ready(function () {
        var check1 = $('#checkbox-1');
        var check2 = $('#checkbox-2');

        $('.cart-checkbox').on('click',function () {
            if (check1.is(':checked')) { //physic
                $('.cart-name').show();
                $('.cart-surname').show();
//                $('.cart-phone_number').show();
//                $('.cart-email').show();
                $('.cart-company').hide();
                $('.cart-vat').hide();
                $('.cart-phone_company').hide();
                $('.cart-email_company').hide();
            } else if(check2.is(':checked')) { //legal
                $('.cart-company').show();
                $('.cart-vat').show();
                $('.cart-name').hide();
                $('.cart-surname').hide();
//                $('.cart-phone_number').hide();
//                $('.cart-email').hide();
                $('.cart-phone_company').show();
                $('.cart-email_company').show();
            }
        });

    });
</script>
<style>
    .pac-container {
        z-index: 10000 !important;
    }
</style>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDajHgGvN3ueE1JXOzn0BFx43GVzVnTLdI&language=en&libraries=places&callback=initAutocomplete" async defer></script>
</script>