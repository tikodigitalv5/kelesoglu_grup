<?php

function getStockQuantity($stockId, $modelStock)
{
    $stock = $modelStock->find($stockId);
    if (!$stock) {
        return null; // Stok bulunamazsa null döndür
    }

    if ($stock['parent_id'] == 0) {
        $subStocks = $modelStock->where('parent_id', $stockId)->findAll();
        $totalQuantity = 0;
        foreach ($subStocks as $subStock) {
            $totalQuantity += getStockQuantity($subStock['stock_id']);
        }
        return $totalQuantity;
    } else {
        return $stock['stock_quantity'];
    }
}

//düz stok miktarı günceller ve alt ürünse parent idyi de günceller
function updateStockQuantity($stockId, $quantity, $type, $modelStock)
{
    $stock = $modelStock->find($stockId);
    if (!$stock) {
        return "güncellenecek stok bulunamadı";
    }
    $parentQuantity  = "";
    if(!empty($stock['parent_id'])){
        $parentQuantity = $modelStock->find($stock['parent_id'])['stock_quantity'];

    }
    $currentQuantity = $modelStock->find($stockId)['stock_quantity'];

    if ($parentQuantity >= 0 && $currentQuantity >= 0) {
        if ($type === 'add') {
            $newQuantity = $currentQuantity + $quantity;
            $parentQuantity = $parentQuantity + $quantity;
        } elseif ($type === 'remove') {
            if ($quantity <= $currentQuantity) {
                $newQuantity = $currentQuantity - $quantity;
                $parentQuantity = $parentQuantity - $quantity;
            } else {
                return false;
            }

        } else {
            return false;
        }

        if ($stock['parent_id'] == 0)
            return false;
        else {
            $data = [
                'stock_quantity' => $newQuantity
            ];

            $modelStock->set($data)
                ->where('stock_id', $stockId)
                ->update();

            $dataParent = [
                'stock_quantity' => $parentQuantity
            ];

            $modelStock->set($dataParent)
                ->where('stock_id', $stock['parent_id'])
                ->update();
        }

        return true;
    } else {
        return false;
    }



}



//verilen parent idye göre alt ürünleri gezip stok miktarılarını toplatıyor
function updateParentStockQuantity($stockId, $modelStock)
{
    $parentStock = $modelStock->find($stockId);

    if ($parentStock && $parentStock['parent_id'] == 0) {
        $subStocks = $modelStock->where('parent_id', $stockId)->findAll();
        $totalQuantity = 0;

        foreach ($subStocks as $subStock) {
            $totalQuantity += $subStock['stock_quantity'];
        }

        $data = [
            'stock_quantity' => $totalQuantity
        ];

        $modelStock->set($data)
            ->where('stock_id', $stockId)
            ->update();

        return true; // Güncelleme başarılı
    }

    return "Ana ürün bulunamadı veya ana ürün değil";
}



function updateStockTotalQuantity($modelStock, $stockId, $quantity, $type)
{
  
    if($stockId > 0):
    $modelCurrentQuantity = $modelStock
        ->where('user_id', session()->get('user_id'))
        ->where('stock_id', $stockId)
        ->first();



    $currentStockQuantity = $modelCurrentQuantity['stock_total_quantity'];

    // echo "currentMainStockQuantity: ".$currentStockQuantity."  ";
    // echo "func gelen quantity: ".$quantity."  ";

    if ($type === 'add') {
        $newTotalStockQuantity = floatval($currentStockQuantity) + $quantity;
    } else if ($type === 'remove') {
        $newTotalStockQuantity = floatval($currentStockQuantity) - $quantity;
    } else {
        echo json_encode(['icon' => 'error', 'message' => "updateStockTotalQuantity işlem tipi eşleşmedi"]);
        return false;
    }

   //$modelStock->update($stockId, ['stock_total_quantity' => $newTotalStockQuantity,'manuel_add' => 1]);
     $modelStock->update($stockId, ['stock_total_quantity' => $newTotalStockQuantity]);
    endif;
}


