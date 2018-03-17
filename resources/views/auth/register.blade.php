@extends('layouts.main')
@section('locale')
    @parent
@endsection

@section('menu-catalog')
@endsection

@section('menu-user')
@endsection

@section('content')
        <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="group clearfix">
                            <div class="my_tabs">
                                <!-- Навигация -->
                                <ul class="nav nav-tabs" role="tablist">
                                    <li><a href="{{ route('login') }}">@lang('messages.LOGIN')</a></li>
                                    <li  class="active"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">@lang('messages.REGISTRATION')</a></li>
                                    <li><a href="{{ URL::to(App::getLocale().'/password/reset') }}">@lang('messages.RESET_PASSWORD')</a></li>
                                </ul>
                                <!-- Содержимое вкладок -->
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane-active" id="profile">
                                        {!! Form::open(['route' => 'custom-register', 'method' => 'POST', 'class' => 'login', 'id' => 'register_form']) !!}
                                            @include('auth.forms.register')
                                        {!! Form::close() !!}
                                    </div>    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
@endsection

@section('js')
@parent

<?php $lang = App::getLocale();
if ($lang == "en")
    $captha_src = "https://www.google.com/recaptcha/api.js?hl=en";
else if ($lang == "it")
    $captha_src = "https://www.google.com/recaptcha/api.js?hl=it";
else if ($lang == "sp")
    $captha_src = "https://www.google.com/recaptcha/api.js?hl=es";
else if ($lang == "pl")
    $captha_src = "https://www.google.com/recaptcha/api.js?hl=pl";
else if ($lang == "ru")
    $captha_src = "https://www.google.com/recaptcha/api.js?hl=ru";
?>

        <script src="{{$captha_src}}"></script>
<script>
        $(document).ready(function(){
            $('#register_form :checkbox').change(function() {
                // this will contain a reference to the checkbox
                if (this.checked) {
                    var country = $('input[name=country]').val();
                    var province = $('input[name=province]').val();
                    var city = $('input[name=city]').val();
                    var region = $('input[name=region]').val();
                    var street = $('input[name=street]').val();
                    var build = $('input[name=build]').val();
                    var post_code = $('input[name=post_code]').val();
                    $('input[name=post_country]').val(country);
                    $('input[name=post_province]').val(province);
                    $('input[name=post_city]').val(city);
                    $('input[name=post_region]').val(region);
                    $('input[name=post_street]').val(street);
                    $('input[name=post_build ]').val(build );
                    $('input[name=post_post_code]').val(post_code );
                    $('.postal_addr').hide(1000);
                } else {
                    $('.postal_addr').show("slow");
                }
            });
        });
        $('.login_link').on('click', function(){
            var tab = $(this).attr("href");
            $('a[href="'+tab+'"]').tab('show');
            $(tab).tab('show');
        });
    </script>
    <script>
//        $('#click_login').click(function (e) {
//            e.preventDefault();
//            var login = $('input[name=login]').val();
//            var password_login = $('input[name=password_login]').val();
//
//
//            var token = $('input[name=_token]').val();
//         
//            $.ajax({
//                url: '/custom-register/user',
//                type: 'post',
//                dataType: "json",
//                data: {
//                    _token:token,
//                    login: login,
//                    password_login: password_login
//                },
//                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
//                success: function () {
//                    $('#login_form').trigger('reset');
//                    window.location.href = '/';
//                },
//                error: function (response) {
//                    $('.sp_error').css('display', 'none');
//                    var responseText = $.parseJSON(response.responseText);
//                    $.each(responseText, function (key, value) {
//                        $('#' + key + '-error').css('display', 'inline-block').text(value);
//                    });
//                }
//            });
//        });
    </script>
    <script>
        $('#click_register').click(function (e) {
            e.preventDefault();
            var name = $('input[name=name]').val();
            var surname = $('input[name=surname]').val();
            var company = $('input[name=company]').val();
            var country = $('input[name=country]').val();
            var region = $('input[name=region]').val();
            var province = $('input[name=province]').val();
            var city = $('input[name=city]').val();
            var street = $('input[name=street]').val();
            var build = $('input[name=build]').val();
            var post_code = $('input[name=post_code]').val();
            var post_country = $('input[name=post_country]').val();
            var post_region = $('input[name=post_region]').val();
            var post_province = $('input[name=post_province]').val();
            var post_city = $('input[name=post_city]').val();
            var post_street = $('input[name=post_street]').val();
            var post_post_code = $('input[name=post_post_code]').val();
            var phone = $('input[name=phone]').val();
            var phone_company = $('input[name=phone_company]').val();
            var email_company = $('input[name=email_company]').val();
            var email = $('input[name=email]').val();
            var password = $('input[name=password]').val();
            var password_confirmation = $('input[name=password_confirmation]').val();
            var comment = $('#comment[name=comment]').val();
            var vat = $('#vat').val();

            var token = $('input[name=_token]').val();
            $.ajax({
                url: '/custom-register/user',
                type: 'post',
                dataType: "json",
                data: {
                    _token:token,
                    name: name,
                    phone: phone,
                    phone_company: phone_company,
                    email_company: email_company,
                    email: email,
                    surname: surname,
                    company: company,
                    country: country,
                    province: province,
                    region: region,
                    city: city,
                    street: street,
                    build: build,
                    post_code: post_code,
                    post_country: post_country,
                    post_province: post_province,
                    post_region: post_region,
                    post_city: post_city,
                    post_street: post_street,
                    post_post_code: post_post_code,
                    password: password,
                    password_confirmation: password_confirmation,
                    comment: comment,
                    vat: vat,
                    captcha: grecaptcha.getResponse()
                },
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (response) {
                    $('.sp_error').css('display', 'none');
                    $('#register_form').trigger('reset');
                    var tab = "#home";
                    $('a[href="'+tab+'"]').tab('show');
                    $(tab).tab('show');
                    $('#thanks').modal('show');
                     window.location.href = '/login';
                },
                error: function (response) {
                    $('.sp_error').css('display', 'none');
                    var responseText = $.parseJSON(response.responseText);
                    $.each(responseText, function (key, value) {
                        $('#' + key + '-error').css('display', 'inline-block').text(value);
                    });
                }
            });
        });
    </script>
    <script>
        //Google Places API
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
                /** @type {!HTMLInputElement} */(document.getElementById('autocomplete')),
                {types: ['geocode']});

            // When the user selects an address from the dropdown, populate the address
            // fields in the form.
            autocomplete.addListener('place_changed', fillInAddress);
        }

        function fillInAddress() {
            // Get the place details from the autocomplete object.
            var place = autocomplete.getPlace();

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

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBXbIq3pGU7AsQUcu-u4cm-ZRzgJ42oO3k&language=en&libraries=places&callback=initAutocomplete"
            async defer></script>
@endsection

