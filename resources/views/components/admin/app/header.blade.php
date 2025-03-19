<div class="nk-header is-light nk-header-fixed is-light">
    <div class="container-xl wide-xl">
        <div class="nk-header-wrap">
            <div class="nk-menu-trigger d-xl-none ms-n1 me-3">
                <a href="#" class="nk-nav-toggle nk-quick-nav-icon" data-target="sidebarMenu"><em class="icon ni ni-menu"></em></a>
            </div>
            <div class="nk-header-brand d-xl-none">
                <a href="" class="logo-link">
                    <img class="logo-light logo-img" src="/assets/images/logo.png" srcset="/assets/images/logo2x.png 2x" alt="لوگو" />
                    <img class="logo-dark logo-img" src="/assets/images/logo-dark.png" srcset="/assets/images/logo-dark2x.png 2x" alt="لوگوی تاریک" />
                </a>
            </div>
            <!-- .nk-header-brand -->
            <div class="nk-header-menu is-light">
                <div class="nk-header-menu-inner">
                    <!--                ---- Menu ----                   -->
                    <ul class="nk-menu nk-menu-main">
                        <li class="nk-menu-item has-sub">
                            <a href="#" class="nk-menu-link nk-menu-toggle">
                                <span class="nk-menu-text">داشبورد ها</span>
                            </a>
                            <ul class="nk-menu-sub">
                                <li class="nk-menu-item">
                                    <a href="#" class="nk-menu-link">
                                        <span class="nk-menu-text">تحلیل فروش</span>
                                    </a>
                                </li>
                            </ul>
                            <!-- .nk-menu-sub -->
                        </li>
                        <!-- .nk-menu-item -->
                        <li class="nk-menu-item">
                            <a href="{{ route('cart.list') }}" class="nk-menu-link">
                                <span class="nk-menu-text">سبد خرید</span>
                            </a>
                        </li>
                        <!-- .nk-menu-item -->
                    </ul>
                    <!--                ---- Menu ----                  -->
                </div>
            </div>
            <!-- .nk-header-menu -->
            <div class="nk-header-tools">
                <ul class="nk-quick-nav">
                    <li class="dropdown notification-dropdown">
                        <a href="#" class="dropdown-toggle nk-quick-nav-icon" data-bs-toggle="dropdown">
                            <div class="icon-status icon-status-info"><em class="icon ni ni-bell"></em></div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-xl dropdown-menu-end">
                            <div class="dropdown-head">
                                <span class="sub-title nk-dropdown-title">یادآوری ها</span>
                                <a href="#">علامت گذاری همه به عنوان خوانده شده</a>
                            </div>
                            <div class="dropdown-body">
                                <div class="nk-notification">
                                    <div class="nk-notification-item dropdown-inner">
                                        <div class="nk-notification-icon">
                                            <em class="icon icon-circle bg-primary-dim ni ni-share"></em>
                                        </div>
                                        <div class="nk-notification-content">
                                            <div class="nk-notification-text">مهرداد <span>Dashlite-v2</span> را با شما به اشتراک گذاشت.</div>
                                            <div class="nk-notification-time">هم اکنون</div>
                                        </div>
                                    </div>
                                </div>
                                <!-- .nk-notification -->
                            </div>
                            <!-- .nk-dropdown-body -->
                            <div class="dropdown-foot center">
                                <a href="#">مشاهده همه</a>
                            </div>
                        </div>
                    </li>
                    <!-- .dropdown -->
                    <li class="dropdown user-dropdown">
                        <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown">
                            <div class="user-toggle">
                                <div class="user-avatar sm">
                                    <em class="icon ni ni-user-fill-c text-primary-dim" style="font-size: 40px;"></em>
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-md dropdown-menu-end">
                            <div class="dropdown-inner user-card-wrap bg-lighter d-none d-md-block">
                                <div class="user-card">
                                    <div class="user-avatar">
                                        <em class="icon ni ni-user-fill fs-18px"></em>
                                    </div>
                                    <div class="user-info">
                                        <span class="lead-text">{{ Auth::user()->name }}</span>
                                        <span class="sub-text">{{ Auth::user()->username }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="dropdown-inner">
                                <ul class="link-list">
                                    <li>
                                        <a href="#"><em class="icon ni ni-user-alt"></em><span>مشاهده پروفایل</span></a>
                                    </li>
                                    <li>
                                        <a href="#"><em class="icon ni ni-setting-alt"></em><span>تنظیمات حساب</span></a>
                                    </li>
                                    <li>
                                        <a class="dark-switch" href="#"><em class="icon ni ni-moon"></em><span>حالت تاریک</span></a>
                                    </li>
                                </ul>
                            </div>
                            <div class="dropdown-inner">
                                <ul class="link-list">
                                    <li>
                                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout').submit();" class="text-danger"><em class="icon ni ni-signout"></em><span>خروج</span></a>
                                        <form id="logout" action="{{ route('logout') }}" class="d-none" method="post">@csrf</form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <!-- .nk-header-tools -->
        </div>
        <!-- .nk-header-wrap -->
    </div>
    <!-- .container-fliud -->
</div>
