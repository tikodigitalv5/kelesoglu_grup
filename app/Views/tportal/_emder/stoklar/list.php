<table class="datatable-init-urunler nk-tb-list nk-tb-ulist" data-auto-responsive="false">
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
                                                        <th class="nk-tb-col tb-col-lg"><span class="sub-text">Fabrika</span></th>
                                                        <th class="nk-tb-col tb-col-md"><span class="sub-text">Merter</span></th>
                                                        <th class="nk-tb-col tb-col-lg"><span class="sub-text">İkiteli</span></th>
                                                        <th class="nk-tb-col tb-col-lg"><span class="sub-text">Toplam</span></th>
                                                        <th class="nk-tb-col tb-col-md"><span class="sub-text">Durum</span></th>
                                                        <th class="nk-tb-col nk-tb-col-tools text-end">
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php foreach($stock_items as $stock_item){ ?>
                                    
                                    <tr class="nk-tb-item">
                                        <td class="nk-tb-col nk-tb-col-check">
                                            <div class="custom-control custom-control-sm custom-checkbox notext">
                                                <input type="checkbox" class="custom-control-input" id="uid2">
                                                <label class="custom-control-label" for="uid2"></label>
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
                                                    <span class="sub-text"><?= $stock_item['stock_code'] ?> - <?= $stock_item['category_title'] ?></span>
                                                </div>
                                            </div>
                                        </td>
                                 
                                        <td class="nk-tb-col tb-col-md">
                                            <span class="tb-amount">
                                                569 
                                                <span class="currency fs-10px"><?= $stock_item['sale_unit_title'] ?></span>
                                            </span>
                                        </td>
                                        <td class="nk-tb-col tb-col-md">
                                            <span class="tb-amount">
                                                214 
                                                <span class="currency fs-10px"><?= $stock_item['sale_unit_title'] ?></span>
                                            </span>
                                        </td>
                                        <td class="nk-tb-col tb-col-md">
                                            <span class="tb-amount">
                                                106 
                                                <span class="currency fs-10px"><?= $stock_item['sale_unit_title'] ?></span>
                                            </span>
                                        </td>
                                        <td class="nk-tb-col tb-col-md">
                                            <span class="tb-amount">889 <span
                                                    class="currency fs-10px"><?= $stock_item['sale_unit_title'] ?></span></span>
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