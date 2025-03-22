<x-admin.main title="لیست فروشندگان">

    <div class="nk-content nk-content-fluid">
        <div class="container-xl wide-xl">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <h3 class="nk-block-title page-title">لیست فروشندگان</h3>
                            <div class="nk-block-des text-soft">
                                @if($n !== 0)
                                    <p>در مجموع {{ $n }} فروشنده وجود دارد.</p>
                                @endif
                            </div>
                        </div>
                        <div class="nk-block-head-content">
                            <div class="toggle-wrap nk-block-tools-toggle">
                                <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                                <div class="toggle-expand-content" data-content="pageMenu">
                                    <ul class="nk-block-tools g-3">
                                        <li>
                                            <a href="{{ route('purchases.sellers.create') }}" class="dropdown-toggle btn btn-dark btn-dim" data-bs-toggle="modal" data-bs-target="#modalZoom"
                                               onclick="event.preventDefault(); document.getElementById('form133').submit();">
                                                <em class="icon ni ni-plus"></em>
                                                <span class="fw-normal">
                                                    افزودن فروشنده
                                                </span>
                                            </a>
                                            <form id="form133" action="{{ route('purchases.sellers.create') }}" class="d-none"></form>
                                        </li>
                                        <li>
                                            <a href="{{ route('purchases.sellers.trash') }}" class="dropdown-toggle btn btn-light btn-dim" data-bs-toggle="modal" data-bs-target="#modalZoom"
                                               onclick="event.preventDefault(); document.getElementById('sellers_trash').submit();">
                                                <em class="icon ni ni-trash"></em>
                                                <span class="fw-normal">
                                                    سطل زباله
                                                </span>
                                            </a>
                                            <form id="sellers_trash" action="{{ route('purchases.sellers.trash') }}" class="d-none"></form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if(session('deleted'))
                    <div class="alert alert-fill alert-success alert-icon bg-success-dim text-success">
                        <em class="icon ni ni-check-circle"></em>
                        فروشنده "{{session('deleted')}}" با موفقیت به
                        <a href="#" class="text-success" data-bs-toggle="modal" data-bs-target="#modalZoom"
                           onclick="event.preventDefault(); document.getElementById('sellers_trash').submit();">
                            <u>سطل زباله</u>
                        </a>
                        منتقل شد.
                    </div>
                @endif
                @if(session('edited'))
                    <div class="alert alert-fill alert-success alert-icon bg-success-dim text-success">
                        <em class="icon ni ni-check-circle"></em>
                        فروشنده "{{session('edited')}}" با موفقیت ویرایش شد.
                    </div>
                @endif
                @if($n == 0)
                    <div class="alert alert-fill alert-light alert-icon">
                        <em class="icon ni ni-alert-circle"></em>
                        هیچ فروشنده‌ای وجود ندارد! سطل زباله را بررسی کنید.
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
                                                <span class="tb-odr-info">{{ $seller->number }}</span>
                                            </td>
                                            <td class="tb-odr-info">
                                                <span class="tb-odr-info">{{ $seller->phone }}</span>
                                            </td>
                                            <td class="tb-odr-info">
                                                <span class="tb-odr-info">{{ $seller->address }}</span>
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
                                                    <a href="{{ route('purchases.sellers.edit' , ['id' => $seller->id]) }}" class="btn btn-warning btn-dim"><em class="icon ni ni-edit-alt-fill"></em><span class="fw-normal">ویرایش</span>
                                                    </a>
                                                </div>
                                                <div class="tb-odr-btns d-none d-md-inline" style=" margin-right: 3px">
                                                    <a href="{{ route('purchases.sellers.delete' , ['id' => $seller->id]) }}"
                                                       onclick="event.preventDefault(); document.getElementById('delete_seller{{$seller->id}}').submit();"
                                                       class="btn btn-danger btn-dim"
                                                       style="padding: 6px 9px !important;"><em class="icon ni ni-trash-fill"></em></a>
                                                    <form id="delete_seller{{$seller->id}}" method="post"
                                                          action="{{ route('purchases.sellers.delete' , ['id' => $seller->id]) }}"
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
