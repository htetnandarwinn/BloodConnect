<?php

namespace Routes;

class Router
{
    private array $routes = [];
    private array $patterns = [];

    public function get($uri, $action)
    {
        $this->addRoute('GET', $uri, $action);
    }

    public function post($uri, $action)
    {
        $this->addRoute('POST', $uri, $action);
    }

    private function addRoute($method, $uri, $action)
    {
        $this->routes[$method][$uri] = $action;
        $this->patterns[$method][$uri] = $this->buildPattern($uri);
    }

    private function buildPattern(string $uri): string
    {
        return '#^' . preg_replace('#\{([^/]+)\}#', '([^/]+)', str_replace('/', '\/', $uri)) . '$#';
    }

    public function dispatch($uri, $method)
    {
        $action = $this->routes[$method][$uri] ?? null;
        $params = [];

        if (!$action) {
            foreach ($this->routes[$method] ?? [] as $routeUri => $routeAction) {
                if (preg_match($this->patterns[$method][$routeUri], $uri, $matches)) {
                    $action = $routeAction;
                    array_shift($matches);
                    $params = $matches;
                    break;
                }
            }
        }

        if (!$action) {
            http_response_code(404);
            require __DIR__ . '/../App/Shared/Presentation/View/404.php';
            exit;
        }

        // Callable routes
        if (is_callable($action)) {
            return call_user_func($action);
        }

        // Array controller routes
        if (is_array($action)) {
            [$controller, $function] = $action;

            if (!class_exists($controller)) {
                throw new \Exception("Controller not found: $controller");
            }

            $instance = new $controller();

            if (!method_exists($instance, $function)) {
                throw new \Exception("Method not found: $function in $controller");
            }

            if (!empty($params)) {
                return $instance->$function(...$params);
            }

            return $instance->$function();
        }

        // String include routes (optional legacy support)
        if (is_string($action)) {
            require $action;
            return;
        }

        return null;
    }
}
