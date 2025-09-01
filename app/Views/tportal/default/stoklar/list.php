

<table class="datatable-init-urunler-paginate-none nk-tb-list nk-tb-ulist" data-auto-responsive="false">
                            <thead>
                                <tr  class="nk-tb-item nk-tb-head tb-tnx-head">
                                    <th class="nk-tb-col nk-tb-col-check">
                                        <div class="custom-control custom-control-sm custom-checkbox notext">
                                            <input type="checkbox" class="custom-control-input" id="uid">
                                            <label class="custom-control-label" for="uid"></label>
                                        </div>
                                    </th>
                                    
                                    <!-- <th class="nk-tb-col tb-col-lg"><span class="sub-text">S.Tipi</span></th> -->
                                    <th class="nk-tb-col"><span class="sub-text">Ürün</span></th>
                                    <!-- <th class="nk-tb-col tb-col-mb"><span class="sub-text">Kodu</span></th> -->
                                    <th class="nk-tb-col tb-col-lg" data-orderable="false"><span class="sub-text">Kategori</span></th>
                                    <th class="nk-tb-col tb-col-md" data-orderable="false"><span class="sub-text">Stokta</span></th>
                                    <th class="nk-tb-col tb-col-lg" data-orderable="false"><span class="sub-text">İşlemde</span></th>
                                    <th class="nk-tb-col tb-col-lg" data-orderable="false"><span class="sub-text">Toplam</span></th>
                                    <th class="nk-tb-col tb-col-md" data-orderable="false"><span class="sub-text">Durum</span></th>
                                    <th class="nk-tb-col nk-tb-col-tools text-end" data-orderable="false"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($stock_items as $stock_item){ ?>
                                        
                                        <tr class="nk-tb-item">
                                            
                                            <td class="nk-tb-col nk-tb-col-check">
                                                <div class="custom-control custom-control-sm custom-checkbox notext">
                                                    <input type="checkbox" class="custom-control-input" id="uid_<?= $stock_item['stock_id'] ?>">
                                                    <label class="custom-control-label" for="uid_<?= $stock_item['stock_id'] ?>"></label>
                                                </div>
                                            </td>
                                            <!-- <td class="nk-tb-col tb-col-lg">
                                                <a href="<?= route_to('tportal.stocks.detail', $stock_item['stock_id']) ?>">
                                                    <span class="tb-amount"><?= $stock_item['type_title'] ?></span>
                                                </a>
                                            </td> -->
                                            <td class="nk-tb-col">
                                                <div class="user-card">
                                                    <div class="user-avatar">
                                                        <img class="w-100 h-100" src="<?= base_url($stock_item['default_image']) ?>"
                                                            alt="<?= $stock_item['stock_title'] ?>">
                                                    </div>
                                                    <div class="user-info">
                                                        <span class="lead-text"><?= $stock_item['stock_title'] ?></span>
                                                        <span class="sub-text"><?= $stock_item['stock_code'] ?></span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="nk-tb-col tb-col-lg">
                                                <span class="tb-amount"><?= $stock_item['category_title'] ?></span>
                                                <span class="sub-text"><?= $stock_item['type_title'] ?></span>
                                            </td>
                                            <td class="nk-tb-col tb-col-md">
                                                <span class="tb-amount"><?= isset($stock_item['stock_total_amount']['stock_amount']) ? number_format($stock_item['stock_total_amount']['stock_amount'],2,',','.') : '0' ?> <span
                                                        class="currency"><?= $stock_item['buy_unit_title'] ?></span></span>
                                            </td>
                                            <td class="nk-tb-col tb-col-md">
                                                <span class="tb-amount">0 <span
                                                        class="currency"><?= $stock_item['buy_unit_title'] ?></span></span>
                                            </td>
                                            <td class="nk-tb-col tb-col-md">
                                                <span class="tb-amount"><?= isset($stock_item['stock_total_amount']['stock_amount']) ? number_format($stock_item['stock_total_amount']['stock_amount'],2,',','.') : '0' ?> <span
                                                        class="currency"><?= $stock_item['buy_unit_title'] ?></span></span>
                                            </td>
                                            <?php if($stock_item['status'] == 'processing'){ 
                                                echo '
                                                <td class="nk-tb-col tb-col-md">
                                                    <span class="tb-status text-warning">İşlemde</span>
                                                </td>';
                                            }elseif($stock_item['status'] == 'critical'){
                                                echo '
                                                <td class="nk-tb-col tb-col-md">
                                                    <span class="tb-status text-danger">Kritik</span>
                                                </td>
                                                ';
                                            }elseif($stock_item['status'] == 'active'){
                                                echo '
                                                <td class="nk-tb-col tb-col-md">
                                                    <span class="tb-status text-success">Aktif</span>
                                                </td>
                                                ';
                                            }elseif($stock_item['status'] == 'passive'){
                                                echo '
                                                <td class="nk-tb-col tb-col-md">
                                                    <span class="tb-status text-secondary">Pasif</span>
                                                </td>
                                                ';
                                            }
                                            ?>
                                            <td class="nk-tb-col nk-tb-col-tools  text-end">
                                                <a href="<?= route_to('tportal.stocks.detail', $stock_item['stock_id']) ?>"
                                                    class="btn btn-round btn-icon btn-outline-light"><em
                                                        class="icon ni ni-chevron-right"></em></a>
                                            </td>
                                        </tr><!-- .nk-tb-item -->
                                <?php } ?>
                                
                            </tbody>
                        </table>