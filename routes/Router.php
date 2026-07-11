<?php

namespace Routes;

use App\Shared\Infrastructure\Container\Container;
use App\Shared\Helpers\Permission;

class Router
{
    private array $routes = [];
    private array $patterns = [];
    private array $middlewareAliases = [];
    private string $groupPrefix = '';
    private array $groupMiddleware = [];
    private ?Container $container = null;

    public function setContainer(Container $container): void
    {
        $this->container = $container;
    }

    public function aliasMiddleware(string $name, string $class): void
    {
        $this->middlewareAliases[$name] = $class;
    }

    public function get($uri, $action)
    {
        $this->addRoute('GET', $uri, $action);
    }

    public function post($uri, $action)
    {
        $this->addRoute('POST', $uri, $action);
    }

    public function group(array $attributes, callable $callback): void
    {
        $prefix = $attributes['prefix'] ?? '';
        $middleware = $attributes['middleware'] ?? [];

        $previousPrefix = $this->groupPrefix;
        $previousMiddleware = $this->groupMiddleware;

        $this->groupPrefix = $previousPrefix . $prefix;
        $this->groupMiddleware = array_merge($previousMiddleware, (array)$middleware);

        $callback($this);

        $this->groupPrefix = $previousPrefix;
        $this->groupMiddleware = $previousMiddleware;
    }

    public function middleware($name, callable $callback): void
    {
        $previousMiddleware = $this->groupMiddleware;

        $this->groupMiddleware = array_merge($previousMiddleware, (array)$name);

        $callback($this);

        $this->groupMiddleware = $previousMiddleware;
    }

    private function addRoute($method, $uri, $action)
    {
        $fullUri = $this->groupPrefix . $uri;

        $this->routes[$method][$fullUri] = [
            'action'     => $action,
            'middleware' => $this->groupMiddleware,
        ];

        $this->patterns[$method][$fullUri] = $this->buildPattern($fullUri);
    }

    private function buildPattern(string $uri): string
    {
        return '#^' . preg_replace('#\{([^/]+)\}#', '([^/]+)', str_replace('/', '\/', $uri)) . '$#';
    }

    public function dispatch($uri, $method)
    {
        $routeEntry = $this->routes[$method][$uri] ?? null;
        $params = [];

        if (!$routeEntry) {
            foreach ($this->routes[$method] ?? [] as $routeUri => $entry) {
                if (preg_match($this->patterns[$method][$routeUri], $uri, $matches)) {
                    $routeEntry = $entry;
                    array_shift($matches);
                    $params = $matches;
                    break;
                }
            }
        }

        if (!$routeEntry) {
            http_response_code(404);
            require __DIR__ . '/../App/Shared/Presentation/View/404.php';
            exit;
        }

        $action = $routeEntry['action'];
        $middleware = $routeEntry['middleware'] ?? [];

        $this->runMiddleware($middleware);

        // Callable routes
        if (is_callable($action)) {
            return call_user_func($action);
        }

        // Array controller routes: [ControllerClass::class, 'method']
        if (is_array($action)) {
            [$controller, $function] = $action;

            if (!class_exists($controller)) {
                throw new \Exception("Controller not found: $controller");
            }

            $instance = $this->resolveController($controller);

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

    private function resolveController(string $controller): object
    {
        if ($this->container !== null && $this->container->has($controller)) {
            return $this->container->get($controller);
        }

        if ($this->container !== null) {
            try {
                return $this->container->make($controller);
            } catch (\Exception $e) {
                // Fall through to default instantiation
            }
        }

        return new $controller();
    }

    private function runMiddleware(array $middlewareList): void
    {
        foreach ($middlewareList as $name) {
            // Support middleware with parameters: "permission:dashboard.view"
            if (is_string($name) && str_contains($name, ':')) {
                $parts = explode(':', $name, 2);
                $alias = $parts[0];
                $param = $parts[1];

                $class = $this->middlewareAliases[$alias] ?? null;

                if (!$class) {
                    throw new \Exception("Middleware alias '$alias' is not registered.");
                }

                $instance = new $class($param);

                if (!method_exists($instance, 'handle')) {
                    throw new \Exception("Middleware $class must have a handle() method.");
                }

                $instance->handle();
                continue;
            }

            $class = $this->middlewareAliases[$name] ?? null;

            if (!$class) {
                throw new \Exception("Middleware alias '$name' is not registered.");
            }

            if (!class_exists($class)) {
                throw new \Exception("Middleware class not found: $class");
            }

            $instance = new $class();

            if (!method_exists($instance, 'handle')) {
                throw new \Exception("Middleware $class must have a handle() method.");
            }

            $instance->handle();
        }
    }
}
