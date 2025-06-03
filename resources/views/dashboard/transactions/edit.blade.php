<x-admin.main title="ویرایش تراکنش">

    <div class="nk-content nk-content-fluid">
        <div class="container-xl wide-xl">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between g-3">
                        <div class="nk-block-head-content">
                            <h3 class="nk-block-title page-title">ویرایش تراکنش #{{ $transaction->id }}</h3>
                            <div class="nk-block-des text-soft">
                                <p>ویرایش اطلاعات تراکنش</p>
                            </div>
                        </div>
                    </div>
                </div>

                <x-admin.templates.successAlert/>
                <x-admin.templates.warningAlert/>
                <x-admin.templates.dangerAlert/>

                <div class="nk-block">
                    <div class="card card-bordered">
                        <div class="card-inner">
                            <form action="{{ route('transactions.update', $transaction->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="type">نوع تراکنش</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control" id="type" name="type" value="{{ $transaction->type }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="amount">مبلغ</label>
                                            <div class="form-control-wrap">
                                                <input type="number" class="form-control" id="amount" name="amount" value="{{ $transaction->amount }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="date">تاریخ</label>
                                            <div class="form-control-wrap">
                                                <input type="date" class="form-control" id="date" name="date" value="{{ $transaction->date }}">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Add more form fields for other transaction details -->
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary">ذخیره تغییرات</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @slot('script')
        <!-- Add custom scripts here -->
    @endslot
</x-admin.main>
