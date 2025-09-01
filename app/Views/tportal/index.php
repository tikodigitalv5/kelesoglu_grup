<?= $this->extend('tportal/layout') ?>
<?= $this->section('page_title') ?> Anasayfa
<?= $this->endSection() ?>
<?= $this->section('title') ?> Anasayfa |
<?= session()->get('user_item')['firma_adi'] ?>
<?= $this->endSection() ?>
<?= $this->section('subtitle') ?>
<?= $this->endSection() ?>




<?= $this->section('main') ?>
<div class="nk-content nk-content-fluid">
  <div class="container-xl wide-xl">
    <div class="nk-content-body">
      <div class="nk-block-head nk-block-head-sm d-none">
        <div class="nk-block-between">
          <div class="nk-block-head-content">
            <h3 class="nk-block-title page-title " style="line-height: .7; margin-bottom:0;">Anasayfa</h3>
            <div class="nk-block-des text-soft">
              <p></p>
            </div>
          </div>
          <div class="nk-block-head-content">
            <div class="toggle-wrap nk-block-tools-toggle">
              <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em
                  class="icon ni ni-more-v"></em></a>
              <div class="toggle-expand-content" data-content="pageMenu">
                <ul class="nk-block-tools g-3">
                  <li><a href="#" class="btn btn-white btn-dim btn-outline-primary"><em
                        class="icon ni ni-download-cloud"></em><span>Export</span></a></li>
                  <li><a href="#" class="btn btn-white btn-dim btn-outline-primary"><em
                        class="icon ni ni-reports"></em><span>Reports</span></a></li>
                  <li class="nk-block-tools-opt">
                    <div class="drodown">
                      <a href="#" class="dropdown-toggle btn btn-icon btn-primary" data-bs-toggle="dropdown"><em
                          class="icon ni ni-plus"></em></a>
                      <div class="dropdown-menu dropdown-menu-end">
                        <ul class="link-list-opt no-bdr">
                          <li><a href="#"><em class="icon ni ni-user-add-fill"></em><span>Add User</span></a></li>
                          <li><a href="#"><em class="icon ni ni-coin-alt-fill"></em><span>Add Order</span></a></li>
                          <li><a href="#"><em class="icon ni ni-note-add-fill-c"></em><span>Add Page</span></a></li>
                        </ul>
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </div><!-- .nk-block-head-content -->
        </div><!-- .nk-block-between -->
      </div><!-- .nk-block-head -->
      <div class="nk-block">
        <div class="row g-gs">
          <div class="col-lg-2 col-6">

              <a href="<?php  if(session()->get('user_id') == 3 || session()->get('user_id') == 14 ) { echo route_to('tportal.cari.sale_order_create', 0);  }else{ echo  route_to('tportal.faturalar.create'); } ?>"
              class="btn btn-icon w-100 btn-kare btn-dim btn-outline-light <?php if(array_search('Faturalar', array_column(session()->get('user_modules'), 'module_title')) != null || strval(array_search('Faturalar', array_column(session()->get('user_modules'), 'module_title'))) == '0') echo '1'; else echo 'disabled'; ?>">
              <img src="<?= base_url('custom/img/add-fatura.png') ?>" class="" style="width: 50px">
              <br>
              <span>
                <?php 

                if(session()->get('user_id') == 3 || session()->get('user_id') == 14 ){
                  echo 'Yeni Satış';
                  $retVal = "Yeni Satış";
                  

                }else{
                  echo 'Yeni Fatura';
                  $retVal = "Yeni Fatura";

                }
                
