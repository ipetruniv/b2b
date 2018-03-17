@foreach($products as $product)
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
@endforeach