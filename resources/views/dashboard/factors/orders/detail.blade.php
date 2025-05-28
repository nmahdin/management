<x-admin.main title="جزئیات سفارش">

    <div class="nk-content nk-content-fluid">
        <div class="container-xl wide-xl">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between g-3">
                        <div class="nk-block-head-content">
                            <h3 class="nk-block-title page-title">جزئیات سفارش #{{ $order->id }}</h3>
                            <div class="nk-block-des text-soft">
                                <p>{{ $order->title }}</p>
                            </div>
                        </div>
                        <div class="nk-block-head-content">
                            <div class="toggle-wrap nk-block-tools-toggle">
                                <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em
                                        class="icon ni ni-more-v"></em></a>
                                <div class="toggle-expand-content" data-content="pageMenu">
                                    <ul class="nk-block-tools g-3">
                                        <li>
                                            <a href="{{ route('orders.edit', $order->id) }}"
                                               class="btn btn-primary btn-dim">
                                                <em class="icon ni ni-edit"></em>
                                                <span class="fw-normal">ویرایش سفارش</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('orders.list') }}" class="btn btn-secondary btn-dim">
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
                                                <div
                                                    class="badge bg-lighter text-gray rounded-pill">{{ $order->type->label ?? 'نامشخص' }}</div>
                                                <h5>شماره سفارش: #{{ $order->id }}</h5>
                                                {{--                                                <span class="sub-text">شماره سفارش: #{{ $order->id }}</span>--}}
                                            </div>
                                            <br>
                                            <div class="user-card-status">
                                                <div class="user-card-status-info">
                                                    @if($order->status)
                                                        @if($order->status == 'completed')
                                                            <span
                                                                class="badge badge-lg rounded-pill badge-dim bg-success">
                                                            تکمیل شده
                                                        </span>
                                                        @elseif($order->status == 'uncompleted')
                                                            <span
                                                                class="badge badge-lg rounded-pill badge-dim bg-warning">
                                                            تکمیل نشده
                                                        </span>
                                                        @elseif($order->status == 'pre_order')
                                                            <span
                                                                class="badge badge-lg rounded-pill badge-dim bg-primary">
                                                            پیش سفارش
                                                        </span>
                                                        @elseif($order->status == 'waiting')
                                                            <span
                                                                class="badge badge-lg rounded-pill badge-dim bg-warning">
                                                            در انتظار
                                                        </span>
                                                        @elseif($order->status == 'unpaid')
                                                            <span
                                                                class="badge badge-lg rounded-pill badge-dim bg-danger">
                                                            پرداخت نشده
                                                        </span>
                                                        @elseif($order->status == 'paid')
                                                            <span class="badge badge-lg rounded-pill bg-info badge-dim">
                                                            پرداخت شده
                                                        </span>

                                                        @elseif($order->status == 'canceled')
                                                            <span class="badge badge-lg rounded-pill badge-dim bg-dark">
                                                            لغو شده
                                                        </span>

                                                        @else
                                                            <span class="badge rounded-pill badge-dim bg-lighter">
                                                            {{ $order->status }}
                                                        </span>
                                                        @endif

                                                    @else
                                                        <span class="badge rounded-pill bg-lighter">نامشخص</span>
                                                    @endif
                                                    <br>
                                                    <div class="dropdown" style="margin-top: 20px">
                                                        <button
                                                            class="btn btn-secondary btn-sm dropdown-toggle fw-normal"
                                                            type="button" id="statusDropdown" data-bs-toggle="dropdown"
                                                            aria-expanded="false">
                                                            تغییر وضعیت
                                                        </button>
                                                        <ul class="dropdown-menu" aria-labelledby="statusDropdown">
                                                            <li><a class="dropdown-item" href="#"
                                                                   onclick="event.preventDefault(); document.getElementById('status_completed').submit();">تکمیل
                                                                    شده</a></li>
                                                            <li><a class="dropdown-item" href="#"
                                                                   onclick="event.preventDefault(); document.getElementById('status_uncompleted').submit();">تکمیل
                                                                    نشده</a></li>
                                                            <li><a class="dropdown-item" href="#"
                                                                   onclick="event.preventDefault(); document.getElementById('status_pre_order').submit();">پیش
                                                                    سفارش</a></li>
                                                            <li><a class="dropdown-item" href="#"
                                                                   onclick="event.preventDefault(); document.getElementById('status_waiting').submit();">در
                                                                    انتظار</a></li>
                                                            <li><a class="dropdown-item" href="#"
                                                                   onclick="event.preventDefault(); document.getElementById('status_unpaid').submit();">پرداخت
                                                                    نشده</a></li>
                                                            <li><a class="dropdown-item" href="#"
                                                                   onclick="event.preventDefault(); document.getElementById('status_paid').submit();">پرداخت
                                                                    شده</a></li>
                                                            <li><a class="dropdown-item" href="#"
                                                                   onclick="event.preventDefault(); document.getElementById('status_canceled').submit();">لغو
                                                                    شده</a></li>
                                                        </ul>
                                                    </div>

                                                    <form id="status_completed" method="post"
                                                          action="{{ route('orders.updateStatus', ['order' => $order->id, 'status' => 'completed']) }}"
                                                          class="d-none">
                                                        @csrf
                                                        @method('patch')
                                                    </form>
                                                    <form id="status_uncompleted" method="post"
                                                          action="{{ route('orders.updateStatus', ['order' => $order->id, 'status' => 'uncompleted']) }}"
                                                          class="d-none">
                                                        @csrf
                                                        @method('patch')
                                                    </form>
                                                    <form id="status_pre_order" method="post"
                                                          action="{{ route('orders.updateStatus', ['order' => $order->id, 'status' => 'pre_order']) }}"
                                                          class="d-none">
                                                        @csrf
                                                        @method('patch')
                                                    </form>
                                                    <form id="status_waiting" method="post"
                                                          action="{{ route('orders.updateStatus', ['order' => $order->id, 'status' => 'waiting']) }}"
                                                          class="d-none">
                                                        @csrf
                                                        @method('patch')
                                                    </form>
                                                    <form id="status_unpaid" method="post"
                                                          action="{{ route('orders.updateStatus', ['order' => $order->id, 'status' => 'unpaid']) }}"
                                                          class="d-none">
                                                        @csrf
                                                        @method('patch')
                                                    </form>
                                                    <form id="status_paid" method="post"
                                                          action="{{ route('orders.updateStatus', ['order' => $order->id, 'status' => 'paid']) }}"
                                                          class="d-none">
                                                        @csrf
                                                        @method('patch')
                                                    </form>
                                                    <form id="status_canceled" method="post"
                                                          action="{{ route('orders.updateStatus', ['order' => $order->id, 'status' => 'canceled']) }}"
                                                          class="d-none">
                                                        @csrf
                                                        @method('patch')
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-inner card-inner-sm">
                                        <ul class="btn-toolbar justify-center gx-1">
                                            <li>
                                                <a href="{{ route('orders.edit', $order->id) }}"
                                                   class="btn btn-trigger btn-icon">
                                                    <em class="icon ni ni-edit"></em>
                                                </a>
                                            </li>
                                            {{-- print --}}
                                            <li>
                                                {{-- دکمه پرینت به صفحه جدید هدایت می‌شود --}}
                                                <a href="{{ route('orders.print', $order->id) }}" target="_blank" class="btn btn-trigger btn-icon">
                                                    <em class="icon ni ni-printer"></em>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('orders.delete', $order->id) }}"
                                                   onclick="event.preventDefault(); document.getElementById('delete_order{{$order->id}}').submit();"
                                                   class="btn btn-trigger btn-icon text-danger">
                                                    <em class="icon ni ni-trash"></em>
                                                </a>
                                            </li>
                                        </ul>
                                        <form id="delete_order{{$order->id}}" method="post"
                                              action="{{ route('orders.delete', $order->id) }}" class="d-none">
                                            @csrf
                                            @method('delete')
                                        </form>
                                    </div>
                                    <div class="card-inner">
                                        <div class="row text-center">
                                            <div class="col-6">
                                                <div class="profile-stats">
                                                    <span class="amount">{{ number_format($order->amount) }}</span>
                                                    <span class="sub-text">تومان</span>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="profile-stats">
                                                    <span class="amount">{{ $order->products->count() }}</span>
                                                    <span class="sub-text">محصول</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-inner">
                                        <h6 class="overline-title mb-2">اطلاعات مشتری</h6>
                                        <div class="row g-3">
                                            <div class="col-12">
                                                <span class="sub-text">نام مشتری:</span>
                                                <span class="lead-text">
                                                     @if($order->customer)
                                                        <a href="{{ route('customers.info' , $order->customer->id) }}"
                                                           class="text-primary">
                                                            {{ $order->customer->name }}
                                                        </a>
                                                    @else
                                                        <span class="text-muted">نامشخص</span>
                                                    @endif
                                                </span>
                                            </div>
                                            <div class="col-12">
                                                <span class="sub-text">شماره تماس:</span>
                                                <span class="lead-text">{{ $order->customer->number ?? 'ندارد' }}</span>
                                            </div>
                                            <div class="col-12">
                                                <span class="sub-text">آدرس:</span>
                                                <span
                                                    class="lead-text">{{ $order->customer->address ?? 'ندارد' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-inner">
                                        <h6 class="overline-title mb-2">اطلاعات ثبت</h6>
                                        <div class="row g-3">
                                            <div class="col-12">
                                                <span class="sub-text">ثبت کننده:</span>
                                                <span class="lead-text">{{ $order->user->name ?? 'نامشخص' }}</span>
                                            </div>
                                            <div class="col-12">
                                                <span class="sub-text">تاریخ سفارش:</span>
                                                <span
                                                    class="lead-text">{{ jdate($order->date)->format('Y/m/d') }}</span>
                                            </div>
                                            <div class="col-12">
                                                <span class="sub-text">تاریخ ثبت:</span>
                                                <span
                                                    class="lead-text">{{ jdate($order->created_at)->format('Y/m/d') }}</span>
                                            </div>

                                            @if($order->updated_at && $order->updated_at != $order->created_at)
                                                <div class="col-12">
                                                    <span class="sub-text">آخرین بروزرسانی:</span>
                                                    <span
                                                        class="lead-text">{{ jdate($order->updated_at)->format('Y/m/d') }}</span>
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
                                            <h5 class="title">محصولات سفارش</h5>
                                            <p>لیست محصولات موجود در این سفارش</p>
                                        </div>
                                        <div class="card card-bordered">
                                            <div class="card-inner">
                                                <div class="table-responsive">
                                                    <table class="table table-striped">
                                                        <thead>
                                                        <tr>
                                                            <th scope="col">#</th>
                                                            <th scope="col">نام محصول</th>
                                                            <th scope="col">تعداد</th>
                                                            <th scope="col">قیمت واحد (تومان)</th>
                                                            <th scope="col">قیمت کل (تومان)</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>

                                                        @foreach($order->products as $index => $item)
                                                            <tr>
                                                                {{--                                                                {{ dd($order->products) }}--}}
                                                                <th scope="row">{{ $index + 1 }}</th>
                                                                <td>
                                                                    @if(\App\Models\Product::find($item->id))
                                                                        <a href="{{ route('products.detail', $item->id) }}"
                                                                           class="text-primary">
                                                                            {{ $item->name }}
                                                                        </a>
                                                                    @else
                                                                        <span class="text-muted">محصول حذف شده</span>
                                                                    @endif
                                                                </td>
                                                                <td>{{ $item->pivot->quantity }}</td>
                                                                <td>{{ number_format($item->pivot->unit_price ) }}</td>
                                                                <td>{{ number_format($item->pivot->total_price) }}</td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                        <tfoot>
                                                        <tr>
                                                            <td colspan="4" class="text-end fw-bold">جمع کل:</td>
                                                            <td class="fw-bold bg-secondary-dim"
                                                                style="border-radius: 7px">{{ number_format($order->amount) }}
                                                                تومان
                                                            </td>

                                                        </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    @if($order->note)
                                        <div class="nk-block mt-5">
                                            <div class="nk-block-head">
                                                <h5 class="title">توضیحات سفارش</h5>
                                            </div>
                                            <div class="card card-bordered">
                                                <div class="card-inner">
                                                    <p>{{ $order->note }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endif



                                    @if($order->transactions->count())
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
                                                                            <span  class="badge bg-danger">پرداخت نشده</span>
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
                                                                            <a
                                                                                href="{{ route('payments.create' , ['order_id' => $order->id , 'amount' => $order->amount - $order->transactions->sum('amount')]) }}"
                                                                                class="btn btn-dim btn-outline-warning fw-medium">پرداختن مبلغ باقی مانده</a></span>
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
                                            <span><strong>هیچ پرداختی برای این سفارش
                                                ثبت نشده است.</strong></span>
                                            {{--                                            <br>--}}
                                            <span class="d-flex justify-content-end">
                                                <a href="{{ route('payments.create' , ['order_id' => $order->id]) }}"
                                                   class="btn btn-dim btn-outline-light fw-normal" STYLE="margin-left: 5px">افزودن پرداخت</a>
                                            <a href="{{ route('payments.create' , ['order_id' => $order->id , 'amount' => $order->amount]) }}"
                                               class="btn btn-dim btn-outline-light fw-normal"> پرداختن کل مبلغ</a>
                                            </span>

                                        </div>

                                    @endif


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
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const printButton = document.getElementById('printInvoiceBtn');

                    if (printButton) {
                        printButton.addEventListener('click', function(event) {
                            event.preventDefault(); // جلوگیری از رفتار پیش‌فرض لینک
                            window.print();
                        });
                    }
                });
            </script>
    @endslot
</x-admin.main>
