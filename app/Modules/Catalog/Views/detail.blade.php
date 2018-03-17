@extends('layouts.main')

@section('title')
    @if($product) {{ $product->name }} @endif
@endsection

 @section('style')

    <script src="/monika/js/jquery.min.js"></script>
    <script src="/monika/js/owl.carousel.js"></script>
    <script src="/monika/js/jquery.fancybox.js"></script>
    <script src="/monika/js/jquery.fancybox.pack.js"></script>
    <script src="/monika/js/jquery.fancybox-buttons.js"></script>
    <script src="/monika/js/jquery.formstyler.js"></script>
    <script src="/monika/js/imagesloaded.pkgd.min.js"></script>
    <script src="/monika/js/masonry.pkgd.js"></script>


    <link href="/monika/css/owl.carousel.css" rel="stylesheet">
    <link href="/monika/css/owl.theme.default.css" rel="stylesheet">
    <link href="/monika/css/jquery.fancybox.css" rel="stylesheet">
    <link href="/monika/css/jquery.fancybox-buttons.css" rel="stylesheet">
    <link href="/monika/css/jquery.formstyler.css" rel="stylesheet">


 @endsection

@section('locale')
    @parent
@endsection

@section('select-menu-title')
    @section('menu-catalog')
        @widget('Catalog')
    @endsection

    @if($catalogs)
        {{ $catalogs->name }}
    @endif
@endsection

@section('menu-user')
    @parent
@endsection

