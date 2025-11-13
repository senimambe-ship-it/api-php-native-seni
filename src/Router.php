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
        header('Content-Type: application/json');
        $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        $scriptName = $_SERVER['SCRIPT_NAME'];
        $baseDir = str_replace('/index.php', '', $scriptName);
        $requestPath = str_replace($baseDir, '', $requestUri);
        $requestPath = '/' . trim($requestPath, '/');

        foreach ($this->routes as $route) {
            $pattern = "@^" . preg_replace('/\{([\w]+)\}/', '(?P<\1>[\w-]+)', trim($route['path'], '/')) . "$@";
            if ($requestMethod === $route['method'] && preg_match($pattern, trim($requestPath, '/'), $matches)) {
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                call_user_func_array($route['handler'], $params);
                return;
            }
        }

        http_response_code(404);
        echo json_encode(["success" => false, "message" => "Route not found"]);
    }
}
