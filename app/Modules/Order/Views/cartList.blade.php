@extends('layouts.main')

@section('title')
 
@endsection

 @section('style')
     <script src="/monika/js/jquery.fancybox.js"></script>
     <script src="/monika/js/jquery.fancybox.pack.js"></script>
     <script src="/monika/js/jquery.fancybox-buttons.js"></script>

     <link href="/monika/css/jquery.fancybox.css" rel="stylesheet">
     <link href="/monika/css/jquery.fancybox-buttons.css" rel="stylesheet">
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
                <div class="group clearfix">
                    <h1 class="title"> @if( $cart->order_number_1c) @lang('messages.ORDERS')№{{ $cart->order_number_1c }} @endif</h1>
                    <div class="orders" >
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="group_input clearfix">
                                <div id="order_up">
                             
                                    @if($type == 'Diller') 
                                        <div class="group">
                                          <select form='order_form' class ="form-control my_select_dropdown" onchange="changeAgent()" id="agent" name="agent">
                                                <option value ="0">@lang('messages.SELECT') @lang('messages.AGENT')</option>
                                                @forelse($users_data as $user)
                                                    <option value="{{ $user->user_code_1c }}">
                                                        {{ $user->name }}
                                                    </option>
                                                @empty
                                                   @lang('messages.EMPTY')
                                                @endforelse
                                            </select> 
                                        </div>
                                     
                                        <div class="group" id="us">
                                          <select form='order_form' name='buyer' onchange="changeUserBuyer()" id="user-buyer"  class='form-control my_select_dropdown'>
                                                <option value ="0"> @lang('messages.SELECT') @lang('messages.USER')</option>
                                                @forelse($users as $user)
                                                    @if($user->type_price)
                                                    <option value="{{ $user->user_code_1c }}" @if($user->user_code_1c == $cart_user) selected @endif>
                                                        {{ $user->name }}
                                                    </option>
                                                    @endif
                                                @empty
                                                  @lang('messages.EMPTY')
                                                @endforelse
                                            </select>
                                        </div>
                                        <input hidden="" form="order_form"  value="{{ $cart->id }}" name="order">
                                        <div class="group" id="bauyers"></div>
                                        <div class="group" id="payment">
                                            @if ($payment_type)
                                                <label for='payment'>@lang('messages.CURRENCY_TYPE'): </label>
                                                <p class="type-price">{{$payment_type->name}}</p>
                                            @endif
                                        </div>
                                        <div class="group" id="type_payment">
                                                <label for='payment'>@lang('messages.PAYMENT_TYPE'): </label>
                                            @if ($method_price)
                                                <p class="type-price">{{$method_price->value}}</p>
                                            @endif
                                        </div>
                                    
                                    
                                        @elseif($type == 'Bayer')
                                       
                                       <div class="group" id="us">
                                           <select form='order_form' name='buyer' onchange="changeUserBuyer()"  id="user-buyer"  class='form-control my_select_dropdown'>
                                              @forelse($users as $user)
                                                    <option value="{{ $user->user_code_1c }}">
                                                        {{ $user->name }}
                                                    </option>
                                                @empty
                                                  @lang('messages.EMPTY')
                                                @endforelse
                                                
                                            </select>
                                        </div>
                                        <input hidden="" form="order_form"  value="{{ $cart->id }}" name="order">
                                      
                                        <div class="group" id="payment"></div> 
                                        
                                        
                                    
                                    
                                        
                                    @endif
                                        @if($type == 'Agent')
                                            <div class="group">
                                                <select form='order_form' name='buyer' onchange="changeUserBuyer()" id="user-buyer" class='form-control my_select_dropdown'>
                                                    <option value ="0"> @lang('messages.SELECT') @lang('messages.USER')</option>
                                                    @forelse($users as $user)
                                                        <option value="{{ $user->user_code_1c }}" @if($user->user_code_1c == $cart_user) selected @endif>
                                                            {{ $user->name }}
                                                        </option>
                                                    @empty
                                                      @lang('messages.EMPTY')
                                                    @endforelse
                                                </select>
                                                <input hidden="" form="order_form"  value="{{ $cart->id }}" name="order">
                                            </div>
                                            <div class="group" id="bauyers"></div>
                                            <div class="group" id="payment"></div> 
                                          @endif
                                        @if($type == 'Bayer') 
                                            @forelse($users as $user)
                                                <input hidden="" form="order_form"  value="{{ $user->user_code_1c }}" name='buyer'>
                                                <div class="group" form="order_form" value="{{ $user->type_price }}"  id="payment"></div>
                                            @empty
                                               @lang('messages.EMPTY')
                                            @endforelse  
                                    @endif
                                       
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="table-responsive">
                              
                                @if (session('status'))
                                    <div class="alert alert-success alert-dismissible" style="">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        <h4><i class="icon fa fa-check"></i>{{ session('status') }} </h4>   
                                    </div>
                                @endif
                                @if (session('stat_error'))
                                    <div class="alert alert-danger alert-dismissible" style="">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        <h4><i class="icon fa fa-ban"></i>{{ session('stat_error') }} </h4>   
                                    </div>
                                @endif
                                @if (count($errors) > 0)
                                    <div class="alert alert-danger alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        {{--<h4><i class="icon fa fa-ban"></i> Некоректні дані!</h4>--}}
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                
                                <table id="tab" class="table my_table" cellpadding="0" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <td><i class="fa fa-camera" aria-hidden="true"></i></td>
                                            <td>@lang('messages.NAME')</td>
                                            <td>@lang('messages.COLOR')</td>
                                            <td style="position: relative;">@lang('messages.SIZE')
                                                <div class="tooltip tooltip_size">
                                                    <i class="fa fa-info-circle" aria-hidden="true"></i>
                                                    <div class="tooltiptext">
                                                       <img src="{{URL::to('images/size.png')}}" alt="" id="">
                                                    </div>
                                                </div>
                                            </td>
                                            <td>@lang('messages.QUANTITY')</td>
                                            <td>@lang('messages.STORE')</td>
                                            <td>@lang('messages.PRICE')</td>
                                            <td>@lang('messages.SALE')</td>
                                            {{--<td>Tax</td>--}}
                                            <td>@lang('messages.TOTAL')</td>
                                            <td>
                                               @lang('messages.COMMENT')
                                            </td>
                                            <td></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($userCartRow as $row)   
      

                                            <tr data-id="{{$row->id}}">
                                                <td>
                                                    <a style="color:black" class="fancybox-button" rel="fancybox-button" href="/images/products/{{$row->product_1c}}/{{$row->product_1c}}_0.jpg" title="{{ $row->name }}">
                                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                                    </a>
                                                </td>
                                                <td class="my_select name_select_prod">
                                                    <select form="order_form"  name="collection" id="name__prod_{{$row->id}}" class="form-control my_select_dropdown name__prod {{$row->id}}">
                                                         <option value="{{ $row->product_1c }}">{{ $row->product_name }}</option>
                                                    </select>
                                                </td>
                                                <td class="my_select my_select_2 my_color">   
                                                    {{ Form::select('color', $row->AllColors ,$row->id_1c_color, [ 'class'=>'form-control my_select_dropdown_2 color__prod','id'=>'color_'.$row->id, 'data-id'=>$row->id,]) }}
                                                </td>
                                                <td class="my_select my_select_2 my_size">
                                                    {{ Form::select('size', $row->AllSizes ,$row->id_1c_size, [ 'class'=>'form-control my_select_dropdown_color_size','id'=>'size_'.$row->id,'data-id'=>$row->id,]) }}
                                                </td>
                                                <td><input type="number" value="{{ $row->count }}" disabled min="1"></td>
                                                <td id="storage_prod_{{$row->id}}"> {{ $row->store }}</td>
                                                <td id="price_prod_{{$row->id}}"> {{ $row->price }}</td>
                                                @if($row->discount)
                                                <td id="discount_prod_{{$row->id}}">{{$row->discount}}%</td>
                                                @else
                                                <td id="discount_prod_{{$row->id}}">0%</td>
                                                @endif
                                                {{--<td>0</td>--}}
                                                <td  id="price_total_{{$row->id}}">{{ $row->price_sum }}</td>
                                                <td class="my_textarea">
                                                  
                                                <textarea rows="auto" cols="auto" placeholder="" class="comment" id="{{$row->id}}">
                                                    {{$row->comment}}
                                                </textarea>
                                                  
                                                  
                                                  
                                                </td>
                                                <td class="my_delete">
                                                    <a href="#" class="row-remove">X</a>
                                                </td>
                                            </tr>
                                            <div id="myModal_{{$row->id}}" class="modal fade custom_size" tabindex="-1" role="dialog">
                                                <div class="modal-dialog">
                                                    <!-- Modal content-->
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            <h1 class="title">Custom size</h1>
                                                        </div>
                                                        <div class="modal-body clearfix">
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 col_center my_custom_50">
                                                                <div class="group">
                                                                    <label>Breast Heigh</label>
                                                                    <input id="Breast_Heigh" type="text" placeholder="5 - 50" value="" onclick="document.getElementById('dinamic').src = '/images/products/{{$row->code_1c}}/{{$row->code_1c}}.jpg';">
                                                                    <span class="err_breast_heigh"></span>
                                                                </div>
                                                                <div class="group">
                                                                    <label>Shoulder Width</label>
                                                                    <input id="Shoulder_Width" type="text" placeholder="20 - 100" value="" onclick="document.getElementById('dinamic').src = '/images/products/{{$row->code_1c}}/{{$row->code_1c}}.jpg';">
                                                                    <span class="err_shoulder_width"></span>
                                                                </div>
                                                                <div class="group">
                                                                    <label>Back width</label>
                                                                    <input id="Back_width" type="text" placeholder="20 - 60" value="" onclick="document.getElementById('dinamic').src = 'images/catalog/catalog_img_4.jpg';">
                                                                    <span class="err_back_width"></span>
                                                                </div>
                                                                <div class="group">
                                                                    <label>Shirina pílochki</label>
                                                                    <input id="Shirina_pílochki" type="text" placeholder="20 - 60" value="" onclick="document.getElementById('dinamic').src = 'images/catalog/catalog_img_5.jpg';">
                                                                    <span class="err_shirina_pílochki"></span>
                                                                </div>
                                                                <div class="group">
                                                                    <label>Breast volume</label>
                                                                    <input id="Breast_volume" type="text" placeholder="50 - 150" value="" onclick="document.getElementById('dinamic').src = 'images/catalog/catalog_img_6.jpg';">
                                                                    <span class="err_breast_volume"></span>
                                                                </div>
                                                                <div class="group">
                                                                    <label>Waist</label>
                                                                    <input id="Waist" type="text" placeholder="50 - 150" value="" onclick="document.getElementById('dinamic').src = 'images/catalog/catalog_img_1.jpg';">
                                                                    <span class="err_waist"></span>
                                                                </div>
                                                                <div class="group">
                                                                    <label>Thigh size</label>
                                                                    <input id="Thigh_size" type="text" placeholder="50 - 150" value="" onclick="document.getElementById('dinamic').src = 'images/catalog/catalog_img_2.jpg';">
                                                                    <span class="err_thigh_size"></span>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 col_center my_custom_50">
                                                                <div class="group">
                                                                    <label>Length of sleeves</label>
                                                                    <input id="Length_of_sleeves" type="text" placeholder="1 - 75" value="" onclick="document.getElementById('dinamic').src = 'images/catalog/catalog_img_3.jpg';">
                                                                    <span class="err_length_of_sleeves"></span>
                                                                </div>
                                                                <div class="group">
                                                                    <label>Girth of the forearm</label>
                                                                    <input id="Girth_of_the_forearm" type="text" placeholder="10 - 60" value="" onclick="document.getElementById('dinamic').src = 'images/catalog/catalog_img_4.jpg';">
                                                                    <span class="err_girth_of_the_forearm"></span>
                                                                </div>
                                                                <div class="group">
                                                                    <label>Length of the loop from the waist</label>
                                                                    <input id="Length_of_the_loop_from_the_waist" type="text" placeholder="150 - 250" value="" onclick="document.getElementById('dinamic').src = 'images/catalog/catalog_img_5.jpg';">
                                                                    <span class="err_length_of_the_loop_from_the_waist"></span>
                                                                </div>
                                                                <div class="group">
                                                                    <label>From waist to floor</label>
                                                                    <input id="From_waist_to_floor" type="text" placeholder="100 - 150" value="" onclick="document.getElementById('dinamic').src = 'images/catalog/catalog_img_6.jpg';">
                                                                    <span class="err_from_waist_to_floor"></span>
                                                                </div>
                                                                <div class="group">
                                                                    <label>Length of the product along the side seam</label>
                                                                    <input id="Length_of_the_product_along_the_side_seam" type="text" placeholder="100 - 150" value="" onclick="document.getElementById('dinamic').src = 'images/catalog/catalog_img_1.jpg';">
                                                                    <span class="err_length_of_the_product_along_the_side_seam"></span>
                                                                </div>
                                                                <div class="group">
                                                                    <label>Height on heels</label>
                                                                    <input id="Height_on_heels" type="text" placeholder="100 - 250" value="" onclick="document.getElementById('dinamic').src = 'images/catalog/catalog_img_2.jpg';">
                                                                    <span class="err_height_on_heels"></span>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 col_center my_custom_100">
                                                                <div class="dinamic_img">
                                                                    <img src="images/catalog/catalog_img_1.jpg" alt="" id="dinamic">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <input onclick="addToCartInd()" type="submit" value="Submit">
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                        @empty
                                        
                                        @endforelse
                                      
                                        <tr data-id="empty-column" onclick="">
                                            <td><i class="fa fa-eye" aria-hidden="true"></i></td>
                                            <td class="my_select name_select_prod">
                                                <select name="collection" id="name__prod_empty-column" class="form-control my_select_dropdown name__prod empty-column">

                                                </select>
                                            </td>
                                            <td class="my_select my_select_2 my_color">
                                                <select name="color" id="color_empty-column" class="form-control my_select_dropdown_2 color__prod checkme">

                                                </select>
                                            </td>
                                            <td class="my_select my_select_2">
                                                <select name="size" id="size_empty-column"  class="form-control my_select_dropdown_color_size checkme">
                                                    <option >

                                                    </option>
                                                </select>
                                            </td>
                                            <td></td>
                                            <td id="stor"></td>
                                            <td id="price_prod_empty-column"></td>
                                            <td></td>
                                            {{--<td></td>--}}
                                            <td  id="price_total_empty-column"></td>
                                            <td class="my_textarea">
                                                <textarea rows="3" cols="15" id="coment_empty"  placeholder="">

                                                </textarea>
                                            </td>
                                            <td class="my_delete">
