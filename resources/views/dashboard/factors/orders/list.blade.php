<x-admin.main title="لیست سفارشات">

    <div class="nk-content nk-content-fluid">
        <div class="container-xl wide-xl">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <!--   --------------- title --------------     -->
                            <h3 class="nk-block-title page-title">لیست سفارشات</h3>
                            <div class="nk-block-des text-soft">
                                <!--   --------------- توضیح صفحه --------------     -->
                                @if($n !== 0)
                                    <p>در مجموع {{ $n }} سفارش ثبت شده است.</p>
                                @endif
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
                                            <a href="{{ route('products.list') }}"
                                               class="btn btn-primary">
                                                <em class="icon ni ni-plus"></em>
                                                <span class="fw-normal">
                                                    ثبت سفارش جدید
                                                </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('orders.trash') }}"
                                               class="btn btn-danger btn-dim">
                                                <em class="icon ni ni-trash"></em>
                                                <span class="fw-normal">
                                                    سطل زباله
                                                </span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- .nk-block-head-content -->
                    </div>
                    <!-- .nk-block-between -->
                </div>
                @if(session('deleted'))
                    <div class="alert alert-fill alert-success alert-icon bg-success-dim text-success">
                        <em class="icon ni ni-check-circle"></em>
                        سفارش "{{session('deleted')}}" با موفقیت به
                        <a href="{{ route('orders.trash') }}" class="text-success">
                            <u>سطل زباله</u>
                        </a>
                        منتقل شد.
                    </div>
                @endif

                <x-admin.templates.successAlert/>
                <x-admin.templates.warningAlert/>
                <x-admin.templates.dangerAlert/>

                <!-- .nk-block-head -->
                @if($n == 0)
                    <div class="alert alert-fill alert-light alert-icon">
                        <em class="icon ni ni-alert-circle"></em>
                        هیچ سفارشی ثبت نشده است!
                    </div>
                @endif

                @if($n !== 0)
                    <div class="nk-block nk-block-lg">
                        <div class="card card-bordered card-preview">
                            <div class="card-inner">
                                <table class="datatable-init table table-hover">
                                    <thead class="table-light">
                                    <tr>
                                        <th class="tb-col-sm">شماره سفارش</th>
                                        <th>مشتری</th>
                                        <th>نوع سفارش</th>
                                        <th>وضعیت</th>
                                        <th>مبلغ (تومان)</th>
                                        <th>تاریخ سفارش</th>
                                        <th class="tb-col-md">عملیات</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($orders as $order)
                                        <tr>
                                            <td>{{ $order->id }}</td>
                                            <td>
                                                @if($order->customer)
                                                    <a href="{{ route('customers.info' , $order->customer->id) }}" class="text-primary">
                                                        {{ $order->customer->name }}
                                                    </a>
                                                @else
                                                    <span class="text-muted">بدون مشتری</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($order->type)
                                                    <span class="badge bg-gray badge-dim">{{ $order->type->label }}</span>
                                                @else
                                                    <span class="text-muted">نامشخص</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($order->status)
                                                    @if($order->status == 'completed')
                                                        <span class="badge badge-dim bg-success">
                                                            تکمیل شده
                                                        </span>
                                                    @elseif($order->status == 'unpaid')
                                                        <span class="badge badge-dim bg-warning">
                                                            پرداخت نشده
                                                        </span>
                                                    @elseif($order->status == 'paid')
                                                        <span class="badge badge-dim bg-info">
                                                            پرداخت شده
                                                        </span>

                                                    @elseif($order->status == 'canceled')
                                                        <span class="badge badge-dim bg-danger">
                                                            لغو شده
                                                        </span>


                                                    @else
                                                        <span class="badge badge-dim bg-light">
                                                            {{ $order->status }}
                                                        </span>
                                                    @endif

                                                @else
                                                    <span class="badge bg-secondary">نامشخص</span>
                                                @endif
                                            </td>
                                            <td>{{ number_format($order->price) }}</td>
                                            <td>{{ jdate($order->date)->format('Y/m/d') }}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <a class="btn btn-icon btn-trigger dropdown-toggle"
                                                       data-bs-toggle="dropdown">
                                                        <em class="icon ni ni-more-h"></em>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <ul class="link-list-opt">
                                                            <li>
                                                                <a href="{{ route('orders.detail', $order->id) }}">
                                                                    <em class="icon ni ni-eye"></em>
                                                                    <span>مشاهده جزئیات</span>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('orders.edit', $order->id) }}">
                                                                    <em class="icon ni ni-edit"></em>
                                                                    <span>ویرایش</span>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="#"
                                                                   onclick="event.preventDefault(); document.getElementById('delete_order_{{ $order->id }}').submit();"
                                                                   class="text-danger">
                                                                    <em class="icon ni ni-trash"></em>
                                                                    <span>حذف</span>
                                                                </a>
                                                                <form id="delete_order_{{ $order->id }}" method="post"
                                                                      action="{{ route('orders.delete', $order->id) }}"
                                                                      class="d-none">
                                                                    @csrf
                                                                    @method('delete')
                                                                </form>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- .card-preview -->
                    </div>
                @endif
                <!-- .nk-block -->
            </div>
        </div>
    </div>

    @slot('script')
        <script src="/assets/js/libs/datatable-btns.js"></script>
        <script>
            $(document).ready(function () {
                // جستجو در جدول
                $("#search-orders").on("keyup", function () {
                    var value = $(this).val().toLowerCase();
                    $("table tbody tr").filter(function () {
                        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                    });
                });

                // فعال‌سازی tooltip
                $('[data-toggle="tooltip"]').tooltip();
            });
        </script>
    @endslot

</x-admin.main>

