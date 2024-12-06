<x-admin.main title="لیست خرید های حذف شده">

    <div class="nk-content nk-content-fluid">
        <div class="container-xl wide-xl">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <!--   --------------- title --------------     -->
                            <h3 class="nk-block-title page-title">لیست خرید های حذف شده</h3>
                            <div class="nk-block-des text-soft">
                                <!--   --------------- توضیح صفحه --------------     -->
{{--                                @if($n !== 0)--}}
{{--                                    <p>در مجموج {{ $n }} خرید وجود دارد.</p>--}}
{{--                                @endif--}}
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
                                            <a href="{{ route('purchases.list') }}" class="dropdown-toggle btn btn-dark btn-dim " data-bs-toggle="modal" data-bs-target="#modalZoom"
                                               onclick="event.preventDefault(); document.getElementById('form12').submit();">
{{--                                                <em class="icon ni ni-plus"></em>--}}
                                                <em class="icon ni ni-forward-ios"></em>
                                                <span class="fw-normal">
                                                    لیست خرید ها
                                                </span>
                                            </a>
                                            <form id="form12" action="{{ route('purchases.list') }}" class="d-none"></form>
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
                    خرید "{{session('deleted')}}" با موفقیت به
                    طور کامل حذف شد.
                </div>
                @endif
                @if(session('restored'))
                    <div class="alert alert-fill alert-success alert-icon bg-success-dim text-success">
                        <em class="icon ni ni-check-circle"></em>
                        خرید "{{session('restored')}}" با موفقیت به
                        لیست اصلی منتقل شد.
                    </div>
                @endif
                @if($n == 0)
                    <div class="alert alert-fill alert-light alert-icon">
                        <em class="icon ni ni-alert-circle"></em>
                        هیچ خریدی در سطل زباله وجود ندارد!
                    </div>
                @endif
                @if($n !== 0)
                    <div class="nk-block nk-block-lg">
                        <div class="card card-preview">
                            <div class="card-inner">
                                <table class="datatable-init nk-tb-list nk-tb-ulist" data-auto-responsive="false">
                                    <thead>
                                    <tr class="nk-tb-item nk-tb-head">
                                        <th class="nk-tb-col nk-tb-col-check">
                                        <span>
                                            انتخاب
                                        </span>
                                        </th>
                                        <th class="nk-tb-col"><span class="">کد خرید</span></th>
                                        <th class="nk-tb-col tb-col-lg"><span class="">نام خرید</span></th>
                                        <th class="nk-tb-col tb-col-md"><span class="sub-text">دسته بندی</span></th>
                                        <th class="nk-tb-col tb-col-md"><span class="sub-text">مقدار</span></th>
                                        <th class="nk-tb-col tb-col-md"><span class="sub-text">قیمت واحد</span></th>
                                        <th class="nk-tb-col tb-col-sm"><span class="sub-text">قیمت کل</span></th>
                                        <th class="nk-tb-col nk-tb-col-tools text-end"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($purchases as $purchase)
                                        <tr class="nk-tb-item">
{{--                                            <td class="nk-tb-col nk-tb-col-check">--}}
{{--                                                <div class="custom-control custom-control-sm custom-checkbox notext">--}}
{{--                                                    <input type="checkbox" class="custom-control-input" id="s{{ $purchase->id }}" />--}}
{{--                                                    <label class="custom-control-label" for="s{{ $purchase->id }}"></label>--}}
{{--                                                </div>--}}
{{--                                            </td>--}}
                                            <td class="nk-tb-col nk-tb-col-check">
                                                dd
                                            </td>
                                            <td class="nk-tb-col tb-col-sm" data-order="35040.34">
                                                <span class="fw-light"><a href="{{ route('purchases.detail' , ['purchase' => $purchase]) }}">{{ $purchase->code }}</a></span>
                                            </td>
                                            <td class="nk-tb-col tb-col-lg">
                                                <div class="user-card">
                                                    <div class="user-info">
                                                        <span class="tb-lead"><a href="{{ route('purchases.detail' , ['purchase' => $purchase]) }}">{{ $purchase->name }}</a><span class="dot dot-success d-md-none ms-1"></span></span>
                                                        <span>{{ $purchase->color }}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="nk-tb-col tb-col-sm">
                                                <span class="badge badge-dim bg-dark fw-light">{{ \App\Models\PurchasesCategory::find($purchase->category_id)->first()->name ?? 'بدون دسته بندی' }}</span>
                                            </td>
                                            <td class="nk-tb-col tb-col-sm">
                                                <span>{{ $purchase->amount . ' ' . $purchase->unit }}</span>
                                            </td>
                                            <td class="nk-tb-col tb-col-sm">
                                                <span style="font-size:15px ">{{ number_format($purchase->unit_price , 0, ',') }}</span>
                                            </td>
                                            <td class="nk-tb-col tb-col-md">
                                                <span class="" style="font-size: 15px; color: #3c3e42"><span>{{ number_format($purchase->total_price , 0, ',') }}</span></span>
                                            </td>
                                            <td class="nk-tb-col nk-tb-col-tools">
                                                <ul class="nk-tb-actions gx-1">
                                                    <li class="nk-tb-action-hidden">
                                                        <a href="{{ route('purchases.restore' , ['purchase' => $purchase->id]) }}" class="btn btn-trigger btn-icon" data-bs-toggle="tooltip" data-bs-placement="top"
                                                           onclick="event.preventDefault(); document.getElementById('restore_pur{{$purchase->id}}').submit();" title="بازگردانی">
                                                            <em class="icon ni ni-redo"></em>
                                                        </a>
                                                        <form id="restore_pur{{$purchase->id}}" method="post" action="{{ route('purchases.restore' , ['purchase' => $purchase->id]) }}" class="d-none">@csrf @method('post')</form>
                                                    </li>
                                                    <li class="nk-tb-action-hidden">
                                                        <a href="{{ route('purchases.delete.trash' , ['purchase' => $purchase->id]) }}" onclick="event.preventDefault(); document.getElementById('delete_pur{{$purchase->id}}').submit();"
                                                           class="btn btn-trigger btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="حذف کامل">
                                                            <em class="icon ni ni-trash-fill"></em>
                                                        </a>
                                                        <form id="delete_pur{{$purchase->id}}" method="post" action="{{ route('purchases.delete.trash' , ['purchase' => $purchase->id]) }}" class="d-none">@csrf @method('delete')</form>
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
                @endif

                <!-- .nk-block -->
            </div>
        </div>
    </div>
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
    <x-admin.modal id="modalTrash" class="modal-body-md">در حال رفتن به صفحه خریدات حذف شده ...</x-admin.modal>

@slot('script')
        <script src="/assets/js/libs/datatable-btns.js"></script>
    @endslot

</x-admin.main>