<!--                                                    <a href="#" class="row-remove">X</a>-->
                                            </td>
                                        </tr>    
                                    </tbody>
                                </table>
                                    <table id="sum_tab" class="table my_table" cellpadding="0" cellspacing="0">
                                        <thead>
                                        <tr>
                                            <td>@lang('messages.SALE')</td>
                                            {{--<td>Tax</td>--}}
                                            <td>@lang('messages.TOTAL')</td>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td id="total_discount">{{$totalSum - $totalDiscount}}</td>
                                            <td id="total_sum">{{$totalDiscount}}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="my_date">
                                <form id="order_form" method="post" action="{{ URL::to('/'.App::getLocale().'/order') }}">
                                    {{ csrf_field() }}
                                    <div id="dpcontainer" class="ui-widget">
                                        <label for="my_datepicker">@lang('messages.DESIRED_DELIVERY_DATE'): </label>
                                        <input name="date" value="{{ old('date') }}" id="my_datepicker"/>
                                    </div>
                                {{--</form>--}}
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="group clearfix">
                                <div class="my_tabs my_tabs_order">
                                    <!-- Навигация -->
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">@lang('messages.COMMENT') </a></li>
                                        <li><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">@lang('messages.ASK_MANAGER')</a></li>
                                    </ul>
                                    <!-- Содержимое вкладок -->
                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane active" id="home">
                                            <textarea rows="6" form="order_form" name="order_comment" cols="" placeholder="" style="width:100%;border:none;">

                                            </textarea>
                                        </div>
                                        <div role="tabpanel" class="tab-pane" id="profile">
                                            <p>
                                               @lang('messages.EMPTY')
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @include('order.delivery');
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="myModal" class="modal fade custom_size" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <form id="customSize">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h1 class="title">@lang('messages.INDIVIDUAL_SIZE')</h1>
                </div>
                <div class="modal-body clearfix">
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 col_center my_custom_50">
                        <div class="group">
                            <label>@lang('messages.BREAST_HEIGH')</label>
                            <input 
                                name="Breast_Heigh"  id="Breast_Heigh" type="text" placeholder="5 - 50" value="" onfocus="document.getElementById('dinamic_custom').src = '/images/individual_size/breast_heigh.jpg';">
                            <span class="err_breast_heigh"></span>
                        </div>
                        <div class="group">
                            <label>@lang('messages.SHOULDER_WIDTH')</label>
                            <input name="Shoulder_Width" id="Shoulder_Width" type="text" placeholder="20 - 100" value="" onfocus="document.getElementById('dinamic_custom').src = '/images/individual_size/shoulder_width.jpg';">
                            <span class="err_shoulder_width"></span>
                        </div>
                        <div class="group">
                            <label>@lang('messages.BACK_WIDTH')</label>
                            <input name="Back_width" id="Back_width" type="text" placeholder="20 - 60" value="" onfocus="document.getElementById('dinamic_custom').src = '/images/individual_size/back_width.jpg';">
                            <span class="err_back_width"></span>
                        </div>
                        <div class="group">
                            <label>@lang('messages.FROM_ARMPIT_TO_ARMPIT')</label>
                            <input name="Shirina_pílochki" id="Shirina_pílochki" type="text" placeholder="20 - 60" value="" onfocus="document.getElementById('dinamic_custom').src = '/images/individual_size/shirina_pilochki.jpg';">
                            <span class="err_shirina_pílochki"></span>
                        </div>
                        <div class="group">
                            <label>@lang('messages.BREAST_VOLUME')</label>
                            <input name="Breast_volume" id="Breast_volume" type="text" placeholder="50 - 150" value="" onfocus="document.getElementById('dinamic_custom').src = '/images/individual_size/breast_volume.jpg';">
                            <span class="err_breast_volume"></span>
                        </div>
                        <div class="group">
                            <label>@lang('messages.WAIST')</label>
                            <input name="Waist" id="Waist" type="text" placeholder="50 - 150" value="" onfocus="document.getElementById('dinamic_custom').src = '/images/individual_size/waist.jpg';">
                            <span class="err_waist"></span>
                        </div>
                        <div class="group">
                            <label>@lang('messages.HIPS_VOLUME')</label>
                            <input name="Thigh_size" id="Thigh_size" type="text" placeholder="50 - 150" value="" onfocus="document.getElementById('dinamic_custom').src = '/images/individual_size/thigh_size.jpg';">
                            <span class="err_thigh_size"></span>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 col_center my_custom_50">
                        <div class="group">
                            <label>@lang('messages.LENGTH_OF_SLEEVES')</label>
                            <input name="Length_of_sleeves" id="Length_of_sleeves" type="text" placeholder="1 - 75" value="" onfocus="document.getElementById('dinamic_custom').src = '/images/individual_size/length_of_sleeves.jpg';">
                            <span class="err_length_of_sleeves"></span>
                        </div>
                        <div class="group">
                            <label>@lang('messages.GIRTH_OF_THE_FOREARM')</label>
                            <input name="Girth_of_the_forearm" id="Girth_of_the_forearm" type="text" placeholder="10 - 60" value="" onfocus="document.getElementById('dinamic_custom').src = '/images/individual_size/girth_of_the_forearm.jpg';">
                            <span class="err_girth_of_the_forearm"></span>
                        </div>
                        <div class="group">
                            <label>@lang('messages.LENGTH_OF_THE_LOOP_FROM_THE_WAIST')</label>
                            <input name="Length_of_the_loop_from_the_waist" id="Length_of_the_loop_from_the_waist" type="text" placeholder="150 - 250" value="" onfocus="document.getElementById('dinamic_custom').src = '/images/individual_size/length_of_the_loop_from_the_waist.jpg';">
                            <span class="err_length_of_the_loop_from_the_waist"></span>
                        </div>
                        <div class="group">
                            <label>@lang('messages.FROM_WAIST_TO_FLOOR')</label>
                            <input name="From_waist_to_floor" id="From_waist_to_floor" type="text" placeholder="100 - 150" value="" onfocus="document.getElementById('dinamic_custom').src = '/images/individual_size/from_waist_to_floor.jpg';">
                            <span class="err_from_waist_to_floor"></span>
                        </div>
                        <div class="group">
                            <label>@lang('messages.LENGTH_SIDE_SEAM')</label>
                            <input name="Length_of_the_product_along_the_side_seam" id="Length_of_the_product_along_the_side_seam" type="text" placeholder="100 - 150" value="" onfocus="document.getElementById('dinamic_custom').src = '/images/individual_size/length_of_the_product_along_the_side_seam.jpg';">
                            <span class="err_length_of_the_product_along_the_side_seam"></span>
                        </div>
                        <div class="group">
                            <label>@lang('messages.HEIGHT_ON_HEELS')</label>
                            <input name="Height_on_heels" id="Height_on_heels" type="text" placeholder="100 - 250" value="" onfocus="document.getElementById('dinamic_custom').src = '/images/individual_size/height_on_heels.jpg';">
                            <span class="err_height_on_heels"></span>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 col_center my_custom_100">
                        <div class="dinamic_img">
                            <img src="" alt="" id="dinamic_custom"">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input onclick="addToCartInd()" type="submit" value="@lang('messages.SUBMIT')">
                </div>
            </div>
        </form>

        </div>
    </div>



