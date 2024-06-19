<x-admin.main title="لیست دسترسی ها">

    <div class="nk-content nk-content-fluid">
        <div class="container-xl wide-xl">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <!--   --------------- title --------------     -->
                            <h3 class="nk-block-title page-title">لیست دسترسی ها</h3>
                            <div class="nk-block-des text-soft">
                                <!--   --------------- توضیح صفحه --------------     -->
                                <p>در مجموج {{ $n }} دسترسی وجود دارد.</p>
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
                                            <a href="{{ route('users.all') }}"
                                               class="dropdown-toggle btn btn-primary btn-dim btn-outline-light"
                                               data-bs-toggle="modal" data-bs-target="#modalZoom"
                                               onclick="event.preventDefault(); document.getElementById('form12').submit();">
                                                <em class="icon ni ni-forward-ios"></em>
                                                <span>
                                                    لیست کاربران
                                                </span>
                                            </a>
                                            <form id="form12" action="{{ route('users.all') }}" class="d-none"></form>
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
                            <table class="table table-tranx">
                                <thead class="bg-light bg-opacity-75">
                                <tr class="tb-tnx-head">
                                    <th class="tb-tnx-info"><span class="">نام</span></th>
                                    <th class="tb-tnx-info">
                                    <span class="tb-tnx-desc d-none d-sm-inline-block">
                                        <span>توضیحات</span>
                                    </span>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($permissions as $permission)
                                <tr class="tb-tnx-item">
                                    <td class="tb-tnx-info text-gray">
                                       <span>{{ $permission->label }}</span>
                                    </td>
                                    <td class="tb-tnx-info">
                                        <div class="tb-tnx-desc">
                                            <span class="title">{{ $permission->note ?? 'بدون توضیح' }}</span>
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


