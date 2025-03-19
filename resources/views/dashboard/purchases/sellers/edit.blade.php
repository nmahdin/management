<x-admin.main title="ویرایش فروشنده">
    <div class="nk-content nk-content-fluid">
        <div class="container-xl wide-xl">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <h3 class="nk-block-title page-title">ویرایش فروشنده</h3>
                        </div>
                        <div class="nk-block-head-content">
                            <div class="toggle-wrap nk-block-tools-toggle">
                                <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu">
                                    <em class="icon ni ni-more-v"></em>
                                </a>
                                <div class="toggle-expand-content" data-content="pageMenu">
                                    <ul class="nk-block-tools g-3">
                                        <li>
                                            <a href="#" class="dropdown-toggle btn btn-dark btn-dim" data-bs-toggle="modal" data-bs-target="#modalList" onclick="event.preventDefault(); document.getElementById('form1').submit();">
                                                <em class="icon ni ni-forward-ios"></em>
                                                <span class="fw-normal">لیست فروشندگان</span>
                                            </a>
                                            <form id="form1" action="{{ route('purchases.sellers.list') }}" class="d-none"></form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if($errors->any())
                    <div class="alert alert-fill alert-danger alert-icon bg-danger-dim text-danger">
                        <em class="icon ni ni-cross-circle"></em>
                        فروشنده ویرایش نشد!
                    </div>
                @endif

                <div class="nk-block nk-block-lg">
                    <div class="card card-preview">
                        <div class="card-inner">
                            <form action="{{ route('purchases.sellers.edit', ['seller' => $seller->id]) }}" method="post">
                                @csrf
                                <div class="row g-4">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label" for="name">نام و نام خانوادگی</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control @error('name') error @enderror" id="name" value="{{ old('name', $seller->name) }}" name="name">
                                                @error('name')
                                                <span id="fv-full-name-error" class="invalid">{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label" for="phone">شماره تماس</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control @error('phone') error @enderror" id="phone" value="{{ old('phone', $seller->phone) }}" name="phone">
                                                @error('phone')
                                                <span class="invalid">{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label" for="address">آدرس</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control" id="address" value="{{ old('address', $seller->address) }}" name="address">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-label" for="note">یادداشت</label>
                                            <textarea class="form-control form-control-sm" name="note" id="note" placeholder="یادداشت یا نکته یا یادآوری در مورد فروشنده">{{ old('note', $seller->note) }}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-lg btn-primary btn-dim fw-normal">ویرایش اطلاعات</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-admin.modal id="modalEdit" class="modal-body-md">در حال ویرایش فروشنده "{{ $seller->name }}" ...</x-admin.modal>
    <x-admin.modal id="modalList" class="modal-body-md">در حال رفتن به لیست فروشندگان ...</x-admin.modal>

    @slot('script')
        <script src="/assets/js/libs/datatable-btns.js"></script>
    @endslot
</x-admin.main>
