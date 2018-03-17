@extends('layouts.main')

@section('title')
    @lang('messages.SETTINGS')
@endsection

@section('locale')
@parent
@endsection

@section('menu-catalog')
@widget('Catalog')
@endsection

@section('select-menu-title')

@endsection

@section('menu-user')
@parent
@endsection

@section('content')
<div class="container container_center">
    <div class="row row_center">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 col_center">
            <div class="info-ajax"></div>
                                      
                   {!! Form::open(['class'=>'login log_new', 'id' => 'add_user' ]) !!}

                      <h2 class="title">@lang('messages.CREATE')</h2>
                      <div class="group clearfix">
                          {!! Form::label('name', __('messages.NAME') . '*') !!}
                          {{ Form::text('name', old('name'), ['id'=>'name']) }}
                          <span class="err_name"></span>
                      </div>                             
                      <div class="group clearfix">
                          {!! Form::label('surname', __('messages.SURNAME') . '*') !!}
                          {{ Form::text('surname', old('surname'), ['id'=>'surname']) }}
                           <span class="err_surname"></span>
                      </div>
                    <div class="group clearfix">
                        {!! Form::label('phone', __('messages.PHONE_NUMBER') . '*') !!}
                        {!! Form::text('phone', old('phone')) !!}
                        <span class="err_phone"></span>
                    </div>
                    <div class="group clearfix">
                        {!! Form::label('email', 'Email' . '*') !!}
                        {{ Form::email('email',old('email')) }}
                        <span class="err_email"></span>
                    </div>
                      @if($type =='Agent')
                          <div class="group clearfix">
                              {!! Form::label('role', __('messages.ROLE')) !!}
                              {{ Form::select('role', ['bayer'=>'Bayer'],'bayer', [ 'class'=>'diler_select', 'onchange' => 'agent(this)']) }}
                          </div>
                          <span class="err_role"></span>
                      @endif
                      
                      @if($type =='Diller')
                          <div class="group clearfix">
                              {!! Form::label('role', __('messages.ROLE')) !!}
                              {{ Form::select('role', ['bayer'=>'Bayer','agent'=>'Agent'],'agent', [ 'class'=>'diler_select', 'onchange' => 'agent(this)']) }}
                          </div>
                          <span class="err_role"></span>
                      @endif

                      <div class="group clearfix role_d" style="display: none">
                          @if($type =='Diller')
                              {!! Form::label('type_user', __('messages.AGENT')) !!}
                              <select name='type_user' id="type_user"  class='diler_select'>
                                  <option value ="0"> -Select Agent-</option>
                                  @forelse($agent_list as $key=>$value)
                                      <option value="{{ $key }}">
                                          {{ $value }}
                                      </option>
                                  @empty
                                     @lang('messages.EMPTY')
                                  @endforelse
                              </select>
                              {{--{{ Form::select('type_user',--}}
                                  {{--array('0' => ' -Select Agent-')+$agent_list->sectionPrototypes->lists('name', 'user_code_1c'),--}}
                                  {{--null,--}}
                                  {{--[ 'class'=>'diler_select'])--}}
                              {{--}}--}}
                         @endif
                         <span class="err_type_user"></span>
                      </div>
                    <div class="group clearfix">
                    {!! Form::label('vat', __('messages.VAT')) !!}
                    {{ Form::text('vat', old('vat'), ['id'=>'vat']) }}
                    <span class="err_vat"></span>
                    </div>
                      <div class="group clearfix">
                          {!! Form::label('company', __('messages.COMPANY')) !!}
                          {{ Form::text('company', old('company'), ['id'=>'company']) }}
                          <span class="err_company"></span>
                      </div>
                    <div class="group clearfix">
                        {!! Form::label('phone_company', __('messages.PHONE_NUMBER_COMPANY')) !!}
                        {!! Form::text('phone_company', old('phone_company')) !!}
                        <span class="err_phone_company"></span>
                    </div>
                    <div class="group clearfix">
                        {!! Form::label('email_company', __('messages.EMAIL_COMPANY')) !!}
                        {!! Form::text('email_company', old('email_company')) !!}
                        <span class="err_email_company"></span>
                    </div>




                      @if(count($currency_type)>=1)
                          <div class="group clearfix">
                              {!! Form::label('currency', __('messages.CURRENCY_TYPE')) !!}
                              {{ Form::select('currency', $currency_type, null, [ 'class'=>'diler_select ']) }}
                              <span class="err_currency"></span>
                          </div>
                      @endif  
                        
                      <div class="group clearfix">
                          {!! Form::label('type_value', __('messages.TYPE_OF_VALUE')) !!}
                          {{ Form::select('type_value',$typOf, null, [ 'class'=>'diler_select ']) }}
                          <span class="err_type_value"></span>
                      </div>
                        
                        
                      
                      <div class="group clearfix">
                          @if($pay_method)
                              {!! Form::label('paymant_type', __('messages.PAYMENT_TYPE')) !!}
                              {{ Form::select('paymant_type', $pay_method, null, [ 'class'=>'diler_select ' ]) }}
                          @endif
                          <span class="err_paymant_type"></span>
                      </div>
                     
                        
                      <h2 class="title">@lang('messages.LEGAL_ADDRESS')</h2>
                        
                      <div class="group clearfix">
                          {!! Form::label('autocomplete', __('messages.ADDRESS')) !!}
                          {!! Form::text('autocomplete', false, ['placeholder'=>'Enter your address', 'onclick' => 'initAutocomplete(this)' ])!!}
                      </div>
                      
                      <div class="group clearfix">
                          {!! Form::label('build', __('messages.STREET')) !!}
                          {!! Form::text('build', false, ['id' => 'street_number', 'disabled'=>true, 'style'=>'width:20%; display: inline-block;']) !!}
                          {!! Form::text('street', false, ['id'=>'route', 'disabled'=>true, 'style'=>'width:50%; margin-left:5%; display: inline-block;']) !!}
                         <span class="err_street"></span>
                         <span class="err_build"></span>
                      </div>

                      <div class="group clearfix">
                          {!! Form::label('province', __('messages.PROVINCE')) !!}
                          {!! Form::text('province', false, ['id'=>'administrative_area_level_2', 'disabled'=>true]) !!}
                          <span class="err_province"></span>
                      </div>

                          <div class="group clearfix">
                              {!! Form::label('city', __('messages.CITY')) !!}
                              {!! Form::text('city', false, ['id'=>'locality', 'disabled'=>true]) !!}
                              <span class="err_city"></span>
                          </div>
                          <div class="group clearfix">
                              {!! Form::label('region', __('messages.REGION')) !!}
                              {!! Form::text('region', false, ['id'=>'administrative_area_level_1', 'disabled'=>true]) !!}
                              <span class="err_region"></span>
                          </div>
                          <div class="group clearfix">
                              {!! Form::label('post_code', __('messages.POST_CODE')) !!}
                              {!! Form::text('post_code', false, ['id'=>'postal_code', 'disabled'=>true]) !!}
                              <span class="err_post_code"></span>
                          </div>
                          <div class="group clearfix">
                              {!! Form::label('country', __('messages.COUNTRY')) !!}
                              {!! Form::text('country', false, ['id'=>'country', 'disabled'=>true]) !!}
                              <span class="err_country"></span>
                          </div>

                          <h2 class="title">@lang('messages.DELIVERY_ADRESS')</h2>



                              <div class="group my_checkbox clearfix" style="text-align: center; max-width: 160px">
                                  <label>
                                      {!! Form::checkbox('legal', 'legal', false, ['id' => "legal", 'class' => 'postal_checkbox',  'onclick' => 'sameAsLegal(this)' ]) !!}
                                      <span>@lang('messages.SAME_AS_LEGAL')</span></label>
                                  <span class="err_legal"></span>
                              </div>


                          <div class="postal_addr">
                              <div class="group clearfix">
                                  {!! Form::label('post_build', __('messages.STREET')) !!}
                                  {!! Form::text('post_build', false, ['id' => 'post_street_number', 'style'=>'width:20%; display: inline-block;']) !!}
                                  {!! Form::text('post_street', false, ['id'=>'route', 'style'=>'width:50%; margin-left:5%; display: inline-block;']) !!}
                                 <span class="err_post_street"></span>
                                 <span class="err_post_build"></span>
                              </div>
                              <div class="group clearfix">
                                  {!! Form::label('post_city', __('messages.CITY')) !!}
                                  {!! Form::text('post_city', false, ['id'=>'post_locality']) !!}
                                  <span class="err_post_city"></span>
                              </div>
                              <div class="group clearfix">
                                  {!! Form::label('post_province', __('messages.PROVINCE')) !!}
                                  {!! Form::text('post_province', false, ['id'=>'post_administrative_area_level_2']) !!}
                                  <span class="err_post_province"></span>
                              </div>
                              <div class="group clearfix">
                                  {!! Form::label('post_region', __('messages.REGION')) !!}
                                  {!! Form::text('post_region', false, ['id'=>'post_administrative_area_level_1']) !!}
                                  <span class="err_post_region"></span>
                              </div>
                              <div class="group clearfix">
                                  {!! Form::label('post_post_code', __('messages.POST_CODE')) !!}
                                  {!! Form::text('post_post_code', false, ['id'=>'postal_code']) !!}
                                  <span class="err_post_post_code"></span>
                              </div>
                              <div class="group clearfix">
                                  {!! Form::label('post_country', __('messages.COUNTRY')) !!}
                                  {!! Form::text('post_country', false, ['id'=>'post_country']) !!}
                                  <span class="err_post_country"></span>
                              </div>
                          </div>
                          <div class="group clearfix">
                              {!! Form::label('password', __('messages.PASSWORD')) !!}
                              {!! Form::password('password') !!}
                              <span class="err_password"></span>
                          </div>
                          <div class="group clearfix">
                              {!! Form::label('password_confirmation', __('messages.CONFIRM')) !!}
                              {!! Form::password('password_confirmation') !!}
                              <span class="err_password_confirmation"></span>
                          </div>
                          <div class="group clearfix">
                              {!! Form::label('comment', __('messages.COMMENT')) !!}
                              {!! Form::textarea('comment', old('comment'), ['cols' => '30', 'rows' => '5']) !!}
                              <span class="err_comment"></span>
                          </div>
                    {!! Form::close() !!}
                   <button onclick="addUser(this)" id="click_register">@lang('messages.CREATE')</button>
                </div>
            </div>
        </div>
