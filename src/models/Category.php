<?php

require_once __DIR__ . '/BaseModel.php';

/**
 * Category Model
 */
class Category extends BaseModel {
    protected $table = 'categories';
    protected $fillable = [
        'name', 'slug', 'description', 'image', 'parent_id', 
        'sort_order', 'is_active'
    ];
    
    public function getActive() {
        return $this->findAll(['is_active' => 1], 'sort_order ASC, name ASC');
    }
    
    public function getWithProductCount() {
        $sql = "SELECT c.*, COUNT(p.id) as product_count 
                FROM {$this->table} c 
                LEFT JOIN products p ON c.id = p.category_id AND p.is_active = 1
                WHERE c.is_active = 1 
                GROUP BY c.id 
                ORDER BY c.sort_order ASC, c.name ASC";
        return $this->db->fetchAll($sql);
    }
    
    public function getBySlug($slug) {
        return $this->db->fetch("SELECT * FROM {$this->table} WHERE slug = ? AND is_active = 1", [$slug]);
    }
    
    public function getChildren($parentId) {
        return $this->findAll(['parent_id' => $parentId, 'is_active' => 1], 'sort_order ASC, name ASC');
    }
    
    public function getHierarchy() {
        $categories = $this->getActive();
        $hierarchy = [];
        
        // First, get all parent categories
        foreach ($categories as $category) {
            if ($category['parent_id'] === null) {
                $category['children'] = [];
                $hierarchy[$category['id']] = $category;
            }
        }
        
        // Then, add children to their parents
        foreach ($categories as $category) {
            if ($category['parent_id'] !== null && isset($hierarchy[$category['parent_id']])) {
                $hierarchy[$category['parent_id']]['children'][] = $category;
            }
        }
        
        return array_values($hierarchy);
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