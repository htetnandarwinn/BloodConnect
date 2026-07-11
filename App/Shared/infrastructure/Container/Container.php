<?php

namespace App\Shared\Infrastructure\Container;

use Closure;

class Container
{
    private array $bindings = [];
    private array $instances = [];

    public function bind(string $abstract, string|Closure $concrete): void
    {
        $this->bindings[$abstract] = $concrete;
    }

    public function singleton(string $abstract, string|Closure $concrete): void
    {
        $this->bindings[$abstract] = $concrete;
        unset($this->instances[$abstract]);
    }

    public function instance(string $abstract, object $instance): void
    {
        $this->instances[$abstract] = $instance;
    }

    public function make(string $abstract): object
    {
        if (isset($this->instances[$abstract])) {
            return $this->instances[$abstract];
        }

        if (isset($this->bindings[$abstract])) {
            $concrete = $this->bindings[$abstract];

            if ($concrete instanceof Closure) {
                $object = $concrete($this);
            } elseif (is_string($concrete)) {
                $object = $this->resolve($concrete);
            } else {
                throw new ContainerException("Invalid binding for {$abstract}");
            }

            $this->instances[$abstract] = $object;
            return $object;
        }

        return $this->resolve($abstract);
    }

    private function resolve(string $class): object
    {
        $reflection = new \ReflectionClass($class);

        $constructor = $reflection->getConstructor();

        if ($constructor === null) {
            return $reflection->newInstance();
        }

        $parameters = $constructor->getParameters();
        $dependencies = [];

        foreach ($parameters as $parameter) {
            $type = $parameter->getType();

            if ($type === null || $type->isBuiltin()) {
                if ($parameter->isDefaultValueAvailable()) {
                    $dependencies[] = $parameter->getDefaultValue();
                } else {
                    throw new ContainerException("Cannot resolve parameter \${$parameter->getName()} for {$class}");
                }
            } else {
                $dependencies[] = $this->make($type->getName());
            }
        }

        return $reflection->newInstanceArgs($dependencies);
    }

    public function has(string $abstract): bool
    {
        return isset($this->bindings[$abstract]) || isset($this->instances[$abstract]);
    }

    public function get(string $abstract): object
    {
        return $this->make($abstract);
    }
}
