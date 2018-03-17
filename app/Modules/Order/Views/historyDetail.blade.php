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
                    <h1 class="title"> @if( $cart->order_number_1c) Order№{{ $cart->order_number_1c }} @endif</h1>
                    <div class="orders" >
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="group_input clearfix">
                                <div id="order_up">
                                    @if($cart->agent_id)
                                        <div class="group" id="agent-style">
                                            <label for="text_a">@lang('messages.AGENT'):</label>
                                            <input type="hidden" id="agent" value="{{ $cart->getAgent->user_code_1c }}">
                                            <p class="agent-name"> {{ $cart->getAgent->name }}</p>
                                        </div> 
                                    @endif
                                    <div class="group" id="bauyers">
                                        <label for="text_b">@lang('messages.BUYER'):</label>
                                         <input type="hidden" id="user-buyer" value="{{ $cart->getByersOrder->user_code_1c }}">
                                        <p class="type-price"> {{ $cart->getByersOrder->name }}</p>
                                   </div> 
                                   
                                    <div class="group" id="payment">
                                        <label for="text_2">@lang('messages.CURRENCY_TYPE'):</label>
                                        <p class="type-price"> {{ $cart->getTypeUserPrice->getTypePrice->name  }}</p>
                                   </div>
                                    <div class="group" id="type_payment">
                                        <label for='payment'>@lang('messages.PAYMENT_TYPE'): </label>
                                        @if ($method_price)
                                            <p class="type-price">{{$method_price->value}}</p>
                                        @endif
                                    </div>
                                    <div class="group" id="payment">
                                        <label for="text_2">@lang('messages.STATUS'):</label>
                                        <p class="type-price"> {{ $cart->getStatus()  }}</p>
                                   </div>
                                
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="table-responsive">
                              
                               
                                <table id="tab" class="table my_table" cellpadding="0" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <td><i class="fa fa-camera" aria-hidden="true"></i></td>
                                            <td>@lang('messages.NAME')</td>
                                            <td>@lang('messages.COLOR')</td>
                                            <td>@lang('messages.SIZE')</td>
                                            <td>@lang('messages.PRICE')</td>
                                            <td>@lang('messages.SALE')</td>
                                            <td>@lang('messages.TAX')</td>
                                            <td>@lang('messages.BAR_CODE')</td>
                                            <td>@lang('messages.INVOICE')</td>
                                            <td>@lang('messages.TOTAL')</td>
                                            <td>
                                                <div class="tooltip">
                                                    @lang('messages.COMMENT')
                                                    <i class="fa fa-info-circle" aria-hidden="true"></i>
                                                    <span class="tooltiptext">
                                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                        Nunc gravida ultrices massa non ultricies. Nunc ut varius ex,
                                                        ac aliquet elit.
                                                    </span>
                                                </div>
                                            </td>
                                            @if(!$cart->OrderNotEdit())
                                                <td></td>
                                            @endif
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
                                                    <select @if($cart->OrderNotEdit()) disabled="disabled" @endif form="order_form"  name="collection" id="name__prod_{{$row->id}}" class="form-control my_select_dropdown name__prod {{$row->id}}">
                                                         <option value="{{ $row->product_1c }}">{{ $row->product_name }}</option>
                                                    </select>
                                                </td>
                                                <td class="my_select my_select_2 my_color">
                                                    <select @if($cart->OrderNotEdit()) disabled="disabled" @endif form="order_form"  id="color_{{$row->id}}" class="form-control my_select_dropdown_2 color__prod">
                                                        <option>{{ $row->color }}</option>
                                                    </select>
                                                </td>
                                                <td class="my_select my_select_2">
                                                    <select @if($cart->OrderNotEdit()) disabled="disabled" @endif form="order_form"   id="size_{{$row->id}}"  class="form-control my_select_dropdown_color_size">
                                                      <option  value="{{ $row->id_1c_size }}">
                                                           @if($row->size=='db25be32-09ba-11e7-bff6-00215a4648ba')
                                                          Individual size
                                                          @else
                                                           {{ $row->size }}
                                                           @endif
                                                        </option> 
                                                    </select>
                                                </td>
                                                <td id="price_prod_{{$row->id}}"> {{ $row->price }}</td>
                                                <td>0</td>
                                                <td>0</td>
                                                <td>{{$row->consignment}}</td><!--Bar code-->
                                                <td></td><!--Invoice-->
                                                <td  id="price_total_{{$row->id}}">{{ $row->price }}</td>
                                                <td class="my_textarea">
                                                  
                                                <textarea rows="6" cols="15" class="comment" id="{{$row->id}}" placeholder="">
                                                    {{$row->comment}}
                                                </textarea>
                                                  
                                                  
                                                  
                                                </td>
                                                @if(!$cart->OrderNotEdit())
                                                    <td class="my_delete">
                                                        <a href="#" class="row-remove">X</a>
                                                    </td>
                                                @endif
                                            </tr>    
                                        @empty
                                        
                                        @endforelse

                                        @if(!$cart->OrderNotEdit())
                                            <tr data-id="empty-column" onclick="">
                                                <td><i class="fa fa-eye" aria-hidden="true"></i></td>
                                                <td class="my_select name_select_prod">
                                                    <select name="collection" id="name__prod_empty-column" class="form-control my_select_dropdown name__prod empty-column">

                                                    </select>
                                                </td>
                                                <td class="my_select my_select_2 my_color">
                                                    <select name="color" id="color_empty-column" class="form-control my_select_dropdown_2 color__prod">

                                                    </select>
                                                </td>
                                                <td class="my_select my_select_2">
                                                    <select name="color" id="size_empty-column"  class="form-control my_select_dropdown_color_size">
                                                        <option >

                                                        </option>
                                                    </select>
                                                </td>
                                                <td id="price_prod_empty-column"></td>
                                                <td></td>
                                                <td></td>
                                                <td  id="price_total_empty-column"></td>
                                                <td class="my_textarea">
                                                    <textarea rows="6" cols="15" id="coment_empty" placeholder="">

                                                    </textarea>
                                                </td>
                                                <td class="my_delete">
    <!--                                                    <a href="#" class="row-remove">X</a>-->
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>

                                <table id="sum_tab" class="table my_table" cellpadding="0" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <td>@lang('messages.SALE')</td>
                                            <td>@lang('messages.TAX')</td>
                                            <td>@lang('messages.TOTAL')</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>{{$totalSum}}</td>
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
                                            @if($cart->OrderNotEdit())
                                                <input readonly="readonly" name="date" value="{{date('d.m.y', strtotime($cart->desirable_delivery)) }}" style="width: 320px; border: 1px solid #4b4b4b; font-size: 14px; padding: 7px;"/>
                                            @else
                                                <input name="date" value="{{date('d.m.y', strtotime($cart->desirable_delivery)) }}" id="my_datepicker"/>
                                            @endif
                                        </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="group clearfix">
                                <div class="my_tabs my_tabs_order">
                                    <!-- Навигация -->
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">@lang('messages.COMMENT')</a></li>
                                        <li><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">@lang('messages.ASK_MANAGER')</a></li>
                                    </ul>
                                    <!-- Содержимое вкладок -->
                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane active" id="home">
                                            <textarea rows="6" cols="175" placeholder="">

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

                        @include('order.deliveryHistory',['user'=>$cart->getByersOrder])
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection


