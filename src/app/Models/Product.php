<?php
  class Product {
    private $conn;

    public function __construct(
      PDO $conn
    ) {
      $this->conn = $conn;

      $this->conn->query(file_get_contents(__DIR__ . '/product.sql'));
    }

    public function getAll(
      int $limit
    ) {
      return $this->conn->query('SELECT * FROM Products WHERE IS_HIDDEN = 0 ORDER BY DATE_CREATE DESC LIMIT ' . $limit . ';');
    }

    public function getAllColumns() {
      return $this->conn->query('SHOW COLUMNS FROM Products;');
    }

    public function getCount() {
      return $this->conn->query('SELECT count(*) FROM Products;');
    }
    
    public function toggleIsHidden(int $id, bool $val) {
      return $this->conn->query('UPDATE Products SET IS_HIDDEN = ' . $val . ' WHERE ID = ' . $id . ';');
    }

    public function updateQuantity(int $id, int $amount) {
      return $this->conn->query('UPDATE Products SET PRODUCT_QUANTITY = ' . $amount . ' WHERE ID = ' . $id . ';');
    }
  }