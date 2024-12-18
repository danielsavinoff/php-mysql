<?php
  class CProduct {
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
      return $this->conn->query('SELECT * FROM Products ORDER BY DATE_CREATE DESC LIMIT ' . $limit . ';');
    }

    public function getAllColumns() {
      return $this->conn->query('SHOW COLUMNS FROM Products;');
    }

    public function getCount() {
      return $this->conn->query('SELECT count(*) FROM Products;');
    }
    
  }