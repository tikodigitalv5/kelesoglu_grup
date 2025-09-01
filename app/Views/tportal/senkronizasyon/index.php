<?= $this->extend('tportal/layout') ?>
<?= $this->section('page_title') ?> SYSMOND API
<?= $this->endSection() ?>
<?= $this->section('title') ?> SYSMOND API
<?= $this->endSection() ?>
<?= $this->section('subtitle') ?>
<?= $this->endSection() ?>

<?php helper('Helpers\number_format_helper'); ?>


<?= $this->section('main') ?>


<style>
.dataTables_wrapper {
    width: 100%; /* Tablonun genişliği yüzde 100 olacak şekilde ayarlanır */
    overflow-x: auto; /* Eğer tablo genişlerse yatay kaydırma çıkar */
}

table.dataTable {
    table-layout: auto; /* Tablo sütun genişliği içeriğe göre ayarlanacak */
    width: 100%; /* Tablonun genişliği yüzde 100 olacak */
}

    
    .dataTables_length, .dataTables_filter, .datatable-filter{
        display: block!important;

    }
    .with-export{
        display: flex!important;
        margin-bottom:20px;
        margin-right: 10px;

    }
    .dataTables_length .form-control-select{
        display: block!important;
    }
    .dataTables_length span{
        display:block!important;
    }
</style>
<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-xl">
        <div class="nk-content-body">
            <div class="nk-block">
                <div class="card">
                    <div class="card-aside-wrap">
                        <div class="card-inner card-inner-lg">
                            <div class="nk-block-head nk-block-head-lg">
                          
                              
                            </div><!-- .nk-block-head -->

                            <div class="nk-block">
                                <div class="nk-data data-list">


                                <table class="datatable-init-hareketler nowrap table" data-export-title="Export">
                                        <thead>
                                            <tr style="background-color: #ebeef2;">
                                                <th style="background-color: #ebeef2; width:80px">ID</th>
                                                <th style="background-color: #ebeef2; width:80px">TARİH</th>
                                                <th style="background-color: #ebeef2;" data-orderable="false">MESAJ</th>
                                                <th style="background-color: #ebeef2;" data-orderable="false">DURUM</th>
                                                <th style="background-color: #ebeef2;" data-orderable="false">MAİL</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($sysmond_item as $substock_item){ ?>
                                            <tr>
                                                <td class="text-black"><?= $substock_item['cron_id'] ?></td>
                                                <td><?= $substock_item['tarih'] ?></td>
                                                <td><?= $substock_item['durum'] ?></td>
                                                <td><?php 

                                                if($substock_item['mesaj'] == "active")
                                                {
                                                    echo '<span class="badge bg-success">BAŞARILI</span>';
                                                }                                                
                                                ?></td>
                                                <td><?php 

if($substock_item['mail'] == "1")
{
    echo '<span class="badge bg-success">GÖNDERİLDİ</span>';
}                                                
?></td>
                                              
                                            </tr>
                                            <?php
                                            }
                                            ?>

                                        </tbody>
                                    </table>
                                </div><!-- data-list -->

                            </div><!-- .nk-block -->
                        </div>

                        <!-- card-aside -->
                    </div><!-- .card-aside-wrap -->
                </div><!-- .card -->
            </div><!-- .nk-block -->
        </div>
    </div>
</div>





<?= $this->endSection() ?>

<?= $this->section('script') ?>




<?= $this->endSection() ?>