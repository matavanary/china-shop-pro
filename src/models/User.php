<?php

require_once __DIR__ . '/BaseModel.php';

/**
 * User Model
 */
class User extends BaseModel {
    protected $table = 'users';
    protected $fillable = [
        'email', 'password', 'first_name', 'last_name', 'phone',
        'date_of_birth', 'gender', 'email_verified', 'email_verification_token',
        'password_reset_token', 'password_reset_expires', 'is_active'
    ];
    
    public function createUser($data) {
        // Hash password
        if (isset($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }
        
        // Generate email verification token
        $data['email_verification_token'] = bin2hex(random_bytes(32));
        
        return $this->create($data);
    }
    
    public function authenticate($email, $password) {
        $user = $this->findByEmail($email);
        
        if ($user && password_verify($password, $user['password']) && $user['is_active']) {
            // Update last login
            $this->update($user['id'], ['last_login_at' => date('Y-m-d H:i:s')]);
            return $user;
        }
        
        return false;
    }
    
    public function findByEmail($email) {
        $sql = "SELECT * FROM {$this->table} WHERE email = ?";
        return $this->db->fetch($sql, [$email]);
    }
    
    public function verifyEmail($token) {
        $sql = "UPDATE {$this->table} SET email_verified = 1, email_verification_token = NULL WHERE email_verification_token = ?";
        return $this->db->query($sql, [$token]);
    }
    
    public function generatePasswordResetToken($email) {
        $token = bin2hex(random_bytes(32));
        $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));
        
        $sql = "UPDATE {$this->table} SET password_reset_token = ?, password_reset_expires = ? WHERE email = ?";
        $result = $this->db->query($sql, [$token, $expires, $email]);
        
        return $result ? $token : false;
    }
    
    public function resetPassword($token, $newPassword) {
        $sql = "SELECT * FROM {$this->table} WHERE password_reset_token = ? AND password_reset_expires > NOW()";
        $user = $this->db->fetch($sql, [$token]);
        
        if ($user) {
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $sql = "UPDATE {$this->table} SET password = ?, password_reset_token = NULL, password_reset_expires = NULL WHERE id = ?";
            return $this->db->query($sql, [$hashedPassword, $user['id']]);
        }
        
        return false;
    }
    
    public function getOrders($userId, $page = 1, $perPage = 10) {
        $offset = ($page - 1) * $perPage;
        
        $sql = "SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC LIMIT ?, ?";
        $orders = $this->db->fetchAll($sql, [$userId, $offset, $perPage]);
        
        $total = $this->db->fetch("SELECT COUNT(*) as count FROM orders WHERE user_id = ?", [$userId]);
        
        return [
            'data' => $orders,
            'total' => $total['count'] ?? 0,
            'per_page' => $perPage,
            'current_page' => $page,
            'last_page' => ceil(($total['count'] ?? 0) / $perPage)
        ];
    }
}