<?php

class AdminView
{
public static function render(string $view, array $data = [])
{
extract($data);

$basePath = realpath(__DIR__ . '/../../../../');

$viewFile = $basePath . "/App/Admin/Presentation/View/{$view}.php";
$layout = $basePath . "/App/Admin/Presentation/Layout/adminApp.php";

if (!is_file($viewFile)) {
die("View not found: " . $viewFile);
}

if (!is_file($layout)) {
die("Layout not found: " . $layout);
}

ob_start();
require $viewFile;
$content = ob_get_clean();

require $layout;
}
}