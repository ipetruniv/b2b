@extends('layouts.admin')

@section('navbar')
    @parent
@endsection

@section('content')
        <section class="content-header">
            <h1>Редагування Користувача</h1>  
        </section>
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">   
                        <div class="box-body"> 
                            @if (count($errors) > 0)
                                <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <h4><i class="icon fa fa-ban"></i> Некоректні дані!</h4>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                             
                       <form class="login log_new" action="/admin/user/edits-confirm/{{ $user->id }}" method="post" id ="edit_user">
                       <div class="box-body">
                         <div class="form-group">
                          {!! Form::label('name', 'Name') !!}
                          {{ Form::text('name', $user->name, ['class'=>'form-control','id'=>'name']) }}
                          <span class="err_name"></span>
                      </div>                             
                       <div class="form-group">
                          {!! Form::label('surname', 'Surname') !!}
                          {{ Form::text('surname', $user->surname, ['class'=>'form-control','id'=>'surname']) }}
                           <span class="err_surname"></span>
                      </div>
                       <div class="form-group">
                          {!! Form::label('agent', 'Agent') !!}
                          {{ Form::text('agent', $user->agent_id, ['class'=>'form-control', 'disabled'=>'disabled']) }}
                          <span class="err_comment"></span>
                      </div> 
                       <div class="form-group">
                          {!! Form::label('diller', 'Diller') !!}
                          {{ Form::text('diller', $user->diller_id, ['class'=>'form-control', 'disabled'=>'disabled']) }}
                          <span class="err_comment"></span>
                      </div> 
                       <div class="form-group">
                          {!! Form::label('phone', 'Phone number') !!}
                          {{ Form::text('phone', $user->phone,['class'=>'form-control'])}}
                          <span class="err_phone"></span>
                      </div>
                       <div class="form-group">
                          {!! Form::label('email', 'Email') !!}
                          {{ Form::email('email',$user->email,['class'=>'form-control']) }}
                          <span class="err_email"></span>
                      </div>
                          @if($typeUserById !== 'Diller')
                          <div class="group clearfix ">
                              {!! Form::label('role', 'ROLE') !!}
                              {{ Form::select('role', ['buyer'=>'Bayer','agent'=>'Agent'],$typeUserById, [ 'class'=>'diler_select select2', 'onchange' => 'agentEdit(this)']) }}
                          </div>
                          <span class="err_role"></span>
                          
                          <div class="group clearfix type_us" @if($user->agent_id == null) style="display:none" @endif>
                        
                              {!! Form::label('type_user', 'Agent') !!}
                              {{ Form::select('type_user', $agent_list, $user->agent_id, [ 'class'=>'diler_select select2']) }}
                        
                              <span class="err_type_user"></span>
                           </div>  
                          @endif
                           
           
  
    
                       <div class="form-group">
                          {!! Form::label('vat', 'VAT') !!}
                          {{ Form::text('vat', $user->vat, ['id'=>'vat','class'=>'form-control']) }}
                          <span class="err_vat"></span>
                      </div>
                     <div class="form-group">
                          {!! Form::label('company', 'Company') !!}
                          {{ Form::text('company', $user->company, ['id'=>'company','class'=>'form-control']) }}
                          <span class="err_company"></span>
                      </div>
                       <div class="form-group">
                          {!! Form::label('phone_company', 'Phone number') !!}
                          {{ Form::text('phone_company', $user->phone, ['class'=>'form-control']) }}
                          <span class="err_phone_company"></span>
                      </div>

                      
                      <div class="form-group">
                          {!! Form::label('user_shops', 'Type of value') !!}      
                          {{  Form::select('user_type_value', $typOf, $user->type_price, ['class' => 'form-control select2',]) }} 
                      </div> 
                          
                      <div class="form-group">
                          {!! Form::label('shops', 'Available type of value') !!}      
                          {{  Form::select('type_value[]', $typOf, $selected_type_value, ['class' => 'form-control select2', 'multiple'=>true,]) }} 
                      </div> 
                         
                      <div class="form-group">
                              {!! Form::label('user_paymant_type', 'Payment type') !!}      
                              {{  Form::select('user_paymant_type', $pay_method, $user->type_pay, ['class' => 'form-control select2',]) }} 
                          <span class="err_paymant_type"></span>
                      </div>
                          
                      <div class="form-group">
                          @if($pay_method)
                              {!! Form::label('paymant_type', 'Available payment type') !!}      
                              {{  Form::select('paymant_type[]', $pay_method, $selected_payment_type, ['class' => 'form-control select2','multiple'=>true,]) }} 
                          @endif
                          <span class="err_user_paymant_type"></span>
                      </div>
                      <h2 class="title">Legal adress</h2>
                        
                       <div class="form-group">
                          {!! Form::label('autocomplete', 'Address') !!}
                          {!! Form::text('autocomplete', false, ['placeholder'=>'Enter your address','class'=>'form-control', 'onclick' => 'initAutocomplete(this)' ])!!}         
                      </div>
                      
                     <div class="form-group">
                          {!! Form::label('build', 'Street') !!}
                          {!! Form::text('build',  $user->build, ['id' => 'street_number','class'=>'form-control', 'style'=>'width:20%; display: inline-block;']) !!}
                          {!! Form::text('street', $user->street, ['id'=>'route','class'=>'form-control', 'style'=>'width:50%; margin-left:5%; display: inline-block;']) !!}
                         <span class="err_street"></span>
                         <span class="err_build"></span>
                      </div>
                      
                           <div class="form-group">
                              {!! Form::label('city', 'City') !!}
                              {!! Form::text('city', $user->city, ['id'=>'locality','class'=>'form-control']) !!}
                              <span class="err_city"></span>
                          </div>
                          <div class="form-group">
                              {!! Form::label('province', 'Province') !!}
                              {!! Form::text('province', $user->province, ['id'=>'administrative_area_level_2','class'=>'form-control']) !!}
                              <span class="err_province"></span>
                          </div>
                           <div class="form-group">
                              {!! Form::label('region', 'Region') !!}
                              {!! Form::text('region', $user->region, ['id'=>'administrative_area_level_1','class'=>'form-control']) !!}
                              <span class="err_region"></span>
                          </div>
                          <div class="form-group">
                              {!! Form::label('post_code', 'Post code') !!}
                              {!! Form::text('post_code', $user->post_code, ['id'=>'postal_code', 'class'=>'form-control']) !!}
                              <span class="err_post_code"></span>
                          </div>
                           <div class="form-group">
                              {!! Form::label('country', 'Country') !!}
                              {!! Form::text('country', $user->country, ['id'=>'country', 'class'=>'form-control']) !!}
                              <span class="err_country"></span>
                          </div>

                          <h2 class="title">Postal adress</h2>

                          <div class="group my_checkbox clearfix">
                              {!! Form::checkbox('legal', 'legal', false, ['id' => "legal", 'class' => 'postal_checkbox',  'onclick' => 'sameAsLegal(this)' ]) !!}
                              {!! Form::label('legal', 'Same as legal') !!}
                              <span class="err_legal"></span>
                          </div>

                          <div class="postal_addr">
                              <div class="form-group">
                                  {!! Form::label('post_build', 'Street') !!}
                                  {!! Form::text('post_build', $user->post_build, ['id' => 'post_street_number', 'class'=>'form-control', 'style'=>'width:20%; display: inline-block;']) !!}
                                  {!! Form::text('post_street', $user->post_street, ['id'=>'route', 'class'=>'form-control', 'style'=>'width:50%; margin-left:5%; display: inline-block;']) !!}
                                 <span class="err_post_street"></span>
                                 <span class="err_post_build"></span>
                              </div>
                               <div class="form-group">
                                  {!! Form::label('post_city', 'City') !!}
                                  {!! Form::text('post_city', $user->post_city, ['id'=>'post_locality', 'class'=>'form-control']) !!}
                                  <span class="err_post_city"></span>
                              </div>
                              <div class="form-group">
                                  {!! Form::label('post_province', 'Province') !!}
                                  {!! Form::text('post_province', $user->post_province, ['id'=>'administrative_area_level_2', 'class'=>'form-control']) !!}
                                  <span class="err_post_province"></span>
                              </div>
                              <div class="form-group">
                                  {!! Form::label('post_region', 'Region') !!}
                                  {!! Form::text('post_region', $user->post_region, ['id'=>'post_administrative_area_level_1', 'class'=>'form-control']) !!}
                                  <span class="err_post_region"></span>
                              </div>
                               <div class="form-group">
                                  {!! Form::label('post_post_code', 'Post code') !!}
                                  {!! Form::text('post_post_code', $user->post_post_code, ['id'=>'postal_code', 'class'=>'form-control']) !!}
                                  <span class="err_post_post_code"></span>
                              </div>
                              <div class="form-group">
                                  {!! Form::label('post_country', 'Country') !!}
                                  {!! Form::text('post_country', $user->post_country, ['id'=>'post_country', 'class'=>'form-control']) !!}
                                  <span class="err_post_country"></span>
                              </div>
                          </div>
                           <div class="form-group">
                              {!! Form::label('password', 'Password') !!}
                              {{ Form::password('password',['class'=>'form-control']) }}
                              <span class="err_password"></span>
                          </div>
                          <div class="form-group">
                              {!! Form::label('password_confirmation', 'Confirm') !!}
                              {{ Form::password('password_confirmation',['class'=>'form-control']) }}
                              <span class="err_password_confirmation"></span>
                          </div>
                          <div class="form-group">
                              {!! Form::label('comment', 'Comment') !!}
                              {{ Form::textarea('comment', $user->comment, ['cols' => '30', 'rows' => '5', 'class'=>'form-control']) }}
                              <span class="err_comment"></span>
                          </div> 
                          <div class="form-group">
                              {!! Form::label('adr', 'Address 1C') !!}
                              {{ Form::textarea('adr', $user->address, ['cols' => '30', 'rows' => '5', 'class'=>'form-control', 'disabled'=>'disabled']) }}
                              <span class="err_comment"></span>
                          </div> 
                          
                          
                          
                       </div>
                              {{ csrf_field() }}
                    <div class="box-footer">
                                    <button type="submit" class="btn btn-primary">Редагувати</button>
                                </div>
                    {!! Form::close() !!}
                   
                  
                        </div>
                    </div>
                </div>
            </div>
        </section>
