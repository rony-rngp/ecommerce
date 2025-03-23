<div class="row gutter-lg">
    <div class="col-md-6 mb-4 mb-md-0">
        <div class="product-gallery product-gallery-sticky">
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
            </div>
            <div class="product-thumbs-wrap swiper-container" data-swiper-options="{
                        'navigation': {
                            'nextEl': '.swiper-button-next',
                            'prevEl': '.swiper-button-prev'
                        }
                    }">
                <div class="product-thumbs swiper-wrapper row cols-4 gutter-sm">
                    @if($product->product_galleries != null && count($product->product_galleries) > 0)
                        @foreach($product->product_galleries ?? [] as $gellery)
                            <div class="product-thumb swiper-slide">
                                <img src="{{ check_image($gellery->image) ? asset('storage/'.$gellery->image) : '' }}"
                                     alt="Product Thumb" width="103" height="116">
                            </div>
                        @endforeach
                    @else
                        <div class="product-thumb swiper-slide">
                            <img src="{{ check_image($product->image) ? asset('storage/'.$product->image) : '' }}"
                                 alt="Product Thumb" width="103" height="116">
                        </div>
                    @endif
                </div>
                <button class="swiper-button-next"></button>
                <button class="swiper-button-prev"></button>
            </div>
        </div>
    </div>
    <div class="col-md-6 overflow-hidden p-relative">
        <div class="product-details scrollable pl-0">
            <h2 class="product-title">{{ $product->name }}</h2>
            <div class="product-bm-wrapper">
                <figure class="brand">
                    <img src="{{ check_image(@$product->brand->image) ? asset('storage/'. @$product->brand->image) : asset('frontend/assets/images/products/brand/brand-1.jpg') }}" alt="Brand" width="102" height="48" />
                </figure>
                <div class="product-meta">
                    <div class="product-categories">
                        Category:
                        <span class="product-category">
                            <a href="#">{{ @$product->category->name ?? 'N/A' }} @if($product->subcategory != null) > {{$product->subcategory->name}}@endif</a>
                        </span>
                    </div>
                    <div class="product-sku">
                        SKU: <span>{{ $product->sku }}</span>
                    </div>
                </div>
            </div>

            <hr class="product-divider">

            <div class="product-price">
                @if($product->discount > 0)
                    <ins id="new_price" class="new-price">{{ base_currency().round($product->price - (($product->discount/100)*$product->price )) }}</ins>
                    <del id="old_price" class="old-price">{{ base_currency().$product->price }}</del>
                @else
                    <ins id="new_price" class="new-price">{{ base_currency().$product->price }}</ins>
                @endif
            </div>

            <div class="ratings-container">
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

            @if(count($product->product_colors) == 0 && count($product->attributes) == 0)
            <div class="product-short-desc">
                {!! nl2br($product->short_description) !!}
            </div>
            @endif

            <hr class="product-divider">

            <form id="cartForm" action="{{ route('add_to_card', $product->id) }}" method="post">
                @csrf
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

                <div class="fix-bottom product-sticky-content sticky-content">
                    <div class="product-form container">
                        <div class="product-qty-form">
                            <div class="input-group">
                                <input class="quantity form-control" required name="quantity" type="number" min="1"
                                       max="100">
                                <button type="button" class="quantity-plus w-icon-plus"></button>
                                <button type="button" class="quantity-minus w-icon-minus"></button>
                            </div>
                        </div>
                        <button class="btn btn-primary btn-cart">
                            <i class="w-icon-cart"></i>
                            <span>Add to Cart</span>
                        </button>
                    </div>
                </div>

            </form>

            <div class="social-links-wrapper">
                <div class="social-links">
                    <div class="social-icons social-no-color border-thin">
                        <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" class="social-icon social-facebook w-icon-facebook"></a>
                        <a target="_blank" href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode('Check this out!') }}" class="social-icon social-twitter w-icon-twitter"></a>
                        <a target="_blank" href="https://www.pinterest.com/pin/create/button/?url={{ urlencode(url()->current()) }}&media={{ urlencode(asset('storage/'.$product->image)) }}&description={{ urlencode('Check this out!') }}"
                           class="social-icon social-pinterest fab fa-pinterest-p"></a>
                        <a target="_blank" href="https://api.whatsapp.com/send?text={{ urlencode('Check this out! ') . urlencode(url()->current()) }}" class="social-icon social-whatsapp fab fa-whatsapp"></a>
                        <a target="_blank" href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(url()->current()) }}"
                           class="social-icon social-youtube fab fa-linkedin-in"></a>
                    </div>
                </div>
                <span class="divider d-xs-show"></span>
                <div class="product-link-wrapper d-flex">
                    <a href="javascript:void(0)" onclick="addWishlist('{{ $product->id }}')" class="btn-product-icon {{ $product->check_wish ? 'w-icon-heart-full' : 'w-icon-heart' }}  wish_{{ $product->id }}"
                       title="Add to wishlist"></a>
                </div>
            </div>
        </div>
    </div>
</div>



<script>

    var has_attribute = "{{ $product->has_attribute == 1 ? true : false }}";
    var attribute_title = "{{ $product->attribute_title }}";
    var has_color = "{{ count($product->product_colors) > 0 ? true : false }}";

    $('#cartForm').submit(function(event) {
        if(has_color == 1){
            var color = $("#color_name").val();
            if(color == ''){
                iziToast.error({
                    title: 'Error',
                    message: 'Please select a color',
                    position: "topRight",
                });
                return false;
            }
        }
        if(has_attribute == 1){
            var attr = $("#attribute").val();
            if(attr == ''){
                iziToast.error({
                    title: 'Error',
                    message: 'Please select a '+attribute_title,
                    position: "topRight",
                });
                return false;
            }
        }
        return true;
    });

    function setColor(color_name) {
        $(".set_color").removeClass('active');
        $("#active_color_"+color_name).addClass('active');
        $("#color_name").val(color_name);
    }


    var product_discount = parseInt('{{ $product->discount }}');
    var base_currency = '{{base_currency()}}';

    function setAttr(attr_id, attr_name, attr_price, stock) {

        {{--if(stock < 1){--}}
            {{--    alert('Sorry, This {{ $product->attribute_title }} out of stock');--}}
            {{--    return false;--}}
            {{--}--}}
        if(stock > 0){
            $(".showStock").html(stock);
        }else{
            $(".showStock").html('Out Of Stock');
        }


        $(".set_attr").removeClass('active');
        $("#active_attr_"+attr_id).addClass('active');
        $("#attribute").val(attr_name);

        var attr_price_float = parseFloat(attr_price);
        if(product_discount > 0){
            var new_price = attr_price_float - ((product_discount/100)*attr_price_float) ;
            new_price = Math.round(new_price);
            $("#new_price").text(base_currency+new_price);
            $("#old_price").text(base_currency+attr_price);
        }else{
            $("#new_price").text(base_currency+attr_price);
        }
    }
</script>
