<div class="row deals-wrapper appear-animate mb-8">
    <div class="col-lg-9 mb-4">
        <div class="single-product h-100 br-sm">
            <h4 class="title-sm title-underline font-weight-bolder ls-normal">
                Deals Hot of The Day
            </h4>
            <div class="swiper">
                <div class="swiper-container swiper-theme nav-top swiper-nav-lg" data-swiper-options="{
                                        'spaceBetween': 20,
                                        'slidesPerView': 1
                                    }">
                    <div class="swiper-wrapper row cols-1 gutter-no">
                        @foreach($hot_deals as $product)
                        <div class="swiper-slide">
                            <div class="product product-single row">
                                <div class="col-md-6">
                                    <div class="product-gallery product-gallery-sticky product-gallery-vertical">
                                        <div class="swiper-container product-single-swiper swiper-theme nav-inner">
                                            <div class="swiper-wrapper row cols-1 gutter-no">
                                                @if($product->product_galleries != null && count($product->product_galleries) > 0)
                                                    @foreach($product->product_galleries ?? [] as $gellery)
                                                        <div class="swiper-slide">
                                                            <figure class="product-image">
                                                                <img src="{{ check_image($gellery->image) ? asset('storage/'.$gellery->image) : '' }}"
                                                                     data-zoom-image="{{ check_image($gellery->image) ? asset('storage/'.$gellery->image) : '' }}"
                                                                     alt="{{ $product->name }}" width="800" height="900">
                                                            </figure>
                                                        </div>
                                                    @endforeach
                                                @else

                                                    <div class="swiper-slide">
                                                        <figure class="product-image">
                                                            <img src="{{ check_image($product->image) ? asset('storage/'.$product->image) : '' }}"
                                                                 data-zoom-image="{{ check_image($product->image) ? asset('storage/'.$product->image) : '' }}"
                                                                 alt="{{ $product->name }}" width="800" height="900">
                                                        </figure>
                                                    </div>
                                                @endif

                                            </div>
                                            <button class="swiper-button-next"></button>
                                            <button class="swiper-button-prev"></button>
                                            @if($product->discount > 0)
                                                <div class="product-label-group">
                                                    <label class="product-label label-discount">{{ $product->discount }}% Off</label>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="product-thumbs-wrap swiper-container"
                                             data-swiper-options="{
                                                                'direction': 'vertical',
                                                                'breakpoints': {
                                                                    '0': {
                                                                        'direction': 'horizontal',
                                                                        'slidesPerView': 4
                                                                    },
                                                                    '992': {
                                                                        'direction': 'vertical',
                                                                        'slidesPerView': 'auto'
                                                                    }
                                                                }
                                                            }">
                                            <div class="product-thumbs swiper-wrapper row cols-lg-1 cols-4 gutter-sm">
                                                @if($product->product_galleries != null && count($product->product_galleries) > 0)
                                                    @foreach($product->product_galleries ?? [] as $gellery)
                                                        <div class="product-thumb swiper-slide">
                                                            <img src="{{ check_image($gellery->image) ? asset('storage/'.$gellery->image) : '' }}"
                                                                 alt="Product thumb" width="60" height="68" />
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <div class="product-thumb swiper-slide">
                                                        <img src="{{ check_image($product->image) ? asset('storage/'.$product->image) : '' }}"
                                                             alt="Product thumb" width="60" height="68" />
                                                    </div>
                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="product-details scrollable">
                                        <h2 class="product-title " style="font-size: 17px"><a
                                                href="{{ route('product_details', $product->slug) }}">{{ \Illuminate\Support\Str::limit($product->name, 70) }}</a></h2>

                                        <hr class="product-divider" style="margin: 4px">

                                        <div class="product-price">
                                            @if($product->discount > 0)
                                                <ins id="new_price" class="new-price ls-50" style="font-size: 20px">{{ base_currency().round($product->price - (($product->discount/100)*$product->price )) }}</ins>
                                                <del id="old_price" class="old-price ls-50" style="font-size: 20px">{{ base_currency().$product->price }}</del>
                                            @else
                                                <ins id="new_price" class="new-price ls-50" style="font-size: 21px">{{ base_currency().$product->price }}</ins>
                                            @endif
                                        </div>

                                        <div class="product-countdown-container flex-wrap">
                                            <label class="mr-2 text-default">Offer Ends In:</label>
                                            <div class="product-countdown countdown-compact"
                                                 data-until="{{ date('Y, m, d', strtotime(\Carbon\Carbon::now()->addDay(1))) }}" data-compact="true">
                                                629 days, 11: 59: 52</div>
                                        </div>

                                        <div class="ratings-container mb-2">
                                            <div class="ratings-full">
                                                <span class="ratings" style="width: {{ getAvg($product['rating'][0]['average'] ?? 0) }}%;"></span>
                                                <span class="tooltiptext tooltip-top"></span>
                                            </div>
                                            <a href="#" class="rating-reviews">({{ $product->rating[0]['rating_count'] ?? 0 }} Reviews)</a>
                                        </div>

                                        <div style="font-weight: bold; font-size: 14px" class="bold mb-2">
                                            STOCK : <span class="showStock">
                                            @if($product->has_attribute == 1)
                                                    {{  @$product->attributes->sum('stock') > 0 ?  @$product->attributes->sum('stock') : 'Out Of Stock' }}
                                                @else
                                                    {{ $product->stock > 0 ? $product->stock : 'Out Of Stock' }}
                                                @endif
                                            </span>
                                        </div>
                                        @if(count($product->attributes) == 0 || count($product->product_colors) == 0)
                                            <?php
                                            if( count($product->attributes) == 0 && count($product->product_colors) == 0){
                                                $height = 120;
                                            }else{
                                                $height = 60;
                                            }
                                            ?>
                                            <div class="product-short-desc" style="max-height: {{ $height }}px; text-overflow: ellipsis; overflow: hidden">
                                                {!! nl2br($product->short_description) !!}
                                            </div>
                                        @endif

                                        @if(count($product->product_colors) > 0)
                                            <div class="product-form product-variation-form product-color-swatch">
                                                <label>Color:</label>
                                                <div class="d-flex align-items-center product-variations">
                                                    @foreach($product->product_colors as $product_color)
                                                        <span id="active_color_{{ $product_color->color_name }}" onclick="setColor('{{ $product_color->color_name }}')" class="color set_color" title="{{ $product_color->color_name }}" style="cursor: pointer; background-color: {{ $product_color->color_code }}; border: 1px solid"></span>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <span class="d-block" style="color: red">{{ $errors->has('color_name') ? $errors->first('color_name') : '' }}</span>

                                            <input type="hidden" name="color_name" id="color_name">
                                        @endif

                                        @if($product->has_attribute == 1 && count($product->attributes) > 0)
                                            <div class="product-form product-variation-form product-size-swatch">
                                                <label class="mb-1">{{ $product->attribute_title }}:</label>
                                                <div class="flex-wrap d-flex align-items-center product-variations">
                                                    @foreach($product->attributes ?? [] as $product_attribute)
                                                        <a style="cursor: pointer" id="active_attr_{{ $product_attribute->id }}" onclick="setAttr('{{ $product_attribute->id }}', '{{ $product_attribute->attribute }}', '{{ $product_attribute->price }}', '{{ $product_attribute->stock }}')" class="size set_attr">{{ $product_attribute->attribute }}</a>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <span class="d-block" style="color: red">{{ $errors->has('attribute') ? $errors->first('attribute') : '' }}</span>
                                            <input type="hidden" name="attribute" id="attribute">
                                        @endif

                                        <div class="product-form pt-4">
                                            <a href="{{ route('product_details', $product->slug) }}" class="btn btn-primary btn-cart">
                                                <i class="w-icon-eye"></i>
                                                <span>View Details</span>
                                            </a>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <button class="swiper-button-prev"></button>
                    <button class="swiper-button-next"></button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 mb-4">
        <div class="widget widget-products widget-products-bordered h-100">
            <div class="widget-body br-sm h-100">
                <h4 class="title-sm title-underline font-weight-bolder ls-normal mb-2">Top {{ count($best_sells) }} Best
                    Seller</h4>
                <div class="swiper">
                    <div class="swiper-container swiper-theme nav-top" data-swiper-options="{
                                            'slidesPerView': 1,
                                            'spaceBetween': 20,
                                            'breakpoints': {
                                                '576': {
                                                    'slidesPerView': 2
                                                },
                                                '768': {
                                                    'slidesPerView': 3
                                                },
                                                '992': {
                                                    'slidesPerView': 1
                                                }
                                            }
                                        }">
                        <div class="swiper-wrapper row cols-lg-1 cols-md-3">
                            @php($best_sells_chunk = $best_sells->chunk(3))
                            @foreach($best_sells_chunk as $best_sell)
                            <div class="swiper-slide product-widget-wrap">
                                @foreach($best_sell as $product)
                                <div class="product product-widget bb-no">
                                    <figure class="product-media">
                                        <a href="{{ route('product_details', $product->slug) }}">
                                            <img src="{{ check_image($product->image) ? asset('storage/'.$product->image) : '' }}"
                                                 alt="Product" width="105" height="118" />
                                        </a>
                                    </figure>
                                    <div class="product-details">
                                        <h4 class="product-name">
                                            <a href="{{ route('product_details', $product->slug) }}">{{ $product->name }}</a>
                                        </h4>
                                        <div class="ratings-container">
                                            <div class="ratings-full">
                                                <span class="ratings" style="width: {{ getAvg($product['rating'][0]['average'] ?? 0) }}%;"></span>
                                                <span class="tooltiptext tooltip-top"></span>
                                            </div>
                                        </div>
                                        <div class="product-price">
                                            <ins class="new-price">$150.60</ins>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @endforeach
                        </div>
                        <button class="swiper-button-next"></button>
                        <button class="swiper-button-prev"></button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
