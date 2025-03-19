<x-admin.main title="وضعیت های حذف شده">

    <div class="nk-content nk-content-fluid">
        <div class="container-xl wide-xl">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <!--   --------------- title --------------     -->
                            <h3 class="nk-block-title page-title">وضعیت های حذف شده</h3>
                            <div class="nk-block-des text-soft">
                                <!--   --------------- توضیح صفحه --------------     -->
                                @if($n !== 0)
                                <p>در مجموج {{ $n }} وضعیت حذف وجود دارد.</p>
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
                                            <a href="{{ route('products.statuses.list') }}"
                                               class="dropdown-toggle btn btn-dark btn-dim"
                                               data-bs-toggle="modal" data-bs-target="#modalZoom"
                                               onclick="event.preventDefault(); document.getElementById('form133').submit();">
                                                <em class="icon ni ni-forward-ios"></em>
                                                <span class="fw-normal">
                                                    لیست وضعیت ها
                                                </span>
                                            </a>
                                            <form id="form133" action="{{ route('products.statuses.list') }}"
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
                        وضعیت "{{session('deleted')}}" با موفقیت به
                        طور  کامل حذف شد.
                    </div>
                @endif
                @if(session('restored'))
                    <div class="alert alert-fill alert-success alert-icon bg-success-dim text-success">
                        <em class="icon ni ni-check-circle"></em>
                        وضعیت "{{session('restored')}}" با موفقیت
                        بازگردانی شد.
                    </div>
                @endif
            <!-- .nk-block-head -->
                @if($n == 0)
                    <div class="alert alert-fill alert-light alert-icon">
                        <em class="icon ni ni-alert-circle"></em>
                    هیچ وضعیتی در سطل زباله وجود ندارد!
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
                                            <span class="tb-odr-info">توضیحات</span>
                                        </th>
                                        <th class="tb-odr-action">&nbsp;</th>
                                    </tr>
                                    </thead>
                                    <tbody class="tb-odr-body">
                                    @foreach($statuses as $status)
                                        <tr class="tb-odr-item">
                                            <td class="tb-odr-info">
                                                <span class="tb-odr-info">{{ $status->name }}</span>
                                            </td>
                                            <td class="tb-odr-info">
                                                @if($status->notes)
                                                <span class="tb-odr-info">
                                                    {{ $status->notes }}
                                                </span>
                                                @else
                                                    <span class="tb-odr-info text-gray fw-light">
                                                    بدون توضیح
                                                </span>
                                                @endif
                                            </td>
                                            <td class="tb-odr-action">
                                                <div class="tb-odr-btns d-none d-md-inline" style=" margin-right: 3px">
                                                    <a href="{{ route('products.statuses.trash.r' , ['status' => $status->id]) }}"
                                                       onclick="event.preventDefault(); document.getElementById('restore_sta{{$status->id}}').submit();"
                                                       class="btn btn-warning btn-dim"
                                                       style="padding: 6px 9px !important;"><em class="icon ni ni-redo"></em><span class="fw-normal">بازگردانی</span></a>
                                                    <form id="restore_sta{{$status->id}}" method="post"
                                                          action="{{ route('products.statuses.trash.r' , ['status' => $status->id]) }}"
                                                          class="d-none">@csrf @method('post')</form>

                                                </div>

                                                <div class="tb-odr-btns d-none d-md-inline" style=" margin-right: 3px">
                                                    <a href="{{ route('products.statuses.trash.d' , ['status' => $status->id]) }}"
                                                       onclick="event.preventDefault(); document.getElementById('delete_sta{{$status->id}}').submit();"
                                                       class="btn btn-danger btn-dim"
                                                       style="padding: 6px 9px !important;"><em
                                                            class="icon ni ni-trash-fill"></em><span class="fw-normal">حذف کامل</span></a>
                                                    <form id="delete_sta{{$status->id}}" method="post"
                                                          action="{{ route('products.statuses.trash.d' , ['status' => $status->id]) }}"
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


