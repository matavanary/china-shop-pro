<?php

/**
 * Session Management Class
 */
class Session {
    public static function start() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    
    public static function set($key, $value) {
        self::start();
        $_SESSION[$key] = $value;
    }
    
    public static function get($key, $default = null) {
        self::start();
        return $_SESSION[$key] ?? $default;
    }
    
    public static function has($key) {
        self::start();
        return isset($_SESSION[$key]);
    }
    
    public static function remove($key) {
        self::start();
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }
    
    public static function destroy() {
        self::start();
        session_destroy();
    }
    
    public static function regenerate() {
        self::start();
        session_regenerate_id(true);
    }
    
    public static function setFlash($key, $message) {
        self::start();
        $_SESSION['flash'][$key] = $message;
    }
    
    public static function getFlash($key = null) {
        self::start();
        if ($key === null) {
            $flash = $_SESSION['flash'] ?? [];
            unset($_SESSION['flash']);
            return $flash;
        }
        
        $message = $_SESSION['flash'][$key] ?? null;
        unset($_SESSION['flash'][$key]);
        return $message;
    }
    
    public static function hasFlash($key = null) {
        self::start();
        if ($key === null) {
            return !empty($_SESSION['flash']);
        }
        return isset($_SESSION['flash'][$key]);
    }
    
    // CSRF Token methods
    public static function generateCSRFToken() {
        self::start();
        $token = bin2hex(random_bytes(32));
        $_SESSION['csrf_token'] = $token;
        return $token;
    }
    
    public static function getCSRFToken() {
        self::start();
        if (!isset($_SESSION['csrf_token'])) {
            return self::generateCSRFToken();
        }
        return $_SESSION['csrf_token'];
    }
    
    public static function verifyCSRFToken($token) {
        self::start();
        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }
    
    // User authentication methods
    public static function login($user) {
        self::start();
        self::regenerate();
        $_SESSION['user'] = [
            'id' => $user['id'],
            'email' => $user['email'],
            'first_name' => $user['first_name'],
            'last_name' => $user['last_name'],
            'logged_in' => true
        ];
    }
    
    public static function logout() {
        self::start();
        unset($_SESSION['user']);
        self::setFlash('success', 'You have been logged out successfully.');
    }
    
    public static function isLoggedIn() {
        self::start();
        return isset($_SESSION['user']) && $_SESSION['user']['logged_in'] === true;
    }
    
    public static function getUser() {
        self::start();
        return $_SESSION['user'] ?? null;
    }
    
    public static function getUserId() {
        $user = self::getUser();
        return $user ? $user['id'] : null;
    }
    
    // Admin authentication methods
    public static function adminLogin($admin) {
        self::start();
        self::regenerate();
        $_SESSION['admin'] = [
            'id' => $admin['id'],
            'username' => $admin['username'],
            'email' => $admin['email'],
            'first_name' => $admin['first_name'],
            'last_name' => $admin['last_name'],
            'role' => $admin['role'],
            'logged_in' => true
        ];
    }
    
    public static function adminLogout() {
        self::start();
        unset($_SESSION['admin']);
    }
    
    public static function isAdminLoggedIn() {
        self::start();
        return isset($_SESSION['admin']) && $_SESSION['admin']['logged_in'] === true;
    }
    
    public static function getAdmin() {
        self::start();
        return $_SESSION['admin'] ?? null;
    }
}