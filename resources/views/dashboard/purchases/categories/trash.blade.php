<x-admin.main title="سطل زباله دسته بندی ها">

    <div class="nk-content nk-content-fluid">
        <div class="container-xl wide-xl">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <!--   --------------- title --------------     -->
                            <h3 class="nk-block-title page-title">سطل زباله دسته بندی ها</h3>
                            <div class="nk-block-des text-soft">
                                <!--   --------------- توضیح صفحه --------------     -->
                                @if($n !== 0)
                                    <p>در مجموج {{ $n }} دسته بندی در سطل زباله وجود دارد.</p>
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
                                            <a href="{{ route('purchases.categories.list') }}"
                                               class="dropdown-toggle btn btn-dark btn-dim"
                                               data-bs-toggle="modal" data-bs-target="#modalZoom"
                                               onclick="event.preventDefault(); document.getElementById('form133').submit();">
                                                <em class="icon ni ni-forward-ios"></em>
                                                <span class="fw-normal">
                                                    لیست دسته بندی ها
                                                </span>
                                            </a>
                                            <form id="form133" action="{{ route('purchases.categories.list') }}"
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
                        دسته بندی "{{session('restored')}}" با موفقیت به
                        <a href="{{ route('purchases.categories.list') }}" class="text-success" data-bs-toggle="modal"
                           data-bs-target="#modalZoom"
                           onclick="event.preventDefault(); document.getElementById('form133').submit();">
                            <u>لیست دسته بندی ها</u>
                        </a>
                        منتقل شد.
                    </div>
                @endif
                @if(session('deleted'))
                    <div class="alert alert-fill alert-success alert-icon bg-success-dim text-success">
                        <em class="icon ni ni-check-circle"></em>
                        دسته بندی "{{session('deleted')}}" با موفقیت به
                        طور کامل حذف شد.
                    </div>
                @endif
                @if($n == 0)
                    <div class="alert alert-fill alert-light alert-icon">
                        <em class="icon ni ni-alert-circle"></em>
                        هیچ دسته بندی ای در سطل زباله وجود ندارد!
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
                                            <span class="tb-odr-info">نام</span>
                                        </th>
                                        <th class="tb-odr-info">
                                            <span class="tb-odr-info">توضیحات</span>
                                        </th>
                                        <th class="tb-odr-action">اقدام</th>
                                    </tr>
                                    </thead>
                                    <tbody class="tb-odr-body">
                                    @foreach($categories as $category)
                                        <tr class="tb-odr-item">
                                            <td class="tb-odr-info">
                                                <span class="tb-odr-info">{{ $category->name }}</span>
                                            </td>
                                            <td class="tb-odr-info">
                                                @if($category->notes)
                                                    <span class="tb-odr-info">
                                                    {{ $category->notes }}
                                                </span>
                                                @else
                                                    <span class="tb-odr-info text-gray fw-light">
                                                    بدون توضیح
                                                </span>
                                                @endif
                                            </td>
                                            <td class="tb-odr-action">
                                                <div class="tb-odr-btns d-none d-md-inline">
                                                    <a href="{{ route('purchases.categories.edit' , ['category' => $category->id]) }}"
                                                       class="btn btn-warning btn-dim"><em
                                                            class="icon ni ni-edit-alt-fill"></em><span
                                                            class="fw-normal">ویرایش</span>
                                                    </a>
                                                </div>
                                                <div class="tb-odr-btns d-none d-md-inline" style=" margin-right: 3px">
                                                    <a href="{{ route('purchases.categories.delete' , ['category' => $category->id]) }}"
                                                       onclick="event.preventDefault(); document.getElementById('delete_cate{{$category->id}}').submit();"
                                                       class="btn btn-danger btn-dim"
                                                       style="padding: 6px 9px !important;"><em
                                                            class="icon ni ni-trash-fill"></em></a>
                                                    <form id="delete_cate{{$category->id}}" method="post"
                                                          action="{{ route('purchases.categories.delete' , ['category' => $category->id]) }}"
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
   <x-admin.modal id="modalGeneral">در حال بارگذاری ...</x-admin.modal>
   <x-admin.modal id="modaldelete">در حال حذف کامل دسته بندی ...</x-admin.modal>
   <x-admin.modal id="modalrestore">در حال بازگردانی دسته بندی ...</x-admin.modal>
   <x-admin.modal id="modalZoom" class="modal-body-md">در حال بازگشت به لیست دسته بندی ها ...</x-admin.modal>
    @slot('script')
        <script src="/assets/js/libs/datatable-btns.js"></script>
    @endslot

</x-admin.main>


