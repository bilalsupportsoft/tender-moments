<header class="tmp-header-area-start header-one header--sticky header--transparent">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="header-content">
                        <div class="logo">
                            <a href="{{ route('/') }}">
                                <img class="logo-dark" src="assets/web/logo.png" width="120" alt="">
                                <img class="logo-white" src="assets/web/logo.png" width="120" alt="">
                            </a>
                        </div>
                        <div class="tmp-mainmenu-nav d-none d-xl-block">
                            <nav class="navbar-example2 onepagenav">
                                <ul class="tmp-mainmenu nav nav-pills">
                                    <li class="nav-item"><a class="smoth-animation" href="{{ route('/') }}">Home</a></li>
                                    <li class="nav-item"><a class="smoth-animation" href="#service">About Me</a></li>
                                    <li class="nav-item"><a class="smoth-animation" href="#about">What to Expect</a></li>
                                    <li class="nav-item"><a class="smoth-animation" href="#resume">Contact</a></li>
                                </ul>
                            </nav>
                        </div>
                        <div class="tmp-header-right">
                            <!-- Profile menu or Sign Up button -->
                            @if(Auth::check())
                            <div class="profile-infobeluser d-xl-block">
                                <div class="profile-menu" onClick="toggleDropdown()">
                                    <img src="{{ Auth::user()->avatar ? asset(Auth::user()->avatar) : asset('assets/web/images/no-user.jpg') }}" class="profile-pic" alt="User">
                                    <span class="user-name">{{ Auth::user()->name ?? 'Guest' }}</span>
                                    <span class="arrow-down">▼</span>
                                    <div id="dropdownMenu" class="dropdown">
                                        <a href="{{ route('my-booking') }}"><i class="fa-light fa-calendar-days"></i> My Booking</a>
                                        <a href="{{ route('edit-profile') }}"><i class="fa-regular fa-user"></i> Edit Profile</a>
                                        <a href="{{ route('user.logout') }}"><i class="fa-regular fa-arrow-right-from-bracket"></i> Logout</a>
                                    </div>
                                </div>
                            </div>
                        @else
                        <div class="tmp-header-right">
                            <div class="header-right-info d-flex align-items-center">
                                <a class="tmp-btn hover-icon-reverse btn-border tmp-modern-button download-icon w-100 btn-md" href="javascript:void(0)" onClick="openCustomPopup()">
                                    <div class="icon-reverse-wrapper">
                                        <span class="btn-text">Sign In</span>
                                        <div class="btn-hack"></div>
                                        <img src="assets/web/images/button/btg-bg.svg" alt="" class="btn-bg">
                                        <img src="assets/web/images/button/btg-bg-2.svg" alt="" class="btn-bg-hover">
                                        <span class="btn-icon"><i class="ffa-sharp fa-regular fa-arrow-right"></i></span>
                                        <span class="btn-icon"><i class="ffa-sharp fa-regular fa-arrow-right"></i></span>
                                    </div>
                                </a>
                            </div>
                            <div class="tmp-side-collups-area d-block d-xl-none">
                                <button class="hamberger-menu humberger_menu_active"><i id="menuBtn" class="fa-light fa-bars humberger-menu"></i></button>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Start Popup Mobile Menu  -->
    <div class="d-block d-xl-none">
        <div class="tmp-popup-mobile-menu">
            <div class="inner">
                <div class="header-top">
                    <div class="logo">
                        <a href="index.html" class="logo-area">
                            <img class="logo-dark" src="assets/web/logo.png" alt="">
                            <img class="logo-white" src="assets/web/logo.png" alt="">
                        </a>
                    </div>
                    <div class="close-menu">
                        <button class="close-button tmp-round-action-btn">
                            <i class="fa-sharp fa-light fa-xmark"></i>
                        </button>
                    </div>
                </div>
                <ul class="tmp-mainmenu onepagenav-click">
                    <li><a class="smoth-animation" href="#">Home</a></li>
                    <li><a class="smoth-animation" href="#">About Me</a></li>
                    <li><a class="smoth-animation" href="#">What to Expect</a></li>
                    <li><a class="smoth-animation" href="#">Contact</a></li>
                </ul>
                <!-- social sharea area -->
                <!-- end -->
            </div>
        </div>
    </div>
    <!-- End Popup Mobile Menu  -->
