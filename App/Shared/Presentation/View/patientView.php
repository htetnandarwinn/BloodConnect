<?php

namespace App\Shared\Presentation\View;

class patientView
{
    public static function render(string $view, array $data = [])
    {
        extract($data);

        $basePath = dirname(__DIR__, 4);

        $viewFile = $basePath . "/App/User/Presentation/View/{$view}.php";
        $layout   = $basePath . "/App/User/Presentation/Layout/patientApp.php";

        // Better error message (more readable)
        if (!is_file($viewFile)) {
            throw new \Exception("View not found: {$viewFile}");
        }

        if (!is_file($layout)) {
            throw new \Exception("Layout not found: {$layout}");
        }

        ob_start();
        require $viewFile;
        $content = ob_get_clean();

        require $layout;
    }
}
