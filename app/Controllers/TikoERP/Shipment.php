<?php

namespace App\Controllers\TikoERP;

use App\Controllers\BaseController;

use App\Controllers\TikoERP\Log;
use App\Controllers\TikoPortal\GeneralConfig;
use CodeIgniter\I18n\Time;
use Exception;
use tidy;

/**
 * @property IncomingRequest $request 
 */


class Shipment extends BaseController
{
    private $DatabaseConfig;
    private $currentDB;

    private $modelStockBarcode;
    private $modelShipment;
    private $modelShipmentItem;
    private $modelWarehouse;
    private $modelStock;
    private $modelShipmentOrderItem;
    private $modelSaleOrderItem;

    private $logClass;

    public function __construct()
    {
        $TikoERPModelPath = 'App\Models\TikoERP';

        $this->DatabaseConfig = new GeneralConfig();
        $this->currentDB = $this->DatabaseConfig->setDBConfigs();

        $db_connection = \Config\Database::connect($this->currentDB);

        $this->modelStockBarcode = model($TikoERPModelPath.'\StockBarcodeModel', true, $db_connection);
        $this->modelShipment = model($TikoERPModelPath.'\ShipmentModel', true, $db_connection);
        $this->modelShipmentOrderItem = model($TikoERPModelPath.'\ShipmentOrderItemModel', true, $db_connection);
        $this->modelShipmentItem = model($TikoERPModelPath.'\ShipmentItemModel', true, $db_connection);
        $this->modelWarehouse = model($TikoERPModelPath.'\WarehouseModel', true, $db_connection);
        $this->modelStock = model($TikoERPModelPath.'\StockModel', true, $db_connection);        
        $this->modelSaleOrderItem = model($TikoERPModelPath.'\SaleOrderItemModel', true, $db_connection);        

        $this->logClass = new Log();
        helper('Helpers\number_format_helper');
        helper('Helpers\date_helper');
        helper('Helpers\barcode_helper');

        helper('date');
        helper('text');
    }

    public function list($shipment_type = 'all')
    {
        $query = $this->modelShipment->where('user_id', session()->get('user_id'))->where('shipment_type', 'warehouse_to_warehouse');
        if ($shipment_type == 'all') {
            $query;
        } elseif ($shipment_type == 'open') {
            $shipment_items = $query->whereIn('shipment_status', ['pending', 'processing']);
        } elseif ($shipment_type == 'closed') {
            $shipment_items = $query->whereIn('shipment_status', ['successful', 'failed']);
        } else {
            return redirect()->back();
        }
        $shipment_items = $query->orderBy('created_at', 'DESC')->findAll();
        $warehouse_items = $this->modelWarehouse->where('user_id', session()->get('user_id'))->where('status', 'active')->orderBy('order', 'ASC')->findAll();


        $data = [
            'shipment_items' => $shipment_items,
            'warehouse_items' => $warehouse_items
        ];
        return view('tportal/sevkiyatlar/index', $data);
    }

