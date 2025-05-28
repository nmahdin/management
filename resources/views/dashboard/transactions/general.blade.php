<x-admin.main title="لیست تراکنش ها">

    <div class="nk-content nk-content-fluid">
        <div class="container-xl wide-xl">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between g-3">
                        <div class="nk-block-head-content">
                            <h3 class="nk-block-title page-title">لیست تراکنش ها</h3>
                            <div class="nk-block-des text-soft">
                                {{--                                <p>شما در مجموع 12835 سفارش دارید.</p>--}}
                            </div>
                        </div>



                        <!-- .nk-block-head-content -->
                        <div class="nk-block-head-content">
                            <div class="toggle-wrap nk-block-tools-toggle">
                                <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-menu-alt-r"></em></a>
                                <div class="toggle-expand-content" data-content="pageMenu">
                                    <ul class="nk-block-tools g-3">
                                        <li>
                                            <a href="#" class="btn btn-white btn-dim btn-outline-light"><em class="icon ni ni-download-cloud"></em><span>خروجی گرفتن</span></a>
                                        </li>
                                        <li class="nk-block-tools-opt">
                                            <div class="drodown">
                                                <a href="#" class="dropdown-toggle btn btn-icon btn-primary" data-bs-toggle="dropdown"><em class="icon ni ni-plus"></em></a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <ul class="link-list-opt no-bdr">
                                                        <li>
                                                            <a href="#"><span>افزودن تراکنش</span></a>
                                                        </li>
                                                        <li>
                                                            <a href="#"><span>افزودن واریزی</span></a>
                                                        </li>
                                                        <li>
                                                            <a href="#"><span>افزودن برداشت</span></a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- .nk-block-head-content -->
                    </div>
                    <!-- .nk-block-between -->
                </div>

                <x-admin.templates.successAlert/>
                <x-admin.templates.warningAlert/>
                <x-admin.templates.dangerAlert/>

                <!-- .nk-block-head -->
                <div class="nk-block">
                    <div class="card card-stretch">
                        <div class="card-inner-group">
                            <div class="card-inner">
                                <div class="card-title-group">
                                    <div class="card-title">
                                        <h5 class="title">همه سفارشات</h5>
                                    </div>
                                    <div class="card-tools me-n1">
                                        <ul class="btn-toolbar gx-1">
                                            <li>
                                                <a href="#" class="search-toggle toggle-search btn btn-icon" data-target="search"><em class="icon ni ni-search"></em></a>
                                            </li>
                                            <!-- li -->
                                            <li class="btn-toolbar-sep"></li>
                                            <!-- li -->
                                            <li>
                                                <div class="dropdown">
                                                    <a href="#" class="btn btn-trigger btn-icon dropdown-toggle" data-bs-toggle="dropdown">
                                                        @php
                                                            $filters = request()->query();
                                                            $filteredCount = collect($filters)->filter(function($value) {
                                                                return !empty($value);
                                                            })->count();
                                                        @endphp

                                                        <div class="badge badge-circle bg-primary">{{ $filteredCount }}</div>
                                                        <em class="icon ni ni-filter-alt"></em>
                                                    </a>
                                                    <div class="filter-wg dropdown-menu dropdown-menu-xl dropdown-menu-end">
                                                        <form method="GET" action="{{ route('transactions.general') }}">
                                                        <div class="dropdown-head">
                                                            <span class="sub-title dropdown-title">فیلتر پیشرفته</span>
                                                            <div class="dropdown">
                                                                <a href="#" class="link link-light">
                                                                    <em class="icon ni ni-more-h"></em>
                                                                </a>
                                                            </div>
                                                        </div>

                                                            <input type="hidden" name="per_page" value="{{ request('per_page', 20) }}">
                                                            <input type="hidden" name="sort" value="{{ request('sort', 'desc') }}">

                                                        <div class="dropdown-body dropdown-body-rg">
                                                            <div class="row gx-7 gy-4">
                                                                <!-- نوع -->
                                                                <div class="col-6">
                                                                    <div class="form-group">
                                                                        <label class="overline-title overline-title-alt">نوع</label>
                                                                        <div class="form-check">
                                                                            <input type="radio" class="form-check-input" name="type" id="type_input" value="input" @checked(request()->query('type') == 'input')>
                                                                            <label class="form-check-label" for="type_input">ورودی</label>
                                                                        </div>
                                                                        <div class="form-check">
                                                                            <input type="radio" class="form-check-input" name="type" id="type_output" value="output" @checked(request()->query('type') == 'output')>
                                                                            <label class="form-check-label" for="type_output">خروجی</label>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <!-- وضعیت -->
                                                                <div class="col-6">
                                                                    <div class="form-group">
                                                                        <label class="overline-title overline-title-alt">وضعیت</label>
                                                                        <div class="form-check">
                                                                            <input type="radio" class="form-check-input" name="status" id="status_paid" value="paid" @checked(request()->query('status') == 'paid')>
                                                                            <label class="form-check-label" for="status_paid">پرداخت شده</label>
                                                                        </div>
                                                                        <div class="form-check">
                                                                            <input type="radio" class="form-check-input" name="status" id="status_unpaid" value="unpaid" @checked(request()->query('status') == 'unpaid')>
                                                                            <label class="form-check-label" for="status_unpaid">پرداخت نشده</label>
                                                                        </div>
                                                                    </div>
                                                                </div>


                                                                @php
                                                                $Accounts = \App\Models\Accounts::all();
                                                                    @endphp
                                                                <!-- حساب مقصد -->
                                                                <div class="col-6">
                                                                    <div class="form-group">
                                                                        <label class="overline-title overline-title-alt">حساب مقصد</label>
                                                                        <select class="form-select js-select2" name="account">
                                                                            {{-- گزینه "همه حساب‌ها" --}}
                                                                            <option value="any" @selected(request()->query('account') == 'any')>همه حساب‌ها</option>

                                                                            {{--  حساب‌ها از دیتابیس می‌آیند --}}
                                                                             @foreach($Accounts as $Account)
                                                                                <option value="{{ $Account->id }}" @selected(request()->query('account') == $Account->id)>{{ $Account->label }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <!-- روش پرداخت -->
                                                                <div class="col-6">
                                                                    <div class="form-group">
                                                                        <label class="overline-title overline-title-alt">روش</label>
                                                                        <select class="form-select js-select2" name="payment_method">
                                                                            <option value="any" @selected(request()->query('payment_method') == 'any')>همه روش‌ها</option>
                                                                            <option value="card" @selected(request()->query('payment_method') == 'card')>کارت به کارت</option>
                                                                            <option value="cash" @selected(request()->query('payment_method') == 'cash')>نقدی</option>
                                                                            <option value="online" @selected(request()->query('payment_method') == 'online')>درگاه پرداخت</option>
                                                                            <option value="pos" @selected(request()->query('payment_method') == 'pos')>دستگاه پز</option>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <!-- مبلغ -->
                                                                <div class="col-12">
                                                                    <div class="form-group">
                                                                        <label class="overline-title overline-title-alt">مبلغ</label>
                                                                        <div class="d-flex">
                                                                            <input type="number" class="form-control" name="amount_from" placeholder="از مبلغ">
                                                                            <span class="mx-2">تا</span>
                                                                            <input type="number" class="form-control" name="amount_to" placeholder="تا مبلغ">
                                                                        </div>
                                                                    </div>
                                                                </div>


                                                                <!-- تاریخ -->
                                                                <div class="col-6">
                                                                    <div class="form-group">
                                                                        <label class="overline-title overline-title-alt">تاریخ</label>
                                                                        <div class="d-flex">
                                                                            <input type="date" class="form-control" name="date_from" placeholder="از تاریخ">
                                                                            <span class="mx-2">تا</span>
                                                                            <input type="date" class="form-control" name="date_to" placeholder="تا تاریخ">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <br>


                                                                <!-- حذف شده‌ها -->
                                                                <div class="col-8">
                                                                    <div class="form-group">
                                                                        <div class="custom-control custom-control-sm custom-checkbox">
                                                                            <input type="checkbox" class="custom-control-input" id="includeDel" name="include_deleted">
                                                                            <label class="custom-control-label" for="includeDel">از جمله حذف شده‌ها</label>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <!-- دکمه فیلتر -->
                                                                <div class="col-12">
                                                                    <div class="form-group">

                                                                        <!-- فیلترها و ورودی‌ها -->
                                                                        <button type="submit" class="btn btn-secondary">فیلتر</button>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="dropdown-foot between">
                                                            <a href="{{ route('transactions.general') }}" class="btn btn-link">بازنشانی فیلتر</a>
                                                        </div>
                                                        </form>
                                                    </div>

                                                    <!-- .filter-wg -->
                                                </div>
                                                <!-- .dropdown -->
                                            </li>
                                            <!-- li -->
                                            <li>
                                                <div class="dropdown">
                                                    <a href="#" class="btn btn-trigger btn-icon dropdown-toggle" data-bs-toggle="dropdown">
                                                        <em class="icon ni ni-setting"></em>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-xs dropdown-menu-end">
                                                        <!-- تعداد نمایش -->
                                                        <ul class="link-check">
                                                            <li><span>نمایش</span></li>
                                                            <li class="{{ $perPage == 10 ? 'active' : '' }}">
                                                                <a href="{{ request()->fullUrlWithQuery(['per_page' => 10]) }}">10</a>
                                                            </li>
                                                            <li class="{{ $perPage == 20 ? 'active' : '' }}">
                                                                <a href="{{ request()->fullUrlWithQuery(['per_page' => 20]) }}">20</a>
                                                            </li>
                                                            <li class="{{ $perPage == 50 ? 'active' : '' }}">
                                                                <a href="{{ request()->fullUrlWithQuery(['per_page' => 50]) }}">50</a>
                                                            </li>
                                                        </ul>

                                                        <!-- مرتب‌سازی -->
                                                        <ul class="link-check">
                                                            <li><span>مرتب سازی</span></li>
                                                            <li class="{{ $sort == 'desc' ? 'active' : '' }}">
                                                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'desc']) }}">نزولی</a>
                                                            </li>
                                                            <li class="{{ $sort == 'asc' ? 'active' : '' }}">
                                                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'asc']) }}">صعودی</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>


                                                <!-- .dropdown -->
                                            </li>
                                            <!-- li -->
                                        </ul>
                                        <!-- .btn-toolbar -->
                                    </div>
                                    <!-- .card-tools -->
                                    <div class="card-search search-wrap" data-search="search">
                                        <div class="search-content">
                                            <a href="#" class="search-back btn btn-icon toggle-search" data-target="search"><em class="icon ni ni-arrow-left"></em></a>
                                            <input type="text" class="form-control border-transparent form-focus-none" placeholder="جستجوی سریع بر اساس تراکنش"/>
                                            <button class="search-submit btn btn-icon"><em class="icon ni ni-search"></em></button>
                                        </div>
                                    </div>
                                    <!-- .card-search -->
                                </div>
                                <!-- .card-title-group -->
                            </div>
                            <!-- .card-inner -->
                            <div class="card-inner p-0">
                                <div class="nk-tb-list nk-tb-tnx">
                                    <div class="nk-tb-item nk-tb-head">
                                        <div class="nk-tb-col"><span>جزئیات</span></div>
                                        <div class="nk-tb-col tb-col-xxl"><span>حساب بانکی</span></div>
                                        <div class="nk-tb-col tb-col-lg"><span>مربوط به ...</span></div>
                                        <div class="nk-tb-col text-end"><span>مقدار</span></div>
                                        <div class="nk-tb-col text-end tb-col-sm"><span>تاریخ</span></div>
                                        <div class="nk-tb-col nk-tb-col-status"><span class="sub-text d-none d-md-block">وضعیت</span></div>
                                        <div class="nk-tb-col nk-tb-col-tools"></div>
                                    </div>
                                    @foreach($transactions as $transaction)
                                        <!-- .nk-tb-item -->
                                        <div class="nk-tb-item">
                                            <div class="nk-tb-col">
                                                <div class="nk-tnx-type">

                                                    @if($transaction->type == 'input')
                                                        <div class="nk-tnx-type-icon bg-success-dim text-success">
                                                            <em class="icon ni ni-downward-ios"></em>
                                                        </div>
                                                    @elseif($transaction->type == 'output')
                                                        <div class="nk-tnx-type-icon bg-danger-dim text-danger">
                                                            <em class="icon ni ni-upword-ios"></em>
                                                        </div>
                                                    @endif


                                                    <div class="nk-tnx-type-text">
                                                        <span class="tb-lead">{{ $transaction->name }}</span>
{{--                                                        <span class="text-sm">({{ jdate($transaction->date)->ago() }})</span>--}}
                                                        <span class="tb-date">{{ jdate($transaction->date)->ago() }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="nk-tb-col tb-col-xxl">
                                                <span class="tb-lead-sub">{{ $transaction->account->label }}</span>
                                                <span class="tb-sub">{{ __('payment.'. $transaction->payment_way) }}</span>
                                            </div>
                                            <div class="nk-tb-col tb-col-lg">
                                                <span class="tb-lead-sub"><a
                                                        href="{{ route("$transaction->source_type.detail" , $transaction->source_id) }}">{{ __('payment.' . $transaction->source_type) . ' ' . "#$transaction->source_id"}}</a></span>

                                            </div>
                                            <div class="nk-tb-col text-end tb-col-sm">
                                                <span class="tb-amount">{{ number_format($transaction->amount) .' ' }}<span>تومان</span></span>
                                                {{--                                                <span class="tb-amount-sm">1,012,900,000 تومان</span>--}}
                                            </div>
                                            <div class="nk-tb-col text-end">
                                                <span class="tb-amount">{{ jdate($transaction->date)->format('Y/m/d') }}</span>
                                                <span class="tb-amount-sm">{{ jdate($transaction->date)->format('%B') }}</span>
                                            </div>
                                            <div class="nk-tb-col nk-tb-col-status">
                                                @if($transaction->status == 'paid')
                                                    <span class="badge badge-sm  bg-success d-none d-md-inline-flex">پرداخت شده</span>
                                                @elseif($transaction->status == 'unpaid')
                                                    <span class="badge badge-sm  bg-danger d-none d-md-inline-flex">پرداخت نشده</span>
                                                @endif

                                            </div>
                                            <div class="nk-tb-col nk-tb-col-tools">
                                                <ul class="nk-tb-actions gx-2">
                                                    <li class="nk-tb-action-hidden">
                                                        <a href="#tranxDetails" data-bs-toggle="modal" class="bg-white btn btn-sm btn-outline-light btn-icon btn-tooltip" title="جزئیات"><em
                                                                class="icon ni ni-eye"></em></a>
                                                    </li>
                                                    <li class="nk-tb-action-hidden">
                                                        <a href="#" title="ویرایش"
                                                           class="bg-white btn btn-sm btn-outline-light btn-icon btn-tooltip"><em class="icon ni ni-pen"></em></a>
                                                    </li>
                                                    <li class="nk-tb-action-hidden">
                                                        <a title="حذف"
                                                           class="bg-white btn btn-sm btn-outline-light btn-icon btn-tooltip"
                                                           onclick="event.preventDefault(); document.getElementById('delete_transaction{{$transaction->id}}').submit();"
                                                           href="{{ route('transactions.delete' , $transaction->id) }}"><em class="icon ni ni-trash-empty"></em></a>
                                                        <form id="delete_transaction{{$transaction->id}}" method="post"
                                                              action="{{ route('transactions.delete', $transaction->id) }}" class="d-none">
                                                            @csrf
                                                            @method('delete')
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                                <!-- .nk-tb-list -->
                            </div>

                            {!! $transactions->links('vendor.pagination.dashboard') !!}

                            <!-- .card-inner -->
                        </div>
                        <!-- .card-inner-group -->
                    </div>
                    <!-- .card -->
                </div>
                <!-- .nk-block -->
            </div>
        </div>
    </div>

</x-admin.main>
