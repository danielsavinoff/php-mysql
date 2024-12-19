<?php
  declare(strict_types=1);

  require_once $_SERVER['DOCUMENT_ROOT'] . '/Router.php';

  // If a route is matched it'd stop further execution of the script
  Router::handle(HttpMethod::GET, '/', __DIR__ . '/app/Views/Home.php');
  Router::handle(HttpMethod::PATCH, '/products/:ID', __DIR__ . '/app/Controllers/ProductController.php');
  
  // Return not found page if no route was matched
  http_response_code(404);
  require_once __DIR__ . '/app/Views/Not-found.php';