    public function detail($shipment_number = null){

        helper('Helpers\number_format_helper');


        $shipment_item = $this->modelShipment->join('warehouse from_warehouse', 'from_warehouse.warehouse_id = shipment.from_where')
                                            ->join('warehouse to_warehouse', 'to_warehouse.warehouse_id = shipment.to_where')
                                            ->select('shipment.*, from_warehouse.warehouse_title as from_warehouse_title, to_warehouse.warehouse_title as to_warehouse_title')
                                            ->where('shipment.user_id', session()->get('user_id'))
                                            ->where('shipment.shipment_number', $shipment_number)
                                            ->first();

        if (!$shipment_item) {
            return view('not-found');
        }
        $data = [
            'shipment_item' => $shipment_item,
            'total_stock_amount' => 0
        ];

        $shipment_items = $this->modelShipmentItem->join('shipment_order_item', 'shipment_order_item.shipment_order_item_id = shipment_item.shipment_order_item_id')
            ->join('stock', 'stock.stock_id = shipment_order_item.stock_id')
            ->join('unit as buy_unit', 'stock.buy_unit_id = buy_unit.unit_id')
            ->where('shipment_item.shipment_id', $shipment_item['shipment_id'])
            ->select('stock.stock_title, stock.stock_code, shipment_order_item.shipment_order_quantity, shipment_order_item.quantity_shipped')
            ->select('buy_unit.unit_value as buy_unit_value')
            ->select('shipment_item.*');



        if ($shipment_item['shipment_status'] == 'pending') {

            $shipment_order_items = $this->modelShipmentOrderItem->join('stock', 'stock.stock_id = shipment_order_item.stock_id')
                ->select('shipment_order_item.*, stock.stock_title, stock.stock_code')
                ->where('shipment_order_item.shipment_id', $shipment_item['shipment_id'])
                ->where('stock.user_id', session()->get('user_id'))
                ->orderBy('stock.stock_code', 'ASC')
                ->findAll();


            $shipment_sale_order_items = $this->modelSaleOrderItem->join('shipment', 'shipment.shipment_id = sale_order_item.shipment_id')
                ->join('stock', 'stock.stock_id = sale_order_item.stock_barcode_id')
                ->where('shipment.user_id', session()->get('user_id'))
                ->where('shipment.shipment_id', $shipment_item['shipment_id'])
                ->where('shipment.shipment_type', 'warehouse_to_customer')
                ->orderBy('shipment.created_at', 'DESC')
                ->findAll();

            // echo $shipment_sale_order_items;
            // exit();


            $shipment_items = $shipment_items->orderBy('stock.stock_code', 'ASC')
                ->groupBy('shipment_order_item.stock_id')
                ->findAll();

            $data['shipment_order_items'] = $shipment_order_items;
            $data['shipment_items'] = $shipment_items;
            $data['shipment_sale_order_items'] = $shipment_sale_order_items;

            return view('tportal/sevkiyatlar/detay/sevkiyat_emir', $data);
        }
        elseif ($shipment_item['shipment_status'] == 'processing') {
            $shipment_items = $shipment_items->selectSum('(CASE WHEN shipment_item.shipment_item_status = "successful" THEN shipment_item.during_shipment_amount ELSE 0 END)', 'total_successful_during_shipment_amount')
                ->orderBy('stock.stock_code', 'ASC')
                ->groupBy('shipment_order_item.stock_id')
                ->findAll();

                $shipment_sale_order_items2 = $this->modelSaleOrderItem->join('shipment', 'shipment.shipment_id = sale_order_item.shipment_id')
                ->join('stock', 'stock.stock_id = sale_order_item.stock_barcode_id')
                ->where('shipment.user_id', session()->get('user_id'))
                ->where('shipment.shipment_id', $shipment_item['shipment_id'])
                ->where('shipment.shipment_type', 'warehouse_to_customer')
                ->orderBy('shipment.created_at', 'DESC')
                ->findAll();

            $data['shipment_items'] = $shipment_items;
            $data['sale_order_items'] = $shipment_sale_order_items2;
            
            return view('tportal/sevkiyatlar/detay/sevkiyat_kabul', $data);
        }
    }