?>              </span>
            </a>
          </div>
          <?php if(session()->get('user_id') == 3 || session()->get('user_id') == 14 ){ ?>

            <div class="col-lg-2 col-6">

<a href="<?php  if(session()->get('user_id') == 3 || session()->get('user_id') == 14 ) { echo route_to('tportal.cari.supplier_return_create', 0);  }else{ echo  route_to('tportal.faturalar.create'); } ?>"
class="btn btn-icon w-100 btn-kare btn-dim btn-outline-light <?php if(array_search('Faturalar', array_column(session()->get('user_modules'), 'module_title')) != null || strval(array_search('Faturalar', array_column(session()->get('user_modules'), 'module_title'))) == '0') echo '1'; else echo 'disabled'; ?>">
<img src="<?= base_url('custom/img/add-fatura.png') ?>" class="" style="width: 50px">
<br>
<span>
  <?php 

  if(session()->get('user_id') == 3 || session()->get('user_id') == 14 ){
    echo 'Yeni Tedarikçi İadesi';
    $retVal = "Yeni Tedarikçi İadesi";
    

  }else{
    echo 'Yeni Tedarikçi İadesi';
    $retVal = "Yeni Tedarikçi İadesi";

  }
  
?>              </span>
</a>
</div>
            <?php } ?>

          <div class="col-lg-2 col-6">
            <a href="<?= route_to('tportal.cariler.create') ?>"
              class="btn btn-icon w-100 btn-kare btn-dim btn-outline-light <?php if(array_search('Cariler', array_column(session()->get('user_modules'), 'module_title')) != null || strval(array_search('Cariler', array_column(session()->get('user_modules'), 'module_title'))) == '0') echo '1'; else echo 'disabled'; ?>">
              <img src="<?= base_url('custom/img/add-cari.png') ?>" class="" style="width: 50px">
              <br>
              <span>Yeni Cari</span>
            </a>
          </div>

          <div class="col-lg-2 col-6">
            <a href="<?= route_to('tportal.stocks.create') ?>"
              class="btn btn-icon w-100 btn-kare btn-dim btn-outline-light <?php if(array_search('Stoklar', array_column(session()->get('user_modules'), 'module_title')) != null || strval(array_search('Stoklar', array_column(session()->get('user_modules'), 'module_title'))) == '0') echo '1'; else echo 'disabled'; ?>">
              <img src="<?= base_url('custom/img/add-stok.png') ?>" class="" style="width: 50px">
              <br>
              <span>Yeni Stok</span>
            </a>
          </div>

          <div class="col-lg-2 col-6">
            <a href="#" class="btn btn-icon w-100 btn-kare btn-dim btn-outline-light <?php if(array_search('Hesaplar', array_column(session()->get('user_modules'), 'module_title')) != null || strval(array_search('Hesaplar', array_column(session()->get('user_modules'), 'module_title'))) == '0') echo '1'; else echo 'disabled'; ?>">
              <img src="<?= base_url('custom/img/add-gider.png') ?>" class="" style="width: 50px">
              <br>
              <span>Yeni Gider</span>
            </a>
          </div>

          <div class="col-lg-2 col-6">
            <a href="<?= route_to('tportal.cariler.payment_or_collection_create_page') ?>?q=tahsilat"
              class="btn btn-icon w-100 btn-kare btn-dim btn-outline-light <?php if(array_search('Hesaplar', array_column(session()->get('user_modules'), 'module_title')) != null || strval(array_search('Hesaplar', array_column(session()->get('user_modules'), 'module_title'))) == '0') echo '1'; else echo 'disabled'; ?>">
              <img src="<?= base_url('custom/img/add-tahsilat.png') ?>" class="" style="width: 50px">
              <br>
              <span>Yeni Tahsilat</span>
            </a>
          </div>

          <div class="col-lg-2 col-6 <?php if(session()->get('user_id') == 3 || session()->get('user_id') == 14 ) echo 'd-none'; ?>">
            <a href="<?= route_to('tportal.cariler.payment_or_collection_create_page') ?>?q=odeme"
              class="btn btn-icon w-100 btn-kare btn-dim btn-outline-light <?php if(array_search('Hesaplar', array_column(session()->get('user_modules'), 'module_title')) != null || strval(array_search('Hesaplar', array_column(session()->get('user_modules'), 'module_title'))) == '0') echo '1'; else echo 'disabled'; ?>">
              <img src="<?= base_url('custom/img/add-odeme.png') ?>" class="" style="width: 50px">
              <br>
              <span>Yeni Ödeme</span>
            </a>
          </div>
          <div class="col-lg-12 d-none">
            <div class="card h-100">
              <div class="card-inner">
                <div class="card-title-group align-start mb-3">
                  <div class="card-title">
                    <h6 class="title">Gelir / Gider (Son 12 Ay)</h6>
                    <p>Son 12 ay içindeki alış ve satış faturalarınızın grafiği.</p>
                  </div>

                </div><!-- .card-title-group -->
                <div class="nk-order-ovwg">
                  <div class="row g-4 align-end">
                    <div class="col-xxl-9">
                      <div class="nk-order-ovwg-ck">
                        <canvas class="order-overview-chart" id="orderOverview"></canvas>
                      </div>
                    </div><!-- .col -->
                    <div class="col-xxl-3">
                      <div class="row g-4">
                        <div class="col-sm-6 col-xxl-12">
                          <div class="nk-order-ovwg-data sell">
                            <div class="amount">338.500 <small class="currenct currency-usd">TL</small></div>
                            <div class="info">KDV <strong>61.020 <span class="currenct currency-usd">TL</span></strong>
                            </div>
                            <div class="title"><em class="icon ni ni-arrow-down-right"></em> Gelirler</div>
                          </div>
                        </div>
                        <div class="col-sm-6 col-xxl-12">
                          <div class="nk-order-ovwg-data buy">
                            <div class="amount">185.860 <small class="currenct currency-usd">TL</small></div>
                            <div class="info">KDV <strong>39.485 <span class="currenct currency-usd">TL</span></strong>
                            </div>
                            <div class="title"><em class="icon ni ni-arrow-up-left"></em> Giderler</div>
                          </div>
                        </div>
                      </div>
                    </div><!-- .col -->
                  </div>
                </div><!-- .nk-order-ovwg -->
              </div><!-- .card-inner -->
            </div><!-- .card -->
          </div><!-- .col -->

          <div class="col-xl-12 <?php if(array_search('Faturalar', array_column(session()->get('user_modules'), 'module_title')) != null || strval(array_search('Faturalar', array_column(session()->get('user_modules'), 'module_title'))) == '0') echo '1'; else echo 'd-none'; ?>">
            <div class="card card-full">
              <div class="card-inner">
                <div class="card-title-group">
                  <div class="card-title">
                    <h6 class="title"><span class="me-2">Bugüne Ait Faturalar</span><small class="subtext">(<?php echo date('d/m/Y') ?>)</small></h6>
                  </div>
                  <div class="card-tools">
                    <ul class="card-tools-nav">
                      <ul class="nav" role="tablist" style="justify-content: end; margin-right: 10px;">
                        <li class="nav-item" role="presentation"><a class="nav-link active" data-bs-toggle="tab"
                            href="#tabItem1" aria-selected="false" role="tab" tabindex="-1">Satış</a></li>
                        <li class="nav-item" role="presentation"><a class="nav-link" data-bs-toggle="tab"
                            href="#tabItem2" aria-selected="false" role="tab" tabindex="-1">Alış</a></li>
                      </ul>
                    </ul>
                  </div>
                </div>
              </div><!-- .card-inner -->
              <div class="card-inner p-0 border-top">
                <div class="card-inner p-0">
                  <div class="tab-content">
                    <div class="tab-pane active show" id="tabItem1" role="tabpanel">

                      <div class="datatable-wrap my-3">
                        <div class="dataTables_scroll">
                          
                          <div class="" style="position: relative; overflow: auto; width: 100%;">

                            <table id="datatableInvoice" class="nk-tb-list nk-tb-ulist dataTable no-footer"
                              data-auto-responsive="false" aria-describedby="datatableInvoice_info">
                              <thead>
                                    <tr class="nk-tb-item nk-tb-head tb-tnx-head">

                                        <th class="nk-tb-col"><span class="sub-text">MÜŞTERİ / E-POSTA</span></th>
                                        <th class="nk-tb-col tb-col-lg" data-orderable="false"><span class="sub-text">FATURA NUMARASI</span></th>
                                        <th class="nk-tb-col tb-col-md" data-orderable="false"><span class="sub-text">FATURA TARİHİ</span></th>
                                        <th class="nk-tb-col tb-col-lg" data-orderable="false"><span class="sub-text">FATURA TİPİ</span></th>
                                        <th class="nk-tb-col tb-col-lg" data-orderable="false"><span class="sub-text">FATURA DURUMU</span></th>
                                        <th class="nk-tb-col tb-col-lg" data-orderable="false"><span class="sub-text">FATURA TUTARI</span></th>
                                        <th class="nk-tb-col nk-tb-col-tools text-end" data-orderable="false"></th>
                                    </tr>
                                </thead>

                              <tbody>

                                <?php
                                foreach ($outgoing_invoices as $outgoing_invoice) {
                                  
                                  $text1 = '';
                                  if ($outgoing_invoice['sale_type'] == 'quick' && $outgoing_invoice['invoice_direction'] == 'incoming_invoice')
                                      $text1 = 'Hızlı Alış Faturası';
                                  else if ($outgoing_invoice['sale_type'] == 'quick' && $outgoing_invoice['invoice_direction'] == 'outgoing_invoice')
                                      $text1= 'Hızlı Satış Faturası';
                          
                                  ?>

                                  <tr class="nk-tb-item odd" onclick="window.location.href = '<?= $outgoing_invoice['sale_type'] == 'quick' ? route_to('tportal.cari.quick_sale_order.detail',$outgoing_invoice['invoice_id']) : route_to('tportal.faturalar.detail',$outgoing_invoice['invoice_id']) ?>' ">
                                    <td class="  nk-tb-col nk-tb-col tb-col-lg">

                                      <div class="user-card">
                                        <div class="user-avatar bg-secondary-dim sq">
                                          <span>
                                            <?= $outgoing_invoice['cari_invoice_title'] == '' ? mb_substr($outgoing_invoice['cari_name'], 0, 1) : mb_substr($outgoing_invoice['cari_invoice_title'], 0, 1) ?>
                                          </span>
                                        </div>
                                        <div class="user-info">
                                          <a href="<?= $outgoing_invoice['sale_type'] == 'quick' ? route_to('tportal.cari.quick_sale_order.detail',$outgoing_invoice['invoice_id']) : route_to('tportal.faturalar.detail',$outgoing_invoice['invoice_id']) ?>" style="color:inherit;">
                                            <span class="tb-lead"><?= $outgoing_invoice['cari_invoice_title'] == '' ? $outgoing_invoice['cari_name'] : $outgoing_invoice['cari_invoice_title'] ?><span
                                                class="dot dot-warning d-md-none ms-1"></span></span>
                                            <span> </span>
                                          </a>
                                        </div>
                                      </div>

                                    </td>
                                    <td class="  nk-tb-col nk-tb-col tb-col-md">


                                      <div class="user-info">
                                        <span class="tb-lead"><?= $outgoing_invoice['sale_type'] == 'quick' ? "#PROFORMA" : ($outgoing_invoice['is_quick_sale_receipt'] == 1 && $outgoing_invoice['invoice_direction'] == 'outgoing_invoice' ? 'Hızlı Satış Fişi' : $outgoing_invoice['invoice_no']) ?> </span>
                                        <span> <?= $text1 ?> <?= $outgoing_invoice['invoice_serial_prefix'] == null ? '' : $outgoing_invoice['invoice_serial_prefix'] ?>  <?= $outgoing_invoice['sale_type'] == 'quick' ? "" : ($outgoing_invoice['cari_obligation'] == 'e-archive' ? "E-Arşiv" : "E-Fatura") ?> </span>
                                      </div>


                                    </td>
                                    <td class="  nk-tb-col nk-tb-col tb-col-md">


                                      <div class="user-info">
                                        <span class="tb-lead"><?= date("d/m/Y", strtotime($outgoing_invoice['invoice_date'])) ?></span>
                                        <!-- <span>15:46:53</span> -->
                                      </div>

                                    </td>
                                    <td class="  nk-tb-col nk-tb-col tb-col-md">

                                      <div class="user-card">
                                        <div class="user-info">
                                          <span class="tb-lead"> <?= $outgoing_invoice['invoice_direction'] == 'outgoing_invoice' ? 'Satış' : 'Alış' ?> </span>
                                          <span> </span>
                                        </div>
                                      </div>

                                    </td>
                                    <td class="  nk-tb-col nk-tb-col tb-col-md">

                                      <span class="tb-lead">
                                        
                                      <?php foreach($selectArrayOutGoing as $status):?>
                                        <?php if($status['invoice_outgoing_status_id'] == $outgoing_invoice['invoice_status_id']):?>
                                          <span class="dot dot-<?php echo $status['status_info'];?> ms-1"></span>  <?php echo $status['status_name'];?>
                                        <?php endif;?>
                                      <?php endforeach;?>
                                      
                                      </span>

                                    </td>
                                    <td class="  nk-tb-col nk-tb-col tb-col-md">

                                      <span class="tb-lead"> <?= $outgoing_invoice['money_icon'] . ' ' . number_format($outgoing_invoice['amount_to_be_paid'], 2, ',', '.') ?> </span>

                                    </td>

                                    

                                    <td class="  nk-tb-col nk-tb-col tb-col-md">
                                      <a href="<?= $outgoing_invoice['sale_type'] == 'quick' ? route_to('tportal.cari.quick_sale_order.detail',$outgoing_invoice['invoice_id']) : route_to('tportal.faturalar.detail',$outgoing_invoice['invoice_id']) ?>" class="btn btn-round btn-icon btn-outline-light"><em class="icon ni ni-chevron-right"></em></a></td>
                                  </tr>

                                <?php } ?>

                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>

                    </div>
                    <div class="tab-pane" id="tabItem2" role="tabpanel">
                      <div class="datatable-wrap my-3">
                        <div class="dataTables_scroll">
                          
                          <div class="" style="position: relative; overflow: auto; width: 100%;">

                            <table id="datatableInvoice" class="nk-tb-list nk-tb-ulist dataTable no-footer"
                              data-auto-responsive="false" aria-describedby="datatableInvoice_info">
                              <thead>
                                    <tr class="nk-tb-item nk-tb-head tb-tnx-head">

                                        <th class="nk-tb-col"><span class="sub-text">MÜŞTERİ / E-POSTA</span></th>
                                        <th class="nk-tb-col tb-col-lg" data-orderable="false"><span class="sub-text">FATURA NUMARASI</span></th>
                                        <th class="nk-tb-col tb-col-md" data-orderable="false"><span class="sub-text">FATURA TARİHİ</span></th>
                                        <th class="nk-tb-col tb-col-lg" data-orderable="false"><span class="sub-text">FATURA TİPİ</span></th>
                                        <th class="nk-tb-col tb-col-lg" data-orderable="false"><span class="sub-text">FATURA DURUMU</span></th>
                                        <th class="nk-tb-col tb-col-lg" data-orderable="false"><span class="sub-text">FATURA TUTARI</span></th>
                                        <th class="nk-tb-col nk-tb-col-tools text-end" data-orderable="false"></th>
                                    </tr>
                                </thead>

                              <tbody>

                                <?php
                                foreach ($incoming_invoices as $incoming_invoices) {
                                  
                                  $text1 = '';
                                  $text2 = '';
                                  if ($incoming_invoices['sale_type'] == 'quick' && $incoming_invoices['invoice_direction'] == 'incoming_invoice')
                                      $text1 = 'Hızlı Alış Faturası';
                                  else if ($incoming_invoices['sale_type'] == 'quick' && $incoming_invoices['invoice_direction'] == 'incoming_invoices')
                                      $text1= 'Hızlı Satış Faturası';
                          
                                  if ($incoming_invoices['sale_type'] == 'quick' && $incoming_invoices['invoice_direction'] == 'incoming_invoice' && $incoming_invoices['is_return'] == 1)
                                    $text2 = '( iade )';
                                  ?>

                                  <tr class="nk-tb-item odd" onclick="window.location.href= '<?= $incoming_invoices['sale_type'] == 'quick' ? route_to('tportal.cari.quick_sale_order.detail',$incoming_invoices['invoice_id']) : route_to('tportal.faturalar.detail',$incoming_invoices['invoice_id']) ?>' ">
                                    <td class="  nk-tb-col nk-tb-col tb-col-lg">

                                      <div class="user-card">
                                        <div class="user-avatar bg-secondary-dim sq">
                                          <span>
                                            <?= $incoming_invoices['cari_invoice_title'] == '' ? mb_substr($incoming_invoices['cari_name'], 0, 1) : mb_substr($incoming_invoices['cari_invoice_title'], 0, 1) ?>
                                          </span>
                                        </div>
                                        <div class="user-info">
                                          <a href="<?= $incoming_invoices['sale_type'] == 'quick' ? route_to('tportal.cari.quick_sale_order.detail',$incoming_invoices['invoice_id']) : route_to('tportal.faturalar.detail',$incoming_invoices['invoice_id']) ?>" style="color:inherit;">
                                            <span class="tb-lead"><?= $incoming_invoices['cari_invoice_title'] == '' ? $incoming_invoices['cari_name'] : $incoming_invoices['cari_invoice_title'] ?><span
                                                class="dot dot-warning d-md-none ms-1"></span></span>
                                            <span> </span>
                                          </a>
                                        </div>
                                      </div>

                                    </td>
                                    <td class="  nk-tb-col nk-tb-col tb-col-md">


                                      <div class="user-info">
                                        <span class="tb-lead"><?= $incoming_invoices['sale_type'] == 'quick' ? "#PROFORMA" : ($incoming_invoices['is_quick_sale_receipt'] == 1 && $incoming_invoices['invoice_direction'] == 'incoming_invoices' ? 'Hızlı Satış Fişi' : $incoming_invoices['invoice_no']) ?> </span>
                                        <span> <?= $text1 ?> <?= $text2 ?>  <?= $incoming_invoices['sale_type'] == 'quick' ? "" : ($incoming_invoices['cari_obligation'] == 'e-archive' ? "E-Arşiv" : "E-Fatura") ?> </span>
                                      </div>


                                    </td>
                                    <td class="  nk-tb-col nk-tb-col tb-col-md">


                                      <div class="user-info">
                                        <span class="tb-lead"><?= date("d/m/Y", strtotime($incoming_invoices['invoice_date'])) ?></span>
                                        <!-- <span>15:46:53</span> -->
                                      </div>

                                    </td>
                                    <td class="  nk-tb-col nk-tb-col tb-col-md">

                                      <div class="user-card">
                                        <div class="user-info">
                                          <span class="tb-lead"> <?= $incoming_invoices['invoice_direction'] == 'incoming_invoices' ? 'Satış' : 'Alış' ?> </span>
                                          <span> </span>
                                        </div>
                                      </div>

                                    </td>
                                    <td class="  nk-tb-col nk-tb-col tb-col-md">

                                      <span class="tb-lead"><span class="dot dot-primary ms-1"></span> Sistemde</span>

                                    </td>
                                    <td class="  nk-tb-col nk-tb-col tb-col-md">


                                      <span class="tb-lead"> <?= $incoming_invoices['money_icon'] . ' ' . number_format($incoming_invoices['amount_to_be_paid'], 2, ',', '.') ?> </span>


                                    </td>

                                    

                                    <td class="  nk-tb-col nk-tb-col tb-col-md">
                                      <a href="<?= $incoming_invoices['sale_type'] == 'quick' ? route_to('tportal.cari.quick_sale_order.detail',$incoming_invoices['invoice_id']) : route_to('tportal.faturalar.detail',$incoming_invoices['invoice_id']) ?>" class="btn btn-round btn-icon btn-outline-light"><em class="icon ni ni-chevron-right"></em></a></td>
                                  </tr>

                                <?php } ?>

                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                  </div>
                </div>
              </div><!-- .card-inner -->
              <div class="card-inner-sm border-top text-center d-sm-none">
                <a href="#" class="btn btn-link btn-block">See History</a>
              </div><!-- .card-inner -->
            </div>
          </div><!-- .col -->
          <div class="col-xl-5 col-xxl-4">

            <div class="row g-gs d-none">
              <div class="col-md-6 col-lg-12">
                <div class="card card-full">
                  <div class="card-inner">
                    <div class="card-title-group align-start mb-2">
                      <div class="card-title">
                        <h6 class="title">Kontür Kullanımı (1000/32)</h6>
                        <p>Son kontür paketi kullanımları.</p>
                      </div>

                    </div><!-- .card-title-group -->
                    <div class="nk-coin-ovwg">
                      <div class="nk-coin-ovwg-ck">
                        <canvas class="coin-overview-chart" id="coinOverview"></canvas>
                      </div>
                      <ul class="nk-coin-ovwg-legends">
                        <li style="margin-top: 25px;"><span class="dot dot-lg sq" data-bg="#014ad0"></span><span>Satış
                            (17)</span></li>
                        <li style="margin-top: 55px;"><span class="dot dot-lg sq" data-bg="#F2426E"></span><span>Alış
                            (15)</span></li>
                      </ul>
                    </div><!-- .nk-coin-ovwg -->
                  </div><!-- .card-inner -->
                </div><!-- .card -->
              </div><!-- .col -->
              <div class="col-md-6 col-lg-12 d-none">
                <div class="card card-full">
                  <div class="card-inner">
                    <div class="card-title-group align-start mb-3">
                      <div class="card-title">
                        <h6 class="title">Cariler</h6>
                        <p>Sistemdeki toplam müşteri ve tedarikçi sayılarınız</p>
                      </div>
                      <div class="card-tools mt-n1 me-n1">

                      </div>
                    </div>
                    <div class="user-activity-group g-4">
                      <div class="user-activity">
                        <em class="icon ni ni-users"></em>
                        <div class="info">
                          <span class="amount">345</span>
                          <span class="title">Müşteri</span>
                        </div>
                      </div>
                      <div class="user-activity">
                        <em class="icon ni ni-users"></em>
                        <div class="info">
                          <span class="amount">49</span>
                          <span class="title">Tedarikçi</span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="user-activity-ck">
                    <canvas class="usera-activity-chart" id="userActivity"></canvas>
                  </div>
                </div><!-- .card -->
              </div><!-- .col -->
            </div><!-- .row -->
          </div><!-- .col -->
        </div><!-- .row -->
      </div><!-- .nk-block -->
    </div>
  </div>