@section('js')
    @parent
    <script>
        $(document).ready(function() {
            $(".fancybox-button").fancybox({
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
          
        if($('#agent').val()==0) {
            Lobibox.notify('info', {
                size: 'normal',
                position: 'right bottom',
                msg: "Select agent"
            }); 
        }
        else if($('#user-buyer').val()==0) {
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
       
        if($('#user-buyer').val() == 0) {
          $('#payment').empty();
        } else {
            var data = {
              user : $('#user-buyer').val(),
              agent : $('#agent').val(),
              _token  : '{{csrf_token()}}'
            }

            getPaimentType(data);
        }
      }
      
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
              $('#payment').empty();
              var html = " <label for='text_2'>Type of payment</label><p class='type-price'>"+response.ok.name+"</p>";
              $('#payment').append(html);
                $('#type_payment').empty();
                var html2 = " <label for='text_2'>Type of payment</label><p class='type-price'>"+response.method_payment.value+"</p>";
                $('#type_payment').append(html2);
              $('#country').val(response.ok.country);
              $('#company').val(response.ok.company);
              $('#region').val(response.ok.region);
              $('#city').val(response.ok.city);
              $('#street').val(response.ok.street);
              $('#build').val(response.ok.build);
              $('#post').val(response.ok.post_code);
              $('#phone').val(response.ok.phone);
              $('#email').val(response.ok.email);
            }
            
          
            if(response.agent) {
             
              $('#agent').val(response.agent.user_code_1c).trigger('change');
            }
            if(response.agent == null) {
               Lobibox.notify('error', {
                            size: 'normal',
                            position: 'right bottom',
                            msg: 'No agent found for this user'
                        }); 
            }
            
            
           

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
              var options = '<option value="0">-Select User-</option>'; 
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
                options_size += '<option  value="' + row.code_1c + '">' + row.value + '</option>';
              });
              
              $('#size_'+id).append(options_size);  
            }
            
            if(response.colors) {
              $('#color_'+id).empty();
              var price = '';
              var ProdSelect = $('#color_'+id);
              var options = '<option value="0">-Select Color-</option>'; 
              console.log(response.colors);
              $(response.colors).each(function(i, row){
                options += '<option  value="' + row.code_1c + '">' + row.value + '</option>';
              });

              ProdSelect.append(options);

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
        FindProdByCoror(param,id);
     
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
                options_size += '<option  value="' + row.code_1c_characteristic_size_value + '">' + row.name_characteristic_size_value + '</option>';
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
          order_id : {{$cart->id}},
          _token  : '{{csrf_token()}}'     
        }
 
        getPriceBySize(param,id);
     
      });
      
      

      function getPriceBySize(param,id) {
     
         $.ajax({
          url: "{{ URL::to('/'.App::getLocale().'/get-product-price') }}",
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
              console.log('***xxxx*************');
              console.log(response.ok);
              console.log('*****xxx***********');
              $('#price_prod_'+id).empty();
              $('#price_total_'+id).empty();
              $('#price_prod_'+id).append(response.ok.price_value);
              $('#price_total_'+id).append(response.ok.price_value);
              return location.reload();
            }

        })  
      }

      $( ".group_check input" ).checkboxradio();



      function comment(id) {
     
        var comment = this;
        console.log('commeeeee');
       console.log(comment);
        console.log('commeeeee');
      }




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
                $.extend($.datepicker.regional["ru"])
        );
        $("#my_datepicker").datepicker({
//            format: 'YYYY-MM-DD',
//            pickTime: false,
            showButtonPanel: false,
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
   
     
</script>


@endsection