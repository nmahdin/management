<x-admin.main title="سطل زباله برچسب‌های تراکنش">

    <div class="nk-content nk-content-fluid">
        <div class="container-xl wide-xl">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <!--   --------------- title --------------     -->
                            <h3 class="nk-block-title page-title">سطل زباله برچسب‌های تراکنش</h3>
                            <div class="nk-block-des text-soft">
                                <!--   --------------- توضیح صفحه --------------     -->
                                @if($n !== 0)
                                    <p>در مجموع {{ $n }} برچسب در سطل زباله وجود دارد.</p>
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
                                            <a href="{{ route('transactions.labels.index') }}"
                                               class="dropdown-toggle btn btn-dark btn-dim"
                                               data-bs-toggle="modal" data-bs-target="#modalZoom"
                                               onclick="event.preventDefault(); document.getElementById('form133').submit();">
                                                <em class="icon ni ni-forward-ios"></em>
                                                <span class="fw-normal">
                                                    لیست برچسب ها
                                                </span>
                                            </a>
                                            <form id="form133" action="{{ route('transactions.labels.index') }}"
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
                @if(session('restored'))
                    <div class="alert alert-fill alert-success alert-icon bg-success-dim text-success">
                        <em class="icon ni ni-check-circle"></em>
                        برچسب "{{session('restored')}}" با موفقیت به
                        <a href="{{ route('products.categories.list') }}" class="text-success" data-bs-toggle="modal"
                           data-bs-target="#modalZoom"
                           onclick="event.preventDefault(); document.getElementById('form133').submit();">
                            <u>لیست برچسب ها</u>
                        </a>
                        منتقل شد.
                    </div>
                @endif
                @if(session('deleted'))
                    <div class="alert alert-fill alert-success alert-icon bg-success-dim text-success">
                        <em class="icon ni ni-check-circle"></em>
                        برچسب "{{session('deleted')}}" با موفقیت به طور کامل حذف شد.
                    </div>
                @endif
                @if($n == 0)
                    <div class="alert alert-fill alert-light alert-icon">
                        <em class="icon ni ni-alert-circle"></em>
                        هیچ برچسبی در سطل زباله وجود ندارد!
                    </div>
                @endif
            <!-- .nk-block-head -->

                @if($n !== 0)
                    <div class="nk-block nk-block-lg">
                        <div class="card card-preview">
                            <div class="card-inner">
                                <table class="table table-orders">
                                    <thead class="tb-odr-head">
                                    <tr class="tb-odr-item">
                                        <th class="tb-odr-info">
                                                <span class="tb-odr-info">نام برچسب</span>
                                        </th>
                                        <th class="tb-odr-info">
                                            <span class="tb-odr-info">توضیحات</span>
                                        </th>
                                        <th class="tb-odr-action">&nbsp;</th>
                                    </tr>
                                    </thead>
                                    <tbody class="tb-odr-body">
                                    @foreach($labels as $label)
                                        <tr class="tb-odr-item">
                                            <td class="tb-odr-info">
                                                <span class="tb-odr-info">{{ $label->name }}</span>
                                            </td>
                                            <td class="tb-odr-info">
                                                @if($label->notes)
                                                    <span class="tb-odr-info">
                                                    {{ $label->notes }}
                                                </span>
                                                @else
                                                    <span class="tb-odr-info text-gray fw-light">
                                                    بدون توضیح
                                                </span>
                                                @endif
                                            </td>
                                            <td class="tb-odr-action">
                                                <div class="tb-odr-btns d-none d-md-inline">
                                                    <a href="{{ route('transactions.labels.trash.restore' , ['id' => $label->id]) }}"
                                                       class="btn btn-warning btn-dim" data-bs-toggle="modal"
                                                       data-bs-target="#modalrestore"
                                                       onclick="event.preventDefault(); document.getElementById('restore_trash{{$label->id}}').submit();"
                                                    ><em class="icon ni ni-redo"></em><span class="fw-normal">بازگردانی</span> </a>
                                                    <form id="restore_trash{{$label->id}}" method="post"
                                                          action="{{ route('transactions.labels.trash.restore' , ['id' => $label->id]) }}"
                                                          class="d-none">@csrf</form>

                                                </div>


                                                @if($label->transactions->count() == 0)
                                                    <div class="tb-odr-btns d-none d-md-inline"
                                                         style=" margin-right: 3px">
                                                        <a href="{{ route('transactions.labels.trash.delete' , ['id' => $label->id]) }}"
                                                           data-bs-toggle="modal" data-bs-target="#modaldelete"
                                                           onclick="event.preventDefault(); document.getElementById('delete_trash{{$label->id}}').submit();"
                                                           class="btn btn-danger btn-dim"
                                                           style="padding: 6px 9px !important;"><em class="icon ni ni-trash-fill"></em><span class="fw-normal">حذف کامل</span></a>
                                                    </div>
                                                    <form id="delete_trash{{$label->id}}" method="post"
                                                          action="{{ route('transactions.labels.trash.delete' , ['id' => $label->id]) }}"
                                                          class="d-none">@csrf @method('delete')</form>
                                                @endif
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
   <x-admin.modal id="modalGeneral">در حال بارگذاری ...</x-admin.modal>
   <x-admin.modal id="modaldelete">در حال حذف کامل دسته بندی ...</x-admin.modal>
   <x-admin.modal id="modalrestore">در حال بازگردانی دسته بندی ...</x-admin.modal>
   <x-admin.modal id="modalZoom" class="modal-body-md">در حال بازگشت به لیست دسته بندی ها ...</x-admin.modal>
    @slot('script')
        <script src="/assets/js/libs/datatable-btns.js"></script>
    @endslot

</x-admin.main>


