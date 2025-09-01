<li>
                    <a  class="<?php $sonuc = ($segments[3] == 'property') ? 'active' : ''; echo $sonuc; ?>"
                        href="<?= route_to('tportal.stocks.property', $stock_item['stock_id']) ?>">
                        <em class="icon ni ni-property"></em>
                        <span>Ürün Özellikleri</span>
                    </a>
                </li>