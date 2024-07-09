@php
    $homeBanners = getPageContent('homeBanners');
@endphp
<section class="section pb_20 small_pt">
    <div class="container">
        <div class="row">
            @foreach($homeBanners as  $key =>$banner )
                @if($banner['status'] == '1')
                    <div class="col-md-4">
                        <div class="sale-banner mb-3 mb-md-4">
                            <a class="hover_effect1" href="{{$banner['link']}}" title="{{$banner['link']}}">
                                @if(!empty($banner['img']))
                                  <img src="{{asset('uploads/home_banners/images/'.$banner['img'])}}" alt="{{$key}}">
                                @endif
                            </a>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>


</section>
