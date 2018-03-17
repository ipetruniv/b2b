@extends('layouts.main')

@section('title')
  @if($catalogs) {{ $catalogs->name }} @endif
@endsection


@section('locale')
    @parent
@endsection



@section('select-menu-title')@section('menu-catalog')
    @widget('Catalog')
@endsection
      @if($catalogs) 
          {{ $catalogs->name }}
      @endif 
      
      @if($children) -> {{ $children->name }} @endif
@endsection
 
 
 
@section('menu-user')
    @parent
@endsection

@section('content')
    <div class="container container_center">
        <div class="row row_center">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 col_center">
                @if(count($users) > 1)
                <select form='order_form' name='buyer'  id="user-buyer"  style="visibility:hidden;" class='buyerPrice my_select_dropdown user-buyer'>
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
                <div class="group clearfix">
                    <h1 class="title">
                        @if($children)  {{ $children->name }} @endif
                    </h1>
                    <div class="catalog">
                        @forelse($products as $product)
                            <div class="item col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                <div class="group">
                                  <img style="backup_picture" src="{{$product->getProductPhoto()}}"
                                  onerror="this.onerror=null;this.src='http://dev.monicaloretti.softwest.cf/monika/images/pr.jpg';"
                                  alt="{{ $product->name }}">
                                    <div class="dark">
                                        <div class="group">
                                            <h2 class="title_catalog">{{ $product->name }}</h2>
                                            @if($product->new_price != $product->price_value)
                                                <div class="old_price">{{ $product->price_value }}</div>
                                                <div class="new_price">{{ $product->new_price }}
                                            @else
                                                <div class="new_price">{{ $product->price_value }}
                                            @endif
                                             @if($typePrice) {{ $typePrice->name }} @endif
                                                </div>
                                            <a href="{{URL::to(App::getLocale().'/catalog/'.$catalogs->url.'/product/'.$product->id) }}" class="my_button">@lang('messages.LEARN_MORE')</a>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        @empty
                        <div class="item">
                            <div class="group">
                                @lang('messages.PR_NOT_FOUND')
                            </div>
                        </div>
                        @endforelse
                    </div>
                    <div class="catalog">
                        <div id="post-data">

                        </div>
                    </div>
                   
                </div>
            </div>
        </div>

    </div>
    <div class="ajax-load text-center" style="display:none">
        <p><img src="http://demo.itsolutionstuff.com/plugin/loader.gif">Loading More</p>
    </div>


@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="/monika/js/imagesloaded.pkgd.min.js"></script>
    <script src="/monika/js/masonry.pkgd.js"></script>
    <script src="/monika/js/jquery.formstyler.js"></script>


    <style type="text/css">
        .ajax-load{
            background: #e1e1e1;
            padding: 10px 0;
            width: 100%;
        }
    </style>

    <script type="text/javascript">
        var page = 0;
        $(window).scroll(function() {
            if($(window).scrollTop() + $(window).height() + 60 >= $(document).height()) {
                page+= 10;
                loadMoreData(page);
            }
        });

        function loadMoreData(page){
            $_token = "{{ csrf_token() }}";
            $.ajax(
                {
                    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                    url: '{{ url::to(App::getLocale()."/catalog")."/".$catalogs->url }}/load-more-product/'+page+"@if($children)  {{ $children->url }} @endif",
                    data: { '_token': $_token }, //see the $_token
                    datatype: 'html',
                    type: "POST",
                    beforeSend: function()
                    {
                        $('.ajax-load').show();
                    }
                })
                .done(function(result)
                {
                    console.log(page);
                    if(result.html == ""){
                        $('.ajax-load').css("padding", '0');
                        $('.ajax-load').html("");
                        return;
                    }
                    $("#post-data .item").css("position","relative !important");
                    $('.ajax-load').hide();
                    $("#post-data").append(result.html);
                })
                .fail(function(jqXHR, ajaxOptions, thrownError)
                {
                    alert('server not responding...');
                });
        }
    </script>

    <script>
        $(document).ready(function(){
            var $grid = $('.catalog').imagesLoaded( function() {
                $('.catalog').removeClass("hidden");
                $grid.masonry({
                    itemSelector: '.item',
                    columnWidth: '.item',
                    transitionDuration: '0.8s',
                    resize: true,
                    percentPosition: true,
                    initLayout: true
                });
            });
        });

    </script>

@endsection
