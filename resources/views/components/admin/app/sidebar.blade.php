<div class="nk-sidebar-element">
    <div class="nk-sidebar-content">
        <div class="nk-sidebar-menu" data-simplebar>
            <ul class="nk-menu">
                <li class="nk-menu-heading">
                    <h6 class="overline-title text-primary-alt">اصلی</h6>
                </li>
                <!-- .nk-menu-item -->
                <li class="nk-menu-item">
                    <a href="html/copywriter/index.html" class="nk-menu-link">
                                            <span class="nk-menu-icon">
                                                <em class="icon ni ni-bag"></em>
                                            </span>
                        <span class="nk-menu-text">داشبورد اصلی</span><span class="nk-menu-badge bg-dark-dim text-dark">بدون اطلاعات</span>
                    </a>
                </li>
                <!-- .nk-menu-item -->
                <li class="nk-menu-heading">
                    <h6 class="overline-title text-primary-alt">داشبوردها</h6>
                </li>
                <!-- .nk-menu-item -->
                <li class="nk-menu-item">
                    <a href="#" class="nk-menu-link">
                        <span class="nk-menu-icon"><em class="icon ni ni-presentation"></em></span>
                        <span class="nk-menu-text">نگاه کلی</span>
                    </a>
                </li>
                <!-- .nk-menu-item -->
                <li class="nk-menu-item">
                    <a href="#" class="nk-menu-link">
                        <span class="nk-menu-icon"><em class="icon ni ni-presentation"></em></span>
                        <span class="nk-menu-text">تحلیل محصولات</span>
                    </a>
                </li>
                <!-- .nk-menu-item -->
                <li class="nk-menu-item">
                    <a href="#" class="nk-menu-link">
                        <span class="nk-menu-icon"><em class="icon ni ni-cc-alt2"></em></span>
                        <span class="nk-menu-text">تحلیل فروش</span>
                    </a>
                </li>
                <!-- .nk-menu-item بخش ها-->
                <li class="nk-menu-heading">
                    <h6 class="overline-title text-primary-alt">مدیریت</h6>
                </li>
                <!-- .nk-menu-item مشتریان-->
                <li class="nk-menu-item has-sub">
                    <a href="#" class="nk-menu-link nk-menu-toggle">
                        <span class="nk-menu-icon"><em class="icon ni ni-user-list"></em></span>
                        <span class="nk-menu-text">مشتریان</span>
                    </a>
                    <ul class="nk-menu-sub">
                        <li class="nk-menu-item">
                            <a href="{{ route('customers.list') }}" class="nk-menu-link"><span class="nk-menu-text">لیست مشتریان</span></a>
                        </li>
                        <li class="nk-menu-item">
                            <a href="#" class="nk-menu-link"><span class="nk-menu-text">مشخصات مشتری</span></a>
                        </li>
                        <li class="nk-menu-item">
                            <a href="{{ route('customer.creat') }}" class="nk-menu-link"><span class="nk-menu-text">افزودن مشتری</span></a>
                        </li>
                    </ul>
                    <!-- .nk-menu-sub -->
                </li>
                <!-- .nk-menu-item مدیریت کاربران-->
                <li class="nk-menu-item has-sub">
                    <a href="#" class="nk-menu-link nk-menu-toggle">
                        <span class="nk-menu-icon"><em class="icon ni ni-users"></em></span>
                        <span class="nk-menu-text">مدیریت کاربران</span>
                    </a>
                    <ul class="nk-menu-sub">
                        <li class="nk-menu-item">
                            <a href="{{ route('users.all') }}" class="nk-menu-link"><span class="nk-menu-text">لیست کاربران</span></a>
                        </li>
                        <li class="nk-menu-item">
                            <a href="#" class="nk-menu-link"><span class="nk-menu-text">افزودن کاربر</span></a>
                        </li>
                        <li class="nk-menu-item has-sub">
                            <a href="#" class="nk-menu-link nk-menu-toggle"><span class="nk-menu-text">نقش ها</span></a>
                            <ul class="nk-menu-sub">
                                <li class="nk-menu-item">
                                    <a href="{{ route('users.permissions') }}" class="nk-menu-link"><span class="nk-menu-text">لیست دسترسی ها</span></a>
                                </li>
                                <li class="nk-menu-item">
                                    <a href="{{ route('users.roles') }}" class="nk-menu-link"><span class="nk-menu-text">لیست نقش ها</span></a>
                                </li>
                                <li class="nk-menu-item">
                                    <a href="#" class="nk-menu-link"><span class="nk-menu-text">افزودن نقش جدید</span></a>
                                </li>
                            </ul>
                            <!-- .nk-menu-sub -->
                        </li>
                    </ul>
                    <!-- .nk-menu-sub -->
                </li>
                <!-- .nk-menu-item محصولات-->
                <li class="nk-menu-item has-sub">
                    <a href="#" class="nk-menu-link nk-menu-toggle">
                        <span class="nk-menu-icon"><em class="icon ni ni-card-view"></em></span>
                        <span class="nk-menu-text">محصولات</span>
                    </a>
                    <ul class="nk-menu-sub">
                        <li class="nk-menu-item">
                            <a href="#" class="nk-menu-link"><span class="nk-menu-text">لیست محصولات</span></a>
                        </li>
                        <li class="nk-menu-item">
                            <a href="#" class="nk-menu-link"><span class="nk-menu-text">افزودن محصول</span></a>
                        </li>
                    </ul>
                    <!-- .nk-menu-sub -->
                </li>

                <!-- .nk-menu-item مدیریت  مالی-->
                <li class="nk-menu-heading">
                    <h6 class="overline-title text-primary-alt">مدریت مالی</h6>
                </li>
                <!-- .nk-menu-item تراکنش ها-->
                <li class="nk-menu-item has-sub">
                    <a href="#" class="nk-menu-link nk-menu-toggle">
                        <span class="nk-menu-icon"><em class="icon ni ni-tranx"></em></span>
                        <span class="nk-menu-text">تراکنش ها</span>
                    </a>
                    <ul class="nk-menu-sub">
                        <li class="nk-menu-item">
                            <a href="html/transaction-basic.html" class="nk-menu-link"><span class="nk-menu-text">لیست تراکنش ها - پایه</span></a>
                        </li>
                        <li class="nk-menu-item">
                            <a href="html/transaction-crypto.html" class="nk-menu-link"><span class="nk-menu-text">لیست تراکنش ها - ارز دیجیتال</span></a>
                        </li>
                    </ul>
                    <!-- .nk-menu-sub -->
                </li>
                <!-- .nk-menu-item فاکتور ها-->
                <li class="nk-menu-item has-sub">
                    <a href="#" class="nk-menu-link nk-menu-toggle">
                        <span class="nk-menu-icon"><em class="icon ni ni-file-docs"></em></span>
                        <span class="nk-menu-text">فاکتورها</span>
                    </a>
                    <ul class="nk-menu-sub">
                        <li class="nk-menu-item">
                            <a href="html/invoice-list.html" class="nk-menu-link"><span class="nk-menu-text">لیست فاکتورها</span></a>
                        </li>
                        <li class="nk-menu-item">
                            <a href="html/invoice-details.html" class="nk-menu-link"><span class="nk-menu-text">جزئیات فاکتور</span></a>
                        </li>
                    </ul>
                    <!-- .nk-menu-sub -->
                </li>

            </ul>
            <!-- .nk-menu -->
        </div>
        <!-- .nk-sidebar-menu -->
    </div>
    <!-- .nk-sidebar-content -->
</div>
