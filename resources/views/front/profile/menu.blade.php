
<div class="col-lg-3 col-md-4">
    <div class="dashboard_menu">
        <ul class="nav nav-tabs flex-column" >

            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'front.profile' ? 'active' : '' }} " id="dashboard-tab"   href="{{route('front.profile')}}" ><i class="ti-layout-grid2"></i>Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'front.orders' || Route::currentRouteName() == 'front.showOrder'  ? 'active' : '' }}" id="orders-tab" href="{{route('front.orders')}}" ><i class="ti-shopping-cart-full"></i>Orders</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'front.address' ? 'active' : '' }}" id="address-tab" href="{{route('front.address')}}" ><i class="ti-location-pin"></i>My Address</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'front.reviews' ? 'active' : '' }}" id="reviews-tab" href="{{route('front.reviews')}}" ><i class="far fa-star"></i>Reviews</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'front.accountDetail' || Route::currentRouteName() == 'front.change-password' ? 'active' : '' }}" id="account-detail-tab" href="{{route('front.accountDetail')}}" ><i class="ti-id-badge"></i>Account Detail</a>
            </li>
            <li class="nav-item">
                <form action="{{route('logout')}}" method="post">
                    @csrf
                    <button class="nav-link" href="login.html" ><i class="ti-lock"></i>Logout</button>
                </form>
            </li>
        </ul>
    </div>
</div>
