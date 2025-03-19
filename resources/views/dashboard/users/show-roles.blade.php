<x-admin.main title="لیست نقش ها">

    <div class="nk-content nk-content-fluid">
        <div class="container-xl wide-xl">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <!--   --------------- title --------------     -->
                            <h3 class="nk-block-title page-title">لیست نقش ها</h3>
                            <div class="nk-block-des text-soft">
                                <!--   --------------- توضیح صفحه --------------     -->
                                <p>در مجموج {{ $n }} نفش وجود دارد.</p>
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
                                            <a href="{{ route('users.role.creat') }}"
                                               class="dropdown-toggle btn btn-dark btn-dim"
                                               data-bs-toggle="modal" data-bs-target="#modalZoom"
                                               onclick="event.preventDefault(); document.getElementById('form12').submit();">
                                                <em class="icon ni ni-plus"></em>
                                                <span>
                                                    افزودن نقش
                                                </span>
                                            </a>
                                            <form id="form12" action="{{ route('users.role.creat') }}" class="d-none"></form>
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
                <div class="nk-block nk-block-lg">
                    <div class="card card-preview">
                        <div class="card-inner">
                            <table class="table table-orders">
                                <thead class="tb-odr-head">
                                <tr class="tb-odr-item">
                                    <th class="tb-odr-info">
                                        <span class="tb-odr-info">نام</span>
                                        <span class="tb-odr-info">توضیحات</span>
                                    </th>
                                    <th class="tb-tnx-info">
                                        <span class="tb-odr-info">دسترسی ها</span>
                                    </th>
                                    <th class="tb-odr-action">&nbsp;</th>
                                </tr>
                                </thead>
                                <tbody class="tb-odr-body">
                                @foreach($roles as $role)
                                <tr class="tb-odr-item">
                                    <td class="tb-odr-info">
                                        <span class="tb-odr-info">{{ $role->label }}</span>
                                        <span class="tb-odr-info">{{ $role->note }}</span>
                                    </td>
                                    <td class="tb-odr-info">
                                        <span class="tb-odr-info">
                                            @foreach($role->permissions as $per)
                                                <span class="badge bg-light">
                                                    {{ $per->label }}
                                                </span>
                                            @endforeach
                                        </span>
                                    </td>
                                    <td class="tb-odr-action">
                                        <div class="tb-odr-btns d-none d-md-inline">
                                            <a href="#" class="btn btn-warning btn-dim"><em class="icon ni ni-edit-alt-fill"></em><span>ویرایش</span> </a>
                                        </div>
                                        <div class="tb-odr-btns d-none d-md-inline" style=" margin-right: 3px">
                                            <a href="#" class="btn btn-danger btn-dim" style="padding: 6px 9px !important;"><em class="icon ni ni-trash-fill"></em></a>
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


