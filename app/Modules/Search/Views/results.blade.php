@extends('layouts.main')

@section('title')
    Результати пошуку
@endsection

@section('style')
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
                    <h1 class="title">
                   
                        
                    </h1>
                    <div class="catalog hidden" >
                      
                      
                        @forelse($products as $product)
                            <div class="item">
                                <div class="group"> 
                                  <img style="backup_picture" src="/images/products/{{$product->code_1c}}/{{$product->code_1c.'_0.jpg'}}" 
                                  onerror="this.onerror=null;this.src='http://dev.monicaloretti.softwest.cf/monika/images/pr.jpg';" 
                                  alt="{{ $product->name }}"> 
                                    <div class="dark">  
                                        <div class="group">
                                            <h2 class="title_catalog">{{ $product->name }}</h2>
                                            <div class="old_price"></div>
                                            <div class="new_price">{{ $product->getCatProductPrice->price_value }}
                                           
                                              @if($typePrice) {{ $typePrice->name }} @endif</div>
                                          
                                          
                                                <a href="{{URL::to(App::getLocale().'/catalog/'.$product->getCatItemGroup->url.'/product/'.$product->id) }}" class="my_button">Learn more</a>
                                            
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
                   
                </div>
            </div>
        </div>
    </div>

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
