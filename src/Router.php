<?php
namespace Src;

class Router {
    private array $routes = [];

    public function add(string $method, string $path, callable $handler): void {
        $this->routes[] = [
            'method' => strtoupper($method),
            'path' => $path,
            'handler' => $handler
        ];
    }

    public function run(): void {
        $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        // Hilangkan nama folder proyek dari URL
        $scriptDir = str_replace('/public', '', dirname($_SERVER['SCRIPT_NAME']));
        $requestPath = '/' . trim(str_replace($scriptDir, '', $requestUri), '/');

        foreach ($this->routes as $route) {
            $pattern = "@^" . preg_replace('/\{([\w]+)\}/', '(?P<\1>[\w-]+)', trim($route['path'], '/')) . "$@";
            if ($requestMethod === $route['method'] && preg_match($pattern, trim($requestPath, '/'), $matches)) {
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                echo json_encode(call_user_func_array($route['handler'], $params));
                return;
            }
        }

        http_response_code(404);
        echo json_encode(['success' => false, 'message' => 'Route not found']);
    }
}
