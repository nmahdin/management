<x-admin.main title="لیست سفارشات حذف شده">

    <div class="nk-content nk-content-fluid">
        <div class="container-xl wide-xl">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <!--   --------------- title --------------     -->
                            <h3 class="nk-block-title page-title">لیست سفارشات حذف شده</h3>
                            <div class="nk-block-des text-soft">
                                <!--   --------------- توضیح صفحه --------------     -->
                                @if($n !== 0)
                                    <p>در مجموع {{ $n }} سفارش در سطل زباله است.</p>
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
                                            <a href="{{ route('orders.list') }}"
                                               class="dropdown-toggle btn btn-dark btn-dim" data-bs-toggle="modal" data-bs-target="#modalZoom" onclick="event.preventDefault(); document.getElementById('list').submit();">
                                                <em class="icon ni ni-forward-ios"></em>
                                                <span class="fw-normal">
                                                    لیست سفارشات
                                                </span>
                                            </a>
                                            <form id="list" action="{{ route('orders.list') }}" class="d-none"></form>
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
                @if($n == 0)
                    <div class="alert alert-fill alert-light alert-icon">
                        <em class="icon ni ni-alert-circle"></em>
                        هیچ سفارشی در سطل زباله وجود ندارد!
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
                                        <th>مبلغ (تومان)</th>
                                        <th>تاریخ سفارش</th>
                                        <th>تاریخ حذف</th>
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
                                            <td>{{ number_format($order->amount) }}</td>
                                            <td>{{ jdate($order->date)->format('Y/m/d') }}</td>
                                            <td>{{ jdate($order->deleted_at)->format('Y/m/d') }}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <a class="btn btn-icon btn-trigger dropdown-toggle"
                                                       data-bs-toggle="dropdown">
                                                        <em class="icon ni ni-more-h"></em>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <ul class="link-list-opt">
                                                            <li>
                                                                <a href="{{ route('orders.restore', $order->id) }}" class="text-warning"
                                                                   onclick="event.preventDefault(); document.getElementById('restore_order_{{ $order->id }}').submit();">
                                                                    <em class="icon ni ni-redo"></em>
                                                                    <span>بازیابی</span>
                                                                </a>
                                                                <form id="restore_order_{{ $order->id }}" method="post"
                                                                      action="{{ route('orders.restore', $order->id) }}"
                                                                      class="d-none">
                                                                    @csrf
                                                                    @method('post')
                                                                </form>
                                                            </li>
                                                            <li>
                                                                <a href="#"
                                                                   onclick="event.preventDefault(); document.getElementById('delete_order_{{ $order->id }}').submit();"
                                                                   class="text-danger">
                                                                    <em class="icon ni ni-trash"></em>
                                                                    <span class="text-danger">حذف کامل</span>
                                                                </a>
                                                                <form id="delete_order_{{ $order->id }}" method="post"
                                                                      action="{{ route('orders.forceDelete', $order->id) }}"
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

