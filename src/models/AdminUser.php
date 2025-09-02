<?php

require_once __DIR__ . '/BaseModel.php';

/**
 * AdminUser Model
 */
class AdminUser extends BaseModel {
    protected $table = 'admin_users';
    protected $fillable = [
        'username', 'email', 'password', 'first_name', 'last_name', 
        'role', 'permissions', 'is_active'
    ];
    
    public function authenticate($username, $password) {
        $admin = $this->findByUsername($username);
        
        if ($admin && password_verify($password, $admin['password']) && $admin['is_active']) {
            // Update last login
            $this->update($admin['id'], ['last_login_at' => date('Y-m-d H:i:s')]);
            return $admin;
        }
        
        return false;
    }
    
    public function findByUsername($username) {
        $sql = "SELECT * FROM {$this->table} WHERE username = ? OR email = ?";
        return $this->db->fetch($sql, [$username, $username]);
    }
    
    public function createAdmin($data) {
        // Hash password
        if (isset($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }
        
        return $this->create($data);
    }
    
    public function updatePassword($id, $newPassword) {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        return $this->update($id, ['password' => $hashedPassword]);
    }
    
    public function hasPermission($adminId, $permission) {
        $admin = $this->find($adminId);
        
        if (!$admin) {
            return false;
        }
        
        // Super admin has all permissions
        if ($admin['role'] === 'admin') {
            return true;
        }
        
        // Check specific permissions
        $permissions = json_decode($admin['permissions'] ?? '[]', true);
        return in_array($permission, $permissions);
    }
    
    public function getByRole($role) {
        return $this->findAll(['role' => $role, 'is_active' => 1], 'created_at DESC');
    }
}