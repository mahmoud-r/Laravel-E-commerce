<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{route('dashboard')}}" class="brand-link">
        @if(!empty(get_setting('store_logo_white')))
            <div>
                <img src="{{asset('uploads/site/images/'.get_setting('store_logo_white'))}}" alt="{{get_setting('store_name')}}" >
            </div>
        @else
            <img src="{{asset('/front_assets/images/logo_light.png')}}" alt="{{get_setting('store_name')}}" >
        @endif

    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{route('dashboard')}}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                @canany(['category-list','category-create','category-edit','category-delete'])
                    <li class="nav-item">
                        <a href="{{route('categories.index')}}" class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-file-alt"></i>
                            <p>Categories</p>
                        </a>
                    </li>
                @endcanany

                @canany(['brand-list','brand-create','brand-edit','brand-delete'])
                 <li class="nav-item">
                    <a href="{{route('brands.index')}}" class="nav-link {{ request()->routeIs('brands.*') ? 'active' : '' }}">
                        <svg class="h-6 nav-icon w-6 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 4v12l-4-2-4 2V4M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <p>Brands</p>
                    </a>
                </li>
                @endcanany

                @canany(['attribute-list','attribute-create','attribute-edit','attribute-delete'])
                <li class="nav-item">
                    <a href="{{route('attributes.index')}}" class="nav-link {{ request()->routeIs('attributes.*') ? 'active' : '' }} ">
                        <i class="nav-icon  fas fa-scroll"></i>
                        <p>Attributes</p>
                    </a>
                </li>
                @endcanany

                @canany(['product-list','product-create','product-edit','product-delete'])
                <li class="nav-item">
                    <a href="{{route('products.index')}}" class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tag"></i>
                        <p>Products</p>
                    </a>
                </li>
                @endcanany

                @canany(['collection-list','collection-create','collection-edit','collection-delete'])
                <li class="nav-item">
                    <a href="{{route('collections.index')}}" class="nav-link {{ request()->routeIs('collections.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tag"></i>
                        <p>Collections</p>
                    </a>
                </li>
                @endcanany

                @canany(['reviews-list','reviews-publish','reviews-delete'])
                <li class="nav-item">
                    <a href="{{route('reviews.index')}}" class="nav-link {{ request()->routeIs('reviews.*') ? 'active' : '' }}">
                        <i class="far fa-star nav-icon"></i>
                        <p>Reviews</p>
                    </a>
                </li>
                @endcan

                @canany(['shipping-list','shipping-create','shipping-edit','shipping-delete','locations-list','locations-create','locations-edit','locations-delete'])
                    <li class="nav-item {{ request()->routeIs('shipping.*','governorate.*','cities.*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs('shipping.*','governorate.*','cities.*') ? 'active' : '' }}">
                            <i class="fas fa-truck nav-icon"></i>
                            <p>
                                Shipping
                                <i class="right fas fa-angle-left"></i>

                            </p>
                        </a>

                        <ul class="nav nav-treeview" style="display: {{ request()->routeIs('shipping.*','governorate.*','cities.*') ? 'block' : 'none' }};">
                            @canany(['shipping-list','shipping-create','shipping-edit','shipping-delete'])
                            <li class="nav-item">
                                <a href="{{route('shipping.index')}}" class="nav-link {{ request()->routeIs('shipping.*') ? 'active' : '' }}" style="width: 100% !important;">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Zones</p>
                                </a>
                            </li>
                            @endcanany
                            @canany(['locations-list','locations-create','locations-edit','locations-delete'])
                                <li class="nav-item">
                                    <a href="{{route('governorate.index')}}" class="nav-link {{ request()->routeIs('governorate.*','cities.*') ? 'active' : '' }}" style="width: 100% !important;">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Governorate</p>
                                    </a>
                                </li>
                            @endcanany

                        </ul>
                    </li>
                @endcanany

                @canany(['order-list','order-payment-confirm','order-confirm','order-delete','order-cancel','order-update-shipping-information','order-update-shipping-status','order-update-note'])
                <li class="nav-item">
                    <a href="{{route('orders.index')}}" class="nav-link {{ request()->routeIs('orders.*','order.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-shopping-bag"></i>
                        <p>Orders</p>
                    </a>
                </li>
                @endcanany

                @canany(['shipment-list','shipment-update'])
                <li class="nav-item">
                    <a href="{{route('shipments.index')}}" class="nav-link {{ request()->routeIs('shipments.*','shipment.*') ? 'active' : '' }}">
                        <span class="nav-link-icon d-md-none d-lg-inline-block" title="Shipments">
                               <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                              <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                              <path d="M2 3h1a2 2 0 0 1 2 2v10a2 2 0 0 0 2 2h15"></path>
                              <path d="M9 6m0 3a3 3 0 0 1 3 -3h4a3 3 0 0 1 3 3v2a3 3 0 0 1 -3 3h-4a3 3 0 0 1 -3 -3z"></path>
                              <path d="M9 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                              <path d="M18 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                         </svg>
                    </span>
                        <p>Shipments</p>
                    </a>
                </li>
                @endcanany

                @canany(['discount-list','discount-create','discount-edit','discount-delete'])
                <li class="nav-item">
                    <a href="{{route('discount.index')}}" class="nav-link {{ request()->routeIs('discount.*') ? 'active' : '' }}">
                        <i class="nav-icon  fa fa-percent" aria-hidden="true"></i>
                        <p>Discount</p>
                    </a>
                </li>
                @endcanany

                @canany(['customer-list','customer-create','customer-edit','customer-delete','customer-address-create','customer-address-edit','customer-address-delete'])
                <li class="nav-item">
                    <a href="{{route('users.index')}}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                        <i class="nav-icon  fas fa-users"></i>
                        <p>Customers</p>
                    </a>
                </li>
                @endcanany

                @canany(['admin-list','admin-create','admin-edit','admin-delete','role-list','role-create','role-edit','role-delete'])
                <li class="nav-item {{ request()->routeIs('admins.*','roles.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('admins.*','roles.*') ? 'active' : '' }}">
                        <i class="nav-icon  fas fa-users"></i>
                        <p>
                            Admins
                            <i class="right fas fa-angle-left"></i>

                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="display: {{ request()->routeIs('admins.*','roles.*') ? 'block' : 'none' }};">

                        @canany(['admin-list','admin-create','admin-edit','admin-delete'])
                            <li class="nav-item">
                                <a href="{{route('admins.index')}}" class="nav-link {{ request()->routeIs('admins.*') ? 'active' : '' }}" style="width: 100% !important;">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Admins</p>
                                </a>
                            </li>
                        @endcanany

                        @canany(['role-list','role-create','role-edit','role-delete'])
                            <li class="nav-item">
                                <a href="{{route('roles.index')}}" class="nav-link {{ request()->routeIs('roles.*') ? 'active' : '' }}" style="width: 100% !important;">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Roles</p>
                                </a>
                            </li>
                       @endcanany
                    </ul>
                </li>
                @endcanany

                @canany(['menu-list','menu-create','menu-edit','menu-delete'])
                    <li class="nav-item">
                        <a href="{{route('menus.index')}}" class="nav-link {{ request()->routeIs('menus.*') ? 'active' : '' }}">
                            <i class=" nav-icon fas fa-bars"></i>
                            <p>Menus</p>
                        </a>
                    </li>
                @endcanany

                @canany(['pages-home-page','pages-home-banners','pages-contact-page','pages-about-page','pages-term-condition-page','pages-home-slider'])
                <li class="nav-item">
                    <a href="{{route('pages.index')}}" class="nav-link {{ request()->routeIs('pages.*','HomeSlider.*') ? 'active' : '' }}">
                        <i class="nav-icon  far fa-file-alt"></i>
                        <p>Pages</p>
                    </a>
                </li>
                @endcan

                @canany(['contact-list','contact-delete'])
                <li class="nav-item">
                    <a href="{{route('contact.index')}}" class="nav-link {{ request()->routeIs('contact.*') ? 'active' : '' }}">
                        <i class="nav-icon far fa-envelope"></i>
                        <p>Contact</p>
                    </a>
                </li>
                @endcanany

                @canany(['newsletter-list','newsletter-delete','newsletter-create'])
                <li class="nav-item">
                    <a href="{{route('newsletter.index')}}" class="nav-link {{ request()->routeIs('newsletter.*') ? 'active' : '' }}">
                        <i class="nav-icon  far fa-file-alt"></i>
                        <p>Newsletter</p>
                    </a>
                </li>
                @endcanany

                @canany(['settings-general','settings-payment-methods','settings-email','settings-social','settings-social-login','settings-recaptcha'])
                <li class="nav-item">
                    <a href="{{route('settings.index')}}" class="nav-link {{ request()->routeIs('settings.*','payment_methods.*') ? 'active' : '' }}">
                        <i class="fas fa-cog nav-icon"></i>
                        <p>Settings</p>
                    </a>
                </li>
                @endcanany
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
