<?php

/**
 * Shopping Cart Class
 */
class Cart {
    private $sessionKey = 'shopping_cart';
    
    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION[$this->sessionKey])) {
            $_SESSION[$this->sessionKey] = [];
        }
    }
    
    public function add($productId, $quantity = 1, $price = 0) {
        $productId = (int) $productId;
        $quantity = (int) $quantity;
        
        if ($quantity <= 0) {
            return false;
        }
        
        // Get product details
        $product = new Product();
        $productData = $product->find($productId);
        
        if (!$productData || !$productData['is_active']) {
            return false;
        }
        
        // Check stock
        if ($productData['track_stock'] && $productData['stock_quantity'] < $quantity) {
            return false;
        }
        
        $cartItem = [
            'product_id' => $productId,
            'name' => $productData['name'],
            'price' => $productData['price'],
            'quantity' => $quantity,
            'image' => $this->getProductImage($productId),
            'tiktok_url' => $productData['tiktok_url']
        ];
        
        // If item exists, update quantity
        if (isset($_SESSION[$this->sessionKey][$productId])) {
            $newQuantity = $_SESSION[$this->sessionKey][$productId]['quantity'] + $quantity;
            
            // Check stock again
            if ($productData['track_stock'] && $productData['stock_quantity'] < $newQuantity) {
                return false;
            }
            
            $_SESSION[$this->sessionKey][$productId]['quantity'] = $newQuantity;
        } else {
            $_SESSION[$this->sessionKey][$productId] = $cartItem;
        }
        
        return true;
    }
    
    public function update($productId, $quantity) {
        $productId = (int) $productId;
        $quantity = (int) $quantity;
        
        if ($quantity <= 0) {
            return $this->remove($productId);
        }
        
        if (isset($_SESSION[$this->sessionKey][$productId])) {
            // Check stock
            $product = new Product();
            $productData = $product->find($productId);
            
            if ($productData['track_stock'] && $productData['stock_quantity'] < $quantity) {
                return false;
            }
            
            $_SESSION[$this->sessionKey][$productId]['quantity'] = $quantity;
            return true;
        }
        
        return false;
    }
    
    public function remove($productId) {
        $productId = (int) $productId;
        
        if (isset($_SESSION[$this->sessionKey][$productId])) {
            unset($_SESSION[$this->sessionKey][$productId]);
            return true;
        }
        
        return false;
    }
    
    public function getItems() {
        return $_SESSION[$this->sessionKey] ?? [];
    }
    
    public function getCount() {
        $count = 0;
        foreach ($this->getItems() as $item) {
            $count += $item['quantity'];
        }
        return $count;
    }
    
    public function getSubtotal() {
        $subtotal = 0;
        foreach ($this->getItems() as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        return $subtotal;
    }
    
    public function getTotal() {
        $subtotal = $this->getSubtotal();
        $shipping = $this->getShippingCost();
        $tax = $this->getTax();
        
        return $subtotal + $shipping + $tax;
    }
    
    public function getShippingCost() {
        $config = require __DIR__ . '/../config/app.php';
        $subtotal = $this->getSubtotal();
        
        // Free shipping threshold (if configured)
        $freeShippingThreshold = 100; // $100 default
        if ($subtotal >= $freeShippingThreshold) {
            return 0;
        }
        
        return 9.99; // Default shipping cost
    }
    
    public function getTax() {
        $subtotal = $this->getSubtotal();
        $taxRate = 0.10; // 10% default tax rate
        
        return $subtotal * $taxRate;
    }
    
    public function clear() {
        $_SESSION[$this->sessionKey] = [];
    }
    
    public function isEmpty() {
        return empty($_SESSION[$this->sessionKey]);
    }
    
    private function getProductImage($productId) {
        $product = new Product();
        $image = $product->getPrimaryImage($productId);
        
        return $image ? $image['image_path'] : 'assets/images/placeholder.jpg';
    }
    
    public function validateStock() {
        $product = new Product();
        $errors = [];
        
        foreach ($this->getItems() as $productId => $item) {
            $productData = $product->find($productId);
            
            if (!$productData || !$productData['is_active']) {
                $errors[] = "Product '{$item['name']}' is no longer available.";
                $this->remove($productId);
                continue;
            }
            
            if ($productData['track_stock'] && $productData['stock_quantity'] < $item['quantity']) {
                $errors[] = "Only {$productData['stock_quantity']} items available for '{$item['name']}'.";
                $this->update($productId, $productData['stock_quantity']);
            }
        }
        
        return $errors;
    }
}