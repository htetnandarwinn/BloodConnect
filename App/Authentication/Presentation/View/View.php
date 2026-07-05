<?php

namespace App\Authentication\Presentation\View;

class View
{
    public static function render(string $view, array $data = [])
    {
        extract($data);

        $basePath = dirname(__DIR__, 4);

        $path = "../App/Authentication/Presentation/View/{$view}.php";
        $layout = $basePath . "/App/Shared/Presentation/Layout/app.php";

        if (!file_exists($path)) {
            throw new \Exception("View not found: $view");
        }

        ob_start();
        require $path;
        $content = ob_get_clean();

        require $layout;
    }
}