    public function create()
    {
        # TODO: buradaki prefix değişecek.
        $prefix = 'SVK';

        if ($this->request->getMethod('true') == 'POST') {
            try {
                $form_data = $this->request->getPost('formData');
                $shipment_order_items_data = json_decode($this->request->getPost('shipment_order_items'), true);
                foreach ($form_data as $data) {
                    $key = $data['name'];
                    $value = $data['value'];
                    $new_form_data[$key] = $value;
                }
                $from_where = $new_form_data['from_warehouse'];
                $to_where = $new_form_data['to_warehouse'];
                $total_stock_amount = convert_number_for_sql($new_form_data['total_stock_amount']);
                $shipment_note = $new_form_data['shipment_note'];

                if ($from_where == $to_where) {
                    echo json_encode(['icon' => 'error', 'message' => 'Giriş ve çıkış depoları aynı olamaz.']);
                    return;
                }

                $last_shipment = $this->modelShipment->where('user_id', session()->get('user_id'))->orderBy('shipment_counter', 'DESC')->first();
                if ($last_shipment) {
                    $shipment_counter = $last_shipment['shipment_counter'] + 1;
                } else {
                    $shipment_counter = 1;
                }
                $shipment_number = $prefix . str_pad($shipment_counter, 8, '0', STR_PAD_LEFT);

                $shipment_insert_data = [
                    'user_id' => session()->get('user_id'),
                    'shipment_number' => $shipment_number,
                    'departure_date' => null,
                    'arrival_date' => null,
                    'shipment_status' => 'pending',
                    'from_where' => $from_where,
                    'to_where' => $to_where,
                    'shipment_type' => 'warehouse_to_warehouse',
                    'ordered_stock_amount' => $total_stock_amount,
                    'shipped_stock_amount' => 0,
                    'received_stock_amount' => 0,
                    'shipment_note' => $shipment_note,
                    'failed_reason' => null,
                    'transaction_prefix' => $prefix,
                    'transaction_counter' => $shipment_counter
                ];
                $this->modelShipment->insert($shipment_insert_data);
                $shipment_id = $this->modelShipment->getInsertID();

                foreach ($shipment_order_items_data as $shipment_item) {
                    if ($shipment_item['is_sample'] == 'true' && floatval(convert_number_for_sql($shipment_item['shipment_order_quantity'])) > 10) {
                        $shipment_order_quantity = 10;
                    } else {
                        $shipment_order_quantity = convert_number_for_sql($shipment_item['shipment_order_quantity']);
                    }
                    try {
                        $shipment_item_insert_data = [
                            'shipment_id' => $shipment_id,
                            'stock_id' => $shipment_item['stock_id'],
                            'shipment_order_quantity' => $shipment_order_quantity,
                            'shipment_order_unit_id' => $shipment_item['unit_id'],
                            'shipment_order_note' => $shipment_item['shipment_order_note'],
                            'shipment_order_status' => 'incomplete',
                            'is_sample' => $shipment_item['is_sample']
                        ];
                        $this->modelShipmentOrderItem->insert($shipment_item_insert_data);
                    } catch (\Exception $e) {
                        $this->logClass->save_log(
                            'error',
                            'shipment_order_item',
                            null,
                            null,
                            'create',
                            $e->getMessage(),
                            json_encode($_POST)
                        );
                        echo json_encode(['icon' => 'error', 'message' => $e->getMessage()]);
                        continue;
                    }
                }

                echo json_encode(['icon' => 'success', 'message' => 'Sevkiyat başarılı bir şekilde kaydedildi.', 'new_shipment_number' => $shipment_number]);
                return;
            } catch (\Exception $e) {
                $this->logClass->save_log(
                    'error',
                    'shipment',
                    null,
                    null,
                    'create',
                    $e->getMessage(),
                    json_encode($_POST)
                );
                echo json_encode(['icon' => 'error', 'message' => $e->getMessage()]);
                return;
            }
        } else {
            $stock_items = $this->modelStock->where('user_id', session()->get('user_id'))->where('status', 'active')->orderBy('stock_code', 'ASC')->findAll();
            $warehouse_items = $this->modelWarehouse->where('user_id', session()->get('user_id'))
                ->where('status', 'active')
                ->orderBy('order', 'ASC')
                ->findAll();

            $data = [
                'warehouse_items' => $warehouse_items,
                'stock_items' => $stock_items
            ];

            return view('tportal/sevkiyatlar/yeni', $data);
        }
    }

    public function getStockItemsByWarehouse()
    {
        if ($this->request->getMethod('true') == 'POST') {
            $warehouse_id = $this->request->getPost('warehouse_id');

            $stock_items = $this->modelStock->select('stock.stock_id, stock.buy_unit_id, stock.stock_code, stock.stock_title')
                ->select('(SUM(stock_barcode.total_amount) - SUM(stock_barcode.used_amount)) AS total_remaining_amount')
                ->join('stock_barcode', 'stock_barcode.stock_id = stock.stock_id')
                ->where('stock.user_id', session()->get('user_id'))
                ->where('stock.status', 'active')
                ->where('stock.stock_type', 'product')
                ->where('stock_barcode.warehouse_id', $warehouse_id)
                ->where('stock_barcode.stock_barcode_status', 'available')
                ->orderBy('stock.stock_code')
                ->groupBy('stock.stock_id')
                ->findAll();

            if (!$stock_items) {
                echo json_encode(['icon' => 'error', 'message' => 'Seçilen depoda sevkiyata uygun stok bulunamadı.']);
                return;
            }

            echo json_encode(['icon' => 'success', 'message' => 'Seçilen depodaki stoklar başarıyla getirildi.', 'stock_items' => $stock_items]);
            return;
        } else {
            return redirect()->back();
        }
    }

