<div class="row g-3 align-center mb-4 mt-4">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label" for="buy_unit_price">Finisajlı İşlem Mi </label>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label" for="buy_unit_price">Finisajlı İşlem Mi </label>
                            </div>
                        </div>
                        <div class="col-12 mt-0 mt-md-2 d-flex">
                            <div class="col-md-4 col-12 pe-md-2">
                                <div class="form-group">
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control form-control-xl calcStockTotal"
                                            id="buy_unit_price"
                                            value="<?= number_format($stock_item['buy_unit_price'], 4, ',', '') ?>"
                                            placeholder="15,8700" name="buy_unit_price"
                                            onkeypress="return SadeceRakam(event,[',']);">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-12 pe-md-2">
                                <div class="form-group">
                                    <div class="form-control-wrap ">
                                        <div class="form-control-select">
                                            <select required="" class="form-control select2 form-control-xl"
                                                name="buy_money_unit_id" id="buy_money_unit_id">
                                                <option value="" disabled>Lütfen Seçiniz</option>
                                                <?php
                                                foreach ($money_unit_items as $money_unit_item) { ?>
                                                    <option value="<?= $money_unit_item['money_unit_id'] ?>" <?php if ($money_unit_item['money_unit_id'] == $stock_item['buy_money_unit_id']) {
                                                          echo 'selected';
                                                      } ?>>
                                                        <?= $money_unit_item['money_code'] ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                            <input type="hidden" name="" id="buy_money_unit_id"
                                                value="<?= $stock_item['buy_money_unit_id'] ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <div class="form-control-wrap"><input type="text"
                                            class="form-control form-control-xl d-none" id="currency_amount" value=""
                                            placeholder="Döviz Kuru" name="currency_amount"
                                            onkeypress="return SadeceRakam(event,[',']);">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="totalPriceArea" class="d-none">
                            <p>Toplam Fiyat: <span id="totalPrice"></span> <span id="dvz"></span> </p>
                        </div>
                        <div id="totalPriceAreaTRY" class="d-none mt-0">
                            <p>Toplam Fiyat: <span id="totalPriceTRY"></span> <span id="dvz">TRY</span> </p>
                        </div>
                    </div>