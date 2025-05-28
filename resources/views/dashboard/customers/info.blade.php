<x-admin.main title="جزئیات مشتری">

    <div class="nk-content nk-content-fluid">
        <div class="container-xl wide-xl">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <!--   --------------- title --------------     -->
                            <h3 class="nk-block-title page-title">جزئیات مشتری</h3>
                            <div class="nk-block-des text-soft">
                                <!--   --------------- توضیح صفحه --------------     -->
                                {{--                                <p></p>--}}
                            </div>
                        </div>
                        <!-- .nk-block-head-content -->
                        <div class="nk-block-head-content">
                            <div class="toggle-wrap nk-block-tools-toggle">
                                <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em
                                        class="icon ni ni-more-v"></em></a>
                                <div class="toggle-expand-content" data-content="pageMenu">
                                    <ul class="nk-block-tools g-3">
                                        <!--   --------------- links --------------     -->
                                        <li>
                                            <a href="{{ route('customers.list') }}"
                                               class="dropdown-toggle btn btn-dark btn-dim" data-bs-toggle="modal"
                                               data-bs-target="#modalList"
                                               onclick="event.preventDefault(); document.getElementById('form12').submit();">
                                                <em class="icon ni ni-forward-ios"></em>
                                                {{--                                                <em class="icon ni ni-plus"></em>--}}
                                                <span class="fw-medium">
                                                    لیست مشتریان
                                                </span>
                                            </a>
                                            <form id="form12" action="{{ route('customers.list') }}"
                                                  class="d-none"></form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- .nk-block-head-content -->
                    </div>
                    <!-- .nk-block-between -->
                </div>
                <!-- .nk-block-head -->

                <x-admin.templates.successAlert/>
                <x-admin.templates.warningAlert/>
                <x-admin.templates.dangerAlert/>

                @if(session('created'))
                    <div class="alert alert-fill alert-success alert-icon bg-success-dim text-success">
                        <em class="icon ni ni-check-circle"></em>
                        مشتری "{{session('created')}}" با موفقیت ایجاد شد.
                    </div>
                @endif
                @if(session('edited'))
                    <div class="alert alert-fill alert-success alert-icon bg-success-dim text-success">
                        <em class="icon ni ni-check-circle"></em>
                        مشتری "{{session('edited')}}" با موفقیت ویرایش شد.
                    </div>
                @endif
                <div class="nk-block">
                    <div class="row g-gs">
                        <div class="col-xl-4">
                            <div class="card">
                                <div class="card-inner-group">
                                    <div class="card-inner">
                                        <div class="user-card user-card-s2">
                                            <div class="user-avatar lg bg-primary">
                                                <img src="assets/images/avatar/b-sm.jpg" alt="">
                                            </div>
                                            <div class="user-info">
                                                <div class="badge bg-light rounded-pill ucap">
                                                    @if($customer->category_id == null)
                                                        بدون دسته بندی
                                                    @else
                                                        <span>{{$customer->category->category_name}}</span>
                                                    @endif</div>
                                                <h5>
                                                    @if($customer->gender == 'male')
                                                        آقای {{ $customer->name }}
                                                    @else
                                                        خانم {{ $customer->name }}
                                                    @endif
                                                </h5>
                                                {{--                                                <span class="sub-text">someone@email.com</span>--}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-inner card-inner-sm">
                                        <ul class="btn-toolbar justify-center gx-1">
                                            <li>
                                                <a href="{{ route('customers.edit' , ['customer' => $customer->id]) }}"
                                                   class="btn btn-trigger btn-icon" data-bs-toggle="tooltip"
                                                   data-bs-placement="top" title="ویرایش مشتری">
                                                    <em class="icon ni ni-edit-alt-fill"></em></a>
                                            </li>
                                            <li>
                                                <a href="{{ route('customers.delete' , ['customer' => $customer->id]) }}"
                                                   class="btn btn-trigger btn-icon" data-bs-toggle="tooltip"
                                                   data-bs-placement="top" title="حذف مشتری"
                                                   onclick="event.preventDefault(); document.getElementById('delete_cus{{$customer->id}}').submit();">
                                                    <em class="icon ni ni-trash-fill"></em></a>

                                                <form id="delete_cus{{$customer->id}}" method="post"
                                                      action="{{ route('customers.delete' , ['customer' => $customer->id]) }}"
                                                      class="d-none">@csrf @method('delete')</form>


                                            </li>
                                        </ul>
                                    </div>
                                    <div class="card-inner">
                                        <div class="row gy-3 justify-content-center text-center">
                                            <div class="col">
                                                <div class="profile-stats">
                                                    <span class="amount">{{ $customer->orders()->count() }}</span>
                                                    <span class="sub-text">سفارش</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- .card-inner -->
                                    <div class="card-inner">
                                        <h6 class="overline-title mb-2">مشخصات کوتاه</h6>
                                        <div class="row g-3">
                                            <div class="col-sm-6 col-md-4 col-xl-12">
                                                <span class="sub-text">شماره تماس :</span>
                                                <span>{{ $customer->number }}</span>
                                            </div>
                                            @if($customer->birthday)
                                                <div class="col-sm-6 col-md-4 col-xl-12">
                                                    <span class="sub-text">تاریخ تولد:</span>
                                                    <span>
                                                    {{ $customer->birthday }}
                                                </span>
                                                </div>
                                            @endif
                                            <div class="col-sm-6 col-md-4 col-xl-12">
                                                <span class="sub-text">نشانی صورتحساب:</span>
                                                <span>
                                                    @if($customer->address)
                                                        {{ $customer->address }}
                                                    @else
                                                        بدون آدرس ثبت شده
                                                    @endif
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- .card-inner -->
                                </div>
                            </div>
                        </div>

                        @php
                            $sum1 = $customer->orders->sum('amount');
                            $sum2 = $customer->transactions->sum('amount');
                            $sum = $sum1 - $sum2;
                        @endphp

                            <!-- .col -->
                        <div class="col-xl-8">
                            <div class="card">
                                <div class="card-inner">
                                    <div class="nk-block">

                                        <div class="d-flex justify-content-start  mb-3">
                                            <div class="m-2">
                                                <div class="overline-title-alt mb-2 mt-2">گردش مالی</div>
                                                <div class="profile-balance">
                                                    <div class="profile-balance-group gx-4">
                                                        <div class="profile-balance-sub">
                                                            <div class="profile-balance-amount">
                                                                <div class="number">{{ number_format($customer->transactions->sum('amount')) }} <small class="currency currency-usd">تومان</small></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @if($sum)
                                            <div class="m-2">
                                                <div class="overline-title-alt mb-2 mt-2">بدهکاری های مربوط به سفارشات</div>
                                                <div class="profile-balance">
                                                    <div class="profile-balance-group gx-4">
                                                        <div class="profile-balance-sub">
                                                            <div class="profile-balance-amount">
                                                                <div
                                                                    class="number  text-danger">{{ number_format($sum) }}
                                                                    <small class="currency currency-usd">تومان</small></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="col-3">

                                            </div>
                                            <div class="col-3">

                                            </div>
                                        </div>


                                    </div>
                                    <br>
                                    @if($customer->orders->count() > 0)
                                        <div class="nk-block">
                                            <h6 class="lead-text mb-3">سفارشات اخیر</h6>
                                            <div class="nk-tb-list nk-tb-ulist is-compact card">
                                                <div class="nk-tb-item nk-tb-head">
                                                    <div class="nk-tb-col">
                                                        <span class="sub-text">شناسه سفارش</span>
                                                    </div>
                                                    <div class="nk-tb-col tb-col-sm">
                                                        <span class="sub-text">دسته بندی فروش</span>
                                                    </div>
                                                    <div class="nk-tb-col tb-col-xxl">
                                                        <span class="sub-text">قیمت کل</span>
                                                    </div>
                                                    <div class="nk-tb-col">
                                                        <span class="sub-text">وضعیت</span>
                                                    </div>
                                                    <div class="nk-tb-col">
                                                        <span class="sub-text">تاریخ سفارش</span>
                                                    </div>
                                                </div>
                                                @foreach($customer->orders as $order)
                                                    <div class="nk-tb-item">
                                                        <div class="nk-tb-col">
                                                            <a href="{{ route('orders.detail' , $order->id) }}"><span class="fw-bold">#{{ $order->id }}</span></a>
                                                        </div>
                                                        <div class="nk-tb-col tb-col-sm">
                                                            <span class="tb-lead">{{ \App\Models\Type::find($order->type_id)->first()->label }}</span>
                                                        </div>
                                                        <div class="nk-tb-col tb-col-xxl fw-bolder">
                                                            <span class="amount">{{ number_format($order->amount) }} تومان</span>
                                                        </div>
                                                        <div class="nk-tb-col">
                                                            @if($order->status)
                                                                @if($order->status == 'completed')
                                                                    <span class="lead-text text-success fw-normal">
                                                            تکمیل شده
                                                        </span>
                                                                @elseif($order->status == 'unpaid')
                                                                    <span class="lead-text text-warning fw-normal">
                                                            پرداخت نشده
                                                        </span>
                                                                @elseif($order->status == 'paid')
                                                                    <span class="lead-text text-info fw-normal">
                                                            پرداخت شده
                                                        </span>

                                                                @elseif($order->status == 'canceled')
                                                                    <span class="lead-text text-danger fw-normal">
                                                            لغو شده
                                                        </span>

                                                                @else
                                                                    <span class="lead-text text-gray fw-normal">
                                                            {{ $order->status }}
                                                        </span>
                                                                @endif

                                                            @else
                                                                <span class="lead-text text-secondary fw-normal">نامشخص</span>
                                                            @endif
                                                        </div>
                                                        <div class="nk-tb-col">
                                                            <span class="sub-text">{{ jdate($order->date)->format('Y/m/d') }}</span>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <br>
                                            {{--                                        <div class="col-12 col-lg-6 col-xl-12">--}}
                                            {{--                                            <button class="h-100 w-100 bg-white border border-dashed round-xl p-4 d-flex align-items-center justify-content-center" data-bs-toggle="modal" data-bs-target="#add-card">--}}
                                            {{--                                                <span class="text-soft">افزودن سفارش جدید</span>--}}
                                            {{--                                            </button>--}}
                                            {{--                                        </div>--}}
                                        </div>
                                    @else
                                        <div class="alert alert-light alert-icon">
                                            <em class="icon ni ni-alert-circle"></em> هیچ سفارشی برای این مشتری وجود ندارد!
                                        </div>
                                    @endif

                                    @if($customer->transactions->count())
                                        <div class="nk-block mt-5">
                                            <div class="nk-block-head">
                                                <h5 class="title">پرداخت‌ها</h5>
                                                <p>لیست پرداخت‌های مرتبط با این سفارش</p>
                                            </div>
                                            <div class="card card-bordered">
                                                <div class="card-inner">
                                                    <div class="table-responsive">
                                                        <table class="table table-striped">
                                                            <thead>
                                                            <tr>
                                                                <th scope="col">#</th>
                                                                <th scope="col">مبلغ (تومان)</th>
                                                                <th scope="col">وضعیت</th>
                                                                <th scope="col">تاریخ</th>
                                                                <th scope="col">توضیحات</th>
                                                                <th scope="col">اقدام</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach($order->transactions as $index => $payment)
                                                                <tr>
                                                                    <th scope="row">{{ $index + 1 }}</th>
                                                                    <td>{{ number_format($payment->amount) }}</td>
                                                                    <td>
                                                                        @if($payment->status == 'paid')
                                                                            <span
                                                                                class="badge bg-success">پرداخت شده</span>

                                                                        @elseif($payment->status == 'unpaid')
                                                                            <span class="badge bg-danger">پرداخت نشده</span>
                                                                        @else
                                                                            <span class="badge bg-info">مشخص نشده</span>
                                                                        @endif

                                                                    </td>
                                                                    <td>{{ jdate($payment->date)->format('Y/m/d') }}</td>
                                                                    @if($payment->notes)
                                                                        <td>
                                                                            <button
                                                                                class="btn btn-sm btn-light btn-dim fw-normal"
                                                                                type="button" data-bs-toggle="collapse"
                                                                                data-bs-target="#collapsePayment{{ $index }}"
                                                                                aria-expanded="false"
                                                                                aria-controls="collapsePayment{{ $index }}">
                                                                                نمایش توضیحات
                                                                            </button>
                                                                        </td>
                                                                    @else
                                                                        <td></td>
                                                                    @endif
                                                                    <td>
                                                                        <span><a href="{{ route('payments.delete' , $payment->id) }}"
                                                                                 onclick="event.preventDefault(); document.getElementById('delete{{$payment->id}}').submit();"
                                                                                 class="btn btn-sm btn-danger btn-dim"><em class="icon ni ni-trash-fill"></em></a></span>
                                                                        <form id="delete{{$payment->id}}" action="{{ route('payments.delete' , $payment->id) }}" method="post"
                                                                              class="d-none">@csrf @method('Delete')</form>
                                                                        <span><a href="#" class="btn btn-sm btn-info btn-dim"><em class="icon ni ni-pen-fill"></em></a></span>
                                                                        @if($payment->status == 'unpaid')
                                                                            <span><a href="{{ route('payments.paid' , $payment->id) }}"
                                                                                     onclick="event.preventDefault(); document.getElementById('pay{{$payment->id}}').submit();"
                                                                                     class="btn btn-sm btn-success btn-dim"><em class="icon ni ni-check-thick"></em></a></span>
                                                                            <form id="pay{{$payment->id}}" action="{{ route('payments.paid' , $payment->id) }}" method="post"
                                                                                  class="d-none">@csrf @method('Put')</form>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                                <tr id="collapsePayment{{ $index }}" class="collapse">
                                                                    <td colspan="6"
                                                                        class="bg-lighter">{{ $payment->notes }}</td>
                                                                </tr>

                                                            @endforeach
                                                            </tbody>
                                                            <tfoot>
                                                            <tr>
                                                                <td colspan="2" class="text-end fw-bold">جمع
                                                                    پرداخت‌ها:
                                                                </td>
                                                                <td class="fw-bold">{{ number_format($order->transactions->sum('amount')) }}
                                                                    تومان
                                                                </td>
                                                                <td colspan="3"></td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2" class="text-end fw-bold">مانده:</td>
                                                                <td class="fw-bold {{ $order->amount - $order->transactions->sum('amount') > 0 ? 'text-danger' : 'text-success' }}">
                                                                    {{ number_format($order->amount - $order->transactions->sum('amount')) }}
                                                                    تومان
                                                                </td>
                                                                @if($order->amount - $order->transactions->sum('amount') > 0)
                                                                    <td colspan="3"><span
                                                                            class="d-flex justify-content-end">
                                                                            <a href="{{ route('payments.create' , ['order_id' => $order->id]) }}"
                                                                               class="btn btn-dim btn-outline-light fw-normal" STYLE="margin-left: 5px">افزودن پرداخت</a>
                                                                        </span>
                                                                    </td>
                                                                @else
                                                                    <td colspan="3">
                                                                    </td>
                                                                @endif

                                                            </tr>
                                                            </tfoot>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <br>
                                        <div class="alert alert-light alert-icon">
                                            <em class="icon ni ni-alert-circle"></em>
                                            <span><strong>هیچ پرداختی برای این مشتری
                                                ثبت نشده است.</strong></span>
                                            {{--                                            <br>--}}
                                            <span class="d-flex justify-content-end">
                                                <a href="{{ route('transactions.new' , ['type' => 'input']) }}"
                                                   class="btn btn-dim btn-outline-light fw-normal" STYLE="margin-left: 5px">افزودن پرداخت</a>

                                                @if($sum > 0)
                                                    <a href="{{ route('transactions.new' , ['type' => 'input' , 'amount' => $sum , 'info' => 'orders']) }}"
                                                       class="btn btn-dim btn-outline-secondary fw-normal"> پرداختن کامل بدهکاری های مربوط به سفارشات</a>
                                                @endif

                                            </span>

                                        </div>

                                    @endif

                                    <div class="nk-block">
                                        <h6 class="lead-text mb-3">راه های ارتباطی</h6>
                                        <div class="row g-3">
                                            <div class="col-12 col-lg-6 col-xl-12">
                                                <div class="card">
                                                    <div class="card-inner">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <ul class="preview-list g-2">
                                                                @if (! is_null($customer->com_ways))
                                                                    @php
                                                                        $way = json_decode($customer->com_ways);
                                                                    @endphp
                                                                    @if(in_array( 'phone' ,$way))
                                                                        <li class="preview-item">
                                                                            <div class="user-avatar sq md bg-white"
                                                                                 style="border-radius: 10px">
                                                                                <img
                                                                                    src="/assets/images/com_ways/phone.jpg"
                                                                                    alt="تماس">
                                                                            </div>
                                                                            <span
                                                                                class="badge rounded-pill badge-dim bg-dark"
                                                                                style="margin-right: -2px;">تماس تلفنی</span>
                                                                        </li>
                                                                    @endif
                                                                    @if(in_array( 'telegram' ,$way))
                                                                        <li class="preview-item">
                                                                            <div class="user-avatar sq md bg-white"
                                                                                 style="border-radius: 10px">
                                                                                <img
                                                                                    src="/assets/images/com_ways/telegram.jpg"
                                                                                    alt="تلگرام">
                                                                            </div>
                                                                            <span
                                                                                class="badge rounded-pill badge-dim bg-dark"
                                                                                style="margin-right: 8px;">تلگرام</span>
                                                                        </li>
                                                                    @endif
                                                                    @if(in_array( 'instagram' ,$way))
                                                                        <li class="preview-item">
                                                                            <div class="user-avatar sq md bg-white"
                                                                                 style="border-radius: 10px">
                                                                                <img
                                                                                    src="/assets/images/com_ways/instagram.jpg"
                                                                                    alt="اینستاگرام">
                                                                            </div>
                                                                            <span
                                                                                class="badge rounded-pill badge-dim bg-dark"
                                                                                style="margin-right: -1.5px;">اینستاگرام</span>
                                                                        </li>
                                                                    @endif
                                                                    @if(in_array( 'bale' ,$way))
                                                                        <li class="preview-item">
                                                                            <div class="user-avatar sq md bg-white"
                                                                                 style="border-radius: 10px">
                                                                                <img
                                                                                    src="/assets/images/com_ways/bale.jpg"
                                                                                    alt="بله">
                                                                            </div>
                                                                            <span
                                                                                class="badge rounded-pill badge-dim bg-dark"
                                                                                style="margin-right: 13px;">بله</span>
                                                                        </li>
                                                                    @endif
                                                                    @if(in_array( 'eitaa' ,$way))
                                                                        <li class="preview-item">
                                                                            <div class="user-avatar sq md bg-white"
                                                                                 style="border-radius: 10px">
                                                                                <img
                                                                                    src="/assets/images/com_ways/eitaa.jpg"
                                                                                    alt="ایتا">
                                                                            </div>
                                                                            <span
                                                                                class="badge rounded-pill badge-dim bg-dark"
                                                                                style="margin-right: 13px;">ایتا</span>
                                                                        </li>
                                                                    @endif
                                                                @else
                                                                    <span class="text-orange fs-13px">
                                                                        بدون راه ارتباطی!
                                                                    </span>

                                                                @endif

                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- .col -->

                                            <!-- .col -->
                                        </div>
                                        <!-- .row -->
                                    </div>
                                    @if (! is_null($customer->notes))
                                        <div class="nk-block">
                                            <h6 class="lead-text mb-3">توضحیات و یادداشت ها</h6>
                                            <div class="row g-3">
                                                <div class="col-12 col-lg-6 col-xl-12">
                                                    <div class="card-inner">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <ul class="preview-list g-2">
                                                                {{ $customer->notes }}
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- .col -->
                                                <!-- .col -->
                                            </div>
                                            <!-- .row -->
                                        </div>
                                    @endif

                                </div>
                                <!-- .card-inner -->
                            </div>
                            <!-- .card -->
                        </div>
                        <!-- .col -->
                    </div>
                    <!-- .row -->
                </div>

                <!-- .nk-block -->
            </div>
        </div>
    </div>
    <x-admin.modal id="modalList" class="modal-body-md">در حال رفتن به لیست مشتریان ...</x-admin.modal>
    <div class="modal fade zoom  modal-sm" tabindex="-1" id="modalZoom" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <span class="spinner-border text-gray" style="margin-bottom: -12px; font-size: 10px;" role="status">
                    </span>
                    <span class="m-2">
                        درحال بارگذاری ...
                    </span>
                </div>
            </div>
        </div>
    </div>
    @slot('script')
        <script src="/assets/js/libs/datatable-btns.js"></script>
    @endslot

</x-admin.main>