    public function addShipmentItem()
    {
        if ($this->request->getMethod('true') == 'POST') {
            try {
                $barcode = $this->request->getPost('barcode_number');
                $shipment_id = $this->request->getPost('shipment_id');
                $barcode_number = convert_barcode_number_for_sql($barcode);

                $shipment_item = $this->modelShipment->where('user_id', session()->get('user_id'))->where('shipment_id', $shipment_id)->first();

                $barcode_item = $this->modelStockBarcode->join('stock', 'stock.stock_id = stock_barcode.stock_id')
                    ->join('shipment_order_item', 'shipment_order_item.stock_id = stock.stock_id')
                    ->join('unit as buy_unit', 'stock.buy_unit_id = buy_unit.unit_id')
                    ->select('stock_barcode.total_amount, stock_barcode.used_amount, stock_barcode.stock_barcode_id, stock_barcode.warehouse_id')
                    ->select('stock.stock_title, stock.stock_code')
                    ->select('shipment_order_item.shipment_order_quantity, shipment_order_item.quantity_shipped, shipment_order_item.shipment_order_item_id')
                    ->select('buy_unit.unit_value as buy_unit_value')
                    ->where('shipment_order_item.shipment_id', $shipment_id)
                    ->where('stock.user_id', session()->get('user_id'))
                    ->where('stock_barcode.barcode_number', $barcode_number)
                    ->first();

                if ($shipment_item['shipment_status'] != 'pending') {
                    echo json_encode(['icon' => 'error', 'message' => 'Bu sevkiyat yeni ürün eklemeye uygun değil.']);
                    return;
                }
                if ($barcode_item) {
                    if ($shipment_item['from_where'] != $barcode_item['warehouse_id']) {
                        echo json_encode(['icon' => 'error', 'message' => 'Verilen barkod sevkiyatın çıkış deposunda bulunamadı.']);
                        return;
                    }

                    $chk_shipment_item = $this->modelShipmentItem->where('stock_barcode_id', $barcode_item['stock_barcode_id'])
                        ->whereIn('shipment_item_status', ['processing', 'pending'])
                        ->first();
                    if ($chk_shipment_item) {
                        echo json_encode(['icon' => 'error', 'message' => 'Verilen barkod bir sevkiyata eklenmiş durumda.']);
                        return;
                    } else if ($barcode_item['barcode_item_status'] == 'unavailable' || $barcode_item['barcode_item_status'] == 'out_of_stock') {
                        echo json_encode(['icon' => 'error', 'message' => 'Bu barkod sevkiyata eklenmeye uygun değil.']);
                        return;
                    }

                    $alert_message = '';

                    $stock_title = $barcode_item['stock_title'];
                    $stock_code = $barcode_item['stock_code'];
                    $unit_value = $barcode_item['buy_unit_value'];
                    $stock_amount = $barcode_item['total_amount'] - $barcode_item['used_amount'];
                    $quantity_shipped = $barcode_item['quantity_shipped'] + $stock_amount;
                    $update_shipment_order_data = [
                        'quantity_shipped' => $quantity_shipped
                    ];
                    if ($quantity_shipped > $barcode_item['shipment_order_quantity']) {
                        $update_shipment_order_data['shipment_order_status'] = 'more';
                        $remaining_amount = 0;
                        $alert_message = 'Eklediğiniz barkod numarasındaki ürün miktarı sevkiyat emrinden fazla.';
                    } elseif ($quantity_shipped == $barcode_item['shipment_order_quantity']) {
                        $update_shipment_order_data['shipment_order_status'] = 'success';
                        $remaining_amount = 0;
                        $alert_message = 'Sevkiyat emrinde bulunan ürün miktarına ulaşıldı.';
                    } else {
                        $update_shipment_order_data['shipment_order_status'] = 'incomplete';
                        $remaining_amount = $barcode_item['shipment_order_quantity'] - $quantity_shipped;
                    }
                    $this->modelShipmentOrderItem->update($barcode_item['shipment_order_item_id'], $update_shipment_order_data);

                    $insert_shipment_item_data = [
                        'shipment_id' => $shipment_id,
                        'shipment_order_item_id' => $barcode_item['shipment_order_item_id'],
                        'stock_barcode_id' => $barcode_item['stock_barcode_id'],
                        'shipment_item_status' => 'pending',
                        'during_shipment_amount' => $stock_amount,
                        'failed_reason' => null
                    ];
                    $this->modelShipmentItem->insert($insert_shipment_item_data);
                    $update_stock_barcode_data = [
                        'stock_barcode_status' => 'in_shipping'
                    ];
                    $this->modelStockBarcode->update($barcode_item['stock_barcode_id'], $update_stock_barcode_data);
                    echo json_encode([
                        'icon' => 'success',
                        'message' => 'Kayıt başarılı bir şekilde getirildi.',
                        'stock_title' => $stock_title,
                        'stock_code' => $stock_code,
                        'stock_amount' => $stock_amount,
                        'remaining_amount' => $remaining_amount,
                        'unit_value' => $unit_value,
                        'alert_message' => $alert_message,
                    ]);
                    return;
                } else {
                    echo json_encode(['icon' => 'error', 'message' => 'Verilen barkodla ilişkili ürün sevkiyatta bulunamadı.']);
                    return;
                }
            } catch (\Exception $e) {
                echo json_encode(['icon' => 'error', 'message' => $e->getMessage()]);
                return;
            }
        } else {
            return redirect()->back();
        }
    }

