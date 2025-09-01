
<button type="button" id="trigger_<?= $element ?>_okey_button" class="btn btn-success d-none" data-bs-toggle="modal"
    data-bs-target="#okey_modal_<?= $element; ?>">OK</button>
<div class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" data-bs-backdrop="static"
    data-bs-keyboard="false" id="okey_modal_<?= $element; ?>">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-body modal-body-lg text-center">
                <div class="nk-modal">
                    <em class="nk-modal-icon icon icon-circle icon-circle-xxl ni ni-check bg-success"></em>
                    <h4 class="nk-modal-title"><?= $modal_title ?></h4>
                    <div class="nk-modal-text">
                        <div class="caption-text"><?= $modal_text ?></div>
                    </div>
                    <div class="nk-modal-action">
                        <?= $modal_buttons ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>