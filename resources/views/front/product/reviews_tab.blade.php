<div class="tab-pane fade" id="Reviews" role="tabpanel" aria-labelledby="Reviews-tab">
    <div class="row">
        <div class="col-md-5">
            <div class="product-review-number">
                <h3 class="product-review-number-title">Customer reviews</h3>
                <div class="product-review-summary">
                    <div class="product-review-summary-value">
                        <span> {{number_format($product->average_rating_number,2)}} </span>
                    </div>
                    <div class="product-review-summary-rating rating_wrap">
                        <div class="rating">
                            <div class="product_rate" style="width:{{$product->average_rating_percentage}}%"></div>
                        </div>
                        <p> ({{$product->rating_count}} Reviews) </p>
                    </div>
                </div>
                <div class="product-review-progress">
                    <div class="product-review-progress-bar">
                        <span class="product-review-progress-bar-title"> 5 Stars </span>
                        <div class="progress product-review-progress-bar-value">
                            <div role="progressbar"  aria-valuenow="{{ $product->five_star_percentage }}" style="width: {{ $product->five_star_percentage }}%" aria-valuemin="0" aria-valuemax="100" class="progress-bar "></div>
                        </div>
                        <span class="product-review-progress-bar-percent"> {{ number_format($product->five_star_percentage,0) }}% </span>
                    </div><div class="product-review-progress-bar">
                        <span class="product-review-progress-bar-title"> 4 Stars </span>
                        <div class="progress product-review-progress-bar-value">
                            <div role="progressbar" aria-valuenow="{{ $product->four_star_percentage }}" style="width: {{ $product->four_star_percentage }}%" aria-valuemin="0" aria-valuemax="100" class="progress-bar">
                            </div>
                        </div>
                        <span class="product-review-progress-bar-percent"> {{ number_format($product->four_star_percentage,0) }}% </span>
                    </div>
                    <div class="product-review-progress-bar">
                        <span class="product-review-progress-bar-title"> 3 Stars </span>
                        <div class="progress product-review-progress-bar-value">
                            <div role="progressbar" aria-valuenow="{{ $product->three_star_percentage }}" style="width: {{ $product->three_star_percentage }}%" aria-valuemin="0" aria-valuemax="100" class="progress-bar ">
                            </div>
                        </div>
                        <span class="product-review-progress-bar-percent"> {{ number_format($product->three_star_percentage,0) }}% </span>
                    </div>
                    <div class="product-review-progress-bar">
                        <span class="product-review-progress-bar-title"> 2 Stars </span>
                        <div class="progress product-review-progress-bar-value">
                            <div role="progressbar" aria-valuenow="{{ $product->two_star_percentage }}" style="width:{{ $product->two_star_percentage }}%" aria-valuemin="0" aria-valuemax="100" class="progress-bar ">
                            </div>
                        </div>
                        <span class="product-review-progress-bar-percent"> {{ number_format($product->two_star_percentage,0) }}% </span>
                    </div>
                    <div class="product-review-progress-bar">
                        <span class="product-review-progress-bar-title"> 1 Star </span>
                        <div class="progress product-review-progress-bar-value">
                            <div role="progressbar" aria-valuenow="{{ $product->one_star_percentage }}" style="width: {{ $product->one_star_percentage }}%" aria-valuemin="0" aria-valuemax="100" class="progress-bar">

                            </div>
                        </div>
                        <span class="product-review-progress-bar-percent"> {{ number_format($product->one_star_percentage,0) }}% </span>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-md-7">
            <div class="review_form field_form">
                <h5>Add a review</h5>
                @if(!Auth::check())
                  <p class="text-danger"> Please <a href="{{route('login')}}">login</a> to write review! </p>
                @endif
                <form class="row mt-3" id="RatingForm" method="post">
                    <div class="form-group col-12 mb-3">
                        <div class="rating" style="width: 10rem">
                            <input id="rating-5" type="radio" name="rating" value="5"/><label for="rating-5"><i class="fas fa-3x fa-star"></i></label>
                            <input id="rating-4" type="radio" name="rating" value="4"  /><label for="rating-4"><i class="fas fa-3x fa-star"></i></label>
                            <input id="rating-3" type="radio" name="rating" value="3"/><label for="rating-3"><i class="fas fa-3x fa-star"></i></label>
                            <input id="rating-2" type="radio" name="rating" value="2"/><label for="rating-2"><i class="fas fa-3x fa-star"></i></label>
                            <input id="rating-1" type="radio" name="rating" value="1"/><label for="rating-1"><i class="fas fa-3x fa-star"></i></label>

                        </div>
                        <p id="error-rating"></p>

                    </div>
                    <div class="form-group col-12 mb-3">
                        <textarea required="required" placeholder="Your review *" class="form-control" name="comment" rows="4"></textarea>
                        <p id="error-comment"></p>
                    </div>
                    <div class="form-group col-12 mb-3">
                        <button type="submit" class="btn btn-fill-out" name="submit" {{!Auth::check() ?'disabled':''}} value="Submit" style="--bs-btn-disabled-color :#fff">Submit Review</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <div class="comments mt-5">
        @if($product->rating_count >0)
        <h5 class="product_tab_title">{{$product->rating_count}} Review For <span>{{$product->title}}</span></h5>
        @endif
        <ul class="list_none comment_list mt-4">
            @forelse($product->ratings as $rating)
            <li class="row">
                <div class="comment_img col-auto">
                    <img src="{{asset('front_assets/images/user.jpg')}}" alt="{{$rating->user->name}}" width="60"/>
                </div>

                <div class="comment_block col">
                    <div class="rating_wrap">
                        <div class="rating">
                            <div class="product_rate" style="width:{{$rating->rating_percentage}}%"></div>
                        </div>
                    </div>
                    <p class="customer_meta">
                        <span class="review_author">{{$rating->user->name}}</span>
                        <span class="comment-date">{{\carbon\Carbon::parse($rating->created_at)->format('d M,Y')}}</span>
                    </p>
                    <div class="description">
                        <p>{{$rating->comment}}</p>
                    </div>
                </div>
            </li>
            @empty

            @endforelse
        </ul>
    </div>
</div>
