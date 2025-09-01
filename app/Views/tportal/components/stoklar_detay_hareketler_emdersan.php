<table class="datatable-init-hareketler nowrap table" data-export-title="Export">
    <?php

    if (isset($stock_movement_items_parent)) { ?>

        <thead>
            <tr style="background-color: #ebeef2;">
                <th style="background-color: #ebeef2;">Tarih</th>
                <th style="background-color: #ebeef2;" data-orderable="false">İşlem</th>
                <th style="background-color: #ebeef2;" data-orderable="false">Ürün Adı</th>
                <th style="background-color: #ebeef2;" data-orderable="false">Depo</th>
                <th style="background-color: #ebeef2;" data-orderable="false">Miktar</th>
                <th style="background-color: #ebeef2;" data-orderable="false">Stok</th>
                <th style="background-color: #ebeef2;" data-orderable="false">...</th>
            </tr>
        </thead>


        <?php $grandTempBalance = 0;
        foreach ($stock_movement_items_parent as $stock_movement_item_parent) { ?>
            <tr>
                <td data-order="<?= $stock_movement_item_parent['transaction_date'] . $stock_movement_item_parent['stock_movement_id'] ?>"
                    title="<?= $stock_movement_item_parent['transaction_date'] ?>">
                    <?= date("d/m/Y", strtotime($stock_movement_item_parent['transaction_date'])) ?>
                </td>

                <?php
                if ($stock_movement_item_parent['movement_type'] == 'incoming') { ?>
                    <td><span class="tb-status text-success">Giriş
                            <?= $stock_movement_item_parent['is_return'] == 1 ? '<small>(iade)</small>' : '' ?>
                        </span></td>
                <?php } elseif ($stock_movement_item_parent['movement_type'] == 'outgoing') { ?>
                    <td><span class="tb-status text-danger">Çıkış</span></td>
                <?php } else { ?>
                    <td><span class="tb-status text-soft">Sevk</span></td>
                <?php }
                ?>

                <td>
                    <?= $stock_movement_item_parent['stock_title'] ?>
                </td>


                <?php
                if ($stock_movement_item_parent['stock_type'] == 'product') {
                    $grandTempBalance = $stock_movement_item_parent['movement_type'] == 'incoming' ? ($grandTempBalance + $stock_movement_item_parent['transaction_quantity']) : ($grandTempBalance - $stock_movement_item_parent['transaction_quantity']); ?>
                    <td style="max-width: 200px !important; width:200px !important; overflow:hidden; text-overflow:ellipsis"
                        width="200" data-bs-toggle="tooltip" data-bs-placement="top"
                        data-bs-title="<?= $stock_movement_item_parent['warehouse_title'] == null ? $stock_movement_item_parent['cari_invoice_title'] : $stock_movement_item_parent['warehouse_title'] . ' (' . $stock_movement_item_parent['cari_invoice_title'] . ')' ?>">
                        <?= $stock_movement_item_parent['warehouse_title'] == null ? $stock_movement_item_parent['cari_invoice_title'] : $stock_movement_item_parent['warehouse_title'] ?>
                        <?= $stock_movement_item_parent['is_return'] == 1 ? '<small>(' . $stock_movement_item_parent['cari_invoice_title'] . ')</small>' : '' ?>
                    </td>
                <?php } else {
                    $grandTempBalance = $grandTempBalance + $stock_movement_item_parent['transaction_quantity']; ?>
                    <td style="max-width: 200px !important; width:200px !important; overflow:hidden; text-overflow:ellipsis" width="200" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="içi boş kayıt">
                        -
                    </td>
                <?php } ?>
              



                <td class="text-right">
                    <?= number_format($stock_movement_item_parent['transaction_quantity'], 2, ',', '.') . ' ' . $stock_movement_item_parent['unit_title'] ?>
                </td>

              

                <td>
                    <?= convert_number_for_form($grandTempBalance, 2) . ' ' . $stock_movement_item_parent['unit_title'] ?>
                </td>

                <td>
                    <?php if ($stock_movement_item_parent['movement_type'] == 'outgoing') { ?>

                        <a href="<?= $stock_movement_item_parent['sale_type'] != 'quick' ? route_to('tportal.faturalar.detail', $stock_movement_item_parent['invoice_id']) : route_to('tportal.cari.quick_sale_order.detail', $stock_movement_item_parent['invoice_id']) ?>"
                            class="btn btn-icon btn-xs btn-dim btn-outline-dark" id="btnPrintBarcode" data-bs-toggle="tooltip"
                            data-bs-placement="top" data-bs-title="Hareketi Görüntüle"><em class="icon ni ni-arrow-right"></em></a>

                    <?php } else { ?>

                        <?php if (isset($stock_movement_item_parent['invoice_id']) && ($stock_movement_item_parent['invoice_id'] != null) && ($stock_movement_item_parent['sale_type'] == 'detailed')) { ?>
                            <a href="<?= route_to('tportal.faturalar.detail', $stock_movement_item_parent['invoice_id']) ?>"
                                class="btn btn-icon btn-xs btn-dim btn-outline-dark" id="btnPrintBarcode" data-bs-toggle="tooltip"
                                data-bs-placement="top" data-bs-title="Hareketi Görüntüle"><em class="icon ni ni-arrow-right"></em></a>

                        <?php } else if (isset($stock_movement_item_parent['invoice_id']) && ($stock_movement_item_parent['invoice_id'] != null) && ($stock_movement_item_parent['sale_type'] == 'quick')) { ?>
                                <a href="<?= route_to('tportal.cari.quick_sale_order.detail', $stock_movement_item_parent['invoice_id']) ?>"
                                    class="btn btn-icon btn-xs btn-dim btn-outline-dark" id="btnPrintBarcode" data-bs-toggle="tooltip"
                                    data-bs-placement="top" data-bs-title="Hareketi Görüntüle"><em class="icon ni ni-arrow-right"></em></a>
                        <?php } else
                            echo '-';
                        ?>

                        <a href="<?= route_to('tportal.stocks.detail', $stock_movement_item_parent['stock_id']) ?>"
                            class="btn btn-icon btn-xs btn-dim btn-outline-dark" id="btnPrintBarcode" data-bs-toggle="tooltip"
                            data-bs-placement="top" data-bs-title="Alt Ürün Detayına Git"><em class="icon ni ni-box"></em></a>

                        <?php
                    } ?>
                </td>

            </tr>
        <?php }
    } else { ?>
        <thead>
            <tr style="background-color: #ebeef2;">
                <th style="background-color: #ebeef2;">Tarih</th>
                <th style="background-color: #ebeef2;" data-orderable="false">İşlem</th>
                <th style="background-color: #ebeef2;" data-orderable="false">İşlem No</th>
                <th style="background-color: #ebeef2;" data-orderable="false">Bilgi</th>
                <th style="background-color: #ebeef2;" data-orderable="false">Depo</th>
                <th style="background-color: #ebeef2;" data-orderable="false">Miktar</th>
                <th style="background-color: #ebeef2;" data-orderable="false">Stok</th>
                <th style="background-color: #ebeef2;" data-orderable="false">...</th>
            </tr>
        </thead>
        <tbody>
            <?php




            foreach ($stock_movement_items as $stock_movement_item) { ?>
                <tr>
                    <td data-order="<?= $stock_movement_item['transaction_date'] . $stock_movement_item['stock_movement_id'] ?>"
                        title="<?= $stock_movement_item['transaction_date'] ?>">
                        <?= date("d/m/Y", strtotime($stock_movement_item['transaction_date'])) ?>
                    </td>
                    <?php
                    if ($stock_movement_item['movement_type'] == 'incoming') { ?>
                        <td><span class="tb-status text-success">Giriş
                                <?= $stock_movement_item['is_return'] == 1 ? '<small>(iade)</small>' : '' ?>
                            </span></td>
                    <?php } elseif ($stock_movement_item['movement_type'] == 'outgoing') { ?>
                        <td><span class="tb-status text-danger">Çıkış</span></td>
                    <?php } else { ?>
                        <td><span class="tb-status text-soft">Sevk</span></td>
                    <?php } ?>
                    <td>
                        <?= $stock_movement_item['transaction_number'] ?>
                    </td>
                    <td style="max-width: 120px !important; width:120px !important; overflow:hidden; text-overflow:ellipsis"
                        width="120" data-bs-toggle="tooltip" data-bs-placement="top"
                        data-bs-title="  <?php if($stock_movement_item['transaction_info'] != $stock_movement_item['cari_invoice_title']){ echo $stock_movement_item['transaction_info'] . " --- " . $stock_movement_item['cari_invoice_title']; }else{ echo $stock_movement_item['transaction_info']; } ?>">
                        <?= $stock_movement_item['transaction_info'] ?? '-' ?> <br>
                        <?php if($stock_movement_item['transaction_info'] != $stock_movement_item['cari_invoice_title']){ echo  $stock_movement_item['cari_invoice_title']; } ?>
                    </td>

             
                    
                    <?php
                    if ($stock_movement_item['from_warehouse'] != null) {
                        echo '<td style="max-width: 1250px !important; width:150px !important; overflow:hidden; text-overflow:ellipsis"
                        width="120" data-bs-toggle="tooltip" data-bs-placement="top"
                        data-bs-title="' . $warehouse_items[array_search($stock_movement_item['from_warehouse'], array_column($warehouse_items, 'warehouse_id'))]['warehouse_title'] . ($stock_movement_item['is_return'] == 1 ? ' (' . $stock_movement_item['cari_invoice_title'] . ')' : '') . '">' . $warehouse_items[array_search($stock_movement_item['from_warehouse'], array_column($warehouse_items, 'warehouse_id'))]['warehouse_title'] . ($stock_movement_item['is_return'] == 1 ? '<small>(' . $stock_movement_item['cari_invoice_title'] . ')</small>' : '') . '</td>';
                        echo $stock_movement_item['is_return'] == 1 ? '<small>(' . $stock_movement_item['cari_invoice_title'] . ')</small>' : '';
                    } elseif ($stock_movement_item['to_warehouse'] != null) {
                        echo '<td style="max-width: 150px !important; width:150px !important; overflow:hidden; text-overflow:ellipsis"
                        width="120" data-bs-toggle="tooltip" data-bs-placement="top"
                        data-bs-title="' . $warehouse_items[array_search($stock_movement_item['to_warehouse'], array_column($warehouse_items, 'warehouse_id'))]['warehouse_title'] . ($stock_movement_item['is_return'] == 1 ? ' (' . $stock_movement_item['cari_invoice_title'] . ')' : '') . '">' . $warehouse_items[array_search($stock_movement_item['to_warehouse'], array_column($warehouse_items, 'warehouse_id'))]['warehouse_title'] . ($stock_movement_item['is_return'] == 1 ? '<small>(' . $stock_movement_item['cari_invoice_title'] . ')</small>' : '') . '</td>';
                    } elseif ($stock_movement_item['from_warehouse'] == null && $stock_movement_item['to_warehouse'] == null) {
                        echo '<td style="max-width: 150px !important; width:150px !important; overflow:hidden; text-overflow:ellipsis"
                        width="120">-</td>';
                    }

                    if ($stock_movement_item['stock_type'] == 'product') {
                        $temp_balance = $stock_movement_item['movement_type'] == 'incoming' ? ($temp_balance + $stock_movement_item['transaction_quantity']) : ($temp_balance - $stock_movement_item['transaction_quantity']);
                    } else {
                        $temp_balance = $temp_balance + $stock_movement_item['transaction_quantity'];
                    }
                    ?>

                    <td class="text-right">
                        <?= number_format($stock_movement_item['transaction_quantity'], 2, ',', '.'); ?>
                    </td>
                    <td>
                        <?= convert_number_for_form($temp_balance, 2); ?>
                    </td>

                    <td>
                        <?php if ($stock_movement_item['movement_type'] == 'outgoing') { 


                            if ($stock_movement_item['sale_type'] == 'detailed') { ?>
                                <a href="<?= route_to('tportal.faturalar.detail', $stock_movement_item['invoice_id']) ?>"
                                    class="btn btn-icon btn-xs btn-dim btn-outline-dark" id="btnPrintBarcode" data-bs-toggle="tooltip"
                                    data-bs-placement="top" data-bs-title="Faturayı Görüntüle Detaylı"><em
                                        class="icon ni ni-arrow-right"></em></a>
                            <?php } else if ($stock_movement_item['sale_type'] == 'quick') { ?>
                                    <a href="<?= route_to('tportal.cari.quick_sale_order.detail', $stock_movement_item['invoice_id']) ?>"
                                        class="btn btn-icon btn-xs btn-dim btn-outline-dark" id="btnPrintBarcode" data-bs-toggle="tooltip"
                                        data-bs-placement="top" data-bs-title="Faturayı Görüntüle Hızlı"><em
                                            class="icon ni ni-arrow-right"></em></a>
                            <?php } else {

                            }

                            ?>

                            <!-- <a href="" class="btn btn-icon btn-xs btn-dim btn-outline-danger" id="deleteInvoice"
                                data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Hareketi Sil"><em
                                    class="icon ni ni-trash-empty"></em></a>

                                    giden fatura -->

                        <?php } else { ?>

                            <button type="button" class="btn btn-icon btn-xs btn-dim btn-outline-dark" id="printStockBarcode"
                            data-barcode-number="<?= $stock_movement_item['barcode_number'] ?>"
                                    data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Barkod Yazdır"><em
                                        class="icon ni ni-printer-fill"></em></button>
                                        
                            <?php
                            if ($stock_movement_item['is_return'] != 1) {
                                ?>
                                <button type="button" class="btn btn-icon btn-xs btn-dim btn-outline-danger deleteStock"
                                    id="btnDeleteStock" data-stock-barcode-id="<?= $stock_movement_item['stock_barcode_id'] ?>"
                                    data-stock-id="<?= $stock_movement_item['stock_id'] ?>" data-bs-toggle="tooltip"
                                    data-bs-placement="top" data-bs-title="Hareketi Sil"><em
                                        class="icon ni ni-trash-empty"></em></button>


                            <?php }
                            if (isset($stock_movement_item['invoice_id']) && ($stock_movement_item['invoice_id'] != null) && ($stock_movement_item['sale_type'] == 'detailed')) { ?>
                                <a href="<?= route_to('tportal.faturalar.detail', $stock_movement_item['invoice_id']) ?>"
                                    class="btn btn-icon btn-xs btn-dim btn-outline-dark" id="btnPrintBarcode" data-bs-toggle="tooltip"
                                    data-bs-placement="top" data-bs-title="Görüntüle"><em class="icon ni ni-arrow-right"></em></a>
                            <?php } else if (isset($stock_movement_item['invoice_id']) && ($stock_movement_item['invoice_id'] != null) && ($stock_movement_item['sale_type'] == 'quick')) { ?>
                                    <a href="<?= route_to('tportal.cari.quick_sale_order.detail', $stock_movement_item['invoice_id']) ?>"
                                        class="btn btn-icon btn-xs btn-dim btn-outline-dark" id="btnPrintBarcode" data-bs-toggle="tooltip"
                                        data-bs-placement="top" data-bs-title="Görüntüle"><em class="icon ni ni-arrow-right"></em></a>
                            <?php } else
                                echo '-';
                            ?>

                            <?php
                        } ?>
                    </td>
                </tr>
            <?php }
    } ?>
    </tbody>
</table>