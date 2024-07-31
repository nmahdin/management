<x-admin.main title="مدیریت مشتریان">

    <div class="nk-content nk-content-fluid">
        <div class="container-xl wide-xl">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <!--   --------------- title --------------     -->
                            <h3 class="nk-block-title page-title">مدریت مشتریان</h3>
                            <div class="nk-block-des text-soft">
                                <!--   --------------- توضیح صفحه --------------     -->
                                <p>در مجموج {{ $n }} مشتری وجود دارد.</p>
                            </div>
                        </div>
                        <!-- .nk-block-head-content -->
                        <div class="nk-block-head-content">
                            <div class="toggle-wrap nk-block-tools-toggle">
                                <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                                <div class="toggle-expand-content" data-content="pageMenu">
                                    <ul class="nk-block-tools g-3">
                                        <!--   --------------- links --------------     -->
                                        <li>
                                            <a href="{{ route('customer.creat') }}" class="dropdown-toggle btn btn-dark btn-dim " data-bs-toggle="modal" data-bs-target="#modalZoom"
                                               onclick="event.preventDefault(); document.getElementById('form12').submit();">
                                                <em class="icon ni ni-plus"></em>
                                                <span>
                                                    افزودن مشتری
                                                </span>
                                            </a>
                                            <form id="form12" action="{{ route('customer.creat') }}" class="d-none"></form>
                                        </li>
                                        <li>
                                            <a href="{{ route('customer.trash') }}" class="dropdown-toggle btn btn-light btn-dim" data-bs-toggle="modal" data-bs-target="#modalZoom"
                                               onclick="event.preventDefault(); document.getElementById('form13').submit();">
                                                <em class="icon ni ni-trash"></em>
                                                <span>
                                                    سطل زباله
                                                </span>
                                            </a>
                                            <form id="form13" action="{{ route('customer.trash') }}" class="d-none"></form>
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
                @if(session('deleted'))
                <div class="alert alert-fill alert-success alert-icon bg-success-dim text-success">
                    <em class="icon ni ni-check-circle"></em>
                    مشتری "{{session('deleted')}}" با موفقیت به
                    <a href="{{ route('customer.trash') }}" class="text-success" data-bs-toggle="modal" data-bs-target="#modalZoom"
                       onclick="event.preventDefault(); document.getElementById('form13').submit();">
                        <u>سطل زباله</u>
                    </a>
                    منتقل شد.
                </div>
                @endif
                <div class="nk-block nk-block-lg">

                    <div class="card card-preview">
                        <div class="card-inner">
                            <table class="datatable-init nk-tb-list nk-tb-ulist" data-auto-responsive="false">
                                <thead>
                                <tr class="nk-tb-item nk-tb-head">
                                    <th class="nk-tb-col nk-tb-col-check">
                                        <div class="custom-control custom-control-sm custom-checkbox notext">
                                            *
                                        </div>
                                    </th>
                                    <th class="nk-tb-col"><span class="sub-text">آیدی</span></th>
                                    <th class="nk-tb-col tb-col-mb"><span class="sub-text">نام</span></th>
                                    <th class="nk-tb-col tb-col-md"><span class="sub-text">شماره تماس</span></th>
                                    <th class="nk-tb-col tb-col-md"><span class="sub-text">تاریخچه سفارش</span></th>
                                    <th class="nk-tb-col nk-tb-col-tools text-end"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($customers as $customer)
                                <tr class="nk-tb-item">
                                    <td class="nk-tb-col nk-tb-col-check">
                                        <div class="custom-control custom-control-sm custom-checkbox notext">
                                            <input type="checkbox" class="custom-control-input" id="s{{ $customer->id }}" />
                                            <label class="custom-control-label" for="s{{ $customer->id }}"></label>
                                        </div>
                                    </td>
                                    <td class="nk-tb-col tb-col-mb" data-order="35040.34">
                                        <span class="tb-amount">{{ $customer->id }}</span>
                                    </td>
                                    <td class="nk-tb-col">
                                        <div class="user-card">
                                            <div class="user-info">
                                                <span class="tb-lead">{{ $customer->name }} <span class="dot dot-success d-md-none ms-1"></span></span>
                                                <span>{{ $customer->city }}</span>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="nk-tb-col tb-col-md">
                                        <span>{{ $customer->number ?? 'فاقد شماره موبایل' }}</span>
                                    </td>
                                    <td class="nk-tb-col tb-col-md">
                                        <span>{{ $customer->history ?? 'بدون تاریخجه' }}</span>
                                    </td>
                                    <td class="nk-tb-col nk-tb-col-tools">
                                        <ul class="nk-tb-actions gx-1">
                                            <li class="nk-tb-action-hidden">
                                                <a href="{{ route('customer.edit' , ['customer' => $customer->id]) }}" class="btn btn-trigger btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="ویرایش">
                                                    <em class="icon ni ni-edit-alt-fill"></em>
                                                </a>
                                            </li>
                                            <li class="nk-tb-action-hidden">
                                                <a href="{{ route('customer.info' , ['customer' => $customer->id]) }}"
                                                   class="btn btn-trigger btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="مشاهده جزئیات">
                                                    <em class="icon ni ni-info-fill"></em>
                                                </a>
                                            </li>
                                            <li class="nk-tb-action-hidden">
                                                <a href="{{ route('customer.delete' , ['customer' => $customer->id]) }}" onclick="event.preventDefault(); document.getElementById('delete_cus{{$customer->id}}').submit();"
                                                   class="btn btn-trigger btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="حذف">
                                                    <em class="icon ni ni-trash-fill"></em>
                                                </a>
                                                <form id="delete_cus{{$customer->id}}" method="post" action="{{ route('customer.delete' , ['customer' => $customer->id]) }}" class="d-none">@csrf @method('delete')</form>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                                @endforeach
                                <!-- .nk-tb-item  -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- .card-preview -->
                </div>
                <!-- .nk-block -->
            </div>
        </div>
    </div>
    <x-admin.modal id="modalInfo" class="modal-body-md">در حال رفتن به صفحه جزئیات مشتری ...</x-admin.modal>
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


