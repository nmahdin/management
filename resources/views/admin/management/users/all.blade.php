<x-admin.main title="مدیریت کاربران">

    <div class="nk-content nk-content-fluid">
        <div class="container-xl wide-xl">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <!--   --------------- title --------------     -->
                            <h3 class="nk-block-title page-title">مدریت کاربران</h3>
                            <div class="nk-block-des text-soft">
                                <!--   --------------- توضیح صفحه --------------     -->
                                <p>در مجموج {{ $n }} کاربر وجود دارد.</p>
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
                                            <a href="{{ route('main') }}" class="dropdown-toggle btn btn-white btn-dim btn-outline-light" data-bs-toggle="modal" data-bs-target="#modalZoom"
                                               onclick="event.preventDefault(); document.getElementById('form12').submit();">
                                                <em class="icon ni ni-plus"></em>
                                                <span>
                                                    افزودن کاربر
                                                </span>
                                            </a>
                                            <form id="form12" action="{{ route('main') }}" class="d-none"></form>
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
                            <table class="datatable-init nk-tb-list nk-tb-ulist" data-auto-responsive="false">
                                <thead>
                                <tr class="nk-tb-item nk-tb-head">
                                    <th class="nk-tb-col nk-tb-col-check">
                                        <div class="custom-control custom-control-sm custom-checkbox notext">
                                            <input type="checkbox" class="custom-control-input" id="uid" />
                                            <label class="custom-control-label" for="uid"></label>
                                        </div>
                                    </th>
                                    <th class="nk-tb-col"><span class="sub-text">آیدی</span></th>
                                    <th class="nk-tb-col tb-col-mb"><span class="sub-text">نام</span></th>
                                    <th class="nk-tb-col tb-col-md"><span class="sub-text">نام کاربری</span></th>
                                    <th class="nk-tb-col tb-col-lg"><span class="sub-text">نقش</span></th>
                                    <th class="nk-tb-col nk-tb-col-tools text-end"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $user)
                                <tr class="nk-tb-item">
                                    <td class="nk-tb-col nk-tb-col-check">
                                        <div class="custom-control custom-control-sm custom-checkbox notext">
                                            <input type="checkbox" class="custom-control-input" id="uid1" />
                                            <label class="custom-control-label" for="uid1"></label>
                                        </div>
                                    </td>
                                    <td class="nk-tb-col tb-col-mb" data-order="35040.34">
                                        <span class="tb-amount">{{ $user->id }}</span>
                                    </td>
                                    <td class="nk-tb-col">
                                        <div class="user-card">
                                            <div class="user-info">
                                                <span class="tb-lead">{{ $user->name }} <span class="dot dot-success d-md-none ms-1"></span></span>
                                                <span>{{ $user->email }}</span>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="nk-tb-col tb-col-md">
                                        <span>{{ $user->username }}</span>
                                    </td>
                                    <td class="nk-tb-col tb-col-md">
                                        <span class="tb-status text-gray">{{ $user->groups->first()->label ?? 'بدون نقش' }}</span>
                                    </td>
                                    <td class="nk-tb-col nk-tb-col-tools">
                                        <ul class="nk-tb-actions gx-1">
                                            <li class="nk-tb-action-hidden">
                                                <a href="#" class="btn btn-trigger btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="حذف">
                                                    <em class="icon ni ni-trash-fill"></em>
                                                </a>
                                            </li>
                                            <li class="nk-tb-action-hidden">
                                                <a href="#" class="btn btn-trigger btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="ویرایش">
                                                    <em class="icon ni ni-edit-alt-fill"></em>
                                                </a>
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


