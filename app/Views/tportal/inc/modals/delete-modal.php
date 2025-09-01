<!-- Modal Delete -->
<div class="modal fade" tabindex="-1" id="modal_delete_<?= $element ?>">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body modal-body-lg text-center">
                <div class="nk-modal">
                    <em class="nk-modal-icon icon icon-circle icon-circle-xxl ni ni-question text-danger bg-transparent"
                        style="font-size: 70px;"></em>
                    <h4 class="nk-modal-title"><?= $modal_title ?></h4>
                    <div class="nk-modal-action mb-5">
                        <a href="#" class="btn btn-lg btn-mw btn-light" data-bs-dismiss="modal">Hayır</a>
                        <a href="#" class="btn btn-lg btn-mw btn-danger" id="modal_delete_<?= $element ?>_button" data-bs-dismiss="modal">Evet</a>
                    </div>
                    <div class="nk-modal-text">
                        <p class="lead"><?= $modal_text ?></p>
                    </div>
                </div>
            </div><!-- .modal-body -->
        </div>
    </div>
</div>