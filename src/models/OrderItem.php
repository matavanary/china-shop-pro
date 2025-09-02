<?php

require_once __DIR__ . '/BaseModel.php';

/**
 * OrderItem Model
 */
class OrderItem extends BaseModel {
    protected $table = 'order_items';
    protected $fillable = [
        'order_id', 'product_id', 'product_name', 'product_sku', 
        'quantity', 'price', 'total'
    ];
    
    public function getByOrderId($orderId) {
        return $this->findAll(['order_id' => $orderId]);
    }
}