@section('content')
    <div class="container container_center">
        <div class="row row_center">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 col_center">
              @if(count($users) > 1)
                <select form='order_form' name='buyer' id="user-buyer" style="visibility:hidden;" class='buyerPrice my_select_dropdown user-buyer'>
                    @forelse($users as $user)
                        @if($user->type_price)
                            <option value="{{ $user->user_code_1c }}" @if($user->user_code_1c == $buyer->user_code_1c) selected @endif>
                                {{ $user->name }}
                            </option>
                        @endif
                    @empty
                        @lang('messages.EMPTY')
                    @endforelse
                </select>
                @endif
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 col_center">
                <div id="slider">
                    <div class="slide-cont">
                        <div class="owl-carousel">
                            @if($photo_1)
                                <div>
                                    <a class="fancybox-button" rel="fancybox-button" href="/images/products/{{$product->code_1c}}/{{$photo_1}}.jpg" title="{{ $product->name }}">
                                        <img src="/images/products/{{$product->code_1c}}/{{$photo_1}}.jpg"  >
                                    </a>
                                </div>
                            @endif
                            @if($photo_2)
                                <div>
                                    <a class="fancybox-button" rel="fancybox-button" href="/images/products/{{$product->code_1c}}/{{$photo_2}}.jpg" title="{{ $product->name }}">
                                        <img src="/images/products/{{$product->code_1c}}/{{$photo_2}}.jpg"  >
                                    </a>
                                </div>
                          @endif
                          @if($photo_3)
                              <div>
                                  <a class="fancybox-button" rel="fancybox-button" href="/images/products/{{$product->code_1c}}/{{$photo_3}}.jpg" title="{{ $product->name }}">
                                      <img src="/images/products/{{$product->code_1c}}/{{$photo_3}}.jpg"  >
                                  </a>
                              </div>
                          @endif
                        </div>
                    </div>
                </div>
                <div class="group_right">
                    <div class="group_model_info">
                        <div class="model-choose clearfix">
                            @if($preview)
                                <a class="prevw" href="{{ URL::to(App::getLocale().'/catalog/'.$parrent.'/product/'.$preview->id )}} ">
                                    <img src="/monika/images/catalog/arrow_left.png" alt="img">
                                    @lang('messages.PREV')
                                </a>
                            @endif

                            <h1 class="title">{{$product->name}}</h1>
                            @if($next)
                                <a class="nexts" href="{{ URL::to(App::getLocale().'/catalog/'.$parrent.'/product/'.$next->id )}}">
                                    @lang('messages.NEXT')
                                    <img src="/monika/images/catalog/arrow_right.png" alt="img">
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="table-responsive">
                    <input hidden="" id="product"  value="{{$product->code_1c}}" name="order">
                     <div class="info-ajax"></div> 
                        @php  $lic = 1;  @endphp
                        <div class="table_group_responsive">
                            @forelse($data as $key => $value )

                                <table  class="table_mass" cellpadding="0" cellspacing="0" width="100%" style="margin: auto;">
                                    <thead>
                                    <tr>
                                        <td colspan="4">
                                            {{$key}}
                                        </td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $count = count($value);?>
                                    @foreach($value as $i => $row)
                                    @if($count--  > 1)
                                        @if($value[$i]['storage_100'] !== NULL)
                                           @php $data = $value[$i]['storage_100']->id; @endphp
                                        @elseif($value[$i]['storage_50'] !== NULL)
                                            @php $data = $value[$i]['storage_50']->id; @endphp
                                        @elseif($value[$i]['storage_30'] !== NULL)
                                             @php $data = $value[$i]['storage_30']->id; @endphp

                                        @else
                                     @php $data = 'null' @endphp
                                    @endif
                                   @php $lic++; @endphp
                                        <tr>
                                            <td>
                                                <p class="size_pr">{{ $i }}</p>
                                            </td>
                                            <td>
                                                @if($i !== 'Ind')

                                                    <select   name="storages_{{$lic}}" class="storages">

                                                        @if($value[$i]['storage_100'] !== NULL)
                                                            <option value="{{ $value[$i]['storage_100']->code_1c_storage }}">{{ $value[$i]['storage_100']->name_storage }}</option>
                                                        @endif

                                                        @if($value[$i]['storage_50'] !== NULL)
                                                            <option value="{{ $value[$i]['storage_50']->code_1c_storage }}">  {{  $value[$i]['storage_50']->name_storage  }}</option>
                                                        @endif

                                                        @if($value[$i]['storage_30'] !== NULL)
                                                            <option value="{{ $value[$i]['storage_30']->code_1c_storage }}">  {{ $value[$i]['storage_30']->name_storage   }}</option>
                                                        @endif

                                                        @if($value[$i]['storage_100'] == NULL && $value[$i]['storage_50'] == NULL && $value[$i]['storage_30'] == NULL)
                                                            <option value="{{ $i }}">Order</option>
                                                        @endif
                                                    </select>
                                                @else
                                                @endif
                                            </td>
                                            <td>
                                                <table style="width:100%;margin: 0!important;float: none;">
                                                    <tr style="background: transparent;">
                                                         @if($i !== 'Ind' and $row['discount'])
                                                        <td class="old_price" style="padding: 0;">
                                                            <div>

                                                                    {{$row['old_price']}} {{  $typePrice->name}}

                                                            </div>
                                                        </td>
                                                        @endif
                                                        <td class="td_new_price" style="padding: 0;">
                                                            <div>
                                                                @if($i !== 'Ind')
                                                                    {{$row['price']}} {{  $typePrice->name}}
                                                                @endif
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td>
                                              @if($i !== 'Ind')
                                                  <a href="#" class="add_incart" data-size="{{ $i }}" data-old_price="{{$row['old_price']}}" data-new_price ="{{$row['price']}}" data-discount="{{$row['discount']}}" data-id-size="{{$value[$i]['size']}}" data-color="{{$key}}" data-id-color ="{{$value[$i]['color']}}" data-id="{{$lic}}" > @lang('messages.BUY')  </a>
                                              @endif
                                            </td>
                                        </tr>
                                    @endif
                                    @endforeach
                                    @php $lic++; @endphp
                                    </tbody>
                                    <tfoot class="individual">
                                        <tr style="background: transparent;">
                                            <td colspan="4">
                                                <button type="button" class="btn btn-info btn-lg" data-toggle="modal" onclick="getColorAndDiscount('{{$key}}','{{$row['discount']}}')" data-target="#myModal">@lang('messages.INDIVIDUAL')</button>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            @empty
                            @endforelse
                        </div>
                    @include('order.modal_custom_size', ['photo_1'=>$photo_1, 'photo_2'=>$photo_2,'photo_3'=>$photo_3, 'product'=>$product])
                    </div>
                </div>
                <input type="hidden" value="color" class="my_color">
                <input type="hidden" value="discount" class="my_discount">
            </div>
        </div>
    </div>


@endsection


