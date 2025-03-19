<x-admin.main title="ویرایش دسته‌بندی مشتری">

    <div class="nk-content nk-content-fluid">
        <div class="container-xl wide-xl">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <!--   --------------- title --------------     -->
                            <h3 class="nk-block-title page-title">ویرایش دسته‌بندی مشتری</h3>
                            <div class="nk-block-des text-soft">
                                <!--   --------------- توضیح صفحه --------------     -->
{{--                                <p>در مجموج {{ $n }} نفش وجود دارد.</p>--}}
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
                                            <a href="#"
                                               class="dropdown-toggle btn btn-dark btn-dim"
                                               data-bs-toggle="modal" data-bs-target="#modalList"
                                               onclick="event.preventDefault(); document.getElementById('form1').submit();">
                                                <em class="icon ni ni-forward-ios"></em>
                                                <span class="fw-normal">
                                                    لیست دسته‌بندی‌ها
                                                </span>
                                            </a>
                                            <form id="form1" action="{{ route('customers.categories.list') }}" class="d-none"></form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- .nk-block-head-content -->
                    </div>
                    <!-- .nk-block-between -->
                </div>
                @if($errors->any())
                    <div class="alert alert-fill alert-danger alert-icon bg-danger-dim text-danger">
                        <em class="icon ni ni-cross-circle"></em>
                        دسته‌بندی ویرایش نشد!
                    </div>
                @endif
                <!-- .nk-block-head -->
                <div class="nk-block nk-block-lg">

                    <div class="card card-preview">
                        <div class="card-inner">
                            <form action="{{ route('customers.categories.edit', ['id' => $category->id]) }}" method="POST" class="gy-3">
                                @csrf
                                <div class="row g-3 align-center">
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="form-label" for="category_name">نام دسته‌بندی</label>
                                            <span class="form-note">نام دسته‌بندی مشتری</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control @error('category_name') error @enderror" id="category_name" name="category_name" value="{{ old('name', $category->category_name) }}" placeholder="مثال: مشتریان ویژه، مشتریان عادی">
                                                @error('category_name')
                                                <span id="fv-subject-error" class="invalid">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-center">
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="form-label" for="notes">توضیحات</label>
                                            <span class="form-note">توضیحات این دسته‌بندی</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control @error('notes') error @enderror" id="notes" name="notes" value="{{ old('notes', $category->notes) }}" placeholder="توضیحات مربوط به این دسته‌بندی">
                                                @error('notes')
                                                <span id="fv-subject-error" class="invalid">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3">
                                    <div class="col-lg-7 offset-lg-5">
                                        <div class="form-group mt-2">
                                            <button type="submit" class="btn btn-md btn-primary btn-dim fw-normal" data-bs-toggle="modal" data-bs-target="#modalEdit">ویرایش دسته‌بندی</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- .card-preview -->
                </div>
                <!-- .nk-block -->
            </div>
        </div>
    </div>
    <x-admin.modal id="modalEdit" class="modal-body-md">در حال ویرایش دسته‌بندی "{{ $category->name }}" ...</x-admin.modal>
    <x-admin.modal id="modalList" class="modal-body-md">در حال رفت به لیست دسته‌بندی‌ها ...</x-admin.modal>
    <div class="modal fade zoom modal-sm" tabindex="-1" id="modalZoom" style="display: none;" aria-hidden="true">
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
