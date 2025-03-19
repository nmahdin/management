<x-admin.main title="سطل زباله فروشندگان">
    <div class="nk-content nk-content-fluid">
        <div class="container-xl wide-xl">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <h3 class="nk-block-title page-title">سطل زباله فروشندگان</h3>
                            <div class="nk-block-des text-soft">
                                @if($n !== 0)
                                    <p>در مجموع {{ $n }} فروشنده در سطل زباله وجود دارد.</p>
                                @endif
                            </div>
                        </div>
                        <div class="nk-block-head-content">
                            <div class="toggle-wrap nk-block-tools-toggle">
                                <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em
                                        class="icon ni ni-more-v"></em></a>
                                <div class="toggle-expand-content" data-content="pageMenu">
                                    <ul class="nk-block-tools g-3">
                                        <li>
                                            <a href="#" class="dropdown-toggle btn btn-dark btn-dim"
                                               data-bs-toggle="modal" data-bs-target="#modalZoom"
                                               onclick="event.preventDefault(); document.getElementById('form133').submit();">
                                                <em class="icon ni ni-forward-ios"></em>
                                                <span class="fw-normal">لیست فروشندگان</span>
                                            </a>
                                            <form id="form133" action="{{ route('purchases.sellers.list') }}"
                                                  class="d-none"></form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if(session('restored'))
                    <div class="alert alert-fill alert-success alert-icon bg-success-dim text-success">
                        <em class="icon ni ni-check-circle"></em>
                        فروشنده "{{session('restored')}}" با موفقیت به
                        <a href="{{ route('purchases.sellers.list') }}" class="text-success" data-bs-toggle="modal"
                           data-bs-target="#modalZoom"
                           onclick="event.preventDefault(); document.getElementById('form133').submit();">
                            <u>لیست فروشندگان</u>
                        </a>
                        منتقل شد.
                    </div>
                @endif

                @if(session('deleted'))
                    <div class="alert alert-fill alert-success alert-icon bg-success-dim text-success">
                        <em class="icon ni ni-check-circle"></em>
                        فروشنده "{{session('deleted')}}" با موفقیت به طور کامل حذف شد.
                    </div>
                @endif

                @if($n == 0)
                    <div class="alert alert-fill alert-light alert-icon">
                        <em class="icon ni ni-alert-circle"></em>
                        هیچ فروشنده‌ای در سطل زباله وجود ندارد!
                    </div>
                @endif

                @if($n !== 0)
                    <div class="nk-block nk-block-lg">
                        <div class="card card-preview">
                            <div class="card-inner">
                                <table class="table table-orders">
                                    <thead class="tb-odr-head">
                                    <tr class="tb-odr-item">
                                        <th class="tb-odr-info">
                                            <span class="tb-odr-info">نام</span>
                                        </th>
                                        <th class="tb-odr-info">
                                            <span class="tb-odr-info">شماره</span>
                                        </th>
                                        <th class="tb-odr-info">
                                            <span class="tb-odr-info">تلفن</span>
                                        </th>
                                        <th class="tb-odr-info">
                                            <span class="tb-odr-info">آدرس</span>
                                        </th>
                                        <th class="tb-odr-info">
                                            <span class="tb-odr-info">یادداشت</span>
                                        </th>
                                        <th class="tb-odr-action">&nbsp;</th>
                                    </tr>
                                    </thead>
                                    <tbody class="tb-odr-body">
                                    @foreach($sellers as $seller)
                                        <tr class="tb-odr-item">
                                            <td class="tb-odr-info">
                                                <span class="tb-odr-info">{{ $seller->name }}</span>
                                            </td>
                                            <td class="tb-odr-info">
                                                <span class="tb-odr-info">{{ $seller->number ?? 'ثبت نشده'}}</span>
                                            </td>
                                            <td class="tb-odr-info">
                                                <span class="tb-odr-info">{{ $seller->phone ?? 'ثبت نشده'}}</span>
                                            </td>
                                            <td class="tb-odr-info">
                                                <span class="tb-odr-info">{{ $seller->address ?? 'ثبت نشده' }}</span>
                                            </td>
                                            <td class="tb-odr-info">
                                                @if($seller->notes)
                                                    <span class="tb-odr-info">
                                                    {{ $seller->notes }}
                                                </span>
                                                @else
                                                    <span class="tb-odr-info text-gray fw-light">
                                                    بدون یادداشت
                                                </span>
                                                @endif
                                            </td>
                                            <td class="tb-odr-action">
                                                <div class="tb-odr-btns d-none d-md-inline">
                                                    <a href="{{ route('purchases.sellers.trash.restore', ['seller' => $seller->id]) }}"
                                                       onclick="event.preventDefault(); document.getElementById('restore_seller{{$seller->id}}').submit();"
                                                       class="btn btn-warning btn-dim"
                                                       data-bs-toggle="modal" data-bs-target="#modalrestore">
                                                        <em class="icon ni ni-redo"></em>
                                                        <span class="fw-normal">بازگردانی</span>
                                                    </a>
                                                    <form id="restore_seller{{$seller->id}}" method="post"
                                                          action="{{ route('purchases.sellers.trash.restore', ['seller' => $seller->id]) }}"
                                                          class="d-none">@csrf</form>
                                                </div>
                                                <div class="tb-odr-btns d-none d-md-inline" style="margin-right: 3px">
                                                    <a href="{{ route('purchases.sellers.trash.delete', ['seller' => $seller->id]) }}"
                                                       onclick="event.preventDefault(); document.getElementById('force_delete_seller{{$seller->id}}').submit();"
                                                       class="btn btn-danger btn-dim" style="padding: 6px 9px !important;"
                                                       data-bs-toggle="modal" data-bs-target="#modaldelete">
                                                        <em class="icon ni ni-trash-fill"></em>
                                                    </a>
                                                    <form id="force_delete_seller{{$seller->id}}" method="post"
                                                          action="{{ route('purchases.sellers.trash.delete', ['seller' => $seller->id]) }}"
                                                          class="d-none">@csrf @method('delete')</form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <x-admin.modal id="modalGeneral">در حال بارگذاری ...</x-admin.modal>
    <x-admin.modal id="modaldelete">در حال حذف کامل فروشنده ...</x-admin.modal>
    <x-admin.modal id="modalrestore">در حال بازگردانی فروشنده ...</x-admin.modal>
    <x-admin.modal id="modalZoom" class="modal-body-md">در حال بازگشت به لیست فروشندگان ...</x-admin.modal>

    @slot('script')
        <script src="/assets/js/libs/datatable-btns.js"></script>
    @endslot
</x-admin.main>
