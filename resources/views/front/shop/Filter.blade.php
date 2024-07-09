<div class="sidebar">
    <input type="hidden" value="{{$searchQuery}}" id="search-q">
    <div class="widget accordion" id="accordion">
        <h5 class="widget_title">Categories</h5>
        <ul class="widget_categories">
            @forelse($categoreis as $key=>$category)

                <li class="accordion-item">
                    <div class="accordion-header" data-bs-toggle="collapse" data-bs-target="#collapse-{{$key}}">
                        <a href="{{route('front.shop',[$category->slug,'search' => $searchQuery])}}" class="{{$categorySelected == $category->id ? 'text-primary':''}}">
                            <span class="categories_name">{{$category->name}}</span>
                            <span class="categories_num">({{$category->products->count()}})</span>
                        </a>
                    </div>
                    @if($category->subCategories->isNotEmpty())
                        <div id="collapse-{{$key}}" class="accordion-collapse collapse {{$categorySelected == $category->id ? 'show':''}}" aria-labelledby="{{$category->name}}" data-bs-parent="#accordionExample" aria-controls="{{$category->name}}">

                            <div  class="accordion-body ">
                                <ul>
                                    @forelse($category->subCategories as $subCategory)
                                        <li><a href="{{route('front.shop',[$category->slug,$subCategory->slug,'search' => $searchQuery])}}" class="sub_category_name  {{$subCategorySelected == $subCategory->id ? 'text-primary':''}}"><span class="sub_category_name">{{$subCategory->name}}</span></a></li>
                                    @empty
                                    @endforelse
                                </ul>
                            </div>
                        </div>

                    @endif
                </li>

            @empty
            @endforelse
        </ul>
    </div>
    <div class="widget">
        <h5 class="widget_title">Filter</h5>
        <div class="filter_price">
            <div id="price_filter" data-min="{{$minPrice !='' ? $minPrice :0 }}" data-max="{{$maxPrice !='' ? $maxPrice :100000 }}" data-min-value="{{$priceMinSelected !='' ? $priceMinSelected :$minPrice }}" data-max-value="{{$priceMaxSelected !='' ? $priceMaxSelected :$maxPrice }}" data-price-sign="EGP "></div>
            <div class="price_range d-grid gap-2 align-items-center">
                <span>Price: <span id="flt_price"></span></span>
                <button class="btn btn-fill-out  text-uppercase btn-sm mt-2" type="button" onclick="apply_filters()">Filter</button>

                <input type="hidden" id="price_first" value="">
                <input type="hidden" id="price_second" value="">


            </div>

        </div>
    </div>
    <div class="widget">
        <h5 class="widget_title">Brand</h5>
        <ul class="list_brand">
            @forelse($brands as $brand)
                <li>
                    <div class="custome-checkbox">
                        <input {{in_array($brand->slug,$brandArray) ?'checked' : '' }} class="form-check-input brand-label" type="checkbox" name="brands[]" id="brand-{{$brand->slug}}" value="{{$brand->slug}}">
                        <label class="form-check-label" for="brand-{{$brand->slug}}"><span>{{$brand->name}}</span></label>
                    </div>
                </li>
            @empty
            @endforelse


        </ul>
    </div>
    <div class="widget">
        <h5 class="widget_title">Collections</h5>
        <ul class="list_brand">
            @forelse($Collections as $collection)
                <li>
                    <div class="custome-checkbox">
                        <input {{in_array($collection->id,$collectionArray) ?'checked' : '' }} class="form-check-input collection-label" type="checkbox" name="collections[]" id="collection-{{$collection->slug}}" value="{{$collection->slug}}">
                        <label class="form-check-label" for="collection-{{$collection->slug}}"><span>{{$collection->name}}</span></label>
                    </div>
                </li>
            @empty
            @endforelse


        </ul>
    </div>
    <!-- Attributes Filter -->
    @if($categorySelected)
        <div class="widget">
            @foreach($attributes as $attribute)
                <div class="widget">
                    <h5 class="widget_title" data-attribute="{{$attribute->slug}}" >{{ $attribute->name }}</h5>
                    <ul class="list_filter">
                        @foreach($attribute->values as $value)
                            <li>
                                <div class="custome-checkbox">
                                    <input type="checkbox" class="form-check-input attribute-label" name="attributes[{{ $attribute->slug }}]" value="{{ $value->slug }}" id="attribute-{{ $attribute->slug }}-{{ $value->slug }}" {{ isset($attributeFilters[$attribute->slug]) && in_array($value->slug,explode(',', $attributeFilters[$attribute->slug])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="attribute-{{ $attribute->slug }}-{{ $value->slug }}">{{ $value->value }}</label>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>
    @endif



</div>
</div>

