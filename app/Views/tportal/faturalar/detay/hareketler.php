<?= $this->extend('tportal/layout') ?>
<?= $this->section('page_title') ?> Cari Detay <?= $this->endSection() ?>
<?= $this->section('title') ?> Cari Detay | <?= session()->get('user_item')['firma_adi'] ?> <?= $this->endSection() ?>
<?= $this->section('subtitle') ?> <?= $this->endSection() ?>

<?php helper('Helpers\number_format_helper'); ?>


<?= $this->section('main') ?>


<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-xl">
        <div class="nk-content-body">
            <div class="nk-block">
                <div class="card">
                    <div class="card-aside-wrap">
                        <div class="card-inner card-inner-lg">
                            <div class="nk-block-head nk-block-head-lg">
                                <div class="nk-block-between">
                                    <div class="nk-block-head-content">
                                        <h4 class="nk-block-title">Cari Hareketleri</h4>

                                    </div>
                                    <div class="nk-block-head-content align-self-start d-lg-none">
                                        <a href="#" class="toggle btn btn-icon btn-trigger mt-n1"
                                            data-target="userAside"><em class="icon ni ni-menu-alt-r"></em></a>
                                    </div>
                                </div>
                            </div><!-- .nk-block-head -->

                            <div class="nk-block">
                                <div class="nk-data data-list">


                                    <table class="datatable-init-hareketler-order-none nowrap table"
                                        data-export-title="Export">
                                        <thead>
                                            <tr style="background-color: #ebeef2;">
                                                <th style="background-color: #ebeef2;">Tarih</th>
                                                <th style="background-color: #ebeef2;">İşlem</th>
                                                <th style="background-color: #ebeef2;">İşlem No</th>
                                                <th style="background-color: #ebeef2;">Bilgi</th>
                                                <th style="background-color: #ebeef2;">Miktar</th>
                                                <th style="background-color: #ebeef2;">Bakiye</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($financial_movement_items as $financial_movement_item) { ?>
                                                <tr>
                                                    <td><?= date("d/m/Y", strtotime($financial_movement_item['transaction_date'])) ?> </td>
                                                    <td><span class="tb-status <?= $financial_movement_item['transaction_direction'] == 'entry' ? 'text-success' : 'text-danger' ;?>"><?= $transaction_types[$financial_movement_item['transaction_type']] ?></span></td>
                                                    <td><?= $financial_movement_item['transaction_number'] ?? '-' ?></td>
                                                    <td><?= $financial_movement_item['transaction_title'] ?></td>
                                                    <td class="text-end para"><?= convert_number_for_form($financial_movement_item['transaction_amount'], 2) ?> <?= $financial_movement_item['money_icon'] ?></td>
                                                    <td class="text-end para"><?= convert_number_for_form($temp_balance, 2) ?> <?= $cari_item['money_icon'] ?></td>
                                                </tr>
                                                <?php 
                                                $temp_balance = $financial_movement_item['transaction_direction'] == 'entry' ? $temp_balance + $financial_movement_item['transaction_amount'] : $temp_balance - $financial_movement_item['transaction_amount'];
                                        } ?>

                                        </tbody>
                                    </table>
                                </div><!-- data-list -->

                            </div><!-- .nk-block -->
                        </div>

                        <?= $this->include('tportal/cariler/detay/inc/sol_menu') ?>
                        <!-- card-aside -->
                    </div><!-- .card-aside-wrap -->
                </div><!-- .card -->
            </div><!-- .nk-block -->
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>

<script>

</script>

<?= $this->endSection() ?>