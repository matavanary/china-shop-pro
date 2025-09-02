<?php

require_once __DIR__ . '/BaseModel.php';

/**
 * Order Model
 */
class Order extends BaseModel {
    protected $table = 'orders';
    protected $fillable = [
        'user_id', 'order_number', 'status', 'subtotal', 'tax_amount',
        'shipping_amount', 'discount_amount', 'total_amount', 'currency',
        'payment_method', 'payment_status', 'billing_address', 'shipping_address',
        'customer_notes', 'admin_notes', 'shipped_at', 'delivered_at'
    ];
    
    public function generateOrderNumber() {
        $prefix = 'CSP';
        $timestamp = date('Ymd');
        $random = str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
        
        do {
            $orderNumber = $prefix . $timestamp . $random;
            $exists = $this->count(['order_number' => $orderNumber]);
            if ($exists) {
                $random = str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
            }
        } while ($exists);
        
        return $orderNumber;
    }
    
    public function createOrder($data) {
        $this->db->beginTransaction();
        
        try {
            // Generate order number
            $data['order_number'] = $this->generateOrderNumber();
            
            // Create order
            $orderId = $this->create($data);
            
            // Add order items
            if (isset($data['items']) && is_array($data['items'])) {
                $orderItemModel = new OrderItem();
                foreach ($data['items'] as $item) {
                    $item['order_id'] = $orderId;
                    $orderItemModel->create($item);
                    
                    // Update product stock if track_stock is enabled
                    $product = new Product();
                    $productData = $product->find($item['product_id']);
                    if ($productData && $productData['track_stock']) {
                        $product->updateStock($item['product_id'], -$item['quantity']);
                    }
                }
            }
            
            $this->db->commit();
            return $orderId;
            
        } catch (Exception $e) {
            $this->db->rollback();
            throw $e;
        }
    }
    
    public function getWithItems($id) {
        $order = $this->find($id);
        if ($order) {
            // Decode JSON addresses
            $order['billing_address'] = json_decode($order['billing_address'], true);
            $order['shipping_address'] = json_decode($order['shipping_address'], true);
            
            // Get order items
            $sql = "SELECT oi.*, p.name as product_name, p.sku as product_sku 
                    FROM order_items oi 
                    LEFT JOIN products p ON oi.product_id = p.id 
                    WHERE oi.order_id = ?";
            $order['items'] = $this->db->fetchAll($sql, [$id]);
        }
        return $order;
    }
    
    public function getByStatus($status, $page = 1, $perPage = 20) {
        return $this->paginate($page, $perPage, ['status' => $status], 'created_at DESC');
    }
    
    public function getRecentOrders($limit = 10) {
        $sql = "SELECT o.*, u.first_name, u.last_name, u.email 
                FROM {$this->table} o 
                LEFT JOIN users u ON o.user_id = u.id 
                ORDER BY o.created_at DESC 
                LIMIT ?";
        return $this->db->fetchAll($sql, [$limit]);
    }
    
    public function updateStatus($id, $status, $adminNotes = null) {
        $data = ['status' => $status];
        
        if ($adminNotes) {
            $data['admin_notes'] = $adminNotes;
        }
        
        // Set shipped_at when status changes to shipped
        if ($status === 'shipped') {
            $data['shipped_at'] = date('Y-m-d H:i:s');
        }
        
        // Set delivered_at when status changes to delivered
        if ($status === 'delivered') {
            $data['delivered_at'] = date('Y-m-d H:i:s');
        }
        
        return $this->update($id, $data);
    }
    
    public function updatePaymentStatus($id, $paymentStatus) {
        return $this->update($id, ['payment_status' => $paymentStatus]);
    }
    
    public function getTotalRevenue($startDate = null, $endDate = null) {
        $sql = "SELECT SUM(total_amount) as revenue FROM {$this->table} WHERE payment_status = 'paid'";
        $params = [];
        
        if ($startDate && $endDate) {
            $sql .= " AND created_at BETWEEN ? AND ?";
            $params = [$startDate, $endDate];
        }
        
        $result = $this->db->fetch($sql, $params);
        return $result['revenue'] ?? 0;
    }
    
    public function getOrdersByDateRange($startDate, $endDate) {
        $sql = "SELECT DATE(created_at) as order_date, COUNT(*) as order_count, SUM(total_amount) as revenue 
                FROM {$this->table} 
                WHERE created_at BETWEEN ? AND ? 
                GROUP BY DATE(created_at) 
                ORDER BY order_date ASC";
        return $this->db->fetchAll($sql, [$startDate, $endDate]);
    }
    
    public function getByOrderNumber($orderNumber) {
        return $this->db->fetch("SELECT * FROM {$this->table} WHERE order_number = ?", [$orderNumber]);
    }
}