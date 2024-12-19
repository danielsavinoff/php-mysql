<?php
  declare(strict_types=1);

  require_once '__DIR__' . '../../db/db.php';

  if (!$_SERVER['PARAMS']['ID']) {
    http_response_code(404);
  } else {  
    if (is_int(strpos($_SERVER['CONTENT_TYPE'] ?? '', 'application/json'))) {
      $_PATCH = json_decode(file_get_contents('php://input'), true);

      if (is_array($_PATCH)) {
        if (isset($_PATCH['IS_HIDDEN']) && is_bool($_PATCH['IS_HIDDEN'])) {
          $product->toggleIsHidden((int) $_SERVER['PARAMS']['ID'], $_PATCH['IS_HIDDEN']);
        } elseif ((isset($_PATCH['PRODUCT_QUANTITY']) && is_int($_PATCH['PRODUCT_QUANTITY']))) {
          $product->updateQuantity((int) $_SERVER['PARAMS']['ID'], (int) $_PATCH['PRODUCT_QUANTITY']);
        } else {
          http_response_code(400);
        }
      } else {
        http_response_code(400);
      }
    } else {
      http_response_code(400);
    }
  }


  