<script src="/AdminLTE/plugins/select2/select2.full.min.js"></script>
    <!-- Select2 -->
<link rel="stylesheet" href="/AdminLTE/plugins/select2/select2.min.css">

 <script>
     $(document).ready(function() {
           $(".select2").select2();
        }); 

    
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
   

       
       $(document).ready(function () {
        function myselect() {
          $(function() {
            $('.diler_select').styler();
          });
        }
    
       function sameAsLegal(el) {
      if (el.checked) {
          var country = $('input[name=country]').val();
          var city = $('input[name=city]').val();
          var region = $('input[name=region]').val();
          var street = $('input[name=street]').val();
          var build = $('input[name=build]').val();
          var post_code = $('input[name=post_code]').val();
          $('input[name=post_country]').val(country);
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
});

 
           
           
    function agent(el) {
      console.log(el);
       if(  $(el).val() == 'bayer' )  {
            $('.role_d').css("display","table");
         } else {
            $('.role_d').css({display: "none"});
         }
    }
    
    
     function agentEdit(el) {
      console.log(el);
       if(  $(el).val() == 'buyer' )  {
            $('.type_us').css("display","table");
         } else {
            $('.type_us').css({display: "none"});
         }
    }
    
    @if($api == 0)
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

//      (function($) {
//          $(function() {
//              $('#my_edit_length select').styler();
//          });
//      })(jQuery);
// 
@endif
  </script>  
  <style>
      .pac-container {
          z-index: 10000 !important;
      }
   
  </style>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDajHgGvN3ueE1JXOzn0BFx43GVzVnTLdI&libraries=places&callback=initAutocomplete" async defer></script>

@endsection

