<x-admin.main title="افزودن مشتری">

    <div class="nk-content nk-content-fluid">
        <div class="container-xl wide-xl">
            <livewire:creat-customer/>
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
        <script src="/assets/js/persian-date.js"></script>
        <script src="/assets/js/persian-datepicker.js"></script>
    @endslot

</x-admin.main>