@endsection

@section('js')
    @parent
    
    <script>
        $(document).on( 'click', '#user-modal', function () {
            preview();
        });
        $(document).on( 'click', '.edit-user', function () {
            previewEdit( $(this).data('id') );
        });

        function previewEdit(el) {
            $.ajax({
                url: "{{ URL::to('/'.App::getLocale().'/cabinet/user/showedit') }}",
                type:'get',
                data: {id: el},
                success: function (data) {
                    document.getElementById('preview').innerHTML=data;
                    $('#myModal_new_user_edit').modal('show');
                }
            });
        }

        function preview() {
            $.ajax({
                url: "{{ URL::to('/'.App::getLocale().'/cabinet/user/add/form') }}",
                success: function (data) {
                    document.getElementById('preview').innerHTML=data;
                    $('#myModal_new_user').modal('show');
                }
            });
        }
        
            
        function addUser() {
              var data = $( "form" ).serialize();
              let token  = $('meta[name=csrf-token]').attr('content');
              $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': token }});  
              $.ajax({
                 url: "{{ URL::to('/'.App::getLocale().'/cabinet/user/create') }}",
                 data: data,
                 type: 'post'
              })
              .done(function(response) {
                if(response.errors){
                    $.each(response.errors, function(index, val) {
                      console.log(index);
                        $('.err_'+index).html(val);
                    });
                }
                if(response.ok) {
                  console.log(response.ok);
                  $("form").trigger('reset');
                  $('#myModal_new_user').modal('toggle');

                  let item = "<div class='alert alert-success alert-dismissible'>\n\
                                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>\n\
                                    <h4><i class='icon fa fa-check'></i>User successful create</h4>\n\
                                </div>";
                   return $('.info-ajax').append(item);
                   location.reload();
                }
              })
              .fail(function() {

              });
            }
            
        function EditUser(el) {
            var data = $( "form" ).serialize();

            var token  = $('meta[name=csrf-token]').attr('content');
            $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': token }});
            $.ajax({
                url: "{{ URL::to('/'.App::getLocale().'/cabinet/settings/edit') }}",
                data: data,
                type: 'post'
            })
                .done(function(response) {
                    if(response.errors){
                        $.each(response.errors, function(index, val) {
                            console.log(index);
                            $('.err_'+index).html(val);
                        });
                    }
                    if(response.ok) {
                        console.log(response.ok);
                        $("form").trigger('reset');
                        location.reload();
                    }
                })
                .fail(function() {

                });
        }

        function sameAsLegal(el) {
            if (el.checked) {
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
        }

        $('.role_d').css({display: "none"});


        function agent(el) {
            console.log(el);
            if(  $(el).val() == 'bayer' )  {
                $('.role_d').css("display","table");
            } else {
                $('.role_d').css({display: "none"});
            }
        }

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
    <style>
        .pac-container {
            z-index: 10000 !important;
        }
    </style>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDajHgGvN3ueE1JXOzn0BFx43GVzVnTLdI&language=en&libraries=places&callback=initAutocomplete" async defer></script>
@endsection

