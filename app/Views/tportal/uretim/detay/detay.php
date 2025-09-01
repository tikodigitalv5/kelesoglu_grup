<?= $this->extend('tportal/layout') ?>
<?= $this->section('page_title') ?> Üretim Detay <?= $this->endSection() ?>
<?= $this->section('title') ?> Üretim Detay | <?= session()->get('user_item')['firma_adi'] ?> <?= $this->endSection() ?>
<?= $this->section('subtitle') ?> <?= $this->endSection() ?>




<?= $this->section('main') ?>
<style>
    .block{
        display:block;
    }
    table.dataTable.nowrap th, table.dataTable.nowrap td {
    white-space: wrap;
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
                                <div class="nk-block-between">
                                    <div class="nk-block-head-content">
                                        <h4 style="'font-family:Gilroy-Semibold!important;'" class="nk-block-title"> <b><?= $order_item['stock_title'] != '' ? $order_item['stock_title'] : $order_item['stock_title'] . " " . $order_item['stock_title'] ?></b>  Üretim Hareketleri</h4>
                                      
                                    </div>
                                    <div class="nk-block-head-content align-self-start d-lg-none">
                                        <a href="#" class="toggle btn btn-icon btn-trigger mt-n1" data-target="userAside"><em class="icon ni ni-menu-alt-r"></em></a>
                                    </div>
                                </div>
                            </div><!-- .nk-block-head -->
                            
                            <div class="nk-block">
                                <div class="nk-data data-list">
                                   

                                    <table class="  table" data-export-title="Export">
                                        <thead>
                                            <tr  style="background-color: #ebeef2;">
                                              <th width="3%" style="width:3%!important; background-color: #ebeef2;">Tarih</th> 
                                                
                                                <th style="background-color: #ebeef2;" >Operasyon</th>
                                          
                                                <th style="background-color: #ebeef2;" >Operatör</th>
                                                <th width="" style=" background-color: #ebeef2;" >Not</th>
                                                <th style="background-color: #ebeef2;" >Durum</th>
                                       
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                         $statusColors = [
                                            'Askıda' => 'danger', // Kırmızı
                                            'Beklemede' => 'warning', // Turuncu
                                            'Sistemde' => 'primary', // Mavi
                                            'İşlemde' => 'info', // Açık mavi
                                            'Bitti' => 'success', // Yeşil
                                            'İptal' => 'default', // Gri
                                            'Durdu' => 'dark', // Siyah
                                            'Devam' => 'info' // Siyah
                                        ];

                                            foreach($uretimHareketleri as $hareket): 
                                                $status = $hareket["status"];
                                              
                                                $color = isset($statusColors[$status]) ? $statusColors[$status] : 'primary'; // Default color: Beyaz

                                            ?>
                                           <tr style="font-size:14px; font-weight:500; background:#f9f9f9;">
    <td style="width:4%;"><?= !empty($hareket['tarih']) && strtotime($hareket['tarih']) > 0 ? date("d/m/Y H:i", strtotime($hareket['tarih'])) : '-' ?></td>
    <td><span class="block"><?= htmlspecialchars($hareket['operation_title']) ?></span></td>
    <td><span class="block">-</span></td>
    <td>
        <?php
            echo "<b>{$hareket['adet']} adet</b> için ";
            if($hareket['status'] == "Bitti"){
                echo "Operatör işlemi <b>{$hareket['sure']}</b> sürede <span style='color:green;'>tamamladı</span>.";
            } elseif($hareket['status'] == "Durdu"){
                echo "Operatör <b>Durdu</b>";
                if(!empty($hareket['neden'])){
                    echo " <span style='color:red;'>(Neden: " . htmlspecialchars($hareket['neden']) . ")</span>";
                }
                echo " (Süre: <b>{$hareket['sure']}</b>)";
            } elseif($hareket['status'] == "İşlemde"){
                echo "Operatör <b>İşlemde</b> (Süre: <b>{$hareket['sure']}</b>)";
            } elseif($hareket['status'] == "Devam"){
                echo "Operatör <b>Devam</b> (Süre: <b>{$hareket['sure']}</b>)";
            } elseif($hareket['status'] == "Askıda" || $hareket['status'] == "Beklemede"){
                echo "Üretim Emiri Operasyonu Oluşturuldu";
            } else {
                echo $hareket['status'];
            }
        ?>
    </td>
    <td><span class="badge bg-<?= $color; ?>" style="font-size:16px; padding:8px 16px;"><?= $hareket["status"] ?></span></td>
</tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div><!-- data-list -->
                              
                            </div><!-- .nk-block -->
                        </div>
                        
                        <?= $this->include('tportal/uretim/detay/inc/sol_menu') ?>
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