    public function removeShipmentItem()
    {
        if ($this->request->getMethod('true') == 'POST') {
            try {
                $barcode = $this->request->getPost('barcode_number');
                $shipment_id = $this->request->getPost('shipment_id');
                $barcode_number = convert_barcode_number_for_sql($barcode);

                $shipment_item = $this->modelShipment->where('user_id', session()->get('user_id'))->where('shipment_id', $shipment_id)->first();

                $barcode_item = $this->modelStockBarcode->join('stock', 'stock.stock_id = stock_barcode.stock_id')
                    ->join('shipment_order_item', 'shipment_order_item.stock_id = stock.stock_id')
                    ->join('unit as buy_unit', 'stock.buy_unit_id = buy_unit.unit_id')
                    ->select('stock_barcode.total_amount, stock_barcode.used_amount, stock_barcode.stock_barcode_id')
                    ->select('stock.stock_code')
                    ->select('shipment_order_item.shipment_order_quantity, shipment_order_item.quantity_shipped, shipment_order_item.shipment_order_item_id')
                    ->select('buy_unit.unit_value as buy_unit_value')
                    ->where('shipment_order_item.shipment_id', $shipment_id)
                    ->where('stock.user_id', session()->get('user_id'))
                    ->where('stock_barcode.barcode_number', $barcode_number)
                    ->where('stock_barcode.stock_barcode_status', 'in_shipping')
                    ->first();

                if ($shipment_item['shipment_status'] != 'pending') {
                    echo json_encode(['icon' => 'error', 'message' => 'Bu sevkiyat yeni ürün eklemeye uygun değil.']);
                    return;
                }

                if ($barcode_item) {
                    $chk_shipment_item = $this->modelShipmentItem->where('stock_barcode_id', $barcode_item['stock_barcode_id'])
                        ->where('shipment_id', $shipment_id)
                        ->first();
                    if (!$chk_shipment_item) {
                        echo json_encode(['icon' => 'error', 'message' => 'Verilen barkod sevkiyatta bulunamadı.']);
                        return;
                    }

                    $removeElement = false;
                    $stock_code = $barcode_item['stock_code'];
                    $unit_value = $barcode_item['buy_unit_value'];
                    $stock_amount = $barcode_item['total_amount'] - $barcode_item['used_amount'];
                    $quantity_shipped = $barcode_item['quantity_shipped'] - $stock_amount;
                    $update_shipment_order_data = [
                        'quantity_shipped' => $quantity_shipped
                    ];
                    if ($quantity_shipped > $barcode_item['shipment_order_quantity']) {
                        $update_shipment_order_data['shipment_order_status'] = 'more';
                        $remaining_amount = 0;
                    } elseif ($quantity_shipped == $barcode_item['shipment_order_quantity']) {
                        $update_shipment_order_data['shipment_order_status'] = 'success';
                        $remaining_amount = 0;
                    } else {
                        $update_shipment_order_data['shipment_order_status'] = 'incomplete';
                        $remaining_amount = $barcode_item['shipment_order_quantity'] - $quantity_shipped;
                    }
                    $this->modelShipmentOrderItem->update($barcode_item['shipment_order_item_id'], $update_shipment_order_data);
                    $this->modelShipmentItem->delete($chk_shipment_item['shipment_item_id'], true);

                    $update_stock_barcode_data = [
                        'stock_barcode_status' => 'available'
                    ];
                    $this->modelStockBarcode->update($barcode_item['stock_barcode_id'], $update_stock_barcode_data);
                    if ($remaining_amount == $barcode_item['shipment_order_quantity']) {
                        $removeElement = true;
                    }

                    echo json_encode([
                        'icon' => 'success',
                        'message' => 'Kayıt başarılı bir şekilde getirildi.',
                        'stock_code' => $stock_code,
                        'stock_amount' => $stock_amount,
                        'unit_value' => $unit_value,
                        'remaining_amount' => $remaining_amount,
                        'removeElement' => $removeElement
                    ]);
                    return;
                } else {
                    echo json_encode(['icon' => 'error', 'message' => 'Verilen barkodla ilişkili ürün sevkiyatta bulunamadı.']);
                    return;
                }
            } catch (\Exception $e) {
                echo json_encode(['icon' => 'error', 'message' => $e->getMessage()]);
                return;
            }
        } else {
            return redirect()->back();
        }
    }

