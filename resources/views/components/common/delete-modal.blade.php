<div id="delete-modal" class="overlay modal overlay-open:opacity-100 overlay-open:duration-300 hidden" role="dialog"
    tabindex="-1">
    <div class="modal-dialog overlay-open:mt-12 overlay-open:duration-300 transition-all ease-out">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Are you sure?</h3>
                <button type="button" class="btn btn-text btn-circle btn-sm absolute end-3 top-3" aria-label="Close"
                    data-overlay="#delete-modal">
                    <span class="icon-[tabler--x] size-4"></span>
                </button>
            </div>
            <div class="modal-body">
                You won't be able to revert this!
            </div>
            <div class="modal-footer">
                <form id="deleteResourceForm" action="#" method="post" class="contents">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-soft btn-secondary" data-overlay="#delete-modal">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-error">
                        Yes, delete it!
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
