<div class="product_search_form rounded_input">
    <form action="{{ route('front.shop') }}" method="GET" id="searchForm">

        <div class="input-group">
            <div class="input-group-prepend">
                <div class="custom_select">
                    <select  id="category-search"  class="first_null">
                        <option value="">All Category</option>
                        @forelse(getCategories() as $category)
                        <option value="{{$category->slug}}">{{$category->name}}</option>
                        @empty
                        @endforelse
                    </select>
                </div>
            </div>
            <input class="form-control" placeholder="Search Product..." required="" name="search" id="search"  type="text">
            <button type="submit" class="search_btn2">
                <i class="fa fa-search"></i>
            </button>
        </div>
    </form>
    <div  class="panel--search-result " id="searchResults">

    </div>
</div>