    public function receiveShipmentItem()
    {
        if ($this->request->getMethod('true') == 'POST') {
            try {
                $barcode = $this->request->getPost('barcode_number');
                $shipment_id = $this->request->getPost('shipment_id');
                $barcode_number = convert_barcode_number_for_sql($barcode);

                $shipment_item = $this->modelShipmentItem->join('shipment_order_item', 'shipment_order_item.shipment_order_item_id = shipment_item.shipment_order_item_id')
                    ->join('stock', 'stock.stock_id = shipment_order_item.stock_id')
                    ->join('shipment', 'shipment.shipment_id = shipment_item.shipment_id')
                    ->join('stock_barcode', 'stock_barcode.stock_barcode_id = shipment_item.stock_barcode_id')
                    ->join('unit as buy_unit', 'stock.buy_unit_id = buy_unit.unit_id')
                    ->where('shipment_item.shipment_id', $shipment_id)
                    ->where('stock_barcode.barcode_number', $barcode_number)
                    ->select('stock.stock_title, stock.stock_code, shipment.received_stock_amount, shipment.shipped_stock_amount')
                    ->select('buy_unit.unit_value as buy_unit_value')
                    ->select('shipment_item.*')
                    ->first();
                if (!$shipment_item) {
                    echo json_encode(['icon' => 'error', 'message' => 'Verilen barkodla ilişkili ürün sevkiyatta bulunamadı.']);
                    return;
                } elseif ($shipment_item['shipment_item_status'] != 'processing') {
                    echo json_encode(['icon' => 'error', 'message' => 'Verilen barkod sevkiyat kabulüne uygun değil.']);
                    return;
                } else {
                    $stock_title = $shipment_item['stock_title'];
                    $stock_code = $shipment_item['stock_code'];
                    $unit_value = $shipment_item['buy_unit_value'];
                    $stock_amount = $shipment_item['during_shipment_amount'];
                    $received_stock_amount = $shipment_item['received_stock_amount'] + $stock_amount;
                    $remaining_amount = $shipment_item['shipped_stock_amount'] - $received_stock_amount;

                    $update_shipment_data = [
                        'received_stock_amount' => $received_stock_amount
                    ];
                    $this->modelShipment->update($shipment_id, $update_shipment_data);

                    $update_shipment_item_data = [
                        'shipment_item_status' => 'successful'
                    ];
                    $this->modelShipmentItem->update($shipment_item['shipment_item_id'], $update_shipment_item_data);

                    $update_stock_barcode_data = [
                        'stock_barcode_status' => 'available'
                    ];
                    $this->modelStockBarcode->update($shipment_item['stock_barcode_id'], $update_stock_barcode_data);

                    echo json_encode([
                        'icon' => 'success',
                        'message' => 'Kayıt başarılı bir şekilde getirildi.',
                        'stock_title' => $stock_title,
                        'stock_code' => $stock_code,
                        'stock_amount' => $stock_amount,
                        'remaining_amount' => $remaining_amount,
                        'unit_value' => $unit_value,
                    ]);
                    return;
                }
            } catch (\Exception $e) {
                echo json_encode(['icon' => 'error', 'message' => $e->getMessage()]);
                return;
            }
        } else {
            return redirect()->back();
        }
    }

    public function cancelReceiveShipmentItem()
    {
        if ($this->request->getMethod('true') == 'POST') {
            try {
                $barcode = $this->request->getPost('barcode_number');
                $shipment_id = $this->request->getPost('shipment_id');
                $barcode_number = convert_barcode_number_for_sql($barcode);

                $shipment_item = $this->modelShipmentItem->join('shipment_order_item', 'shipment_order_item.shipment_order_item_id = shipment_item.shipment_order_item_id')
                    ->join('stock', 'stock.stock_id = shipment_order_item.stock_id')
                    ->join('shipment', 'shipment.shipment_id = shipment_item.shipment_id')
                    ->join('stock_barcode', 'stock_barcode.stock_barcode_id = shipment_item.stock_barcode_id')
                    ->join('unit as buy_unit', 'stock.buy_unit_id = buy_unit.unit_id')
                    ->where('shipment_item.shipment_id', $shipment_id)
                    ->where('stock_barcode.barcode_number', $barcode_number)
                    ->select('stock.stock_title, stock.stock_code, shipment.received_stock_amount, shipment.shipped_stock_amount')
                    ->select('buy_unit.unit_value as buy_unit_value')
                    ->select('shipment_item.*')
                    ->first();
                if (!$shipment_item) {
                    echo json_encode(['icon' => 'error', 'message' => 'Verilen barkodla ilişkili ürün sevkiyatta bulunamadı.']);
                    return;
                } elseif ($shipment_item['shipment_item_status'] != 'successful') {
                    echo json_encode(['icon' => 'error', 'message' => 'Verilen barkod sevkiyat kabulünden çıkartmaya uygun değil.']);
                    return;
                } else {
                    $removeElement = false;
                    $stock_code = $shipment_item['stock_code'];
                    $unit_value = $shipment_item['buy_unit_value'];
                    $stock_amount = $shipment_item['during_shipment_amount'];
                    $received_stock_amount = $shipment_item['received_stock_amount'] - $stock_amount;
                    $remaining_amount = $shipment_item['shipped_stock_amount'] - $received_stock_amount;

                    $update_shipment_data = [
                        'received_stock_amount' => $received_stock_amount
                    ];
                    $this->modelShipment->update($shipment_id, $update_shipment_data);

                    $update_shipment_item_data = [
                        'shipment_item_status' => 'processing'
                    ];
                    $this->modelShipmentItem->update($shipment_item['shipment_item_id'], $update_shipment_item_data);

                    $update_stock_barcode_data = [
                        'stock_barcode_status' => 'in_shipping'
                    ];
                    $this->modelStockBarcode->update($shipment_item['stock_barcode_id'], $update_stock_barcode_data);

                    if ($remaining_amount == $shipment_item['shipped_stock_amount']) {
                        $removeElement = true;
                    }
                    echo json_encode([
                        'icon' => 'success',
                        'message' => 'Kayıt başarılı bir şekilde getirildi.',
                        'stock_code' => $stock_code,
                        'stock_amount' => $stock_amount,
                        'unit_value' => $unit_value,
                        'remaining_amount' => $remaining_amount,
                        'removeElement' => $removeElement
                    ]);
                    return;
                }
            } catch (\Exception $e) {
                echo json_encode(['icon' => 'error', 'message' => $e->getMessage()]);
                return;
            }
        } else {
            return redirect()->back();
        }
    }