@section('js')
    @parent
    <script>
      
      
       function addToCart(id, color, color_id, size, size_id, discount, old_price, new_price) 
       {
            var  storage  = $('select[name="storages_'+id+'"] option:selected').val(); // id складу
            var  product  = $('#product').val();

            var data = {
              product: product,
              size : size,
              id : id,  
              color:color,
              color_id :color_id,
              size_id :size_id,
              discount :discount,
              old_price :old_price,
              new_price :new_price,              
              storage:storage
            }
            
            var token  = $('meta[name=csrf-token]').attr('content');
            $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': token }}); 
           
            $.ajax({
              url :"{{ URL::to('/'.App::getLocale().'/product/add-pr') }}",
              type: 'post',
              data: data,
              
            }).done(function(response) {
                 if(response.debag) {
                     console.log(response.debag)
                 }
                if(response.error) {
                    $('.info-ajax').empty();
                   let err = "<div class='alert alert-danger alert-dismissible'>\n\
                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>\n\
                            <h4><i class='icon fa fa-ban'></i>"+response.error+"</h4>\n\
                        </div>";
                    return $('.info-ajax').append(err);
                } 
                if(response.count) {
                  console.log(response.count);
                
                  let item = "<a href='{{ URL::to('/'.(App::getLocale().'/cart')) }}'> <i class='fa fa-shopping-basket' aria-hidden='true'>\n\
                    </i><div class='basket_item'>\n\
                    <span class='bas_count'>"+response.count+"</span>\n\
                    </div></a>";
                  $('.info-ajax').empty();
                  $('#basket').empty().addClass('basket');
                  return   $('#basket').append(item);
                    //  location.reload();
                }
 
              })  
          
         
       }
       
       $(document).on( 'click', '.add_incart', function () {
        var id = $( this ).attr( 'data-id' );
        var color = $(this).attr('data-color');
        var color_id = $(this).attr('data-id-color'); 
        var size =  $(this).attr('data-size'); 
        var size_id = $(this).attr('data-id-size'); 
        var discount = $(this).attr('data-discount'); 
        var old_price = $(this).attr('data-old_price'); 
        var new_price = $(this).attr('data-new_price'); 
        
        console.log('***************************');
        console.log(size);
        console.log(size_id);
        console.log('***************************');
        //alert(color);
        addToCart(id, color, color_id, size, size_id, discount, old_price, new_price);
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
              discount: $(".my_discount").val(),
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
                
                  let item = "<a href='{{ URL::to('/'.(App::getLocale().'/cart')) }}'> <i class='fa fa-shopping-basket' aria-hidden='true'>\n\
                    </i><div class='basket_item'>\n\
                    <span class='bas_count'>"+response.count+"</span>\n\
                    </div></a>";
                  $('.info-ajax').empty();
                  $('#basket').empty();
                  $('#basket').addClass('basket');
//                  $('#myModal').hide();
                  location.reload();
                 return   $('#basket').append(item);
                   //  location.reload();
               }
 
            })
          
         
       }
         
      function getColorAndDiscount(color,discount){
          $(".my_color").val(color);
          $(".my_discount").val(discount);
      }
        

    $(document).ready(function(){
        $(".owl-carousel").owlCarousel({

            items: 1,
            animateIn:true,
            lazyLoad:true,
            loop:true,
            autoplayTimeout:3000,
            autoplay:true


        });
    });


    // the following to the end is whats needed for the thumbnails.
    jQuery( document ).ready(function() {


        // 1) ASSIGN EACH 'DOT' A NUMBER
        dotcount = 1;

        jQuery('.owl-dot').each(function() {
            jQuery( this ).addClass( 'dotnumber' + dotcount);
            jQuery( this ).attr('data-info', dotcount);
            dotcount=dotcount+1;
        });

        // 2) ASSIGN EACH 'SLIDE' A NUMBER
        slidecount = 1;

        jQuery('.owl-item').not('.cloned').each(function() {
            jQuery( this ).addClass( 'slidenumber' + slidecount);
            slidecount=slidecount+1;
        });

        // SYNC THE SLIDE NUMBER IMG TO ITS DOT COUNTERPART (E.G SLIDE 1 IMG TO DOT 1 BACKGROUND-IMAGE)
        jQuery('.owl-dot').each(function() {

            grab = jQuery(this).data('info');

            slidegrab = jQuery('.slidenumber'+ grab +' img').attr('src');
            console.log(slidegrab);

            jQuery(this).css("background-image", "url("+slidegrab+")");

        });

        // THIS FINAL BIT CAN BE REMOVED AND OVERRIDEN WITH YOUR OWN CSS OR FUNCTION, I JUST HAVE IT
        // TO MAKE IT ALL NEAT
        amount = jQuery('.owl-dot').length;
        gotowidth = 100/amount;

        jQuery('.owl-dot').css("width", gotowidth+"%");
        newwidth = jQuery('.owl-dot').width();
        jQuery('.owl-dot').css("height", newwidth+"px");



    });
    $(document).ready(function() {
        $(".fancybox-button").fancybox({
            prevEffect		: 'none',
            nextEffect		: 'none',
            closeBtn		: false,
            helpers		: {
                title	: { type : 'inside' },
                buttons	: {}
            }
        });
    });
       (function($) {
           $(function() {
               $('.group_right .table-responsive table select').styler();
           });
       })(jQuery);

       $(document).ready(function() {
           if ($('body').width() < 768) {
               $('.group_right').after($('#slider'));
           }
           $(window).resize(function () {
               if ($('body').width() < 768) {
                   $('.group_right').after($('#slider'));
               } else {
                   $('#slider').after($('.group_right'));
               }
           });
       });
       jQuery(document).ready(function($) {
           var $grid = $('.table_group_responsive').imagesLoaded( function() {
               $grid.masonry({
                   itemSelector: '.table_mass',
                   columnWidth: '.table_mass',
                   transitionDuration: '0.8s',
                   resize: true,
//                   isFitWidth: true,
                   percentPosition: true,
                   initLayout: true
               });
           });
       });
</script>

@endsection