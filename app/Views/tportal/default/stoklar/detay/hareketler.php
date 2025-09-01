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
                if ($stock_movement_item_parent['movement_type'] == 'incoming') {
                    echo '<td><span class="tb-status text-success">Giriş</span></td>';
                } elseif ($stock_movement_item_parent['movement_type'] == 'outgoing') {
                    echo '<td><span class="tb-status text-danger">Çıkış</span></td>';
                } else {
                    echo '<td><span class="tb-status text-soft">Sevk</span></td>';
                }
                ?>

                <td>
                    <?= $stock_movement_item_parent['stock_title'] ?>
                </td>

                <td>
                    <?= $stock_movement_item_parent['warehouse_title'] == null ? $stock_movement_item_parent['cari_invoice_title'] : $stock_movement_item_parent['warehouse_title'] ?>
                </td>

                <?php $grandTempBalance = $stock_movement_item_parent['movement_type'] == 'incoming' ? ($grandTempBalance + $stock_movement_item_parent['transaction_quantity']) : ($grandTempBalance - $stock_movement_item_parent['transaction_quantity']); ?>

                <td class="text-right">
                    <?= number_format($stock_movement_item_parent['transaction_quantity'], 2, ',', '.') . ' ' . $stock_movement_item_parent['unit_title'] ?>
                </td>

                <td>
                    <?= convert_number_for_form($grandTempBalance, 2) . ' ' . $stock_movement_item_parent['unit_title'] ?>
                </td>

                <td>
                    <?php if ($stock_movement_item_parent['movement_type'] == 'outgoing') { ?>

                        <a href="<?= route_to('tportal.faturalar.detail', $stock_movement_item_parent['invoice_id']) ?>"
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
                    <td data-order="<?= $stock_movement_item['transaction_date'] ?>"
                        title="<?= $stock_movement_item['transaction_date'] ?>">
                        <?= date("d/m/Y", strtotime($stock_movement_item['created_at'])) ?>
                    </td>
                    <?php
                    if ($stock_movement_item['movement_type'] == 'incoming') {
                        echo '<td><span class="tb-status text-success">Giriş</span></td>';
                    } elseif ($stock_movement_item['movement_type'] == 'outgoing') {
                        echo '<td><span class="tb-status text-danger">Çıkış</span></td>';
                    } else {
                        echo '<td><span class="tb-status text-soft">Sevk</span></td>';
                    }
                    ?>
                    <td>
                        <?= $stock_movement_item['transaction_number'] ?>
                    </td>
                    <td style="max-width: 120px !important; width:120px !important; overflow:hidden; text-overflow:ellipsis"
                        width="120" data-bs-toggle="tooltip" data-bs-placement="top"
                        data-bs-title="<?= $stock_movement_item['transaction_info'] ?>">
                        <?= $stock_movement_item['transaction_info'] ?>
                    </td>
                    <?php
                    if ($stock_movement_item['from_warehouse'] != null) {
                        echo '<td>' . $warehouse_items[array_search($stock_movement_item['from_warehouse'], array_column($warehouse_items, 'warehouse_id'))]['warehouse_title'] . '</td>';
                    } elseif ($stock_movement_item['to_warehouse'] != null) {
                        echo '<td>' . $warehouse_items[array_search($stock_movement_item['to_warehouse'], array_column($warehouse_items, 'warehouse_id'))]['warehouse_title'] . '</td>';
                    }
                    $temp_balance = $stock_movement_item['movement_type'] == 'incoming' ? ($temp_balance + $stock_movement_item['transaction_quantity']) : ($temp_balance - $stock_movement_item['transaction_quantity']);
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
                                    <a href="<?= route_to('tportal.cari.sale_order.detail', $stock_movement_item['invoice_id']) ?>"
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
                            <button type="button" class="btn btn-icon btn-xs btn-dim btn-outline-dark printStockBarcode"
                                id="btnPrintBarcode" data-barcode-number="<?= $stock_movement_item['barcode_number'] ?>"
                                data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Barkod Yazdır"><em
                                    class="icon ni ni-printer-fill"></em></button>
                            <button type="button" class="btn btn-icon btn-xs btn-dim btn-outline-danger deleteStock"
                                id="btnDeleteStock" data-stock-barcode-id="<?= $stock_movement_item['stock_barcode_id'] ?>"
                                data-stock-id="<?= $stock_movement_item['stock_id'] ?>" data-bs-toggle="tooltip"
                                data-bs-placement="top" data-bs-title="Hareketi Sil"><em
                                    class="icon ni ni-trash-empty"></em></button>


                            <?php if (isset($stock_movement_item['invoice_id']) && ($stock_movement_item['invoice_id'] != null) && ($stock_movement_item['sale_type'] == 'detailed')) { ?>
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

<!-- <table class="datatable-init-hareketler nowrap table" data-export-title="Export">
                                        <thead>
                                            <tr style="background-color: #ebeef2;">
                                                <th style="background-color: #ebeef2;">Tarih</th>
                                                <th style="background-color: #ebeef2;">İşlem</th>
                                                <th style="background-color: #ebeef2;">İşlem No</th>
                                                <th style="background-color: #ebeef2;">Bilgi</th>
                                                <th style="background-color: #ebeef2;">Miktar</th>
                                                <th style="background-color: #ebeef2;">Stok</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>07/08/2023</td>
                                                <td><span class="tb-status text-danger">Çıkış</span></td>
                                                <td>SPRS202300002356</td>
                                                <td>Satış</td>
                                                <td>-4</td>
                                                <td>126</td>
                                            </tr>
                                            <tr>
                                                <td>05/08/2023</td>
                                                <td><span class="tb-status text-success">Giriş</span></td>
                                                <td>URT00023412</td>
                                                <td>Üretim</td>
                                                <td>100</td>
                                                <td>130</td>
                                            </tr>
                                            <tr>
                                                <td>01/08/2023</td>
                                                <td><span class="tb-status text-success">Giriş</span></td>
                                                <td>-</td>
                                                <td>Açılış Stok</td>
                                                <td>30</td>
                                                <td>30</td>
                                            </tr>
                                        </tbody>
                                    </table> -->

