<div class="nk-sidebar-element">
    <div class="nk-sidebar-content">
        <div class="nk-sidebar-menu" data-simplebar>
            <ul class="nk-menu">
                <li class="nk-menu-heading">
                    <h6 class="overline-title text-primary-alt">اصلی</h6>
                </li>
                <!-- .nk-menu-item -->
                <li class="nk-menu-item">
                    <a href="#" class="nk-menu-link">
                        <span class="nk-menu-icon">
                            <em class="icon ni ni-bag"></em>
                        </span>
                        <span class="nk-menu-text">داشبورد اصلی</span><span class="nk-menu-badge bg-dark-dim text-dark">بدون اطلاعات</span>
                    </a>
                </li>
                <!-- .nk-menu-item داشبورد ها  -->
                <li class="nk-menu-heading">
                    <h6 class="overline-title text-primary-alt">داشبوردها</h6>
                </li>
                <!-- .nk-menu-item نگاه کلی  -->
                <li class="nk-menu-item">
                    <a href="#" class="nk-menu-link">
                        <span class="nk-menu-icon"><em class="icon ni ni-presentation"></em></span>
                        <span class="nk-menu-text">نگاه کلی</span>
                    </a>
                </li>
                <!-- .nk-menu-item   تحلیل محصولات  -->
                <li class="nk-menu-item">
                    <a href="#" class="nk-menu-link">
                        <span class="nk-menu-icon"><em class="icon ni ni-presentation"></em></span>
                        <span class="nk-menu-text">تحلیل محصولات</span>
                    </a>
                </li>
                <!-- .nk-menu-item  تحلیل فروش  -->
                <li class="nk-menu-item">
                    <a href="#" class="nk-menu-link">
                        <span class="nk-menu-icon"><em class="icon ni ni-cc-alt2"></em></span>
                        <span class="nk-menu-text">تحلیل فروش</span>
                    </a>
                </li>

                <!-- .nk-menu-item  عمومی  -->
                <li class="nk-menu-heading">
                    <h6 class="overline-title text-primary-alt">عمومی</h6>
                </li>
                <!-- .nk-menu-item مشتریان-->
                <li class="nk-menu-item has-sub">
                    <a href="#" class="nk-menu-link nk-menu-toggle">
                        <span class="nk-menu-icon"><em class="icon ni ni-user-list"></em></span>
                        <span class="nk-menu-text">مشتریان</span>
                    </a>
                    <ul class="nk-menu-sub">
                        <li class="nk-menu-item">
                            <a href="{{ route('customers.list') }}" class="nk-menu-link"><span class="nk-menu-text">لیست مشتریان</span><span class="badge rounded-pill badge-dim bg-gray">{{ \App\Models\Customer::count() }}</span></a>
                        </li>
                        <li class="nk-menu-item">
                            <a href="{{ route('customers.create') }}" class="nk-menu-link"><span class="nk-menu-text">افزودن مشتری</span></a>
                        </li>
                    </ul>
                    <!-- .nk-menu-sub -->
                </li>
                <!-- .nk-menu-item محصولات -->
                <li class="nk-menu-item has-sub">
                    <a href="#" class="nk-menu-link nk-menu-toggle">
                        <span class="nk-menu-icon"><em class="icon ni ni-list-thumb-fill"></em></span>
                        <span class="nk-menu-text">محصولات</span>
                    </a>
                    <ul class="nk-menu-sub">
                        <li class="nk-menu-item">
                            <a href="{{ route('products.list') }}" class="nk-menu-link"><span class="nk-menu-text">لیست محصولات</span>
                                <span class="badge rounded-pill badge-dim bg-gray">{{ \App\Models\Product::count() }}</span></a>
                        </li>
                        <li class="nk-menu-item">
                            <a href="{{ route('products.create') }}" class="nk-menu-link"><span class="nk-menu-text">افزودن محصول</span></a>
                        </li>
                        <li class="nk-menu-item has-sub">
                            <a href="#" class="nk-menu-link nk-menu-toggle"><span class="nk-menu-text">دسته بندی ها</span></a>
                            <ul class="nk-menu-sub">
                                <li class="nk-menu-item">
                                    <a href="{{ route('products.categories.list') }}" class="nk-menu-link"><span class="nk-menu-text">لیست دسته بندی ها</span></a>
                                </li>
                                <li class="nk-menu-item">
                                    <a href="{{ route('products.categories.create') }}" class="nk-menu-link"><span class="nk-menu-text">افزودن دسته بندی</span></a>
                                </li>
                            </ul>
                            <!-- .nk-menu-sub -->
                        </li>
                    </ul>
                    <!-- .nk-menu-sub -->
                </li>
                <!-- .nk-menu-item خرید ها -->
                <li class="nk-menu-item has-sub">
                    <a href="#" class="nk-menu-link nk-menu-toggle">
                        <span class="nk-menu-icon"><em class="icon ni ni-view-list-fill"></em></span>
                        <span class="nk-menu-text">خرید ها</span>
                    </a>
                    <ul class="nk-menu-sub">
                        <li class="nk-menu-item">
                            <a href="{{ route('purchases.list') }}" class="nk-menu-link"><span class="nk-menu-text">لیست خرید ها</span></a>
                        </li>
                        <li class="nk-menu-item">
                            <a href="{{ route('purchases.create') }}" class="nk-menu-link"><span class="nk-menu-text">افزودن خرید</span></a>
                        </li>
                        <li class="nk-menu-item has-sub">
                            <a href="#" class="nk-menu-link nk-menu-toggle"><span class="nk-menu-text">دسته بندی ها</span></a>
                            <ul class="nk-menu-sub">
                                <li class="nk-menu-item">
                                    <a href="{{ route('purchases.categories.list') }}" class="nk-menu-link"><span class="nk-menu-text">لیست دسته بندی ها</span></a>
                                </li>
                                <li class="nk-menu-item">
                                    <a href="{{ route('purchases.categories.create') }}" class="nk-menu-link"><span class="nk-menu-text">افزودن دسته بندی</span></a>
                                </li>
                            </ul>
                            <!-- .nk-menu-sub -->
                        </li>
                    </ul>
                    <!-- .nk-menu-sub -->
                </li>
                <!-- .nk-menu-item فروشنده ها -->
                <li class="nk-menu-item has-sub">
                    <a href="#" class="nk-menu-link nk-menu-toggle">
                        <span class="nk-menu-icon"><em class="icon ni ni-user-list-fill"></em></span>
                        <span class="nk-menu-text">فروشندگان</span>
                    </a>
                    <ul class="nk-menu-sub">
                        <li class="nk-menu-item">
                            <a href="{{ route('purchases.sellers.list') }}" class="nk-menu-link"><span class="nk-menu-text">لیست فروشندگان</span><span class="badge rounded-pill badge-dim bg-gray">{{ \App\Models\Seller::where('deleted' , 0)->count() }}</span></a>
                        </li>
                        <li class="nk-menu-item">
                            <a href="{{ route('purchases.sellers.create') }}" class="nk-menu-link"><span class="nk-menu-text">افزودن فروشنده</span></a>
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
                            <a href="{{ route('transactions.general') }}" class="nk-menu-link"><span class="nk-menu-text">کلی</span></a>
                        </li>
                        <li class="nk-menu-item">
                            <a href="{{ route('transactions.inputs.index') }}" class="nk-menu-link"><span class="nk-menu-text">ورودی</span></a>
                        </li>
                        <li class="nk-menu-item">
                            <a href="{{ route('transactions.outputs.index') }}" class="nk-menu-link"><span class="nk-menu-text">خروجی</span></a>
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
                            <a href="{{ route('orders.list') }}" class="nk-menu-link"><span class="nk-menu-text">لیست فاکتورها</span></a>
                        </li>
                        <li class="nk-menu-item">
                            <a href="{{ route('orders.create') }}" class="nk-menu-link"><span class="nk-menu-text">افزودن فاکتور</span></a>
                        </li>
                        <li class="nk-menu-item has-sub">
                            <a href="#" class="nk-menu-link nk-menu-toggle"><span class="nk-menu-text">دسته های فروش</span></a>
                            <ul class="nk-menu-sub">
                                <li class="nk-menu-item">
                                    <a href="{{ route('orders.types.list') }}" class="nk-menu-link"><span class="nk-menu-text">لیست دسته بندی ها</span></a>
                                </li>
                                <li class="nk-menu-item">
                                    <a href="{{ route('orders.types.create') }}" class="nk-menu-link"><span class="nk-menu-text">افزودن دسته بندی</span></a>
                                </li>
                            </ul>
                            <!-- .nk-menu-sub -->
                        </li>
                        <li class="nk-menu-item has-sub">
                            <a href="#" class="nk-menu-link nk-menu-toggle"><span class="nk-menu-text">وضعیت های فاکتور</span></a>
                            <ul class="nk-menu-sub">
                                <li class="nk-menu-item">
                                    <a href="{{ route('orders.statuses.list') }}" class="nk-menu-link"><span class="nk-menu-text">لیست وضعیت ها</span></a>
                                </li>
                                <li class="nk-menu-item">
                                    <a href="{{ route('orders.statuses.create') }}" class="nk-menu-link"><span class="nk-menu-text">افزودن وضعیت</span></a>
                                </li>
                            </ul>
                            <!-- .nk-menu-sub -->
                        </li>
                    </ul>

                    <!-- .nk-menu-sub -->
                </li>
                <!-- .nk-menu-item شریک ها -->
                <li class="nk-menu-item has-sub">
                    <a href="#" class="nk-menu-link nk-menu-toggle">
                        <span class="nk-menu-icon"><em class="icon ni ni-users-fill"></em></span>
                        <span class="nk-menu-text">شریک ها</span>
                    </a>
                    <ul class="nk-menu-sub">
                        <li class="nk-menu-item">
                            <a href="{{ route('partners.list') }}" class="nk-menu-link"><span class="nk-menu-text">لیست شریک ها</span></a>
                        </li>
                        <li class="nk-menu-item">
                            <a href="{{ route('partners.create') }}" class="nk-menu-link"><span class="nk-menu-text">افزودن شریک</span></a>
                        </li>
                    </ul>
                    <!-- .nk-menu-sub -->
                </li>
                <!-- .nk-menu-item حساب های بانکی -->
                <li class="nk-menu-item has-sub">
                    <a href="#" class="nk-menu-link nk-menu-toggle">
                        <span class="nk-menu-icon"><em class="icon ni ni-cc-alt2"></em></span>
                        <span class="nk-menu-text">حساب های مالی</span>
                    </a>
                    <ul class="nk-menu-sub">
                        <li class="nk-menu-item">
                            <a href="{{ route('accounts.list') }}" class="nk-menu-link"><span class="nk-menu-text">لیست حساب ها</span></a>
                        </li>
                        <li class="nk-menu-item">
                            <a href="{{ route('accounts.create') }}" class="nk-menu-link"><span class="nk-menu-text">افزودن حساب</span></a>
                        </li>
                    </ul>
                    <!-- .nk-menu-sub -->
                </li>

                <!-- .nk-menu-item مدیریت -->
                <li class="nk-menu-heading">
                    <h6 class="overline-title text-primary-alt">مدیریت</h6>
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

                <!-- .nk-menu-item تنظیمات-->
                <li class="nk-menu-item has-sub">
                    <a href="#" class="nk-menu-link nk-menu-toggle">
                        <span class="nk-menu-icon"><em class="icon ni ni-setting-fill"></em></span>
                        <span class="nk-menu-text">تنظیمات</span>
                    </a>
                    <ul class="nk-menu-sub">
                        <li class="nk-menu-item has-sub">
                            <a href="#" class="nk-menu-link nk-menu-toggle"><span class="nk-menu-text">دسته بندی مشتریان</span></a>
                            <ul class="nk-menu-sub">
                                <li class="nk-menu-item">
                                    <a href="{{ route('customers.categories.create') }}" class="nk-menu-link"><span class="nk-menu-text">افزودن دسته بندی</span></a>
                                </li>
                                <li class="nk-menu-item">
                                    <a href="{{ route('customers.categories.list') }}" class="nk-menu-link"><span class="nk-menu-text">لیست دسته بندی ها</span></a>
                                </li>
                            </ul>

                            <!-- .nk-menu-sub -->
                        </li>
                        <li class="nk-menu-sub">
                            <li class="nk-menu-item has-sub">
                                <a href="#" class="nk-menu-link nk-menu-toggle"><span class="nk-menu-text">وضعیت های محصولات</span></a>
                                <ul class="nk-menu-sub">
                                    <li class="nk-menu-item">
                                        <a href="{{ route('products.statuses.create') }}" class="nk-menu-link"><span class="nk-menu-text">افزودن وضعیت</span></a>
                                    </li>
                                    <li class="nk-menu-item">
                                        <a href="{{ route('products.statuses.list') }}" class="nk-menu-link"><span class="nk-menu-text">لیست وضعیت ها</span></a>
                                    </li>
                                </ul>
                                <!-- .nk-menu-sub -->
                            </li>
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
