<?php
  declare(strict_types=1);

  enum HttpMethod: string 
  {
      case GET = 'GET';
      case POST = 'POST';
      case PUT = 'PUT';
      case DELETE = 'DELETE';
      case PATCH = 'PATCH';
      case HEAD = 'HEAD';
      case OPTIONS = 'OPTIONS';
      case TRACE = 'TRACE';
      case CONNECT = 'CONNECT';
  }

  // TODO: Add suport for optional dynamic path and multidynamic path
  class Router 
  {
    public static function handle(
      HttpMethod $method,
      string $route,
      string $filepath
    )
    {
      $_SERVER['PATH_SEGMENTS'] = explode('/', $_SERVER['PATH_INFO'] ?? '');
 
      if ($method->value !== $_SERVER['REQUEST_METHOD'])
      {
        return false;
      }
  
      if (self::matchRoute($route))
      { 
        require_once $filepath;
        exit();
      }

      return false;
    }

    private static function matchRoute(string $route) {
      $routeSegments = explode('/', $route === '/' ? '' : $route);

      if (count($routeSegments) !== count($_SERVER['PATH_SEGMENTS'])) {
        return false;
      }
 
      for($i = 0; $i < count($routeSegments); $i++) {
        $isDynamic = self::isDynamic($routeSegments[$i]); 

        if ($isDynamic && strlen($_SERVER['PATH_SEGMENTS'][$i]) > 0) {
          $_SERVER['PARAMS'] = [
            ...($_SERVER['PARAMS'] ?? []),
            substr($routeSegments[$i], 1) => $_SERVER['PATH_SEGMENTS'][$i]
          ];

          continue;
        }

        if ($routeSegments[$i] !== $_SERVER['PATH_SEGMENTS'][$i]) {
          return false;
        }
      }

      return true;
    } 

    private static function isDynamic(string $segment)
    {
      return str_starts_with($segment, ':');
    }
  }