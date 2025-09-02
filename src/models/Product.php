<?php

require_once __DIR__ . '/BaseModel.php';

/**
 * Product Model
 */
class Product extends BaseModel {
    protected $table = 'products';
    protected $fillable = [
        'category_id', 'name', 'slug', 'description', 'short_description',
        'price', 'compare_price', 'cost_price', 'sku', 'stock_quantity',
        'track_stock', 'weight', 'dimensions', 'tiktok_url', 'featured',
        'is_active', 'meta_title', 'meta_description'
    ];
    
    public function getWithCategory($id) {
        $sql = "SELECT p.*, c.name as category_name, c.slug as category_slug 
                FROM {$this->table} p 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE p.id = ?";
        return $this->db->fetch($sql, [$id]);
    }
    
    public function getWithImages($id) {
        $product = $this->find($id);
        if ($product) {
            $product['images'] = $this->getImages($id);
        }
        return $product;
    }
    
    public function getImages($productId) {
        $sql = "SELECT * FROM product_images WHERE product_id = ? ORDER BY sort_order ASC, is_primary DESC";
        return $this->db->fetchAll($sql, [$productId]);
    }
    
    public function getPrimaryImage($productId) {
        $sql = "SELECT * FROM product_images WHERE product_id = ? AND is_primary = 1 LIMIT 1";
        $image = $this->db->fetch($sql, [$productId]);
        
        if (!$image) {
            $sql = "SELECT * FROM product_images WHERE product_id = ? ORDER BY sort_order ASC LIMIT 1";
            $image = $this->db->fetch($sql, [$productId]);
        }
        
        return $image;
    }
    
    public function addImage($productId, $imagePath, $altText = null, $isPrimary = false) {
        if ($isPrimary) {
            // Remove primary flag from other images
            $this->db->query("UPDATE product_images SET is_primary = 0 WHERE product_id = ?", [$productId]);
        }
        
        $data = [
            'product_id' => $productId,
            'image_path' => $imagePath,
            'alt_text' => $altText,
            'is_primary' => $isPrimary ? 1 : 0,
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        $fields = implode(',', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        
        $sql = "INSERT INTO product_images ({$fields}) VALUES ({$placeholders})";
        return $this->db->query($sql, $data);
    }
    
    public function getFeatured($limit = 8) {
        $sql = "SELECT p.*, 
                       (SELECT image_path FROM product_images pi WHERE pi.product_id = p.id ORDER BY pi.is_primary DESC, pi.sort_order ASC LIMIT 1) as primary_image
                FROM {$this->table} p 
                WHERE p.is_active = 1 AND p.featured = 1 
                ORDER BY p.created_at DESC 
                LIMIT ?";
        return $this->db->fetchAll($sql, [$limit]);
    }
    
    public function getByCategory($categoryId, $page = 1, $perPage = 12) {
        $offset = ($page - 1) * $perPage;
        
        $sql = "SELECT p.*, c.name as category_name,
                       (SELECT image_path FROM product_images pi WHERE pi.product_id = p.id ORDER BY pi.is_primary DESC, pi.sort_order ASC LIMIT 1) as primary_image
                FROM {$this->table} p 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE p.category_id = ? AND p.is_active = 1 
                ORDER BY p.created_at DESC 
                LIMIT ?, ?";
        
        $products = $this->db->fetchAll($sql, [$categoryId, $offset, $perPage]);
        $total = $this->count(['category_id' => $categoryId, 'is_active' => 1]);
        
        return [
            'data' => $products,
            'total' => $total,
            'per_page' => $perPage,
            'current_page' => $page,
            'last_page' => ceil($total / $perPage)
        ];
    }
    
    public function search($query, $page = 1, $perPage = 12) {
        $offset = ($page - 1) * $perPage;
        $searchTerm = "%{$query}%";
        
        $sql = "SELECT p.*, c.name as category_name,
                       (SELECT image_path FROM product_images pi WHERE pi.product_id = p.id ORDER BY pi.is_primary DESC, pi.sort_order ASC LIMIT 1) as primary_image
                FROM {$this->table} p 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE p.is_active = 1 AND (p.name LIKE ? OR p.description LIKE ? OR p.short_description LIKE ?)
                ORDER BY p.name ASC 
                LIMIT ?, ?";
        
        $products = $this->db->fetchAll($sql, [$searchTerm, $searchTerm, $searchTerm, $offset, $perPage]);
        
        // Count total results
        $countSql = "SELECT COUNT(*) as count FROM {$this->table} p 
                     WHERE p.is_active = 1 AND (p.name LIKE ? OR p.description LIKE ? OR p.short_description LIKE ?)";
        $result = $this->db->fetch($countSql, [$searchTerm, $searchTerm, $searchTerm]);
        $total = $result['count'] ?? 0;
        
        return [
            'data' => $products,
            'total' => $total,
            'per_page' => $perPage,
            'current_page' => $page,
            'last_page' => ceil($total / $perPage)
        ];
    }
    
    public function updateStock($id, $quantity) {
        $sql = "UPDATE {$this->table} SET stock_quantity = stock_quantity + ? WHERE id = ?";
        return $this->db->query($sql, [$quantity, $id]);
    }
    
    public function generateSlug($name) {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));
        
        // Check if slug exists
        $count = $this->count(['slug' => $slug]);
        if ($count > 0) {
            $slug .= '-' . ($count + 1);
        }
        
        return $slug;
    }
}