@endsection


@section('js')
    @parent
    <script>

    $('select[name="size"]').change(function(){
        if($(this).val() == '381e2545-269f-11e7-ba21-00215a4648ba'){ // or this.value == 'volvo'
//            $("myModal_"+this.id).show();
//            alert(this.id);
        }
    });

    function addToCartInd()
    {
        var data = {
            breast_heigh: $('#Breast_Heigh').val(),
            shoulder_width: $('#Shoulder_Width').val(),
            back_width: $('#Back_width').val(),
            shirina_pílochki: $('#Shirina_pílochki').val(),
            breast_volume: $('#Breast_volume').val(),
            waist: $('#Waist').val(),
            thigh_size: $('#Thigh_size').val(),
            length_of_sleeves: $('#Length_of_sleeves').val(),
            girth_of_the_forearm: $('#Girth_of_the_forearm').val(),
            length_of_the_loop_from_the_waist: $('#Length_of_the_loop_from_the_waist').val(),
            from_waist_to_floor: $('#From_waist_to_floor').val(),
            length_of_the_product_along_the_side_seam: $('#Length_of_the_product_along_the_side_seam').val(),
            height_on_heels: $('#Height_on_heels').val(),
            product: $('#product').val(),
            color: $(".my_color").val(),
            size: 'ind'
        }


        var token  = $('meta[name=csrf-token]').attr('content');
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': token }});

        $.ajax({
            url :"{{ URL::to('/'.App::getLocale().'/product/add-pr') }}",
            type: 'post',
            data: data,

        }).done(function(response) {
            if(response.debag){
                console.log(response.debag);
            }
            if(response.error) {
                $.each(response.error, function(index, val) {
                    console.log(index);
                    $('.err_'+index).html(val);
                });
            }
            if(response.count) {
                console.log(response.count);

                var item = "<a href='{{ URL::to('/'.(App::getLocale().'/cart')) }}'> <i class='fa fa-shopping-basket' aria-hidden='true'>\n\
                    </i><div class='basket_item'>\n\
                    <span class='bas_count'>"+response.count+"</span>\n\
                    </div></a>";
                $('.info-ajax').empty();
                $('#basket').empty().addClass('basket');
//                  $('#myModal').hide();
                // location.reload();
                return   $('#basket').append(item);
                //  location.reload();
            }

        })


    }


    $(document).ready(function(){
        $("#checkbox-2").attr("checked","checked").button('refresh');
    });

        $(document).ready(function() {
            $(".fancybox-button").fancybox({
//                prevEffect		: 'none',
//                nextEffect		: 'none',
//                closeBtn		: false,
//                helpers		: {
//                    title	: { type : 'inside' },
//                    buttons	: 'none'
//                }
            });
        });

      $(document).on('click', '.name_select_prod ', function() {
        var id = $(this).closest("tr").attr('data-id');
        var def_prod =  $('#name__prod_'+id).val();


        var data = {
              user : $('#user-buyer').val(),
              agent : $('#agent').val(),
              _token  : '{{csrf_token()}}'
            }

//        if($('#agent').val()==0) {
//            Lobibox.notify('info', {
//                size: 'normal',
//                position: 'right bottom',

//                msg: "Select agent"
//            }); 

//        }
         if($('#user-buyer').val()==0) {
            Lobibox.notify('info', {
                size: 'normal',
                position: 'right bottom',
                msg: "Select user"
            }); 

        } else {
            getProduct(data, id);
        }

      });

      function getProduct(data, id) {

        $.ajax({
          url: "{{ URL::to('/'.App::getLocale().'/get-all-prodict') }}",
          type:"post",
          data: data,
        }).done(function(response) {
            if(response.error) {
              Lobibox.notify('error', {
                size: 'normal',
                position: 'right bottom',
                msg: response.error
              });
            }
            if(response.ok) {
              var prod =  $('#name__prod_'+id).val();
              $('#name__prod_'+id).empty();
              var options = '';

              $(response.ok).each(function(i, row) {
                options += '<option  value="' + row.code_1c + '">' + row.name + '</option>';
              });
              $('#name__prod_'+id).append(options);
              $('#name__prod_'+id).select2('destroy').select2();
              $('#name__prod_'+id).val(prod);
              $('#price_prod_'+id).empty();
              $('#price_total_'+id).empty();
              selectProd(id);

            }
        })
      }

      function changeAgent() {
          var agent = $('#agent').val();
          if (agent == 0) {
            $('#bauyers').empty();
            getBuyer(agent);
          }
          else {
              getBuyer(agent);
          }
      }

      function changeUserBuyer() {

        if($('#user-buyer option:selected').val() == 0) {
            alert($('#user-buyer').val());
          $('#payment').empty();
        } else {
            var data = {
              user : $('#user-buyer option:selected').val(),
              agent : $('#agent').val(),
              _token  : '{{csrf_token()}}'
            }

            getPaimentType(data);
        }
      }

      $(document).ready(function(){
          // changeUserBuyer();
          $('.delivery_adress .title').click()
      });

      function getPaimentType(data) {

        var token  = $('meta[name=csrf-token]').attr('content');
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': token }});

        $.ajax({
            url :"{{ URL::to('/'.App::getLocale().'/get-payment-type') }}",
            data:data,
            type:'post',
        }).done(function(response){
            if(response.error) {
                $('#payment').empty();
                 Lobibox.notify('error', {
                            size: 'normal',
                            position: 'right bottom',
                            msg: 'Price type is not defined'
                        }); 
            }

            if(response.ok) {
                var method_payment = response.method_payment;
                if (!method_payment) {
                    method_payment = "";
                } else {
                    method_payment = response.method_payment.value;
                }
              $('#total_discount').html(response.total.total_sum);
              $('#total_sum').html(response.total.total_discount);
              $('#payment').empty();
              var html = " <label for='text_2'>@lang('messages.PAYMENT_TYPE')</label><p class='type-price'>"+response.ok.name+"</p>";
              $('#payment').append(html);
                $('#type_payment').empty();
                if (method_payment){
                    var html2 = " <label for='text_2'>@lang('messages.CURRENCY_TYPE')</label><p class='type-price'>"+method_payment+"</p>";
                    $('#type_payment').append(html2);
                }
                $('#country').val(response.ok.post_country);
              $('#company').val(response.ok.company);
              $('#region').val(response.ok.post_region);
              $('#locality').val(response.ok.post_city);
              $('#street').val(response.ok.post_street);
              $('#build').val(response.ok.post_build);
              $('#post').val(response.ok.post_post_code);
              $('#phone').val(response.ok.phone);
              $('#email').val(response.ok.email);
              $('input[name="order_email"]').val(response.ok.email);
              $('#autocomplete').val(response.ok.address);
              $('#cart_company').val(response.ok.company);
              $('#phone_company').val(response.ok.phone_company);
              $('#email_company').val(response.ok.email_company);
              $('#order_phone').val(response.ok.phone);
            }

            if(response.prices){
                $.each(response.prices, function(index, val) {
                     $('#price_prod_'+index).html(val.price);
                     $('#price_total_'+index).html(val.total);

                });
            }

            if(response.agent) {

              $('#agent').val(response.agent.user_code_1c).trigger('change');
            }
            // location.reload();
//            if(response.agent == null) {
//               Lobibox.notify('error', {
//                            size: 'normal',
//                            position: 'right bottom',
//                            msg: 'No agent found for this user'
//                        }); 
//            }




        });

      }

      function getBuyer(agent) {
        var token  = $('meta[name=csrf-token]').attr('content');
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': token }});
        $.ajax({
          url :"{{ URL::to('/'.App::getLocale().'/get-buyer') }}",
          data:{agent:agent},
          type:'post'

        }).done(function(response) {

            console.log('***********1*****************');
            console.log(response);
            console.log('*************1***************');
            if(response.error) {
                $('#us').empty();
                $('#payment').empty();
                $('#bauyers').empty();
                  Lobibox.notify('error', {
                            size: 'normal',
                            position: 'right bottom',
                            msg: 'This agent doesn\'t have any users, you can add them in the cabinet'
                  });
            }

            if(response.ok) {
              $('#us').empty();
              $('#bauyers').empty();
              $('#payment').empty();

              var k = 0;
              var type = '';
              var options = '<option value="0">'+ "@lang('messages.SELECT') @lang('messages.USER')"+'</option>';
              $(response.ok).each(function(i, row) {

                if(k == 0) {
                  type = 'selected="selected"';
                } else {
                  type = 'selected="false"';
                }
                options += '<option '+type+' value="' + $(this).attr('user_code_1c') + '">' + $(this).attr('name') + '</option>';
                k++;
              });
              var html = "<select  form='order_form' name='buyer' id='user-buyer' onchange='changeUserBuyer()' class='form-control my_select_dropdown'>"+options+"<select>";

                $('#total_sum').html(total.total_sum);
                $('#total_discount').html(total.total_disount);

              $('#bauyers').append(html);
              if(agent != 0) {
                  changeUserBuyer();
              }



              //   $('#bauyers').val($('#bauyers option:first-child').val()).trigger('change');
              //  $('#bauyers').select2().select2('val', $('.select2 option:eq(1)').val());
              return myselect();
            }
        })
      }


      $('.my_select_dropdown.name__prod').on('select2:select', function (e) {
        var id = $(this).closest("tr").attr('data-id');
        var data = e.params.data;
        var param = {
          user    : $('#user-buyer').val(),
          agent   : $('#agent').val(),
          product : data.id,
          _token  : '{{csrf_token()}}'
        }


        getSizeProduct(param,id);


      });


      // По кольору клік
      function getSizeProduct(param,id) {

         $.ajax({
          url: "{{ URL::to('/'.App::getLocale().'/get-product-color-size') }}",
          type:"get",
          data: param,
        }).done(function(response) {
            if(response.error) {
              Lobibox.notify('error', {
                size: 'normal',
                position: 'right bottom',
                msg: response.error
              });
            }
            if(response.ok) {


              var options_size =  '<option value="0">-Select Size-</option>';
              $('#size_'+id).empty();

              $(response.ok).each(function(i, row){
                options_size += '<option  value="' + row.code_1c_characteristic_value + '">' + row.value + '</option>';
              });

              $('#size_'+id).append(options_size);
            }

            if(response.colors) {
              $('#color_'+id).empty();
              var price = '';
              var ProdSelect = $('#color_'+id);
              var options = '<option value="0">-Select Color-</option>';
              $(response.colors).each(function(i, row){
                options += '<option  value="' + row.code_1c_characteristic_value + '">' + row.value + '</option>';
              });

              ProdSelect.append(options);
              $('#discount_prod_'+id).html('');
              $('#storage_prod_'+id).html('');

            }

        })
      }
        $('.my_select_dropdown_2.color__prod').on('select2:select', function (e) {
          var pr =  $('.my_select_dropdown.name__prod').val();
          var id = $(this).closest("tr").attr('data-id');
          var data = e.params.data;
          var param = {
            user    : $('#user-buyer').val(),
            agent   : $('#agent').val(),
            product : pr,
            color   : data.id,
            _token  : '{{csrf_token()}}'
          }

        var size =  $('#size_'+id).val();
        if(size !== '0' && size !== '') {

          var br_id =  $(this).closest("tr").attr('data-id');
          //var data = e.params.data;
          var param = {
            user    : $('#user-buyer').val(),
            agent   : $('#agent').val(),
            product : pr,
            color   :  data.id,
            size    : size,
            br_id   : br_id,
            order_id :"{{$cart->id}}",
            _token  : '{{csrf_token()}}'
          }
           getPriceBySize(param,id);
        } else {
            FindProdByCoror(param,id);
        }

      });


      function FindProdByCoror(param,id)
      {

         $.ajax({
          url: "{{ URL::to('/'.App::getLocale().'/get-product-color') }}",
          type:"get",
          data: param,
        }).done(function(response) {
            if(response.error) {
              Lobibox.notify('error', {
                size: 'normal',
                position: 'right bottom',
                msg: 'COLOR_NOT_FOUND'
              });
            }
            if(response.ok) {

              var options_size = '<option value="0">-Select Size-</option>';
              $('#size_'+id).empty();

              $(response.ok).each(function(i, row){
                options_size += '<option  value="' + row.code_1c_characteristic_value + '">' + row.value + '</option>';
              });
              $('#price_prod_'+id).empty();
              $('#price_total_'+id).empty();
              $('#size_'+id).append(options_size);
            }

        })
      }


      //по розміру клік
      $('.my_select_dropdown_color_size').on('select2:select', function (e) {
        var id = $(this).closest("tr").attr('data-id');
        var prod =  $('#name__prod_'+id).val();
        var color =  $('#color_'+id).val();
        var br_id =  $(this).closest("tr").attr('data-id');
        var data = e.params.data;
        var param = {
          user    : $('#user-buyer').val(),
          agent   : $('#agent').val(),
          product : prod,
          color   : color,
          size    : data.id,
          br_id   : br_id,
          order_id : "{{$cart->id}}",
          _token  : '{{csrf_token()}}'
        }
        if(color !== '0') {
          //alert(color);
           getPriceBySize(param,id);
        }


      });



      function getPriceBySize(param,id) {

          if(param.size == "381e2545-269f-11e7-ba21-00215a4648ba")
              showSizeModal(param,id);
          else
              getPriceProd(param,id);
      }

      function showSizeModal(param,id){
          $('#myModal').modal('show');
          $('#myModal').find('input[type="submit"]').removeAttr('onclick');
          window.customSize = new Object;
          window.customSize.param = param;
          window.customSize.id   = id;
      }

      $(document).ready(function(){
         $('form#customSize').submit(function(e){
             e.preventDefault();

             $.ajax({
                 url  : "{{ URL::to('/'.App::getLocale().'/setSuctomSize') }}",
                 type : "POST",
                 data : {
                     _token     : '{{csrf_token()}}',
                     data       : $('form#customSize').serialize(),
                     customSize : window.customSize
                 },
                 success : function(response){
                     console.log(response);
                     if(response.comment){
                         $('#myModal').modal('hide');
                         window.customSize.param.comm = response.comment;
                         getPriceProd(window.customSize.param,window.customSize.id);
                     }
                 }
             });
         })
      });

      function getPriceProd(param,id) {

          $.ajax({
              url: "{{ URL::to('/'.App::getLocale().'/get-product-price') }}",
              type: "get",
              data: param,
          }).done(function (response) {
              if (response.error) {
                  Lobibox.notify('error', {
                      size: 'normal',
                      position: 'right bottom',
                      msg: response.error
                  });
              }
              console.log('***xxxx*************');
              console.log(response);
              console.log('*****xxx***********');
              if (response.ok) {

                  $('#price_prod_' + id).empty();
                  $('#price_total_' + id).empty();
                  $('#price_prod_' + id).append(response.ok.price);
                  $('#price_total_' + id).append(response.ok.price);
                  $('#stor').append(response.ok.store);
                  return location.reload();
              }

          })
      }

      $( ".group_check input" ).checkboxradio();

      function myselect() {
        $( ".my_select_dropdown" ).select2({
          widht:100,
          language: {
              noResults: function(term) {
                  return "Not found";
              }
          }
        });
      }



      function selectProd(id) {
        $( '#name__prod_'+id ).select2({
          widht:100,
          language: {
            noResults: function(term) {
            return "Not found";
            }
          }
        }).select2("open");
      }


    $( ".my_select_dropdown_color_size" ).select2({
     // minimumResultsForSearch: -1,
      widht:100,
      language: {
        noResults: function(term) {
          return "Not found";
        }
      }
    });


    $( ".my_select_dropdown_2" ).select2({
        //minimumResultsForSearch: -1,
        widht:100,
        language: {
            noResults: function(term) {
                return "Not found";
            }
        }
    });


    function myselectDr2() {
      $( ".my_select_dropdown_2" ).select2({
        //minimumResultsForSearch: -1,
        widht:100,
        language: {
            noResults: function(term) {
                return "Not found";
            }
        }
    });
    }



    $( ".my_select_dropdown" ).select2({
        widht:100,
        language: {
            noResults: function(term) {
                return "Not found";
            }
        }
    });


    $(function(){
        $.datepicker.setDefaults(
                $.extend($.datepicker.regional["en"])
        );
        $("#my_datepicker").datepicker({
            showButtonPanel: false,
            dateFormat: 'dd-mm-yy',
            duration:'normal',
            minDate:0
        });

    });



    $('.payment > .title.left').click(function(){
        $( "#payment_hidden" ).toggle("slow");
        if(!$(this).hasClass('active'))
            $(this).addClass('active');
        else
            $(this).removeClass('active');

    });

    $('.row-remove').click(function () {
      if (confirm("DELETE THIS PRODUCT?")) {
        var element = $(this);
        element.parent().parent().remove();
        var id =  $(this).closest("tr").attr('data-id');

        if(id == Number.isInteger) {
          return true;
        }

        var token  = $('meta[name=csrf-token]').attr('content');
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': token }});

        $.ajax( {
          url: "{{ URL::to('/'.App::getLocale().'/delete-prodict') }}"+'/'+id,
          data: {id: id},
          dataType: 'json',
          type: 'post',
        }).done(function(response) {
            if(response.error) {

                  Lobibox.notify('error', {
                            size: 'normal',
                            position: 'right bottom',
                            msg: response.error,
                        });
            }

            if(response.ok) {


                  Lobibox.notify('success', {
                            size: 'normal',
                          //  rounded: true,
                            position: 'right bottom',
                            msg: response.ok,
                        });

            }
        });
      }
    });

     function appentTableRow(id) {

       $('#tab > tbody:last').append("<tr data-id='empty-column"+id+"'>\n\
           <td><i class='fa fa-eye' aria-hidden='true'></i></td>\n\
            <td class='my_select name_select_prod'>\n\
            <select name='collection' id='name__prod_empty-column' class='form-control my_select_dropdown name__prod 'empty-column"+id+"'>\n\
            </select>\n\
            </td>\n\
            <td class='my_select my_select_2 my_color'>\n\
            <select name='color' id='empty-column"+id+"' class='form-control my_select_dropdown_2 color__prod'>\n\
            </select>\n\
            </td>\n\
            <td class='my_select my_select_2'>\n\
            <select name='color' id='empty-column"+id+"'  class='form-control my_select_dropdown_color_size'>\n\
            <option ></option></select></td>\n\
            <td id='price_prod_empty-column"+id+"'>\n\
            </td>\n\
            <td>\n\
            </td>\n\
            <td>\n\
            </td>\n\
            <td  id='price_total_empty-column"+id+"'></td><td class='my_textarea'><textarea rows='6' cols='15' placeholder=''></textarea></td><td class='my_delete'>\n\
            <a href='#' class='row-remove'>X</a></td></tr>");
            myselectDr2();
            myselect();
     }

    $('.comment').on('change',function(){
        var data = {
              id : $(this).attr('id'),
              comment : $(this).val(),
              _token  : '{{csrf_token()}}'
            }
        $.ajax({
          url: "{{ URL::to('/'.App::getLocale().'/updateComment') }}",
          type:"post",
          data: data,
        })
    });

    // $( ".checkme" ).change(function() {
    //     console.log(12);
    // });
</script>



@endsection