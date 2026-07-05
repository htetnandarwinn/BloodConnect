<?php

require_once __DIR__ . '/../vendor/autoload.php';

session_start();

/**
 * Get request URI
 */
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

/**
 * Get project base path correctly
 */
$basePath = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));

/**
 * Remove base path from URI
 */
if ($basePath !== '/' && $basePath !== '') {
    $uri = str_replace($basePath, '', $uri);
}

/**
 * Normalize URI
 */
$uri = '/' . trim($uri, '/');

if ($uri === '//') {
    $uri = '/';
}

/**
 * Load router
 */
$router = require __DIR__ . '/../routes/web.php';

$router->dispatch($uri, $_SERVER['REQUEST_METHOD']);
