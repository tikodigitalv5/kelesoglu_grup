                                <table class="datatable-init-hareketler-order-none nowrap table" data-export-title="Export">
                                    <thead>
                                        <tr style="background-color: #ebeef2;">
                                            <th style="background-color: #ebeef2;">Tarih</th>
                                            <th style="background-color: #ebeef2;">İşlem</th>
                                            <th style="background-color: #ebeef2;">İşlem No</th>
                                            <th style="background-color: #ebeef2;">Bilgi</th>
                                            <th style="background-color: #ebeef2;">Depo</th>
                                            <th style="background-color: #ebeef2;">Miktar</th>
                                            <th style="background-color: #ebeef2;">Stok</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            foreach($stock_movement_items as $stock_movement_item){ ?>
                                        <tr>
                                            <td><?= date("d/m/Y", strtotime($stock_movement_item['created_at']))?></td>
                                            <?php 
                                            if($stock_movement_item['movement_type'] == 'incoming'){
                                                echo '<td><span class="tb-status text-success">Giriş</span></td>';
                                            }elseif($stock_movement_item['movement_type'] == 'outgoing'){
                                                echo '<td><span class="tb-status text-danger">Çıkış</span></td>';
                                            }else {
                                                echo '<td><span class="tb-status text-soft">Sevk</span></td>';
                                            }
                                            ?>
                                            <td><?= $stock_movement_item['transaction_number'] ?></td>
                                            <td><?= $stock_movement_item['transaction_info'] ?></td>
                                            <?php 
                                            if($stock_movement_item['from_warehouse'] != null){
                                                echo '<td>'.$warehouse_items[array_search($stock_movement_item['from_warehouse'], array_column($warehouse_items, 'warehouse_id'))]['warehouse_title'].'</td>';
                                            }elseif($stock_movement_item['to_warehouse'] != null){
                                                echo '<td>'.$warehouse_items[array_search($stock_movement_item['to_warehouse'], array_column($warehouse_items, 'warehouse_id'))]['warehouse_title'].'</td>';
                                            }
                                            ?>
                                            <td><?= number_format($stock_movement_item['total_amount'], 4, ',', '.'); ?></td>
                                            <td><?= number_format($stock_movement_item['stock_amount'], 4, ',', '.'); ?></td>
                                        </tr>
                                        <?php
                                            }
                                            ?>
                                    </tbody>
                                </table>