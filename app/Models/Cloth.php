<?php
class Cloth {
    private $conn;
    private $table_name = "clothes";

    public function __construct($db) {
        $this->conn = $db;
    }

    // FUNGSI UTAMA: READ + SEARCH + PAGINATION
    public function readWithPagination($user_id, $limit, $offset, $search = '') {
        // 1. Query SQL: Mengambil data baju milik user tertentu + filter nama + limit halaman
        $query = "SELECT c.*, cat.name as category_name 
                  FROM " . $this->table_name . " c
                  JOIN categories cat ON c.category_id = cat.id
                  WHERE c.user_id = :user_id 
                  AND (c.name LIKE :search OR c.vibe LIKE :search)
                  ORDER BY c.id DESC
                  LIMIT :limit OFFSET :offset";

        $stmt = $this->conn->prepare($query);

        // 2. Binding Parameter (Keamanan agar tidak di-hack/SQL Injection)
        $search_term = "%{$search}%";
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':search', $search_term);
        $stmt->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int) $offset, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt;
    }

    // FUNGSI HITUNG TOTAL: Penting untuk menentukan jumlah halaman di Pagination
    public function countAll($user_id, $search = '') {
        $query = "SELECT COUNT(*) as total FROM " . $this->table_name . " 
                  WHERE user_id = :user_id AND name LIKE :search";
        
        $stmt = $this->conn->prepare($query);
        $search_term = "%{$search}%";
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':search', $search_term);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $row['total'];
    }
}