</div>


<?= $this->endSection() ?>

<?= $this->section('script') ?>




<script>

  var orderOverview = {
    labels: ["Ağustos", "Eylül", "Ekim", "Kasım", "Aralık", "Ocak", "Şubat", "Mart", "Nisan", "Mayıs", "Haziran", "Temmuz"],
    dataUnit: 'TL',
    datasets: [{
      label: "Gider",
      color: "#F2426E",
      data: [18200, 12000, 16000, 25000, 18200, 14400, 17000, 18200, 14000, 21000, 11000, 660]
    }, {
      label: "Gelir",
      color: "#035cff",
      data: [30000, 34500, 24500, 18200, 27000, 48700, 24700, 26000, 40000, 23800, 21000, 4000]
    }]
  };
  function orderOverviewChart(selector, set_data) {
    var $selector = selector ? $(selector) : $('.order-overview-chart');
    $selector.each(function () {
      var $self = $(this),
        _self_id = $self.attr('id'),
        _get_data = typeof set_data === 'undefined' ? eval(_self_id) : set_data,
        _d_legend = typeof _get_data.legend === 'undefined' ? false : _get_data.legend;
      var selectCanvas = document.getElementById(_self_id).getContext("2d");
      var chart_data = [];
      for (var i = 0; i < _get_data.datasets.length; i++) {
        chart_data.push({
          label: _get_data.datasets[i].label,
          data: _get_data.datasets[i].data,
          // Styles
          backgroundColor: _get_data.datasets[i].color,
          borderWidth: 2,
          borderColor: 'transparent',
          hoverBorderColor: 'transparent',
          borderSkipped: 'bottom',
          barPercentage: .8,
          categoryPercentage: .6
        });
      }
      var chart = new Chart(selectCanvas, {
        type: 'bar',
        data: {
          labels: _get_data.labels,
          datasets: chart_data
        },
        options: {
          legend: {
            display: _get_data.legend ? _get_data.legend : false,
            rtl: NioApp.State.isRTL,
            labels: {
              boxWidth: 30,
              padding: 20,
              fontColor: '#6783b8'
            }
          },
          maintainAspectRatio: false,
          tooltips: {
            enabled: true,
            rtl: NioApp.State.isRTL,
            callbacks: {
              title: function title(tooltipItem, data) {
                return data.datasets[tooltipItem[0].datasetIndex].label;
              },
              label: function label(tooltipItem, data) {
                return data.datasets[tooltipItem.datasetIndex]['data'][tooltipItem['index']] + ' ' + _get_data.dataUnit;
              }
            },
            backgroundColor: '#eff6ff',
            titleFontSize: 13,
            titleFontColor: '#6783b8',
            titleMarginBottom: 6,
            bodyFontColor: '#9eaecf',
            bodyFontSize: 12,
            bodySpacing: 4,
            yPadding: 12,
            xPadding: 12,
            footerMarginTop: 0,
            displayColors: false
          },
          scales: {
            yAxes: [{
              display: true,
              stacked: _get_data.stacked ? _get_data.stacked : false,
              position: NioApp.State.isRTL ? "right" : "left",
              ticks: {
                beginAtZero: true,
                fontSize: 11,
                fontColor: '#9eaecf',
                padding: 10,
                callback: function callback(value, index, values) {
                  return value + ' TL';
                },
                min: 1000,
                max: 51000,
                stepSize: 10000
              },
              gridLines: {
                color: NioApp.hexRGB("#526484", .2),
                tickMarkLength: 0,
                zeroLineColor: NioApp.hexRGB("#526484", .2)
              }
            }],
            xAxes: [{
              display: true,
              stacked: _get_data.stacked ? _get_data.stacked : false,
              ticks: {
                fontSize: 9,
                fontColor: '#9eaecf',
                source: 'auto',
                padding: 10,
                reverse: NioApp.State.isRTL
              },
              gridLines: {
                color: "transparent",
                tickMarkLength: 0,
                zeroLineColor: 'transparent'
              }
            }]
          }
        }
      });
    });
  }
  // init chart
  NioApp.coms.docReady.push(function () {
    orderOverviewChart();
  });




  var coinOverview = {
    labels: ["Satış Faturaları için", "Alış Faturaları için"],
    stacked: true,
    datasets: [{
      label: "Kontür",
      color: ["#014ad0", "#F2426E"],
      data: [17, 15]
    }]
  };
  function coinOverviewChart(selector, set_data) {
    var $selector = selector ? $(selector) : $('.coin-overview-chart');
    $selector.each(function () {
      var $self = $(this),
        _self_id = $self.attr('id'),
        _get_data = typeof set_data === 'undefined' ? eval(_self_id) : set_data,
        _d_legend = typeof _get_data.legend === 'undefined' ? false : _get_data.legend;
      var selectCanvas = document.getElementById(_self_id).getContext("2d");
      var chart_data = [];
      for (var i = 0; i < _get_data.datasets.length; i++) {
        chart_data.push({
          label: _get_data.datasets[i].label,
          data: _get_data.datasets[i].data,
          // Styles
          backgroundColor: _get_data.datasets[i].color,
          borderWidth: 2,
          borderColor: 'transparent',
          hoverBorderColor: 'transparent',
          borderSkipped: 'bottom',
          barThickness: '8',
          categoryPercentage: 0.5,
          barPercentage: 1.0
        });
      }
      var chart = new Chart(selectCanvas, {
        type: 'horizontalBar',
        data: {
          labels: _get_data.labels,
          datasets: chart_data
        },
        options: {
          legend: {
            display: _get_data.legend ? _get_data.legend : false,
            rtl: NioApp.State.isRTL,
            labels: {
              boxWidth: 30,
              padding: 20,
              fontColor: '#6783b8'
            }
          },
          maintainAspectRatio: false,
          tooltips: {
            enabled: true,
            rtl: NioApp.State.isRTL,
            callbacks: {
              title: function title(tooltipItem, data) {
                return data['labels'][tooltipItem[0]['index']];
              },
              label: function label(tooltipItem, data) {
                return data.datasets[tooltipItem.datasetIndex]['data'][tooltipItem['index']] + ' ' + data.datasets[tooltipItem.datasetIndex]['label'];
              }
            },
            backgroundColor: '#eff6ff',
            titleFontSize: 13,
            titleFontColor: '#6783b8',
            titleMarginBottom: 6,
            bodyFontColor: '#9eaecf',
            bodyFontSize: 12,
            bodySpacing: 4,
            yPadding: 10,
            xPadding: 10,
            footerMarginTop: 0,
            displayColors: false
          },
          scales: {
            yAxes: [{
              display: false,
              stacked: _get_data.stacked ? _get_data.stacked : false,
              ticks: {
                beginAtZero: true,
                padding: 0
              },
              gridLines: {
                color: NioApp.hexRGB("#526484", .2),
                tickMarkLength: 0,
                zeroLineColor: NioApp.hexRGB("#526484", .2)
              }
            }],
            xAxes: [{
              display: false,
              stacked: _get_data.stacked ? _get_data.stacked : false,
              ticks: {
                fontSize: 9,
                fontColor: '#9eaecf',
                source: 'auto',
                padding: 0,
                reverse: NioApp.State.isRTL
              },
              gridLines: {
                color: "transparent",
                tickMarkLength: 0,
                zeroLineColor: 'transparent'
              }
            }]
          }
        }
      });
    });
  }
  // init chart
  NioApp.coms.docReady.push(function () {
    coinOverviewChart();
  });



  var userActivity = {
    labels: ["01 Nov", "02 Nov", "03 Nov", "04 Nov", "05 Nov", "06 Nov", "07 Nov", "08 Nov", "09 Nov", "10 Nov", "11 Nov", "12 Nov", "13 Nov", "14 Nov", "15 Nov", "16 Nov", "17 Nov", "18 Nov", "19 Nov", "20 Nov", "21 Nov"],
    dataUnit: '',
    stacked: true,
    datasets: [{
      label: "Müşteri",
      color: "#014ad0",
      data: [110, 80, 125, 55, 95, 75, 90, 110, 80, 125, 55, 95, 75, 90, 110, 80, 125, 55, 95, 75, 90]
    }, {
      label: "Tedarikçi",
      color: NioApp.hexRGB("#6196f9", .2),
      data: [125, 55, 95, 75, 90, 110, 80, 125, 55, 95, 75, 90, 110, 80, 125, 55, 95, 75, 90, 75, 90]
    }]
  };
  function userActivityChart(selector, set_data) {
    var $selector = selector ? $(selector) : $('.usera-activity-chart');
    $selector.each(function () {
      var $self = $(this),
        _self_id = $self.attr('id'),
        _get_data = typeof set_data === 'undefined' ? eval(_self_id) : set_data,
        _d_legend = typeof _get_data.legend === 'undefined' ? false : _get_data.legend;
      var selectCanvas = document.getElementById(_self_id).getContext("2d");
      var chart_data = [];
      for (var i = 0; i < _get_data.datasets.length; i++) {
        chart_data.push({
          label: _get_data.datasets[i].label,
          data: _get_data.datasets[i].data,
          // Styles
          backgroundColor: _get_data.datasets[i].color,
          borderWidth: 2,
          borderColor: 'transparent',
          hoverBorderColor: 'transparent',
          borderSkipped: 'bottom',
          barPercentage: .7,
          categoryPercentage: .7
        });
      }
      var chart = new Chart(selectCanvas, {
        type: 'bar',
        data: {
          labels: _get_data.labels,
          datasets: chart_data
        },
        options: {
          legend: {
            display: _get_data.legend ? _get_data.legend : false,
            rtl: NioApp.State.isRTL,
            labels: {
              boxWidth: 30,
              padding: 20,
              fontColor: '#6783b8'
            }
          },
          maintainAspectRatio: false,
          tooltips: {
            enabled: true,
            rtl: NioApp.State.isRTL,
            callbacks: {
              title: function title(tooltipItem, data) {
                return data.datasets[tooltipItem[0].datasetIndex].label;
              },
              label: function label(tooltipItem, data) {
                return data.datasets[tooltipItem.datasetIndex]['data'][tooltipItem['index']] + ' ' + _get_data.dataUnit;
              }
            },
            backgroundColor: '#eff6ff',
            titleFontSize: 13,
            titleFontColor: '#6783b8',
            titleMarginBottom: 6,
            bodyFontColor: '#9eaecf',
            bodyFontSize: 12,
            bodySpacing: 4,
            yPadding: 10,
            xPadding: 10,
            footerMarginTop: 0,
            displayColors: false
          },
          scales: {
            yAxes: [{
              display: false,
              stacked: _get_data.stacked ? _get_data.stacked : false,
              ticks: {
                beginAtZero: true
              }
            }],
            xAxes: [{
              display: false,
              stacked: _get_data.stacked ? _get_data.stacked : false,
              ticks: {
                reverse: NioApp.State.isRTL
              }
            }]
          }
        }
      });
    });
  }
  // init chart
  NioApp.coms.docReady.push(function () {
    userActivityChart();
  });
</script>

<?= $this->endSection() ?>