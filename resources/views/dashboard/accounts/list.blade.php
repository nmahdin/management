<x-admin.main title="لیست حساب ها">

    <div class="nk-content nk-content-fluid">
        <div class="container-xl wide-xl">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <!--   --------------- title --------------     -->
                            <h3 class="nk-block-title page-title">لیست حساب ها</h3>
                            <div class="nk-block-des text-soft">
                                <!--   --------------- توضیح صفحه --------------     -->
                                @if($n !== 0)
                                <p>در مجموج {{ $n }} حساب وجود دارد.</p>
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
                                            <a href="{{ route('accounts.create') }}"
                                               class="dropdown-toggle btn btn-dark btn-dim"
                                               data-bs-toggle="modal" data-bs-target="#modalZoom"
                                               onclick="event.preventDefault(); document.getElementById('form133').submit();">
                                                <em class="icon ni ni-plus"></em>
                                                <span class="fw-normal">
                                                    افزودن حساب
                                                </span>
                                            </a>
                                            <form id="form133" action="{{ route('accounts.create') }}"
                                                  class="d-none"></form>
                                        </li>
                                        <li>
                                            <a href="{{ route('accounts.trash') }}"
                                               class="dropdown-toggle btn btn-light btn-dim" data-bs-toggle="modal"
                                               data-bs-target="#modalZoom"
                                               onclick="event.preventDefault(); document.getElementById('acc_trash').submit();">
                                                <em class="icon ni ni-trash"></em>
                                                <span class="fw-normal">
                                                    سطل زباله
                                                </span>
                                            </a>
                                            <form id="acc_trash" action="{{ route('accounts.trash') }}"
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
                @if(session('deleted'))
                    <div class="alert alert-fill alert-success alert-icon bg-success-dim text-success">
                        <em class="icon ni ni-check-circle"></em>
                        حساب "{{session('deleted')}}" با موفقیت به
                        <a href="{{ route('accounts.trash') }}" class="text-success" data-bs-toggle="modal"
                           data-bs-target="#modalZoom"
                           onclick="event.preventDefault(); document.getElementById('acc_trash').submit();">
                            <u>سطل زباله</u>
                        </a>
                        منتقل شد.
                    </div>
                @endif
                @if(session('edited'))
                    <div class="alert alert-fill alert-success alert-icon bg-success-dim text-success">
                        <em class="icon ni ni-check-circle"></em>
                        حساب "{{session('edited')}}" با موفقیت
                        ویرایش شد.
                    </div>
                @endif
            <!-- .nk-block-head -->
                @if($n == 0)
                    <div class="alert alert-fill alert-light alert-icon">
                        <em class="icon ni ni-alert-circle"></em>
                    هیچ حسابی وجود ندارد! سطل زباله را بررسی کنید.
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
                                            <span class="tb-odr-info">نام حساب</span>
                                        </th>
                                        <th class="tb-odr-info">
                                            <span class="tb-odr-info">شماره حساب</span>
                                        </th>
                                        <th class="tb-odr-info">
                                            <span class="tb-odr-info">روش های پرداخت</span>
                                        </th>
                                        <th class="tb-odr-info">
                                            <span class="tb-odr-info">توضیحات</span>
                                        </th>
                                        <th class="tb-odr-action">&nbsp;</th>
                                    </tr>
                                    </thead>
                                    <tbody class="tb-odr-body">
                                    @foreach($accounts as $account)
                                        <tr class="tb-odr-item">
                                            <td class="tb-odr-info">
                                                <span class="tb-odr-info">{{ $account->label }}</span>
                                            </td>
                                            <td class="tb-odr-info">
                                                <span class="tb-odr-info">
                                                    {{ $account->number }}
                                                </span>
                                            </td>
                                            <td class="tb-odr-info">
                                                <span class="tb-odr-info fs-12px">

                                                    @foreach(json_decode($account->payment_ways) as $way)
                                                        @if($way == 'cash')
                                                            پرداخت نقدی /
                                                        @elseif($way == 'cart')
                                                            کارت به کارت /
                                                        @elseif($way == 'online')
                                                            پرداخت آنلاین از درگاه پرداخت /
                                                        @elseif($way == 'pos')
                                                            پرداخت با دستگاه پز /
                                                        @endif
                                                    @endforeach
                                                </span>
                                            </td>
                                            <td class="tb-odr-info">
                                                @if($account->note)
                                                <details>
                                                    <summary class="tb-odr-info">نمایش توضیحات</summary>
                                                <span class="tb-odr-info">
                                                    {{ $account->note }}
                                                </span>
                                                </details>
                                                @else
                                                    <span class="tb-odr-info text-gray fw-light">
                                                    بدون توضیح
                                                </span>
                                                @endif
                                            </td>
                                            <td class="tb-odr-action">
                                                <div class="tb-odr-btns d-none d-md-inline">
                                                    <a href="{{ route('accounts.edit' , ['id' => $account->id]) }}" class="btn btn-warning btn-dim"><em
                                                            class="icon ni ni-edit-alt-fill"></em><span class="fw-normal">ویرایش</span>
                                                    </a>
                                                </div>
                                                <div class="tb-odr-btns d-none d-md-inline">
                                                    <a href="{{ route('accounts.report' , ['id' => $account->id]) }}" class="btn btn-info btn-dim"><em class="icon ni ni-reports"></em><span class="fw-normal">گزارش</span>
                                                    </a>
                                                </div>
                                                <div class="tb-odr-btns d-none d-md-inline" style=" margin-right: 3px">
                                                    <a href="{{ route('accounts.delete' , ['id' => $account->id]) }}"
                                                       onclick="event.preventDefault(); document.getElementById('delete_cate{{$account->id}}').submit();"
                                                       class="btn btn-danger btn-dim"
                                                       style="padding: 6px 9px !important;"><em
                                                            class="icon ni ni-trash-fill"></em></a>
                                                    <form id="delete_cate{{$account->id}}" method="post"
                                                          action="{{ route('accounts.delete' , ['id' => $account->id]) }}"
                                                          class="d-none">@csrf @method('delete')</form>

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


