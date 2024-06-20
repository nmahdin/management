<div class="modal fade zoom  {{ $class ?? 'modal-sm' }}" tabindex="-1" id="{{ $id }}" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                    <span class="spinner-border text-gray" style="margin-bottom: -12px; font-size: 10px;" role="status">
                    </span>
                <span class="m-2">
                       {{ $slot }}
                    </span>
            </div>
        </div>
    </div>
</div>
