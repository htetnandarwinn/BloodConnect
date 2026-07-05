<?php

namespace App\Shared\Presentation\View;

class View
{
    public static function render(string $view, array $data = [])
    {
        extract($data);

        $basePath = dirname(__DIR__, 4);

        $viewFile = $basePath . "/App/Shared/Presentation/View/{$view}.php";
        $layout = $basePath . "/App/Shared/Presentation/Layout/app.php";


        if (!file_exists($viewFile)) {
            throw new \Exception("View not found: $view");
        }

        ob_start();
        require $viewFile;
        $content = ob_get_clean();

        require $layout;
    }
}
