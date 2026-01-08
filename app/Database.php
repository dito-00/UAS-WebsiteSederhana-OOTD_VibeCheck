<?php
class Database {
    private $host = "localhost";
    private $db_name = "db_ootd"; // <--- CEK LAGI: Apa benar nama di phpMyAdmin 'db_ootd'?
    private $username = "root";
    private $password = ""; // <--- Kosongkan jika pakai XAMPP standar
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            die("Koneksi Database Gagal: " . $exception->getMessage());
        }
        return $this->conn;
    }
}