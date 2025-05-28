<x-admin.main title="ویرایش حساب مالی">

    <div class="nk-content nk-content-fluid">
        <div class="container-xl wide-xl">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <!--   --------------- title --------------     -->
                            <h3 class="nk-block-title page-title"> ویرایش حساب مالی</h3>
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
                                            <a href="{{ route('accounts.list') }}"
                                               class="dropdown-toggle btn btn-dark btn-dim"
                                               data-bs-toggle="modal" data-bs-target="#modalZoom"
                                               onclick="event.preventDefault(); document.getElementById('form1').submit();">
                                                <em class="icon ni ni-forward-ios"></em>
                                                <span class="fw-normal">
                                                    حساب های مالی
                                                </span>
                                            </a>
                                            <form id="form1" action="{{ route('accounts.list') }}" class="d-none"></form>
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
                        حساب ایجاد نشد!
                    </div>
                @endif
                <!-- .nk-block-head -->
                <div class="nk-block nk-block-lg">

                    <div class="card card-preview">
                        <div class="card-inner">
                            <form action="{{ route('accounts.edit' , $account->id) }}" method="POST" class="gy-3">
                                @csrf
                                <div class="row g-3 align-center">
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="form-label" for="label">نام حساب</label>
                                            <span class="form-note"></span>
                                        </div>
                                    </div>
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control @error('label') error @enderror" id="label" name="label" value="{{ old('label' , $account->label) }}" placeholder="به نام حساب مقصد نمایش داده می شود">
                                                @error('label')
                                                <span id="fv-subject-error" class="invalid">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-center">
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="form-label" for="number">شماره حساب</label>
                                            <span class="form-note"></span>
                                        </div>
                                    </div>
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control @error('number') error @enderror" id="number" name="number" value="{{ old('number' , $account->number) }}" placeholder="فقط برای ره گیری حساب قابل استفاده است">
                                                @error('number')
                                                <span id="fv-subject-error" class="invalid">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @php
                                      function check($way , $account){
                                          $ways = json_decode($account->payment_ways);
                                         if (in_array($way , $ways)) {
                                             echo 'checked';
                                         }
                                      }
                                @endphp
                                <div class="row g-3 align-center">
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="form-label" for="payment_label">روش های پرداخت</label>
                                            <span class="form-note"></span>
                                        </div>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="form-group">
                                            <ul class="custom-control-group g-3 align-center">
                                                <li>
                                                    <div class="custom-control custom-control-sm custom-checkbox">
                                                        <input type="checkbox" value="cash" {{ check('cash' , $account) }}
                                                               class="custom-control-input @error('payment_ways') error @enderror"
                                                               id="cash" name="payment_ways[]">
                                                        <label class="custom-control-label" for="cash">
                                                            نقدی
                                                        </label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="custom-control custom-control-sm custom-checkbox">
                                                        <input type="checkbox" value="cart" {{ check('cart' , $account) }}
                                                               class="custom-control-input" id="cart"
                                                               name="payment_ways[]">
                                                        <label class="custom-control-label"
                                                               for="cart">کارت به کارت</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="custom-control custom-control-sm custom-checkbox">
                                                        <input type="checkbox" value="online" class="custom-control-input" {{ check('online' , $account) }}
                                                               id="online" name="payment_ways[]">
                                                        <label class="custom-control-label" for="online">پرداخت آنلاین از درگاه پرداخت</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="custom-control custom-control-sm custom-checkbox">
                                                        <input type="checkbox" value="pos" {{ check('pos' , $account) }}
                                                               class="custom-control-input" id="pos"
                                                               name="payment_ways[]">
                                                        <label class="custom-control-label"
                                                               for="pos">پرداخت با دستگاه پز</label>
                                                        @error('payment_ways')
                                                        <span id="fv-full-name-error"
                                                              class="invalid">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-center">
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="form-label" for="note">توضیحات</label>
                                            {{--                                            <span class="form-note">توضیحات این دسته بندی</span>--}}
                                        </div>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control @error('note') error @enderror" id="note" name="note" value="{{ old('note' , $account->note) }}" placeholder="اختیاری">
                                                @error('note')
                                                <span id="fv-subject-error" class="invalid">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3">
                                    <div class="col-lg-7 offset-lg-5">
                                        <div class="form-group mt-2">
                                            <button type="submit" class="btn btn-md btn-primary btn-dim fw-normal"  data-bs-toggle="modal" data-bs-target="#modalCreate">ویرایش حساب</button>
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
    <x-admin.modal id="modalCreate" class="modal-body-md">در حال ویرایش حساب مالی "{{ $account->label }}" ...</x-admin.modal>
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