function updateStockWarehouseParentQuantity($insert_StockWarehouseQuantity, $warehouse_id, $stock_id, $parent_id, $quantity, $type, $modelStockWarehouseQuantity, $modelStock)
{


    //mevcut StockWarehouseQuantity tablo verilerini getirdik
    $StockWarehouseQuantity_item_parent = $modelStockWarehouseQuantity
        ->where('user_id', session()->get('user_id'))
        ->where('warehouse_id', $warehouse_id)
        ->where('stock_id', $parent_id)
        ->first();

    $StockWarehouseQuantity_item_child = $modelStockWarehouseQuantity
        ->where('user_id', session()->get('user_id'))
        ->where('warehouse_id', $warehouse_id)
        ->where('stock_id', $stock_id)
        ->first();

    // print_r($StockWarehouseQuantity_item_parent);
    // print_r($StockWarehouseQuantity_item_child);

    // return;

    $quantity = floatval($quantity);

    //mevcut stock_quantity bilgilerini aldık.
    $parentQuantity = $StockWarehouseQuantity_item_parent['stock_quantity'] ?? 0;
    $childQuantity = $StockWarehouseQuantity_item_child['stock_quantity'] ?? 0;

    // echo "first_parentQuantity: " . $parentQuantity . "  ";
    // echo "first_childQuantity: " . $childQuantity . "  ";


    // stock_quantity tablosunda, eklenmek istenen ürün daha önce eklenmiş diye bakılıyor
    if ($StockWarehouseQuantity_item_child) {

        if ($type === 'add') {
            $parentQuantity = floatval($parentQuantity) + floatval($quantity);
            $childQuantity = floatval($childQuantity) + floatval($quantity);

            updateStockTotalQuantity($modelStock, $parent_id, $quantity, 'add');
            updateStockTotalQuantity($modelStock, $stock_id, $quantity, 'add');


     

        }
        if ($type === 'remove') {
            $kalanGibi = floatval($childQuantity) - floatval($quantity);


            if ($kalanGibi >= 0) {
                $parentQuantity = floatval($parentQuantity) - floatval($quantity);
                $childQuantity = floatval($childQuantity) - floatval($quantity);


                updateStockTotalQuantity($modelStock, $stock_id, $quantity, 'remove');

                updateStockTotalQuantity($modelStock, $parent_id, $quantity, 'remove');
            } else {
                // echo json_encode(['icon' => 'error', 'message' => "bu işlemden sonra stok miktarı eksi duruma düşeceği için bu işlem tamamlanamaz."]);
                return 'eksi_stok';
            }
        }

    
        // echo "last_parentQuantity: " . $StockWarehouseQuantity_item_parent['id'] . "  ";
        // echo "last_parentQuantity2: " . $StockWarehouseQuantity_item_child['id'] . "  ";


        //depo stok miktarlarını günceller
        if(isset($StockWarehouseQuantity_item_parent)):
        $modelStockWarehouseQuantity->update($StockWarehouseQuantity_item_parent['id'], ['stock_quantity' => $parentQuantity]);
        endif;
        $modelStockWarehouseQuantity->update($StockWarehouseQuantity_item_child['id'], ['stock_quantity' => $childQuantity]);


      

        // echo "last_parentQuantity: " . $parentQuantity . "  ";
        // echo "last_childQuantity: " . $childQuantity . "  ";
    } else {

        //eklenmek istenen ürün modelStockWarehouseQuantity yok ve ekle

        // echo 'eklenmek istenen ürün modelStockWarehouseQuantity yok ve ekle';
       /* 
        echo '<pre>';
        print_r($insert_StockWarehouseQuantity);
        echo '</pre>';

        exit;
       */
        $modelStockWarehouseQuantity->insert($insert_StockWarehouseQuantity);


        if ($insert_StockWarehouseQuantity['parent_id'] != 0) {

            $StockWarehouseQuantity_item = $modelStockWarehouseQuantity
                ->where('user_id', session()->get('user_id'))
                ->where('warehouse_id', $warehouse_id)
                ->where('stock_id', $parent_id)
                ->first();

            // print_r($StockWarehouseQuantity_item);

            if (!$StockWarehouseQuantity_item) {

                $insert_parent_StockWarehouseQuantity = [
                    'user_id' => session()->get('user_id'),
                    'warehouse_id' => $warehouse_id,
                    'stock_id' => $parent_id,
                    'parent_id' => 0,
                    'stock_quantity' => $quantity,
                ];
                $modelStockWarehouseQuantity->insert($insert_parent_StockWarehouseQuantity);
                if(!empty($parent_id)){

                    updateStockTotalQuantity($modelStock, $parent_id, $quantity, 'add');
                }
                updateStockTotalQuantity($modelStock, $stock_id, $quantity, 'add');
            } else {
                $parentQuantity2 = $StockWarehouseQuantity_item['stock_quantity'];

                // echo 'else içinde son parent amount çekildi: '.$parentQuantity2;

                if ($type === 'add') {
                    $parentQuantity2 = floatval($parentQuantity2) + floatval($quantity);
                    if(!empty($parent_id)){
                                        
                        updateStockTotalQuantity($modelStock, $parent_id, $quantity, 'add');
                    }
                    updateStockTotalQuantity($modelStock, $stock_id, $quantity, 'add');
                }
                if ($type === 'remove') {
                    if ($quantity <= $parentQuantity2) {
                        $parentQuantity2 = floatval($parentQuantity2) - floatval($quantity);
                        if(!empty($parent_id)){
                    
                            updateStockTotalQuantity($modelStock, $parent_id, $quantity, 'remove');
                        }
                        updateStockTotalQuantity($modelStock, $stock_id, $quantity, 'remove');
                    }
                }
                $modelStockWarehouseQuantity->update($StockWarehouseQuantity_item['id'], ['stock_quantity' => $parentQuantity2]);
            }
        } else {
            // echo 'eklenmek istenen ürün modelStockWarehouseQuantity yok ve ekle. parent_idsi 0dan da farklı';

            $base_quantity = $insert_StockWarehouseQuantity['stock_quantity'];
            // echo ' nere: '.$base_quantity;

            // print_r($parent_id);
            // print_r($quantity);

            if ($type === 'add') {
                // $parentQuantity = floatval($parentQuantity) + floatval($quantity);
                updateStockTotalQuantity($modelStock, $stock_id, $quantity, 'add');
            } elseif ($type === 'remove') {
                $kalanGibi = floatval($base_quantity) - floatval($quantity);

                if ($kalanGibi >= 0) {
                    // $parentQuantity = floatval($parentQuantity) - floatval($quantity);
                    updateStockTotalQuantity($modelStock, $stock_id, $quantity, 'remove');

                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
    }

    return true;
}