    public function checkBeforeDeparture()
    {
        if ($this->request->getMethod('true') == 'POST') {
            try {
                $shipment_id = $this->request->getPost('shipment_id');

                $shipment_order_items = $this->modelShipmentOrderItem->join('stock', 'stock.stock_id = shipment_order_item.stock_id')
                    ->select('stock.stock_title, stock.stock_code')
                    ->select('shipment_order_item.shipment_order_status, shipment_order_item.quantity_shipped, shipment_order_item.shipment_order_quantity')
                    ->where('shipment_id', $shipment_id)
                    ->whereIn('shipment_order_status', ['incomplete', 'more'])
                    ->findAll();
                if (!$shipment_order_items) {
                    echo json_encode(['icon' => 'success']);
                    return;
                } else {
                    echo json_encode(['icon' => 'err', 'shipment_order_items' => $shipment_order_items]);
                    return;
                }
            } catch (\Exception $e) {
                echo json_encode(['icon' => 'error', 'message' => $e->getMessage()]);
                return;
            }
        } else {
            return redirect()->back();
        }
    }

    public function checkBeforeArrival()
    {
        if ($this->request->getMethod('true') == 'POST') {
            try {
                $shipment_id = $this->request->getPost('shipment_id');

                $shipment_items = $this->modelShipmentItem->join('stock_barcode', 'stock_barcode.stock_barcode_id = shipment_item.stock_barcode_id')
                    ->join('stock', 'stock.stock_id = stock_barcode.stock_id')
                    ->join('unit as buy_unit', 'stock.buy_unit_id = buy_unit.unit_id')
                    ->select('stock.stock_title, stock.stock_code, stock_barcode.barcode_number')
                    ->select('buy_unit.unit_value as buy_unit_value')
                    ->select('shipment_item.*')
                    ->where('shipment_item.shipment_id', $shipment_id)
                    ->where('shipment_item.shipment_item_status', 'processing')
                    ->findAll();
                if (!$shipment_items) {
                    echo json_encode(['icon' => 'success']);
                    return;
                } else {
                    echo json_encode(['icon' => 'error', 'shipment_items' => $shipment_items]);
                    return;
                }
            } catch (\Exception $e) {
                echo json_encode(['icon' => 'error', 'message' => $e->getMessage()]);
                return;
            }
        } else {
            return redirect()->back();
        }
    }

