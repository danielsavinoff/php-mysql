<?php
  const DB_HOSTNAME = 'mysql';
  const DB_USER = 'root';
  const DB_PASSWORD = 'admin';
  const DB_NAME = 'mydb';
  const DB_PORT = '3306';

  $db = new PDO(
    'mysql:' .
    'host=' . DB_HOSTNAME . ';' .
    'port=' . DB_PORT . ';' .
    'dbname=' . DB_NAME,
    DB_USER,
    DB_PASSWORD
  );

  include_once __DIR__ . '/../app/Models/Product.php';
  $product = new Product($db);
  $db->query(file_get_contents(__DIR__ . '/seeds/products.sql'));