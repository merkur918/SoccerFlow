<?php

abstract class ApiController
{
    protected SessionManager $session;
    private static ?array $envCache = null;

    public function __construct(SessionManager $session)
    {
        $this->session = $session;
    }

    protected function json(array $payload, int $status = 200): void
    {
        http_response_code($status);
        header('Content-Type: application/json; charset=utf-8');
        header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
        header('Pragma: no-cache');
        echo json_encode($payload, JSON_UNESCAPED_UNICODE);
        exit;
    }

    protected function ok(array $data = [], int $status = 200): void
    {
        $this->json(['ok' => true, 'data' => $data], $status);
    }

    protected function fail(string $message, int $status = 400, array $errors = []): void
    {
        $payload = ['ok' => false, 'message' => $message];
        if (!empty($errors)) $payload['errors'] = $errors;

        $this->json($payload, $status);
    }

    protected function requireMethod(string $method): void
    {
        $current = strtoupper($_SERVER['REQUEST_METHOD'] ?? '');
        if ($current !== strtoupper($method)) {
            $this->fail('Method Not Allowed', 405);
        }
    }

    protected function input(): array
    {
        // API principal: JSON body
        $raw = file_get_contents('php://input') ?: '';
        $json = json_decode($raw, true);
        if (is_array($json)) return $json;

        // Fallback por si envían form-data/x-www-form-urlencoded
        if (!empty($_POST)) return $_POST;

        return [];
    }

    protected function baseUrl(): string
    {
        $https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
        $scheme = $https ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
        return $scheme . '://' . $host;
    }

    protected function env(string $key, ?string $default = null): ?string
    {
        $value = getenv($key);
        if ($value !== false && $value !== '') {
            return $value;
        }

        if (self::$envCache === null) {
            self::$envCache = $this->loadDotEnv();
        }

        if (array_key_exists($key, self::$envCache)) {
            return self::$envCache[$key];
        }

        return $default;
    }

    private function loadDotEnv(): array
    {
        $path = __DIR__ . '/../../.env';
        if (!is_readable($path)) {
            return [];
        }

        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        if (!is_array($lines)) {
            return [];
        }

        $values = [];
        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '' || str_starts_with($line, '#') || str_starts_with($line, ';')) {
                continue;
            }

            $parts = explode('=', $line, 2);
            if (count($parts) !== 2) {
                continue;
            }

            $key = trim($parts[0]);
            $value = trim($parts[1]);
            $value = trim($value, "\"'");

            if ($key !== '') {
                $values[$key] = $value;
            }
        }

        return $values;
    }
}