    public function approveDeparture()
    {
        if ($this->request->getMethod('true') == 'POST') {
            try {
                # TODO: Burada sevkiyata çıkan barkodların hareketlere işlenmesi gerekiyor.
                $shipment_id = $this->request->getPost('shipment_id');

                $chk_shipment = $this->modelShipment->where('user_id', session()->get('user_id'))
                    ->where('shipment_id', $shipment_id)
                    ->first();
                if (!$chk_shipment) {
                    echo json_encode(['icon' => 'error', 'message' => 'Sevkiyat bulunamadı.']);
                    return;
                } elseif ($chk_shipment['shipment_status'] != 'pending') {
                    echo json_encode(['icon' => 'error', 'message' => 'Sevkiyat durumu yola çıkmaya uygun değil.']);
                    return;
                }
                $shipped_stock_amount = 0;
                $shipment_items = $this->modelShipmentItem->where('shipment_id', $shipment_id)->findAll();
                foreach ($shipment_items as $shipment_item) {
                    $shipped_stock_amount += $shipment_item['during_shipment_amount'];
                    $update_shipment_item_data = [
                        'shipment_item_status' => 'processing'
                    ];
                    $this->modelShipmentItem->update($shipment_item['shipment_item_id'], $update_shipment_item_data);
                }

                $now_time = new Time('now', 'Turkey', 'en_US');

                $update_shipment_data = [
                    'shipped_stock_amount' => $shipped_stock_amount,
                    'shipment_status' => 'processing',
                    'departure_date' => $now_time
                ];
                $this->modelShipment->update($chk_shipment['shipment_id'], $update_shipment_data);
                echo json_encode(['icon' => 'success', 'message' => 'Sevkiyat durumu başarıyla güncellendi.']);
                return;
            } catch (\Exception $e) {
                $this->logClass->save_log(
                    'error',
                    'shipment',
                    $chk_shipment['shipment_id'],
                    null,
                    'update',
                    $e->getMessage(),
                    json_encode($_POST)
                );
                echo json_encode(['icon' => 'error', 'message' => $e->getMessage()]);
                return;
            }
        } else {
            return redirect()->back();
        }
    }

    public function approveArrival()
    {
        if ($this->request->getMethod('true') == 'POST') {
            try {
                # TODO: Burada sevkiyata çıkan barkodların hareketlere işlenmesi gerekiyor.
                $shipment_id = $this->request->getPost('shipment_id');

                $chk_shipment = $this->modelShipment->where('user_id', session()->get('user_id'))
                    ->where('shipment_id', $shipment_id)
                    ->first();
                if (!$chk_shipment) {
                    echo json_encode(['icon' => 'error', 'message' => 'Sevkiyat bulunamadı.']);
                    return;
                } elseif ($chk_shipment['shipment_status'] != 'processing') {
                    echo json_encode(['icon' => 'error', 'message' => 'Sevkiyat kabul etmeye uygun değil.']);
                    return;
                }
                $received_stock_amount = 0;
                $shipment_items = $this->modelShipmentItem->where('shipment_id', $shipment_id)->findAll();
                foreach ($shipment_items as $shipment_item) {
                    if ($shipment_item['shipment_item_status'] == 'successful') {
                        $received_stock_amount += $shipment_item['during_shipment_amount'];
                        $shipment_order_item = $this->modelShipmentOrderItem->find($shipment_item['shipment_order_item_id']);
                        $update_shipment_order_item_data = [
                            'quantity_received' => $shipment_item['during_shipment_amount'] + $shipment_order_item['quantity_received']
                        ];
                        $this->modelShipmentOrderItem->update($shipment_order_item['shipment_order_item_id'], $update_shipment_order_item_data);

                        $update_stock_barcode_data = [
                            'warehouse_id' => $chk_shipment['to_where']
                        ];
                        $this->modelStockBarcode->update($shipment_item['stock_barcode_id'], $update_stock_barcode_data);
                    } else {
                        # Failed reason ileride buradan kaydedilecek
                        $update_shipment_item_data = [
                            'shipment_item_status' => 'failed'
                        ];
                        $this->modelShipmentItem->update($shipment_item['shipment_item_id'], $update_shipment_item_data);

                        $update_stock_barcode_data = [
                            'stock_barcode_status' => 'unavailable'
                        ];
                        $this->modelStockBarcode->update($shipment_item['stock_barcode_id'], $update_stock_barcode_data);
                    }
                }

                $now_time = new Time('now', 'Turkey', 'en_US');

                $update_shipment_data = [
                    'received_stock_amount' => $received_stock_amount,
                    'shipment_status' => 'successful',
                    'arrival_date' => $now_time
                ];
                $this->modelShipment->update($chk_shipment['shipment_id'], $update_shipment_data);
                echo json_encode(['icon' => 'success', 'message' => 'Sevkiyat durumu başarıyla güncellendi.']);
                return;
            } catch (\Exception $e) {
                $this->logClass->save_log(
                    'error',
                    'shipment',
                    $chk_shipment['shipment_id'],
                    null,
                    'update',
                    $e->getMessage(),
                    json_encode($_POST)
                );
                echo json_encode(['icon' => 'error', 'message' => $e->getMessage()]);
                return;
            }
        } else {
            return redirect()->back();
        }
    }
}
