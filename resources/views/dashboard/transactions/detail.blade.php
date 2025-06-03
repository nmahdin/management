<x-admin.main title="جزئیات تراکنش">

    <div class="nk-content nk-content-fluid">
        <div class="container-xl wide-xl">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between g-3">
                        <div class="nk-block-head-content">
                            <h3 class="nk-block-title page-title">جزئیات تراکنش #{{ $transaction->id }}</h3>
                            <div class="nk-block-des text-soft">
                                <p>نمایش اطلاعات کامل تراکنش</p>
                            </div>
                        </div>
                        <div class="nk-block-head-content">
                            <div class="toggle-wrap nk-block-tools-toggle">
                                <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em
                                        class="icon ni ni-more-v"></em></a>
                                <div class="toggle-expand-content" data-content="pageMenu">
                                    <ul class="nk-block-tools g-3">
                                        <li>
                                            <a href="{{ route('transactions.edit', $transaction->id) }}"
                                               class="btn btn-primary btn-dim">
                                                <em class="icon ni ni-edit"></em>
                                                <span class="fw-normal">ویرایش تراکنش</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('transactions.general') }}" class="btn btn-secondary btn-dim">
                                                <em class="icon ni ni-arrow-left"></em>
                                                <span class="fw-normal">بازگشت به لیست</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <x-admin.templates.successAlert/>
                <x-admin.templates.warningAlert/>
                <x-admin.templates.dangerAlert/>

                <div class="nk-block">
                    <div class="row g-gs">

                        <div class="col-lg-4 col-xl-4 col-xxl-3">
                            <!-- Sidebar Start -->
                            <div class="card">
                                <div class="card-inner-group">
                                    <div class="card-inner">
                                        <div class="user-card user-card-s2">
                                            <div class="user-info">
                                                <div style="margin: -10px 0 30px 0;">
                                                    @if($transaction->type == 'input')
                                                        <div class="nk-tnx-type-icon bg-success-dim text-success">
                                                            <em class="icon ni ni-downward-ios"></em>
                                                        </div>
                                                    @elseif($transaction->type == 'output')
                                                        <div class="nk-tnx-type-icon bg-danger-dim text-danger">
                                                            <em class="icon ni ni-upword-ios"></em>
                                                        </div>
                                                    @endif
                                                </div>


                                                <h5>شناسه تراکنش: #{{ $transaction->id }}</h5>
                                            </div>
                                            <br>
                                            <div class="user-card-status">
                                                <div class="user-card-status-info">
                                                    <span class="sub-text">وضعیت:</span>
                                                    @if($transaction->status == 'paid')
                                                        <span class="badge badge-dim bg-success badge-md">پرداخت شده</span>
                                                    @elseif($transaction->status == 'unpaid')
                                                        <span class="badge badge-dim bg-danger badge-md">پرداخت نشده</span>
                                                    @else
                                                        <span class="badge badge-dim bg-light badge-md">نا مشخص</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-inner card-inner-sm">
                                        <ul class="btn-toolbar justify-center gx-1">
                                            <li>
                                                <a href="{{ route('transactions.edit', $transaction->id) }}"
                                                   class="btn btn-trigger btn-icon">
                                                    <em class="icon ni ni-edit"></em>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('transactions.delete', $transaction->id) }}"
                                                   onclick="event.preventDefault(); document.getElementById('delete_transaction{{$transaction->id}}').submit();"
                                                   class="btn btn-trigger btn-icon text-danger">
                                                    <em class="icon ni ni-trash"></em>
                                                </a>
                                            </li>
                                        </ul>
                                        <form id="delete_transaction{{$transaction->id}}" method="post"
                                              action="{{ route('transactions.delete', $transaction->id) }}" class="d-none">
                                            @csrf
                                            @method('delete')
                                        </form>
                                    </div>
                                    <div class="card-inner">
                                        <h6 class="overline-title mb-2">اطلاعات ثبت</h6>
                                        <div class="row g-3">
                                            <div class="col-12">
                                                <span class="sub-text">ثبت کننده:</span>
                                                <span class="lead-text">{{ $transaction->user->name ?? 'نامشخص' }}</span>
                                            </div>
                                            <div class="col-12">
                                                <span class="sub-text">تاریخ ثبت:</span>
                                                <span class="lead-text">{{ jdate($transaction->created_at)->format('Y/m/d') }}</span>
                                            </div>

                                            @if($transaction->updated_at && $transaction->updated_at != $transaction->created_at)
                                                <div class="col-12">
                                                    <span class="sub-text">آخرین بروزرسانی:</span>
                                                    <span class="lead-text">{{ jdate($transaction->updated_at)->format('Y/m/d') }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Sidebar End -->
                        </div>
                        <!-- Sidebar End -->

                        <!-- Main Content Start -->
                        <div class="col-lg-8 col-xl-8 col-xxl-9">
                            <div class="card">
                                <div class="card-inner">
                                    <div class="nk-block">
                                        <div class="nk-block-head">
                                            <h5 class="title">جزئیات تراکنش</h5>
{{--                                            <p>اطلاعات کامل تراکنش</p>--}}
                                        </div>


                                                <!-- Display more transaction details here -->
                                                <p>نوع تراکنش: {{ __("payment.$transaction->type") }}</p>
                                                <p>مبلغ: {{ number_format($transaction->amount) }} تومان</p>
                                                <p>تاریخ: {{ jdate($transaction->date)->format('Y/m/d') }}</p>
                                                <p>حساب: {{ $transaction->account->label ?? 'نامشخص' }}</p>
                                                <p>روش پرداخت: {{ $transaction->payment_way }}</p>
                                                <p>یادداشت‌ها: {{ $transaction->notes }}</p>


                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Main Content End -->

                    </div>
                </div>
            </div>
        </div>
    </div>

    @slot('script')
        <!-- Add custom scripts here -->
    @endslot
</x-admin.main>
